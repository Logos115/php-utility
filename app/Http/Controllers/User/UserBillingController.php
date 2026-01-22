<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\Statement;
use Carbon\Carbon;
use PDF;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\View\View;



class UserBillingController extends Controller
{
    public function index(): View
    {
        $user = Auth::user()->loadMissing('statements');
        $currentBalance = 0.00;
        $nextDueDate = null;
        $paymentStatusMessage = 'No upcoming payments due.';

        $upcomingStatement = $user->statements()
                                ->where('status', '!=', 'paid')
                                ->where('due_date', '>=', today())
                                ->orderBy('due_date', 'asc')
                                ->first();
        if ($upcomingStatement) {
            $currentBalance = $upcomingStatement->total_amount;
            $nextDueDate = $upcomingStatement->due_date;
            $paymentStatusMessage = 'Payment Due: ' . Carbon::parse($nextDueDate)->format('M d, Y');
        } else { /* ... (existing logic for overdue/up-to-date) ... */
            $latestOverallStatement = $user->statements()->orderBy('statement_date', 'desc')->first();
            if ($latestOverallStatement) {
                if ($latestOverallStatement->status !== 'paid') {
                    $currentBalance = $latestOverallStatement->total_amount;
                    $paymentStatusMessage = 'Payment Overdue: ' . Carbon::parse($latestOverallStatement->due_date)->format('M d, Y');
                } else {
                    $paymentStatusMessage = 'Account is up to date.';
                }
            }
        }
        $billingData = [
            'balance' => $currentBalance, 'paymentStatus' => $paymentStatusMessage,
            'accountIdentifier' => $user->service_type ?? 'N/A', 'accountNumber' => $user->account_number ?? 'N/A',
        ];
        $adData = [ /* ... ad data ... */ ];
        return view('user.billing.index', compact('billingData', 'adData'));
    }
public function statements(): View
{
    $userId = Auth::id();

    $currentStatement = Statement::where('user_id', $userId)
        ->orderByDesc('statement_date')
        ->orderByDesc('id')
        ->first();

    $pastStatements = Statement::where('user_id', $userId)
        ->when($currentStatement, function ($q) use ($currentStatement) {
            $q->where('id', '!=', $currentStatement->id);
        })
        ->orderByDesc('statement_date')
        ->orderByDesc('id')
        ->paginate(10)
        ->withQueryString();

    return view('user.billing.statements', compact('currentStatement', 'pastStatements'));
}

public function showStatementDetails($statement): View
{
    $userId = Auth::id();

    $statement = Statement::where('id', $statement)
        ->where('user_id', $userId)
        ->with(['user', 'items'])
        ->firstOrFail();

    return view('user.billing.statement_show_details', compact('statement'));
}

public function downloadStatementPdf($statement)
{
    $userId = Auth::id();

    $statement = Statement::where('id', $statement)
        ->where('user_id', $userId)
        ->with(['user', 'items'])
        ->firstOrFail();

    if (!$statement->user) {
        Log::error("[UserBillingController] User missing for statement ID: {$statement->id}");
        return redirect()->back()->with('error', 'User data missing for PDF.');
    }

    $companySettingKeys = [
        'site_name', 'site_logo',
        'pdf_payment_recipient_name', 'pdf_payment_address_line1', 'pdf_payment_address_line2',
        'pdf_customer_service_phone', 'security_code_placeholder', 'autopay_url',
        'important_news_text', 'scam_warning_text', 'unlimited_calling_text',
        'voice_contact_number', 'customer_service_main_phone',
        'do_not_send_payment_address_line1', 'do_not_send_payment_address_line2',
    ];

    $companySettings = Setting::whereIn('key', $companySettingKeys)->pluck('value', 'key')->all();

    // Logo
    $siteLogoPath = $companySettings['site_logo'] ?? null;
    $siteLogoUrlForPdf = null;

    if ($siteLogoPath && Storage::disk('public')->exists($siteLogoPath)) {
        try {
            $imageContent = Storage::disk('public')->get($siteLogoPath);
            $imageExtension = strtolower(pathinfo(storage_path('app/public/' . $siteLogoPath), PATHINFO_EXTENSION));
            $imageType = in_array($imageExtension, ['jpeg', 'jpg', 'png', 'gif', 'svg', 'webp']) ? $imageExtension : 'png';
            if ($imageType === 'svg') {
                $imageType = 'svg+xml';
            }
            $siteLogoUrlForPdf = 'data:image/' . $imageType . ';base64,' . base64_encode($imageContent);
        } catch (\Exception $e) {
            Log::error("[UserBillingController] Logo encode error: " . $e->getMessage());
        }
    } elseif ($siteLogoPath) {
        Log::warning("[UserBillingController] Site logo '{$siteLogoPath}' not on disk.");
    }

    // Barcode
    $barcodeImageBase64 = null;
    $barcodeDataStringForDisplay = null;

    if (!empty($statement->user->account_number)) {
        $barcodeDataString = (string) $statement->user->account_number;
        $barcodeDataString .= (string) ($statement->statement_number ?? $statement->id);

        $amountForBarcode = str_pad(
            str_replace('.', '', number_format($statement->total_amount, 2, '.', '')),
            10,
            '0',
            STR_PAD_LEFT
        );

        $barcodeDataString .= $amountForBarcode;
        $barcodeDataStringForDisplay = $barcodeDataString;

        try {
            $generator = new BarcodeGeneratorPNG();
            $barcodeImageBase64 = base64_encode(
                $generator->getBarcode($barcodeDataString, $generator::TYPE_CODE_128, 2, 40)
            );
        } catch (\Exception $e) {
            Log::error("[UserBillingController] Barcode gen failed for statement {$statement->id}: " . $e->getMessage());
        }
    } else {
        Log::warning("[UserBillingController] No account number for barcode. Stmt ID: {$statement->id}");
    }

    $dataToPassToView = [
        'statement' => $statement,
        'companySettings' => $companySettings,
        'siteLogoUrl' => $siteLogoUrlForPdf,
        'barcodeImageBase64' => $barcodeImageBase64,
        'barcodeDataStringForDisplay' => $barcodeDataStringForDisplay,
    ];

    try {
        Log::info("[UserBillingController] User ID: {$userId} generating PDF for statement ID: {$statement->id}");

        $pdf = PDF::loadView('pdfs.statement_template', $dataToPassToView);

        $fileName = 'Statement-' .
            ($statement->statement_number ?? $statement->id) . '-' .
            Carbon::parse($statement->statement_date)->format('Y-m-d') . '.pdf';

        return $pdf->download($fileName);
    } catch (\Exception $e) {
        Log::error("[UserBillingController] PDF Gen Exception for statement {$statement->id}: " . $e->getMessage());
        return redirect()->route('my-account.billing.statements')
            ->with('error', 'Could not generate PDF. Please try later.');
    }
}
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Statement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Correct import for Storage facade
use Illuminate\View\View;
use PDF; // Barryvdh\DomPDF\Facade\Pdf
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse; // For type hinting

class UserDashboardController extends Controller
{
    /**
     * Display the regular user's account dashboard content page.
     */
    public function index(): View
    {
        $user = Auth::user();
        if (!$user) {
            // This should ideally be caught by 'auth' middleware
            return redirect()->route('login');
        }

        // Fetch the latest statement. This can be used by the view
        // to construct a link to 'my-account.billing.statement.downloadPdf' for the modal.
        $latestStatementForModal = $user->statements() // Using relationship
            ->orderBy('statement_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        // Billing summary data for the dashboard quick view
        $billingSummary = [
            'balance' => 0.00,
            'next_due_text' => 'Your account is up to date.',
        ];

        $nextUnpaidStatement = $user->statements()
            ->where('status', '!=', 'paid') // Consider more specific payable statuses if needed
            ->orderBy('due_date', 'asc')
            ->where('due_date', '>=', today()->toDateString())
            ->first();

        if ($nextUnpaidStatement) {
            $billingSummary['balance'] = $user->statements()
                ->where('status', '!=', 'paid')
                ->sum('total_amount'); // Sum of all non-paid statement totals

            $billingSummary['next_due_text'] = 'Next payment of $' . number_format($nextUnpaidStatement->total_amount, 2) .
                ' due by ' . Carbon::parse($nextUnpaidStatement->due_date)->format('M d, Y') . '.';
        } else {
            $anyOverdue = $user->statements()
                ->where('status', '!=', 'paid')
                ->where('due_date', '<', today()->toDateString())
                ->exists();

            if ($anyOverdue) {
                $billingSummary['balance'] = $user->statements()
                    ->where('status', '!=', 'paid')
                    ->sum('total_amount');
                $billingSummary['next_due_text'] = 'You have overdue payments.';
            } else {
                $totalUnpaidBalance = $user->statements()
                    ->where('status', '!=', 'paid')
                    ->sum('total_amount');
                if ($totalUnpaidBalance > 0) {
                    $billingSummary['balance'] = $totalUnpaidBalance;
                    $billingSummary['next_due_text'] = 'Please review your account balance.';
                }
            }
        }

        return view('user.dashboard', [ // This should be resources/views/user/dashboard.blade.php
            'user' => $user, // Good to pass the user object
            'latestStatement' => $latestStatementForModal, // For the modal link construction
            'billingSummary' => $billingSummary,
            'active_sidebar_item' => 'dashboard', // Or 'home' if your sidebar partial expects 'home'
            'active_mobile_nav_item' => 'dashboard', // Or 'home'
            'pageTitle' => 'My Account Dashboard'
        ]);
    }

    /**
     * Generate and stream/download the user's LATEST billing statement PDF.
     * Corresponds to the '/my-account/statement' route.
     */
  public function showStatement(Request $request): SymfonyResponse // Type hint for Response
    {
        $user = Auth::user();
        if (!$user) {
            // Should be caught by middleware, but good as a safeguard
            return redirect()->route('login')->with('error', 'Please log in to view statements.');
        }

        $latestStatement = $user->statements() // Using relationship
            ->orderBy('statement_date', 'desc')
            ->orderBy('id', 'desc')
            ->with(['user', 'items']) // Eager load for PDF
            ->first();
            // dd($latestStatement);

        if (!$latestStatement) {
            return redirect()->route('my-account.billing.statements') // Redirect to list if no latest
                ->with('error', 'No statement is currently available to download.');
        }

        try {
            $companySettings = Setting::pluck('value', 'key')->all(); // Example fetch

            // NEW: Extract matched item amounts (case-insensitive exact match)
            $matchDescriptions = [
                'spectrum_tv_select' => 'Spectrum TV Select',
                'entertainment_view' => 'Entertainment View',
                'sports_view' => 'Sports View',
                'spectrum_tenant' => 'Spectrum Tenant',
                'spectrum_internet' => ['Spectrum Internet', 'Internet'], // Matches both
                'spectrum_internet_with_WiFi' => ['Spectrum Internet with WiFi'], // Matches both
                'community_wifi_gig' => 'Community WiFi Gig',
            ];

            // Initialize amounts to 0.00
            $matchedAmounts = array_fill_keys(array_keys($matchDescriptions), 0.00);

            // Loop through statement items and match
            foreach ($latestStatement->items as $item) {
                foreach ($matchDescriptions as $varName => $desc) {
                    $descriptions = is_array($desc) ? $desc : [$desc];
                    foreach ($descriptions as $singleDesc) {
                        if (strcasecmp($item->description, $singleDesc) === 0) {
                            $matchedAmounts[$varName] = $item->amount;
                        }
                    }
                }
            }

            // NEW: Calculate total variables
            $spectrum_tv_total = $matchedAmounts['entertainment_view'] + 
                                 $matchedAmounts['sports_view'] + 
                                 $matchedAmounts['spectrum_tenant'];
            $spectrum_internet_total = $matchedAmounts['spectrum_internet'] + 
                                      $matchedAmounts['spectrum_internet_with_WiFi'] + 
                                      $matchedAmounts['community_wifi_gig'];
            $current_activity_total = $spectrum_tv_total + 
                                     $spectrum_internet_total + 
                                     $matchedAmounts['spectrum_tv_select'];

            $dataToPassToView = [
                'statement' => $latestStatement,
                'companySettings' => $companySettings,
                'spectrum_tv_select' => $matchedAmounts['spectrum_tv_select'],
                'entertainment_view' => $matchedAmounts['entertainment_view'],
                'sports_view' => $matchedAmounts['sports_view'],
                'spectrum_tenant' => $matchedAmounts['spectrum_tenant'],
                'spectrum_internet' => $matchedAmounts['spectrum_internet'],
                'spectrum_internet_with_WiFi' => $matchedAmounts['spectrum_internet_with_WiFi'],
                'community_wifi_gig' => $matchedAmounts['community_wifi_gig'],
                'spectrum_tv_total' => $spectrum_tv_total,
                'spectrum_internet_total' => $spectrum_internet_total,
                'current_activity_total' => $current_activity_total,
            ];

            // CORRECTED VIEW PATH
            $pdf = PDF::loadView('pdfs.statement_template', $dataToPassToView);

            return $pdf->stream('statement-latest-' . ($user->account_number ?? $user->id) . '-' . Carbon::parse($latestStatement->statement_date)->format('Ymd') . '.pdf');
        } catch (\Exception $e) {
            Log::error("UserDashboardController::showStatement - PDF Generation Failed for user ID {$user->id}: " . $e->getMessage(), ['exception' => $e]);
            // Redirect back with an error, or show a generic error page
            return redirect()->route('my-account.index')->with('error', 'Could not generate your statement PDF at this time. Please try again later.');
        }
    }
}
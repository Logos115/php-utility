{{-- resources/views/pdfs/partials/bill_details.blade.php --}}
{{-- This is intended to be Page 2 content --}}
<style>
    @font-face {
        font-family: 'ARIAL';
        src: url('{{ storage_path('fonts/ARIAL.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'AvalonBold';
        src: url('{{ storage_path('fonts/AvalonBold.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
</style>
<div class="bill-details-page-content">
    <table style="width: 100%; border-collapse: collapse;">
        <tr
            style="border-bottom: 2px solid transparent; background: linear-gradient(to right, #0055a5, #00a651); background-clip: padding-box;">
            <!-- Logo -->
            <td style="width: 20%; vertical-align: top; padding: 3px;">
                @php
                    $logoPath = public_path('pdf_logo.png');
                @endphp

                @if(file_exists($logoPath))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}"
                        alt="{{ $companySettings['site_name'] ?? 'Site Logo' }}" style="max-height:70px;margin-top:-15px;margin-left:-15px">
                @else
                    <div>{{ $companySettings['site_name'] ?? 'Logo' }}</div>
                @endif
            </td>

                <!-- Account Number -->
                <td style="width: 25%; vertical-align: top; padding: 3px; text-align: left; white-space: nowrap;">
                    <div style="font-size: 7pt; font-weight: bold; color:'black';font-family:AvalonBold">ACCOUNT NUMBER</div>
                    <div style="font-size: 8pt;font-family:ARIAL">
                        {{ $statement->user->account_number ?? 'N/A' }}
                    </div>
                </td>

                <!-- Statement Date -->
                <td style="width: 20%; vertical-align: top; padding: 3px; text-align: left; white-space: nowrap;">
                    <div style="font-size: 7pt; font-weight: bold; color:'black';font-family:AvalonBold">STATEMENT DATE</div>
                    <div style="font-size: 8pt;font-family:ARIAL">
                        {{ $statement->formatted_statement_date }}
                    </div>
                </td>

                <!-- Service Address -->
                <td style="width: 32%; vertical-align: top; padding: 3px; text-align: left;">
                    <div style="font-size: 7pt; font-weight: bold; color:'black';font-family:AvalonBold">SERVICE ADDRESS</div>
                    <div style="font-size: 8pt; line-height: 1.2;font-family:ARIAL">
                        {{ $statement->user->address }}<br>
                        {{ $statement->user->city }}, {{ $statement->user->state }} {{ $statement->user->zip_code }}
                    </div>
                </td>

                <!-- Page Number -->
                <td style="width: 3%; vertical-align: top; padding: 3px; text-align: left; white-space: nowrap;">
                    <div style="font-size: 7pt; font-weight: bold; color:'black';font-family:AvalonBold">PAGE</div>
                    <div style="font-size: 8pt;">2 of 4</div>
                </td>
        </tr>
    </table>
    <div style="width:100%; height:10px; margin-top:3pt; font-size:0;">
        <div style="width:16.6%; height:3px; background-color:#0378ad; display:inline-block;"></div>
        <div style="width:16.6%; height:3px; background-color:#0d859c; display:inline-block;"></div>
        <div style="width:16.6%; height:3px; background-color:#199288; display:inline-block;"></div>
        <div style="width:16.6%; height:3px; background-color:#26a074; display:inline-block;"></div>
        <div style="width:16.6%; height:3px; background-color:#32ad61; display:inline-block;"></div>
        <div style="width:16.6%; height:3px; background-color:#38b155; display:inline-block;"></div>
    </div>
    {{-- Page Header (Static text, different from fixed repeating header) --}}
    <table class="no-border" style="margin-bottom: 15px;width:400px">
        <tr>
            <td style="width: 50%; vertical-align: bottom;">
                <h1 class="bill-details-title">Your Bill Details</h1>
            </td>
            <td style="width: 50%; text-align: right; font-size: 10pt; vertical-align: bottom;">
                Service from
                {{ ($statement->statement_date) ? \Carbon\Carbon::parse($statement->statement_date)->format('M j') : 'N/A' }}
                -
               {{ ($statement->due_date) ? \Carbon\Carbon::parse($statement->due_date)->format('M j') : 'N/A' }}
                
               
            </td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
        <tr>
            <td style="width:50%; vertical-align: top;">
                {{-- Main Bill Details Box --}}
                    <div class=""
                        style="height: 570px; width: 380px; background-color: white; border: 3px solid #8979b7; border-radius: 10px; display: flex; flex-direction: column;background-color: #00416d">
                        <div style="height: 7%; ;border-top-right-radius: 8px;border-top-left-radius:8px">
                        </div>
                        <div style="height: 84%; display: flex; flex-direction: column;background-color:white;">
                            <div style="height: 13%; background-color: #cccdcf; padding: 0 10px; font-size: 12px;">
                                <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%;padding-top:7px">
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight:200px">
                                            Previous Balance
                                        </td>
                                        <td
                                            style="width: 100%; text-align: center !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;margin-top:3px">
                                            ${{ number_format($statement->previous_balance ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 30%; text-align: left; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                            Remaining Balance
                                        </td>
                                        <td
                                            style="width: 70%; text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                            ${{ number_format(($statement->previous_balance ?? 0.00) - ($statement->payments_received ?? 0.00), 2) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                
                            <div style="padding: 0 10px; margin-top:10px;">
                                <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse;">
                                    <!-- First row (keep same) -->
                                    <tr>
                                        <td
                                            style="text-align: left; font-size: 15px; color: #2b4f6d; font-weight: 400; vertical-align: middle;">
                                            Current Activity
                                        </td>
                                        <td class="text-right"
                                            style="text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="text-align: left; font-size: 12px; color: #2b4f6d; font-weight: 500; vertical-align: middle;width:80%;white-space: nowrap;padding-left:5px">
                                            Community Solutions Services
                                        </td>
                                        <td class="text-right"
                                            style="text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;width:20%">
                
                                        </td>
                                    </tr>
                
                                    <!-- Updated rows with left alignment like your example -->
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 10px;">
                                            Spectrum TV Select
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;padding-left: 27px;">
                                            ${{ number_format($spectrum_tv_select ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 15px;">
                                            Disney+ Basic
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 27px;">
                                            Included
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 30px;padding-left: 15px;">
                                            ViX Premium with Ads
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 27px;">
                                            Included
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 15px;">
                                            Paramount+ Essential
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 27px;">
                                            Included
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 15px;">
                                            Max with Ads
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 27px;">
                                            Included
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 30%; text-align: left; font-size: 12px; color: #2b4f6d; font-weight: 500; vertical-align: middle;white-space: nowrap;margin-top:8px">
                                            Community Solutions Services Total
                                        </td>
                                        <td
                                            style="width: 70%; text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                            ${{ number_format($spectrum_tv_select ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                </table>
                                <!-- Gradient Separator -->
                                <div style="width:100%; height:10px; margin-top:3pt; font-size:0;">
                                    <div style="width:16.6%; height:3px; background-color:#0378ad; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#0d859c; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#199288; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#26a074; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#32ad61; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#38b155; display:inline-block;"></div>
                                </div>
                            </div>
                            <div style="height: 20%; padding: 0 10px;">
                                <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td
                                            style="text-align: left; font-size: 12px; color: #2b4f6d; font-weight: 500; vertical-align: middle;width:80%;white-space: nowrap;">
                                            Spectrum TV®
                                        </td>
                                        <td class="text-right"
                                            style="text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;width:20%">
                
                                        </td>
                                    </tr>
                
                                    <!-- Updated rows with left alignment like your example -->
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 450;padding-left: 5px;">
                                            Entertainment View
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;padding-left: 49px;">
                                            ${{ number_format($entertainment_view ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 450;padding-left: 5px;">
                                            Sports View
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 49px;">
                                            ${{ number_format($sports_view ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 450;padding-left: 30px;padding-left: 5px;">
                                            Spectrum Tenant
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 49px;">
                                            ${{ number_format($spectrum_tenant ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 10px;">
                                            Multi-dvr Service
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 27px;">
                
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 30%; text-align: left; font-size: 12px; color: #2b4f6d; font-weight: 500; vertical-align: middle;white-space: nowrap;margin-top:8px">
                                            Spectrum TV® Total
                                        </td>
                                        <td
                                            style="width: 70%; text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                            ${{ number_format($spectrum_tv_total ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                </table>
                                <!-- Gradient Separator -->
                                <div style="width:100%; height:10px; margin-top:3pt; font-size:0;">
                                    <div style="width:16.6%; height:3px; background-color:#0378ad; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#0d859c; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#199288; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#26a074; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#32ad61; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#38b155; display:inline-block;"></div>
                                </div>
                            </div>
                
                
                            <div style="height: 20%; padding: 0 10px;margin-top:23px">
                                <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td
                                            style="text-align: left; font-size: 12px; color: #2b4f6d; font-weight: 500; vertical-align: middle;width:80%;white-space: nowrap;">
                                            Spectrum Internet®
                                        </td>
                                        <td class="text-right"
                                            style="text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;width:20%">
                
                                        </td>
                                    </tr>
                
                                    <!-- Updated rows with left alignment like your example -->
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 450;padding-left: 5px;">
                                            Spectrum Internet
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;padding-left: 49px;">
                                             ${{ number_format($spectrum_internet ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 450;padding-left: 5px;">
                                            Spectrum Internet
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 49px;">
                                             ${{ number_format($spectrum_internet_with_WiFi ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 10px;">
                                            with WiFi
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 10px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 27px;">
                
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 100%; text-align: left; font-size: 11px; color: #2b4f6d; vertical-align: middle;font-weight: 450;padding-left: 30px;padding-left: 5px;">
                                            Community WiFi Gig
                                        </td>
                                        <td
                                            style="width: 70%; text-align: left !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;font-weight: 400;padding-left: 49px;">
                                             ${{ number_format($community_wifi_gig ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="width: 30%; text-align: left; font-size: 12px; color: #2b4f6d; font-weight: 500; vertical-align: middle;white-space: nowrap;margin-top:8px">
                                            Spectrum Internet® Total
                                        </td>
                                        <td
                                            style="width: 70%; text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                            ${{ number_format($spectrum_internet_total ?? 0.00, 2) }}
                                        </td>
                                    </tr>
                                </table>
                                <!-- Gradient Separator -->
                                <div style="width:100%; height:10px; margin-top:3pt; font-size:0;">
                                    <div style="width:16.6%; height:3px; background-color:#0378ad; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#0d859c; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#199288; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#26a074; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#32ad61; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#38b155; display:inline-block;"></div>
                                </div>
                            </div>
                            
                            
                            <div style="height: 20%; padding: 0 10px;margin-top:23px">
                                <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td
                                            style="width: 30%; text-align: left; font-size: 12px; color: #2b4f6d; font-weight: 500; vertical-align: middle;white-space: nowrap;margin-top:8px">
                                            Taxes, Fees & Charges
                                        </td>
                                        <td
                                            style="width: 70%; text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                            @php
                                                // Original total amount
                                                $originalTotal = $statement->total_amount;
                                            
                                                // Correct tax calculation: 11.25%
                                                $taxAmount = round($originalTotal * 11.25 / 100, 2); // 11.25% of total
                                            
                                                // New total including tax
                                                $totalWithTax = round($originalTotal + $taxAmount, 2);
                                            @endphp
                                            ${{ number_format($taxAmount, 2) }}
                                        </td>
                                    </tr>
                                </table>
                                <!-- Gradient Separator -->
                                <div style="width:100%; height:10px; margin-top:3pt; font-size:0;">
                                    <div style="width:16.6%; height:3px; background-color:#0378ad; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#0d859c; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#199288; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#26a074; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#32ad61; display:inline-block;"></div>
                                    <div style="width:16.6%; height:3px; background-color:#38b155; display:inline-block;"></div>
                                </div>
                            </div>
                
                        </div>
                        <div
                            style="height: 5.3%;border-bottom-right-radius: 8px;border-bottom-left-radius:8px;background-color: #cccdcf;padding: 10px 10px;">
                            <table width=" 100%" cellspacing="0" cellpadding="0" style="width: 100%;">
                                <tr>
                                    <td
                                        style="text-align: left; font-size: 17px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                        Amount Due</td>
                                    <td class="text-right"
                                        style="text-align: right; font-size: 17px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                        ${{ number_format($totalWithTax, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                
                    </div>
            </td>
            <!-- RIGHT BLOCK -->
            <td style="width:50%; vertical-align: top; padding-left: 20px;">
                <div style="height:500px; width:100%; background-color:white; display:flex; flex-direction: column; padding:10px;">
                    
                    <!-- PDF Payment Policy -->
                    @if(!empty($companySettings['pdf_payment_policy_header']))
                        <div style="font-size:14px; font-weight:bold; color:#2b4f6d; margin-bottom:5px;">
                            {!! $companySettings['pdf_payment_policy_header'] !!}
                        </div>
                        
                    @if(!empty($companySettings['pdf_payment_policy_text']))
                        <div style="font-size:12px; font-weight:400; color:#2b4f6d; margin-bottom:15px;">
                            {!! nl2br($companySettings['pdf_payment_policy_text']) !!}
                        </div>
                        <hr style="border: 0; height: 1px; background-color: #c5d6e0; margin: 10px 0;">
                    @endif
            
                    @endif
            
                    <!-- Spectrum TV Section -->
                    @if(!empty($companySettings['pdf_spectrum_tv_header']))
                        <div style="font-size:14px; font-weight:bold; color:#2b4f6d; margin-bottom:5px;">
                            {!! $companySettings['pdf_spectrum_tv_header'] !!}
                        </div>
                        
                        @if(!empty($companySettings['pdf_spectrum_tv_text']))
                            <div style="font-size:12px; font-weight:400; color:#2b4f6d;">
                                {!! nl2br($companySettings['pdf_spectrum_tv_text']) !!}
                            </div>
                            <hr style="border: 0; height: 1px; background-color: #c5d6e0; margin: 10px 0;">
                        @endif
            
                    @endif
            
                </div>
            </td>


         </tr>
    </table>
    {{-- Ways to Pay & Store Info Section --}}
    {{-- Ways to Pay & Store Info Section --}}
    <div class="ways-to-pay-section">
        <table class="no-border">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                    <h3 class="section-heading" style="margin:0 0 8px 0; font-size:16px; color:#003366;">Ways to Pay
                    </h3>

                    {{-- Auto Pay --}}
                    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
                        <tr>
                            <td style="width:14px; vertical-align:top; padding-right:6px;">
                                @php
                                    $iconPath = public_path('icon/icon1.png');
                                @endphp
                                
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($iconPath)) }}"
                                     alt="Icon 1"
                                     style="max-height:30px;">

                            </td>
                            <td style="vertical-align:top;">
                                <span class="bold">Auto Pay:</span> Visit <a
                                    href="{{ $companySettings['autopay_url_link'] ?? '#' }}" class="brand-blue-text"
                                    style="color:#0066cc; text-decoration:none;">{{ $companySettings['autopay_url_text'] ?? 'Spectrum.net/AutoPay' }}</a>.
                                Auto Pay is the easiest way to pay your bill on time every month.
                            </td>
                        </tr>
                    </table>
                    <hr style="border:0; border-top:1px solid #ddd; margin:8px 0;">

                    {{-- App --}}
                    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
                        <tr>
                            <td style="width:14px; vertical-align:top; padding-right:6px;">
                               @php
                                $iconPath = public_path('icon/icon2.png');
                               @endphp
                            
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($iconPath)) }}"
                                 alt="Icon 1"
                                 style="max-height:30px;">

                            </td>
                            <td style="vertical-align:top;">
                                <span class="bold">App:</span> Pay your bill through the My Spectrum App.
                            </td>
                        </tr>
                    </table>
                    <hr style="border:0; border-top:1px solid #ddd; margin:8px 0;">

                    {{-- Online --}}
                    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
                        <tr>
                            <td style="width:14px; vertical-align:top; padding-right:6px;">
                                @php
                                    $iconPath = public_path('icon/icon3.png');
                                @endphp
                                
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($iconPath)) }}"
                                     alt="Icon 1"
                                     style="max-height:30px;">

                            </td>
                            <td style="vertical-align:top;">
                                <span class="bold">Online:</span> Pay your bill online at <a
                                    href="{{ $companySettings['online_billing_url_link'] ?? '#' }}"
                                    class="brand-blue-text"
                                    style="color:#0066cc; text-decoration:none;">{{ $companySettings['online_billing_url_text'] ?? 'Spectrum.net' }}</a>.
                                Want to go paperless? Visit <a
                                    href="{{ $companySettings['paperless_url_link'] ?? '#' }}" class="brand-blue-text"
                                    style="color:#0066cc; text-decoration:none;">{{ $companySettings['paperless_url_text'] ?? 'Spectrum.net/billing' }}</a>.
                            </td>
                        </tr>
                    </table>
                    <hr style="border:0; border-top:1px solid #ddd; margin:8px 0;">

                    {{-- Phone --}}
                    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
                        <tr>
                            <td style="width:14px; vertical-align:top; padding-right:6px;">
                            @php
                                $iconPath = public_path('icon/icon4.png');
                            @endphp
                            
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($iconPath)) }}"
                                 alt="Icon 1"
                                 style="max-height:30px;margin-left:4px">
                            </td>
                            <td style="vertical-align:top;">
                                <span class="bold">Phone:</span> Call the automated payment service at <a
                                    href="tel:{{ $companySettings['phone_payment_number_tel'] ?? '8332676097' }}"
                                    class="brand-blue-text"
                                    style="color:#0066cc; text-decoration:none;">{{ $companySettings['phone_payment_number_display'] ?? '(833) 267-6097' }}</a>.
                            </td>
                        </tr>
                    </table>
                    <hr style="border:0; border-top:1px solid #ddd; margin:8px 0;">

                </td>

                {{-- Store Section (unchanged) --}}
                <td style="width: 50%; vertical-align: top; padding: 10px; border-radius: 4px;">
                    <div class="flex items-center gap-2">
                        @php
                            $iconPath = public_path('icon/icon5.png');
                        @endphp
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($iconPath)) }}"
                             alt="Icon 5"
                             style="max-height:25px; display:inline-block">
                        <h3 style="margin:0; font-size:16px; color:#003366; display:inline-block">Store</h3>
                    </div>

                    <p class="store-address" style="margin:0 0 8px 0;">
                        {{ $companySettings['store_address_line1'] ?? '557 N Afalaya Tr, Ste J03B' }}<br>
                        {{ $companySettings['store_address_line2'] ?? 'Orlando, FL 32828' }}
                    </p>
                    <p class="store-hours" style="margin:0 0 8px 0;">
                        {{ $companySettings['store_hours_display'] ?? 'Store Hours: Mon thru Sat - 10:00am to 8:00pm; Sun - 12:00pm to 5:00pm' }}
                    </p>
                    <p style="margin:0;">
                        <a href="{{ $companySettings['store_locator_url_link'] ?? '#' }}" class="brand-blue-text"
                            style="color:#0066cc; text-decoration:none;">Visit
                            {{ $companySettings['store_locator_url_text'] ?? 'Spectrum.com/stores' }} for additional
                            locations and hours.</a>
                    </p>
                </td>
            </tr>
        </table>
    </div>
    
     @if(isset($barcodeImageBase64) && $barcodeImageBase64)
                            <img src="data:image/png;base64,{{ $barcodeImageBase64 }}" alt="Payment Barcode"
                                class="payment-stub-barcode-image">
                            @endif
                            <div class="payment-stub-barcode-line-bottom">
                                {{ $barcodeDataStringForDisplayLine2 ?? ($statement->user->account_number ?? '') . '0026208385100000000' }}
                            </div>

</div>
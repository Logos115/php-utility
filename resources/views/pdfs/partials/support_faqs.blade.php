{{-- resources/views/pdfs/partials/support_faqs.blade.php --}}
{{-- This is intended to be Page 3 (and potentially Page 4) content --}}
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
<div class="statement-page page-3-plus-content support-faqs-section" style="margin-top:-8px">
    {{-- Optional: Replicating the header info block for context at the top of this page section --}}
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
                    <div style="font-size: 8pt;">3 of 4</div>
                </td>
        </tr>
    </table>

    <h1 class="page-title"
        style="color: #00406E;border:none;font-size:19px;font-weight:bolder;margin-bottom:-5px; margin-left: -5px;">
        Support,
        Bill FAQs and
        Descriptions</h1>

    <table class="no-border content-columns-page3"
        style="border: none; width: 100%; margin-left: -10px; margin-right: -10px;">
        <tr style="border:none">
            {{-- Left Column for Support, FAQs, Descriptions --}}
            <td class="left-column-page3" style="width: 48%; vertical-align: top; padding-right: 15px;">
                <div class="section">
                    <h2 class="section-heading" style="color: #0F3C6A;font-size:14px; margin-bottom: 2px;">Support</h2>
                    <p style="color: #1D4574; font-size: 8pt; margin-top: 0; margin-bottom: 8px;">Visit <a
                            href="{{ $companySettings['support_url_billing_link'] ?? '#' }}">{{ $companySettings['support_url_billing_text'] ?? 'Spectrum.net/billing' }}</a><br>
                        Or, call us at <span class="bold brand-blue-text"
                            style="color:#309ADD">{{ $companySettings['support_phone_main'] ?? '1-855-855-8679' }}</span>
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="bold">Moving
                            Soon?</span><br>
                        Visit <a style="color: #309ADD; font-size: 8pt;"
                            href="{{ $companySettings['support_url_moving_link'] ?? '#' }}">{{ $companySettings['support_url_moving_text'] ?? 'Spectrum.com/easy2move' }}</a>
                        or call us at <span class="bold brand-blue-text"
                            style="color:#309ADD; font-size: 8pt;">{{ $companySettings['support_phone_moving'] ?? '(877) 940-7124' }}</span>
                        for help transferring and setting up your services in your new home.</p>
                </div>

                <div class="section">
                    <h3 class="section-heading" style="font-size: 12px; margin-bottom: 2px;">Bill FAQs</h3>
                    <p style="font-size: 8pt; margin: 0; line-height: 1.2;margin-bottom: 8px;">
                        <span class="sub-heading" style="font-size: 8.5pt; font-weight: bold;">
                            How do billing cycles work?
                        </span>
                        {{ $companySettings['faq_billing_cycle'] ?? 'The service period covered by your first bill statement starts on your first day of service and ends on the 30th day of service. Future months\' bill statements cover service periods which start and end on the same days of the month as the first service period. Charges associated with Pay-Per-View or On Demand purchases will be included on the next service period\'s bill statement.' }}
                    </p>

                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px; line-height:1.2;">
                        <span class="sub-heading" style="font-size: 8.5pt; font-weight: bold;">
                            What happens if I have insufficient funds or a past due balance?
                        </span>
                        {{ $companySettings['faq_insufficient_funds'] ?? 'Spectrum may charge a processing fee for any returned checks and card chargebacks. If your payment method is refused or returned for any reason, we may debit your account for the payment, plus an insufficient funds processing fee as described in your terms of service or video services rate card up to the amount allowable by law and any applicable tax. Your bank account may be debited as early as the same day your payment is refused or returned. If your bank account isn\'t debited, the return check amount (plus fee) must be paid by cash, cashier\'s check or money order.' }}
                    </p>

                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px; line-height:1.2;">
                        <span class="sub-heading" style="font-size: 8.5pt; font-weight: bold;">
                            What if I disagree with a charge?
                        </span>
                        {{ $companySettings['faq_disagree_charge'] ?? 'If you want to dispute a charge, you have 60 days from the billing due date to file a complaint. While it\'s being reviewed, your service will remain active as long as you pay the undisputed part of your bill.' }}
                    </p>

                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px; line-height:1.2;">
                        <span class="sub-heading" style="font-size: 8.5pt; font-weight: bold;">
                            What if my service is interrupted?
                        </span>
                        {{ $companySettings['faq_service_interruption'] ?? 'Unless prevented by situations beyond our control, services will be restored within 24 hours of you being notified.' }}
                    </p>

                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px; line-height:1.2;">
                        You can find all of our terms and conditions at
                        <a href="{{ $companySettings['terms_url_link'] ?? '#' }}">
                            {{ $companySettings['terms_url_text'] ?? 'Spectrum.com/policies' }}
                        </a>.
                    </p>

                </div>

                <div class="section">
                    <h3 class="section-heading" style="font-size: 12px; margin-bottom: 2px;">Descriptions</h3>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Taxes and Fees</span> -
                        {{ $companySettings['desc_taxes_fees'] ?? 'This statement reflects the current taxes and fees for your area (including sales, excise, user taxes, etc.). These taxes and fees may change without notice. Visit Spectrum.net/taxesandfees for more information.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Terms & Conditions</span> -
                        {{ $companySettings['desc_terms_conditions'] ?? 'Spectrum\'s detailed standard terms and conditions for service are located at Spectrum.com/policies.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Insufficient Funds Payment Policy</span> -
                        {{ $companySettings['desc_insufficient_funds'] ?? 'Charter may charge an insufficient funds processing fee for all returned checks and bankcard charge-backs. If your check, bankcard (debit or credit) charge, or other instrument or electronic transfer transaction used to pay us is dishonored, refused or returned for any reason, we may electronically debit your account for the payment, plus an insufficient funds processing fee as set forth in your terms of service or on your Video Services rate card (up to the amount allowable by law and any applicable sales tax). Your bank account may be debited as early as the same day payment is dishonored, refused or returned. If your bank account is not debited, the returned check amount (plus fee) must be replaced by cash, cashier\'s check or money order.' }}
                    </p>
                </div>
            </td>

            {{-- Right Column for Legal Text and Other Info --}}
            <td class="right-column-page3" style="width: 48%; vertical-align: top; padding-left: 15px;">
                <div class="section legal-text-block">
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Programming Changes</span> -
                        {{ $companySettings['legal_programming_changes'] ?? 'For information on any upcoming programming changes, please consult the Legal Notices published in your local newspaper and on Spectrum.net/programmingnotices.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Recording Video Services</span> -
                        {{ $companySettings['legal_recording_video'] ?? 'When you pause or otherwise record any video service (using a set-top device, the Spectrum TV App, or any other means), you are making such copy exclusively for your own personal use, and you are not authorized to use, further reproduce or distribute such copy to any other person or for any other purpose. Furthermore, you are not authorized to make derivative works or public performances or public displays of such copy.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Spectrum Terms and Conditions of Service</span>
                        -
                        {{ $companySettings['legal_spectrum_terms'] ?? 'In accordance with the Spectrum Terms and Conditions of Service, Spectrum services are billed on a monthly basis. Spectrum does not provide credits for monthly subscription services that are cancelled prior to the end of the current billing month.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Spectrum Security Center:</span>
                        {{ $companySettings['legal_security_center'] ?? 'Spectrum offers tools and solutions to keep you and your family safe when connected. Learn how to safeguard your information, detect scams and how to identify fraud alerts. Learn more at Spectrum.net/Security Center.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Billing Practices</span> -
                        {{ $companySettings['legal_billing_practices'] ?? 'Spectrum mails monthly, itemized statements to customers for monthly services that are billed in advance. Customers agree to pay amounts due by the due date indicated on the statement, less any authorized credits. If your monthly statement is not paid by the due date, a late payment processing charge may be imposed. Nonpayment of any portion of any services on this statement could result in disconnection of all of your Spectrum services. Disconnection of Phone service may also result in the loss of your phone number.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Past Due Fee / Late Fee Reminder</span> -
                        {{ $companySettings['legal_late_fee'] ?? 'A late fee will be assessed for past due charges for service.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Complaint Procedures:</span>
                        {{ $companySettings['legal_complaint_procedures'] ?? 'If you disagree with your charges, you need to register a complaint no later than 60 days after the due date on your bill statement.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;"><span class="sub-heading"
                            style="font-size: 8.5pt; font-weight: bold;">Video Closed Captioning Inquiries</span> -
                        {{ $companySettings['legal_closed_captioning'] ?? 'Spectrum provided set-top boxes for video consumption support the ability for the user to enable or disable Closed Captions for customers with hearing impairment.' }}
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;">For immediate closed captioning
                        concerns, call <span
                            class="bold">{{ $companySettings['closed_caption_phone'] ?? '855-70-SPECTRUM' }}</span> or
                        email <a
                            href="mailto:{{ $companySettings['closed_caption_email_addr'] ?? 'closedcaptioningsupport@charter.com' }}">{{ $companySettings['closed_caption_email_text'] ?? 'closedcaptioningsupport@charter.com' }}</a>.
                    </p>
                    <p style="font-size: 8pt; margin-top: 0; margin-bottom: 8px;">
                        {{ $companySettings['closed_caption_complaint_instructions_para1'] ?? 'To report a complaint on an ongoing closed captioning issue, please send your concerns via US Mail to W. Wesselman, Sr. Director, 2 Digital Place, Simpsonville, SC 29681, send a fax to 1-704-697-4935, call 1-877-276-7432 or email closedcaptioningissues@charter.com.' }}
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>



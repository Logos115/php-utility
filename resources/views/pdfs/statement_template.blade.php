2<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Statement #{{ $statement->statement_number ?? $statement->id }}</title>
    <style>
    @font-face {
        font-family: 'OCRAStd';
        src: url('{{ storage_path('fonts/OCRAStd.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
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
    @font-face {
        font-family: 'Avalon';
        src: url('{{ storage_path('fonts/Avalon.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'ARIALBD';
        src: url('{{ storage_path('fonts/ARIALBD.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    @font-face {
        font-family: 'calibri';
        src: url('{{ storage_path("fonts/Calibri/Calibri.ttf") }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'calibri';
        src: url('{{ storage_path("fonts/Calibri/Calibri-Bold.ttf") }}') format('truetype');
        font-weight: bold;
        font-style: normal;
    }
    @font-face {
            font-family: 'ocrb';
            src: url('/fonts/OCRAStd.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

    body {
        font-family: 'calibri', sans-serif;
    }

    @page {
        margin: 0.3in 0.4in 0.5in 0.4in;
        /* Top, Right, Bottom, Left */
    }

    body {
        /* font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; */
        font-size: 7.5pt;
        /* Base font size for density */
        color: #333333;
        /* Main text color */
        line-height: 1.25;
        margin: 0;
    }

    /* --- Fixed Header & Footer --- */
    .page-header-placeholder {
        height: 0.8in;
    }

    /* Space for fixed header + separator */
    .page-footer-placeholder {
        height: 0.35in;
    }

    .header-content {
        position: fixed;
        top: 0.15in;
        /* Adjust if needed */
        left: 0.6in;
        right: 0.6in;
        height: 0.6in;
        /* Adjust if header content + separator need more/less space */
        font-size: 8pt;
    }

    .header-content table.header-table-main {
        /* Target the main table inside header-content */
        width: 100%;
        border-bottom: 1px solid #cccccc;
        /* Separator Line - Light Gray */
        padding-bottom: 5pt;
        /* Space between content and line */
    }

    .page-footer {
        position: fixed;
        bottom: 0.15in;
        left: 0.6in;
        right: 0.6in;
        height: 0.2in;
        text-align: right;
        font-size: 7pt;
        color: #777777;
    }

    .footer-content {
        position: fixed;
        bottom: 0.15in;
        left: 0.6in;
        right: 0.6in;
        height: 0.2in;
        text-align: right;
    }

    .footer-content .page-number:after {
        content: "PAGE "counter(page) " OF "counter(pages);
        font-size: 7pt;
        font-weight: bold;
        color: #4A5568;
    }

    /* --- General & Table Styles --- */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    td,
    th {
        padding: 0;
        vertical-align: top;
        text-align: left;
    }

    .no-border td,
    .no-border th {
        border: none;
    }

    .bold {
        font-weight: bold;
    }

    .text-right {
        text-align: right !important;
    }

    .text-center {
        text-align: center !important;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .brand-blue {
        color: #0067b2;
    }

    /* Primary blue */
    .brand-blue-darker {
        color: #004a80;
    }

    .accent-red {
        color: #d9534f;
    }

    /* For "Do Not Pay" or urgent items */
    .accent-orange {
        color: #f0ad4e;
    }

    /* For due by date if positive balance */
    .subtle-text {
        color: #555555;
    }

    .light-gray-bg {
        background-color: #f0f4f7;
    }

    hr.section-divider {
        border: 0;
        border-top: 1px solid #cccccc;
        margin: 8pt 0;
    }

    /* --- Header Section --- */
    .header-logo-cell {
        width: 30%;
        vertical-align: middle;
    }

    .header-logo {
        max-width: 130px;
        max-height: 28px;
        display: block;
    }

    .header-details-cell {
        width: 70%;
        vertical-align: top;
    }

    .header-details-table {
        font-size: 6.5pt;
    }

    .header-details-table td {
        line-height: 1.1;
        padding: 0 0 0.5pt 4pt;
    }

    .header-details-table td.label {
        color: #666666;
        text-align: left;
        width: 35%;
    }

    /* Labels left-aligned */
    .header-details-table td.value {
        font-weight: bold;
        text-align: left;
    }

    /* Values left-aligned */

    /* --- Main Content (Page 1) --- */
    .greeting {
        font-size: 17pt;
        margin: 12pt 0 8pt 0;
        font-weight: 500;
        color: #4d515aff;
    }

    .main-columns-table td {
        padding: 0;
    }

    .summary-box-column {
        width: 42%;
        padding-right: 10pt;
    }

    /* Adjusted width */
    .info-column {
        width: 58%;
        padding-left: 10pt;
    }

    /* Blue Summary Box */
    .summary-box {
        background-color: #00579e;
        /* Spectrum Bill Dark Blue */
        color: white;
        padding: 10pt 10pt 8pt 10pt;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* dompdf might not render shadow */
    }

    .summary-box-header {
        overflow: auto;
        margin-bottom: 6pt;
    }

    .summary-box-header .amount-due-block {
        float: left;
    }

    .summary-box-header .amount-due-block .label {
        font-size: 8.5pt;
        display: block;
        line-height: 1;
    }

    .summary-box-header .amount-due-block .value {
        font-size: 22pt;
        font-weight: bold;
        line-height: 1;
    }

    .summary-box-header .due-by-block {
        float: right;
        text-align: right;
    }

    .summary-box-header .due-by-block .label {
        font-size: 7pt;
        display: block;
    }

    .summary-box-header .due-by-block .value {
        font-size: 9pt;
        font-weight: bold;
        display: block;
        color: white;
    }

    .summary-box-header .due-by-block .value.alert {
        color: #ffeb3b;
    }

    /* Bright yellow for due date if > 0 */
    .summary-box-header .due-by-block .value.do-not-pay {
        color: #b0bec5;
    }

    .summary-details {
        background-color: #f8f9fa;
        /* Lighter than white for contrast */
        color: #2d3748;
        padding: 7pt;
        margin-top: 7pt;
        border-radius: 2px;
    }

    .summary-details .title-bar {
        overflow: auto;
        margin-bottom: 3pt;
    }

    .summary-details .title {
        font-size: 7.5pt;
        color: #00579e;
        font-weight: bold;
        float: left;
    }

    .summary-details .service-period {
        font-size: 6.5pt;
        color: #00579e;
        float: right;
        font-weight: bold;
    }

    .summary-details table {
        font-size: 7.5pt;
        margin-bottom: 4pt;
    }

    .summary-details table td {
        padding: 1.5pt 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .summary-details table tr:last-child td {
        border-bottom: none;
    }

    .summary-details .current-activity-title {
        font-weight: bold;
        margin-top: 6pt;
        margin-bottom: 2pt;
        font-size: 7.5pt;
        color: #333740;
    }

    .summary-details .total-due-row td {
        font-weight: bold;
        background-color: #d6e6f2;
        /* Light blue accent */
        color: #004a80;
        padding: 4pt 0 !important;
        font-size: 8.5pt;
        border-top: 1px solid #b0c4de;
    }

    /* Right Panel Info */
    .info-column .section {
        margin-bottom: 10pt;
    }

    .info-column .section h4 {
        color: #00579e;
        font-size: 8pt;
        margin-bottom: 1pt;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-column .section p {
        margin-top: 0;
        margin-bottom: 4pt;
        font-size: 7pt;
        line-height: 1.2;
    }

    .info-column .section a {
        color: #0067b2;
        text-decoration: none;
        font-weight: 500;
    }

    /* Promo Section */
    .promo-section {
        text-align: center;
        margin: 15pt 0;
        padding: 8pt 0;
        border-top: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
    }

    .promo-section h3 {
        color: #0067b2;
        font-size: 10pt;
        margin-bottom: 2pt;
    }

    .promo-section p {
        font-size: 7pt;
        margin-bottom: 2pt;
        color: #4a5568;
        line-height: 1.2;
    }

    /* Payment Stub */
    .payment-stub-wrapper {
        margin-top: 15pt;
        padding-top: 8pt;
        font-size: 7pt;
    }

    .payment-stub-detach-text {
        text-align: center;
        font-size: 6pt;
        margin-bottom: 6pt;
        color: #4a5568;
    }

    .payment-stub-logo-container {
        width: 40%;
    }

    .payment-stub-logo {
        max-width: 100px;
        margin-bottom: 3pt;
    }

    .payment-stub-warning {
        font-size: 6pt;
        color: #c53030;
        font-weight: bold;
        margin-bottom: 1pt;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .payment-stub-return-address p {
        margin: 0;
        font-size: 6.5pt;
        line-height: 1.1;
    }

    .payment-stub-user-address {
        margin-top: 5pt;
    }

    .payment-stub-user-address p {
        margin: 0;
        font-size: 7pt;
        line-height: 1.15;
    }

    .payment-stub-details-container {
        width: 60%;
        padding-left: 15pt;
    }

    .payment-stub-details-table td {
        font-size: 7.5pt;
        padding: 1pt 0;
        line-height: 1.2;
    }

    .payment-stub-details-table .due-by-value {
        background-color: #e0e0e0;
        padding: 2pt 4pt !important;
        text-align: center !important;
    }

    .payment-stub-payto-address {
        margin-top: 6pt;
        text-align: left;
        font-size: 7pt;
    }

    .payment-stub-payto-address p {
        margin: 0;
        line-height: 1.15;
    }

    .payment-stub-barcode-text {
        text-align: center;
        font-family: 'Courier New', Courier, monospace;
        font-size: 8pt;
        margin-top: 5pt;
        letter-spacing: 0.5px;
        word-wrap: break-word;
    }

    .payment-stub-barcode-image {
        display: block;
        margin: 3pt auto 0 auto;
        max-height: 25px;
    }

    .page-break {
        page-break-after: always;
    }

    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    .bill-details-page-content {
        /* Styles specific to page 2 if needed, or rely on general styles */
    }

    .bill-details-title {
        font-size: 16pt;
        /* Increased size */
        color: #0056b3;
        /* Darker blue */
        font-weight: normal;
        /* Not bold in example */
        margin: 0;
        padding: 0;
        line-height: 1;
    }

    .bill-details-box {
        border: 1px solid #0056b3;
        /* Dark blue border */
        border-radius: 6px;
        /* Rounded corners */
        overflow: hidden;
        /* To make border-radius clip content */
        margin-bottom: 20px;
    }

    .activity-table {
        width: 100%;
        font-size: 8pt;
        border-collapse: collapse;
        /* Important */
    }

    .activity-table th,
    .activity-table td {
        padding: 5px 8px;
        /* Uniform padding */
        text-align: left;
        border: none;
        /* Remove individual cell borders for this style */
    }

    .activity-table thead tr th {
        font-weight: bold;
    }

    .balance-header-row {
        background-color: #0056b3;
        /* Dark blue */
        color: white;
    }

    .balance-header-row th {
        font-size: 9pt;
        /* Slightly larger */
        border-bottom: 1px solid white;
        /* Separator */
    }

    .balance-header-row:last-of-type th {
        /* Remove bottom border from last header row */
        border-bottom: none;
    }


    .activity-main-header-row {
        background-color: #f0f0f0;
        /* Light gray */
        color: #333;
    }

    .activity-main-header-row th {
        font-weight: bold;
        border-bottom: 1px solid #0056b3;
        /* Dark blue line under "Current Activity" */
    }

    .category-title-row td {
        background-color: transparent;
        /* No background for category title */
        color: #0056b3;
        /* Dark blue text */
        font-weight: bold;
        font-size: 9pt;
        padding-top: 8px !important;
        /* More space above category */
        padding-bottom: 3px !important;
        border-bottom: 1px solid #0073e6;
        /* Blue line under category title */
    }

    .item-description {
        padding-left: 8px;
        /* Indent item description */
        color: #333;
    }

    .item-description .included-note {
        font-size: 7pt;
        color: #555;
        margin-left: 5px;
    }

    .item-amount {
        color: #333;
    }

    .category-total-row td {
        font-weight: bold;
        color: #004990;
        /* Darker blue */
        border-top: 1px solid #0073e6;
        /* Blue line above category total */
        padding-top: 4px !important;
        padding-bottom: 6px !important;
    }

    .amount-due-footer-row {
        background-color: #0056b3;
        /* Dark blue */
        color: white;
    }

    .amount-due-footer-row td {
        font-size: 10pt;
        font-weight: bold;
    }

    /* Ways to Pay Section */
    .ways-to-pay-section {
        margin-top: 25px;
        font-size: 8pt;
        border-top: 1px solid #e0e0e0;
        /* Light separator line */
        padding-top: 15px;
    }

    .ways-to-pay-section .section-heading {
        font-size: 11pt;
        color: #333;
        font-weight: bold;
        margin-bottom: 8px;
        display: flex;
        /* For icon alignment */
        align-items: center;
    }

    .ways-to-pay-section .payment-option {
        margin-bottom: 6px;
        display: flex;
        /* For icon alignment */
        align-items: flex-start;
    }

    .ways-to-pay-section .payment-icon {
        margin-right: 8px;
        font-size: 12pt;
        /* Adjust icon size */
        color: #0073e6;
        /* Blue icons */
        width: 20px;
        /* Fixed width for alignment */
        text-align: center;
    }

    .ways-to-pay-section .store-address {
        margin-bottom: 4px;
    }

    .ways-to-pay-section .store-hours {
        font-size: 7.5pt;
        color: #555;
        margin-bottom: 6px;
    }

    .page3-header-info {
        /* Specific styling for the repeated header on page 3 if needed */
        margin-bottom: 5px;
        /* Less margin than full page header */
    }

    .header-divider-page3 {
        border: 0;
        border-top: 1px solid #cccccc;
        margin-bottom: 15px;
    }

    .support-faqs-section .page-title {
        font-size: 14pt;
        /* Matching Spectrum bill's "Support, Bill FAQs and Descriptions" title */
        color: #0056b3;
        font-weight: 500;
        /* Not bold in example */
        border-bottom: 2px solid #0056b3;
        padding-bottom: 5px;
        margin-bottom: 12px;
    }

    .support-faqs-section .content-columns-page3>tbody>tr>td {
        vertical-align: top;
        padding: 0;
    }

    .support-faqs-section .left-column-page3 {
        width: 49%;
        /* Adjust for balance */
        padding-right: 10px;
        /* Space between columns */
    }

    .support-faqs-section .right-column-page3 {
        width: 49%;
        padding-left: 10px;
        /* Space between columns */
    }

    .support-faqs-section .section {
        margin-bottom: 10px;
        /* Space between major sections like Support, Bill FAQs, Descriptions */
    }

    .support-faqs-section .section-heading {
        /* For "Support", "Bill FAQs", "Descriptions" */
        font-size: 11pt;
        color: #0056b3;
        margin-bottom: 5px;
        font-weight: 500;
        /* Less bold than sub-headings */
    }

    .support-faqs-section p {
        margin-top: 0;
        margin-bottom: 6px;
        /* Space between paragraphs */
        font-size: 7.5pt;
        line-height: 1.3;
        color: #333333;
        /* Darker text for readability */
    }

    .support-faqs-section p .sub-heading,
    .support-faqs-section .sub-heading {
        /* For "How do billing cycles work?", "Taxes and Fees" etc. */
        font-weight: bold;
        color: #000000;
        /* Black for these sub-headings */
        display: block;
        /* Make it take its own line if needed, or inline if preferred */
        margin-bottom: 1px;
        /* Little space before the paragraph */
    }

    .support-faqs-section .left-column-page3 p .sub-heading {
        /* Make FAQ questions slightly more prominent */
        font-size: 8pt;
    }

    .support-faqs-section a {
        color: #0073e6;
        text-decoration: none;
        /* Often better for PDFs */
    }

    .support-faqs-section .bold {
        /* Generic bold for phone numbers etc. */
        font-weight: bold;
    }

    .support-faqs-section .brand-blue-text {
        /* For specific blue text like phone numbers if desired */
        color: #0073e6;
    }

    /* Styles for the denser legal text on the right */
    .support-faqs-section .right-column-page3 .section.legal-text-block p {
        font-size: 7pt;
        /* Smaller for dense legal text */
        line-height: 1.25;
        margin-bottom: 5px;
    }

    .support-faqs-section .right-column-page3 .section.legal-text-block p .sub-heading {
        font-size: 7.5pt;
        /* Sub-headings in legal text slightly larger than paragraph */
        color: #000000;
        display: inline;
        /* Keep them inline with the start of the paragraph */
        margin-bottom: 0;
    }

    .support-faqs-section {
        margin-top: 10px;
        font-size: 7.5pt;
        /* Slightly smaller base font for this dense page */
        line-height: 1.35;
        /* Adjust line height for readability */
    }

    .support-faqs-section .page-title {
        /* For "Support, Bill FAQs and Descriptions" */
        font-size: 13pt;
        color: #0056b3;
        /* Spectrum blue */
        font-weight: 500;
        border-bottom: 2px solid #0056b3;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    .support-faqs-section .content-columns-page3>tbody>tr>td {
        vertical-align: top;
        padding: 0;
        /* Remove default padding if any */
    }

    .support-faqs-section .left-column-page3 {
        width: 48%;
        /* Adjust as needed */
        padding-right: 2%;
        /* Create a gutter */
    }

    .support-faqs-section .right-column-page3 {
        width: 48%;
        padding-left: 2%;
        /* Create a gutter */
    }

    .support-faqs-section .section {
        margin-bottom: 12px;
        /* Space between major sections */
    }

    .support-faqs-section .section-heading {
        /* For "Support", "Bill FAQs", "Descriptions" */
        font-size: 10pt;
        /* Made slightly smaller than page-title */
        color: #0056b3;
        /* Spectrum blue */
        margin-bottom: 6px;
        font-weight: bold;
        /* Make these main headings bold */
        padding-top: 5px;
        /* Add a bit of space above if it's not the first section */
    }

    .support-faqs-section .section:first-child .section-heading {
        padding-top: 0;
        /* No extra top padding for the very first section heading */
    }


    .support-faqs-section p {
        margin-top: 0;
        margin-bottom: 7px;
        /* Consistent paragraph spacing */
        color: #383838;
        /* Slightly softer black for text */
    }

    .support-faqs-section p .sub-heading,
    .support-faqs-section .sub-heading {
        /* For "How do billing cycles work?", "Taxes and Fees" etc. */
        font-weight: bold;
        color: #000000;
        /* Black and bold for these sub-titles */
        display: block;
        /* Ensures it's on its own line before the paragraph */
        margin-bottom: 2px;
        /* Small space after the sub-heading */
        font-size: 8pt;
        /* Slightly larger than paragraph text */
    }

    /* Specifically for the right column (legal text) to make it denser if needed */
    .support-faqs-section .right-column-page3 .section p {
        font-size: 7pt;
        /* Even smaller for very dense legal text */
        line-height: 1.25;
        margin-bottom: 4px;
    }

    .support-faqs-section .right-column-page3 .section p .sub-heading {
        font-size: 7.5pt;
        /* Sub-headings in legal text */
        display: inline;
        /* Keep these inline with the paragraph start */
        margin-right: 3px;
    }


    .support-faqs-section a {
        color: #0073e6;
        text-decoration: none;
    }

    .support-faqs-section a:hover {
        /* Hover won't show in PDF, but good for HTML preview */
        text-decoration: underline;
    }

    .support-faqs-section .bold {
        font-weight: bold;
    }

    .support-faqs-section .brand-blue-text {
        color: #0073e6;
    }

    .header-fixed {
        width: 100%;
        margin-bottom: 15px;
        position: relative;
        /* Change from fixed */
        top: 0;
        left: 0;
    }

    .footer-fixed {
        position: relative;
        /* Change from fixed */
        bottom: 0;
        width: 100%;
        text-align: right;
        margin-top: 15px;
    }
    </style>
</head>

<body>
       @php
                                                                // Original total amount
                                                                $originalTotal = $statement->total_amount;
                                                            
                                                                // Correct tax calculation: 11.25%
                                                                $taxAmount = round($originalTotal * 11.25 / 100, 2); // 11.25% of total
                                                            
                                                                // New total including tax
                                                                $totalWithTax = round($originalTotal + $taxAmount, 2);
                                                            @endphp
    {{-- Fixed Header Content (repeats on each page) --}}
    <div class="header-fixed" style="margin-bottom: 0px; height:50px">
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
                    <div style="font-size: 7pt; font-weight: bold; color:#2b4f6d;font-family:AvalonBold">ACCOUNT NUMBER</div>
                    <div style="font-size: 8pt;font-family:ARIAL">
                        {{ strtoupper($statement->user->account_number) ?? 'N/A' }}
                    </div>
                </td>

                <!-- Statement Date -->
                <td style="width: 20%; vertical-align: top; padding: 3px; text-align: left; white-space: nowrap;">
                    <div style="font-size: 7pt; font-weight: bold; color:#2b4f6d;font-family:AvalonBold">STATEMENT DATE</div>
                    <div style="font-size: 8pt;font-family:ARIAL">
                        {{ strtoupper(Carbon\Carbon::parse($statement->statement_date)->format('M j, Y')) }}
                    </div>
                </td>

                <!-- Service Address -->
                <td style="width: 32%; vertical-align: top; padding: 3px; text-align: left;">
                    <div style="font-size: 7pt; font-weight: bold; color:#2b4f6d;font-family:AvalonBold">SERVICE ADDRESS</div>
                    <div style="margin:0;color:#2b4f6d;font-size:8pt;">
                        {{ strtoupper($statement->user->address) }}<br>
                        {{ strtoupper($statement->user->city) }}, {{ strtoupper($statement->user->state) }} {{ strtoupper($statement->user->zip_code) }}
                    </div>
                </td>

                <!-- Page Number -->
                <td style="width: 3%; vertical-align: top; padding: 3px; text-align: left; white-space: nowrap;">
                    <div style="font-size: 7pt; font-weight: bold; color:'black';font-family:AvalonBold">PAGE</div>
                    <div style="font-size: 8pt;">1 of 4</div>
                </td>
            </tr>
        </table>

        <!-- Separator line -->
        <div style="width:100%; height:10px; margin-top:3pt; font-size:0;">
            <div style="width:16.6%; height:3px; background-color:#0378ad; display:inline-block;"></div>
            <div style="width:16.6%; height:3px; background-color:#0d859c; display:inline-block;"></div>
            <div style="width:16.6%; height:3px; background-color:#199288; display:inline-block;"></div>
            <div style="width:16.6%; height:3px; background-color:#26a074; display:inline-block;"></div>
            <div style="width:16.6%; height:3px; background-color:#32ad61; display:inline-block;"></div>
            <div style="width:16.6%; height:3px; background-color:#38b155; display:inline-block;"></div>
        </div>




    </div>



    {{-- Fixed Footer Content (repeats on each page) --}}
    <!-- <div class="footer-fixed">
        <div class="page-number"></div>
    </div> -->

    {{-- Main Content Wrapper Table (DomPDF trick for header/footer spacing) --}}
    <table style="width:100%;">
        <!-- <thead>
            <tr>
                <td>
                    <div class="page-header-placeholder"></div>
                </td>
            </tr>
        </thead> -->
        <tbody>
            <tr>
                <td>
                    {{-- === PAGE 1 CONTENT === --}}
                    <div class="statement-page page-1-content">
                        <div class="greeting">Hi, {{ $statement->user->first_name ?? 'Valued Customer' }}!</div>

                        <table class="main-content-layout no-border">
                            <tr>
                                <td class="summary-box-column">
                                    <div class=""
                                        style="height: 380px; width: 340px; background-color: white; border: 3px solid #8979b7; border-radius: 10px; display: flex; flex-direction: column;background-color: #00416d">
                                        <div
                                            style="height: 13%; ;border-top-right-radius: 8px;border-top-left-radius:8px">
                                        </div>
                                        <div
                                            style="height: 70%; display: flex; flex-direction: column;background-color:white;">
                                            <div
                                                style="height: 17%; background-color: #cccdcf; padding: 0 10px; font-size: 12px;">
                                                <table width="100%" cellspacing="0" cellpadding="0"
                                                    style="width: 100%;">
                                                    <tr>
                                                        <td style="text-align: left;color:#2b4f6d;font-weight:bold;">
                                                            Amount Due</td>
                                                        <td style="text-align: right;color:#2b4f6d;font-weight:bold;">
                                                            Due by</td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="text-align: left; font-size: 16px;color:#2b4f6d;font-weight:bold;">
                                                             ${{ number_format($totalWithTax, 2) }}
                                                        </td>
                                                        <td style="text-align: right; font-size: 16px;color:#2b4f6d;font-weight:bold;"
                                                            class="{{ !($statement->due_date && $statement->total_amount > 0) ? 'do-not-pay' : (($statement->due_date < now()->subDay() && $statement->total_amount > 0 && ($statement->status ?? 'issued') !== 'paid') ? 'alert' : '') }}">
                                                            {{ ($statement->due_date && $totalWithTax > 0) ? $statement->formatted_due_date : 'Do Not Pay' }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div
                                                style="width: 100%; padding: 5px 10px; font-size: 12px; color: #2b4f6d; font-weight: bold; box-sizing: border-box;">
                                                <table style="width: 100%; border-collapse: collapse;">
                                                    <tr>
                                                        <!-- Left text -->
                                                        <td
                                                            style="text-align: left; vertical-align: top;font-size:15px;">
                                                            How It Adds Up
                                                        </td>
                                                        <!-- Right text -->
                                                        <td
                                                            style="text-align: center; vertical-align: top; white-space: normal; left;color:#2b4f6d;font-weight:bold;font-size:8pt">
                                                            Service from
                                                            {{ ($statement->billing_start_date) ? \Carbon\Carbon::parse($statement->billing_start_date)->format('M j') : 'N/A' }}
                                                            -
                                                            {{ ($statement->billing_end_date) ? \Carbon\Carbon::parse($statement->billing_end_date)->format('M j') : 'N/A' }}
                                                        
                                                        
                                                            
                                                        
        
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- Gradient Separator -->
                                                <div
                                                    style="width:100%; height:2px; margin-top:3pt; font-size:0;width:94%">
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#0378ad; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#0d859c; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#199288; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#26a074; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#32ad61; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#38b155; display:inline-block;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="height: 20%; padding: 0 10px;">
                                                <table width="100%" cellspacing="0" cellpadding="0"
                                                    style="width: 100%; border-collapse: collapse;">
                                                    <tr>
                                                        <td
                                                            style="width: 100%; text-align: left; font-size: 12px; color: #2b4f6d; vertical-align: middle;">
                                                            Previous Balance
                                                        </td>
                                                        <td
                                                            style="width: 70%; text-align: center !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;">
                                                            ${{ number_format($statement->previous_balance ?? 0.00, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="width: 100%; text-align: left; font-size: 12px; color: #2b4f6d; vertical-align: middle;">
                                                            Payments Received
                                                        </td>
                                                        <td
                                                            style="width: 100%; text-align: center !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;">
                                                            -${{ number_format($statement->payments_received ?? 0.00, 2) }}
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
                                                <!-- Gradient Separator -->
                                                <div
                                                    style="width:100%; height:2px; margin-top:3pt; font-size:0;width:100%;margin-bottom:0px">
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#0378ad; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#0d859c; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#199288; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#26a074; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#32ad61; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#38b155; display:inline-block;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="padding: 0 10px; margin-top:4px;">
                                                <table width="100%" cellspacing="0" cellpadding="0"
                                                    style="width: 100%; border-collapse: collapse;">
                                                    <!-- First row (keep same) -->
                                                    <tr>
                                                        <td
                                                            style="text-align: left; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                                            Current Activity
                                                        </td>
                                                        <td class="text-right"
                                                            style="text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                                            ${{ number_format($current_activity_total ?? 0.00, 2) }}
                                                        </td>
                                                    </tr>

                                                    <!-- Updated rows with left alignment like your example -->
                                                    <tr>
                                                        <td
                                                            style="width: 70%; text-align: left; font-size: 12px; color: #2b4f6d; vertical-align: middle;">
                                                            Community Solution Service
                                                        </td>
                                                        <td
                                                            style="width: 70%; text-align: center !important; font-size: 12px; color: #2b4f6d; vertical-align: middle;">
                                                            ${{ number_format($spectrum_tv_select ?? 0.00, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="text-align: left; vertical-align: top; font-size: 11px; color: #2b4f6d;">
                                                            Spectrum TV
                                                        </td>
                                                        <td
                                                            style="text-align: center; vertical-align: top; white-space: normal; font-size: 11px; color: #2b4f6d;">
                                                            ${{ number_format($spectrum_tv_total ?? 0.00, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="text-align: left; vertical-align: top; font-size: 11px; color: #2b4f6d;">
                                                            Spectrum Internet
                                                        </td>
                                                        <td
                                                            style="text-align: center !important; vertical-align: top; white-space: normal; font-size: 11px; color: #2b4f6d;">
                                                            ${{ number_format($spectrum_internet_total ?? 0.00, 2) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                                 <!-- Gradient Separator -->
                                                <div
                                                    style="width:100%; height:2px; margin-top:3pt; font-size:0;width:100%;margin-bottom:0px">
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#0378ad; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#0d859c; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#199288; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#26a074; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#32ad61; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#38b155; display:inline-block;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="padding: 0 10px; margin-top:4;">
                                                <table width="100%" cellspacing="0" cellpadding="0"
                                                    style="width: 100%; border-collapse: collapse;">
                                                    <!-- First row (keep same) -->
                                                    <tr>
                                                        <td
                                                            style="width: 30%; text-align: left; font-size: 12px; color: #2b4f6d; font-weight: 500; vertical-align: middle;white-space: nowrap;margin-top:8px">
                                                            Taxes, Fees & Charges
                                                        </td>
                                                        <td
                                                            style="width: 70%; text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                                         
                                                            ${{ number_format($taxAmount, 2) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                                  <!-- Gradient Separator -->
                                                <div
                                                    style="width:100%; height:2px; margin-top:3pt; font-size:0;width:100%;margin-bottom:0px">
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#0378ad; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#0d859c; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#199288; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#26a074; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#32ad61; display:inline-block;">
                                                    </div>
                                                    <div
                                                        style="width:16.6%; height:2px; background-color:#38b155; display:inline-block;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                style="height: 9%; background-color: #cccdcf; padding: 10px 10px; font-size: 12px;margin-top:3px;">
                                                <table width=" 100%" cellspacing="0" cellpadding="0"
                                                    style="width: 100%;">
                                                    <tr>
                                                        <td
                                                            style="text-align: left; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                                            Amount Due</td>
                                                        <td class="text-right"
                                                            style="text-align: right; font-size: 14px; color: #2b4f6d; font-weight: bold; vertical-align: middle;">
                                                            ${{ number_format($totalWithTax, 2) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div
                                            style="height: 15%; ;border-bottom-right-radius: 8px;border-bottom-left-radius:8px">
                                        </div>
                                        <!-- <div class="summary-box-header">
                                            <div class="amount-due-block">
                                                <span class="label">Amount Due</span>
                                                <span
                                                    class="value">${{ number_format($statement->total_amount, 2) }}</span>
                                            </div>
                                            <div class="due-by-block">
                                                <span class="label">Due by</span>
                                                <span
                                                    class="value {{ !($statement->due_date && $statement->total_amount > 0) ? 'do-not-pay' : (($statement->due_date < now()->subDay() && $statement->total_amount > 0 && ($statement->status ?? 'issued') !== 'paid') ? 'alert' : '') }}">
                                                    {{ ($statement->due_date && $statement->total_amount > 0) ? $statement->formatted_due_date : 'Do Not Pay' }}
                                                </span>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>
                                        <div class="summary-details">
                                            <div class="title-bar">
                                                <span class="title">How It Adds Up</span>
                                                <span class="service-period">Service from
                                                    {{ $statement->service_period_start ? \Carbon\Carbon::parse($statement->service_period_start)->format('M j') : 'N/A' }}
                                                    -
                                                    {{ $statement->service_period_end ? \Carbon\Carbon::parse($statement->service_period_end)->format('M j, Y') : 'N/A' }}</span>
                                            </div>
                                            <table>
                                                <tr>
                                                    <td>Previous Balance</td>
                                                    <td class="text-right">
                                                        ${{ number_format($statement->previous_balance ?? 0.00, 2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Payments Received</td>
                                                    <td class="text-right">
                                                        -${{ number_format($statement->payments_received ?? 0.00, 2) }}
                                                    </td>
                                                </tr>
                                                <tr class="bold">
                                                    <td>Remaining Balance</td>
                                                    <td class="text-right">
                                                        ${{ number_format(($statement->previous_balance ?? 0.00) - ($statement->payments_received ?? 0.00), 2) }}
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="current-activity-title">Current Activity</div>
                                            <table>
                                                @forelse($statement->items as $item)
                                                    <tr>
                                                        <td>{{ Str::limit($item->description, 35) }}</td>
                                                        <td class="text-right">${{ number_format($item->amount, 2) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center" style="padding:8pt 0;">No
                                                            current activity items.</td>
                                                    </tr>
                                                @endforelse
                                                <tr class="total-due-row">
                                                    <td>Amount Due</td>
                                                    <td class="text-right">
                                                        ${{ number_format($statement->total_amount, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div> -->
                                    </div>
                                </td>
                                <td class="info-column">
                                    <div class="section">
                                        <h1 style="color: #003f6a;">IMPORTANT NEWS</h1>
                                        <p class="bold brand-blue-text" style="font-size: 14px;color:#1a4e82">Enroll in
                                            Auto Pay
                                            today!</p>
                                        <p style="color: #363f47ff; font-size: 14px;">
                                            {{ $companySettings['important_news_autopay_text'] ?? 'Spectrum Auto Pay is a convenient way to pay your bill on time every month without the hassle of buying stamps or writing checks. Visit' }}
                                            <a
                                                href="{{ $companySettings['autopay_url_link'] ?? '#' }}">{{ $companySettings['autopay_url_text'] ?? 'Spectrum.net/autopay' }}</a>.
                                        </p>
                                    </div>
                                    <hr class="section-divider">
                                    <div class="section">
                                        <h2 style="font-size: 14px;color:#1a4e82">BEWARE OF PAYMENT SCAMS!</h2>
                                        <p style="color: #363f47ff; font-size: 14px;">
                                            {{ $companySettings['scam_warning_text'] ?? 'Spectrum is dedicated to keeping you and your family safe online. Visit' }}
                                            <a
                                                href="{{ $companySettings['scam_security_url_link'] ?? '#' }}">{{ $companySettings['scam_security_url_text'] ?? 'Spectrum.net/securitycenter' }}</a>
                                            {{ $companySettings['scam_warning_suffix'] ?? 'for tools and solutions to keep your personal information secure.' }}
                                        </p>
                                    </div>
                                    <hr class="section-divider">
                                    <div class="section" style="font-family: Arial, sans-serif; padding: 20px;">

                                        <!-- Gradient Heading -->
                                        <h2 style="margin:0; font-size:20px; font-weight:bold;">
                                            <span style="color:#34ad5f;">Unlimited</span>
                                            <span style="color:#0378ad;">calling.</span><br>
                                            <span style="color:#34ad5f;">Unlimited</span>
                                            <span style="color:#0378ad;">connections.</span>
                                        </h2>


                                        <!-- Sub Text -->
                                        <p style="font-size: 9px; color: #333; margin: 10px 0 20px 0;">
                                            Stay in touch with friends and family with unlimited nationwide calling and
                                            28 popular features.
                                        </p>

                                        <!-- Call to Action -->
                                        <p style="font-size: 10px; font-weight: bold; color: #1a237e; margin: 0;">
                                            Call 1-877-470-6728 to add Spectrum Voice<sup>®</sup>.
                                        </p>

                                        <!-- Divider Line -->
                                        <hr style="margin-top: 15px; border: none; border-top: 1px solid #ccc;">
                                    </div>
                                    <!-- <hr class="section-divider"> -->
                                </td>
                            </tr>
                        </table>


                        <div class="payment-stub-wrapper">
                            <p class="payment-stub-detach-text" style="font-size:9px;">Detach the included payment stub
                                and enclose it with a
                                check made payable to Spectrum. If you have questions about your account, call us at
                                {{ $companySettings['customer_service_main_phone'] ?? '(855) 757-7328' }}.</p>
                            <hr class="section-divider">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <!-- LEFT SECTION -->
                                    <td style="width:50%; vertical-align:top; padding:10px; ">
                                        <!-- Logo -->
                                        <div style="margin-bottom:10px;">
                                            @php
                                                $logoPath = public_path('pdf_logo.png');
                                            @endphp

                                            @if(file_exists($logoPath))
                                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}"
                                                    alt="{{ $companySettings['site_name'] ?? 'Site Logo' }}"
                                                   style="max-height:70px;margin-left:-15px">
                                            @else
                                                <div>{{ $companySettings['site_name'] ?? 'Logo' }}</div>
                                            @endif
                                        </div>

                                        <!-- Do Not Send Payments -->
                                        <div style="margin-bottom:10px;margin-top:-10px">
                                            <p style="margin:0; font-size:10pt; font-weight:bold; color:red;">
                                                DO NOT SEND PAYMENTS TO THIS ADDRESS
                                            </p>
                                            <p style="margin:0;color:#03406C">
                                                {{ $companySettings['do_not_send_payment_address_line1'] ?? '4145 S. FALKENBURG RD' }} {{ $companySettings['do_not_send_payment_address_line2'] ?? 'RIVERVIEW FL 33578-8652' }}
                                            </p>
                                            <!--<p style="margin:0;">-->
                                            <!--    {{ $companySettings['do_not_send_payment_address_line2'] ?? 'RIVERVIEW FL 33578-8652' }}-->
                                            <!--</p>-->
                                        </div>

                                        <!-- User Address -->
                                        <div style="font-size:8pt; color: #6ca9d2;font-family:ARIAL;font-size: 8.5pt;">
                                         
                                            <p style="margin:0; font-weight:bold;color:#03406C">{{ strtoupper($statement->user->full_name) }}
                                            </p>
                                            
                                            <p style="margin:0;color:#03406C;font-size:7pt;margin-top:8px;">
                                                @if($statement->user->getSecondaryFullNameAttribute())
                                            
                                                
                                                    {{ strtoupper($statement->user->getSecondaryFullNameAttribute()) }}
            
                                                @endif
                                                {{ strtoupper($statement->user->address) }}<br>
                                                {{ strtoupper($statement->user->city) }}<br>
                                                {{ strtoupper($statement->user->state) }} {{ strtoupper($statement->user->zip_code) }}
                                            </p>
                                            
                                        </div>
                                    </td>

                                    <!-- RIGHT SECTION -->
                                    <td style="width:50%; vertical-align:top; padding:10px; ">
                                        <!-- 3 Rows Same Height -->
                                        <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                                            <tr style="height:40px;">
                                                <td style="width:50%; padding:5px;font-size:10pt;color:#03406C;font-weight:10">Amount Due</td>
                                                <td
                                                    style="width:50%; padding:5px;  text-align:right; font-weight:bold; font-size:10pt;color:#03406C">
                                                    ${{ number_format($totalWithTax, 2) }}
                                                </td>
                                            </tr>
                                            <tr style="height:40px; background-color:#cccdcf;">
                                                <td style="width:50%; padding:5px;  font-size:10pt;color:#03406C">Due by</td>
                                                <td
                                                    style="width:50%; padding:5px;  text-align:right; font-weight:bold; font-size:10pt;color:#03406C">
                                                    {{ ($statement->due_date && $statement->total_amount > 0) ? $statement->formatted_due_date : 'Do Not Pay' }}
                                                </td>
                                            </tr>
                                            <tr style="height:40px;">
                                                <td style="width:50%; padding:5px;  font-size:10pt;color:#03406C">Account Number</td>
                                                <td
                                                    style="width:50%; padding:5px; text-align:right;font-weight:bold; font-size:10pt;color:#03406C">
                                                    {{ $statement->user->account_number }}
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Payment To Section -->
                                        <div style="margin-top:15px; font-size:9pt; ">
                                            <p style="margin:0; font-weight:bold;color:#03406C">Please send payment to:
                                            </p>
                                            <p style="margin:0;color:#03406C;font-size:8pt;margin-top:8px;">
                                                {{ $companySettings['payment_recipient_name'] ?? 'SPECTRUM' }}<br>
                                                {{ $companySettings['payment_recipient_address_line1'] ?? 'PO BOX 7186' }}<br>
                                                {{ $companySettings['payment_recipient_address_line2'] ?? 'PASADENA CA 91109-7186' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            @if(isset($barcodeImageBase64) && $barcodeImageBase64)
                                <!--<img src="data:image/png;base64,{{ $barcodeImageBase64 }}" alt="Payment Barcode"-->
                                <!--    class="payment-stub-barcode-image">-->
                            @endif
                           <div style="
                                position: absolute;
                                bottom: 20px;        /* distance from bottom of page */
                                left: 40%;
                                transform: translateX(-50%);
                                font-family: 'OCRAStd';
                                text-align: center;
                                width: 100%;
                                font-size:15px;
                            ">
                                {{ $barcodeDataStringForDisplayLine2 ?? ($statement->user->account_number ?? '') . '0026208385100000000' }}
                            </div>

                        </div>
                    </div>
                    {{-- END OF PAGE 1 CONTENT --}}

                    {{-- Conditional include for subsequent pages --}}
                    @if(true) {{-- Replace 'true' with actual condition if page 2+ are optional --}}
                        <div class="page-break"></div>
                        {{-- Page 2: Bill Details --}}
                        <div class="bill-details-page-content">
                            @include('pdfs.partials.bill_details', [
                                'statement' => $statement,
                                'companySettings' =>
                                    $companySettings
                            ])
                        </div>

                        <div class="page-break"></div>
                        {{-- Page 3: Support & FAQs --}}
                        <div class="support-faqs-page-content">
                            @include('pdfs.partials.support_faqs', [
                                'statement' => $statement,
                                'companySettings' =>
                                    $companySettings
                            ])
                        </div>
                        <div class="page-break"></div>
                        {{-- Page 3: Support & FAQs --}}
                        <div class="support-faqs-page-content">
                            @include('pdfs.partials.fourth_page', [
                                'statement' => $statement,
                                'companySettings' =>
                                    $companySettings
                            ])
                        </div>
                    @endif

                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="page-footer-placeholder"></div>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
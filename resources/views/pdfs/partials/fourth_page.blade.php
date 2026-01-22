{{-- resources/views/pdfs/partials/fourth_page.blade.php --}}
{{-- This is intended to be Page 4 content --}}

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
                    <div style="font-size: 8pt;">4 of 4</div>
                </td>
        </tr>
    </table>

</div>
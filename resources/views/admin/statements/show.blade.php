@extends('layouts.admin')
@section('title', 'Statement #'.$statement->id)

@section('content')
<section class="admin-content px-4 py-4 md:px-6 md:py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-700">
            Statement Details: #{{ $statement->id }}
        </h1>
        <a href="{{ route('admin.statements.index') }}" class="btn btn-secondary text-sm">
            <i class="fas fa-arrow-left fa-fw mr-1"></i> Back to List
        </a>
    </div>
    <hr class="mb-5">

    @if(session('status')) 
        <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status') }}</div> 
    @endif
    @if(session('error')) 
        <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error') }}</div> 
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Left Column: Statement Info --}}
        <div class="md:col-span-2 widget-card shadow-md border rounded-lg">
            <div class="widget-header bg-gray-50 p-4 border-b">
                <h3 class="text-lg font-medium">Statement for {{ $statement->user->display_name ?? 'N/A' }}</h3>
            </div>
            <div class="widget-content p-6 space-y-4">
                <p><strong>Billing Date:</strong> {{ $statement->formatted_billing_start_date }}-{{ $statement->formatted_billing_end_date }}</p>
                <p><strong>Statement Date:</strong> {{ $statement->formatted_statement_date }}</p>
                <p><strong>Due Date:</strong> {{ $statement->formatted_due_date }}</p>
                <p><strong>Status:</strong> <span class="badge badge-{{ $statement->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($statement->status) }}</span></p>
                <p><strong>Total Amount:</strong> <span class="font-semibold text-xl">${{ number_format($statement->total_amount, 2) }}</span></p>

                {{-- Line Items Display/Edit Section --}}
                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-semibold">Line Items:</h4>
                        <button type="button" id="edit-items-btn" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit fa-fw mr-1"></i> Edit Items
                        </button>
                    </div>

                    {{-- Display Mode --}}
                    <div id="items-display-mode">
                        @if($statement->items->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-2 text-left">Description</th>
                                        <th class="p-2 text-right">Qty</th>
                                        <th class="p-2 text-right">Unit Price</th>
                                        <th class="p-2 text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($statement->items as $item)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $item->description }}</td>
                                        <td class="p-2 text-right">{{ $item->quantity }}</td>
                                        <td class="p-2 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="p-2 text-right font-medium">${{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-semibold bg-gray-50">
                                        <td colspan="3" class="p-2 text-right">Total:</td>
                                        <td class="p-2 text-right">${{ number_format($statement->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @else
                        <p class="text-gray-500">No line items for this statement.</p>
                        @endif
                    </div>

                    {{-- Edit Mode --}}
                    <div id="items-edit-mode" class="hidden">
                        <form action="{{ route('admin.statements.update', $statement->id) }}" method="POST" id="edit-items-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="flex justify-between items-center mb-2">
                                <h5 class="text-sm font-medium text-gray-700">Edit Line Items</h5>
                                <button type="button" id="add-item-btn" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus fa-fw mr-1"></i> Add Item
                                </button>
                            </div>
                            
                            <div id="line-items-container" class="space-y-3">
                                @foreach($statement->items as $index => $item)
                                <div class="line-item grid grid-cols-12 gap-2 items-center p-2 border rounded-md">
                                    <div class="col-span-5">
                                        <select name="items[{{ $index }}][description]" class="form-select text-sm service-select">
                                            <option value="">-- Select Service --</option>
                                            <optgroup label="Spectrum TV Services">
                                                <option value="Entertainment View" {{ $item->description == 'Entertainment View' ? 'selected' : '' }}>Entertainment View</option>
                                                <option value="Sports View" {{ $item->description == 'Sports View' ? 'selected' : '' }}>Sports View</option>
                                                <option value="Spectrum Tenant" {{ $item->description == 'Spectrum Tenant' ? 'selected' : '' }}>Spectrum Tenant</option>
                                            </optgroup>
                                            <optgroup label="Spectrum Internet">
                                                <option value="Spectrum Internet" {{ $item->description == 'Spectrum Internet' ? 'selected' : '' }}>Spectrum Internet</option>
                                                <option value="Spectrum Internet with WiFi" {{ $item->description == 'Spectrum Internet with WiFi' ? 'selected' : '' }}>Spectrum Internet with WiFi</option>
                                                <option value="Community WiFi Gig" {{ $item->description == 'Community WiFi Gig' ? 'selected' : '' }}>Community WiFi Gig</option>
                                            </optgroup>
                                            <optgroup label="Community Solutions Services">
                                                <option value="Spectrum TV Select" {{ $item->description == 'Spectrum TV Select' ? 'selected' : '' }}>Spectrum TV Select</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="number" name="items[{{ $index }}][quantity]" placeholder="Qty" value="{{ $item->quantity }}" class="form-input text-sm item-quantity" min="1">
                                    </div>
                                    <div class="col-span-3">
                                        <input type="number" name="items[{{ $index }}][unit_price]" placeholder="Unit Price" value="{{ $item->unit_price }}" class="form-input text-sm item-unit-price" step="0.01" min="0">
                                    </div>
                                    <div class="col-span-1 text-sm item-amount text-right pr-1">
                                        ${{ number_format($item->amount, 2) }}
                                    </div>
                                    <div class="col-span-1">
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="mt-4 flex justify-end space-x-2">
                                <button type="button" id="cancel-edit-btn" class="btn btn-secondary btn-sm">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save fa-fw mr-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="widget-footer p-4 bg-gray-50 border-t text-right space-x-2">
                <a href="{{ route('admin.statements.downloadPdf', $statement->id) }}" class="btn btn-primary">
                    <i class="fas fa-file-pdf mr-1"></i> Download PDF
                </a>
            </div>
        </div>

        {{-- Right Column: User Info --}}
        <div class="md:col-span-1 widget-card shadow-md border rounded-lg">
            <div class="widget-header bg-gray-50 p-4 border-b">
                <h3 class="text-lg font-medium">User Information</h3>
            </div>
            <div class="widget-content p-6 space-y-2">
                <p><strong>Name:</strong> {{ $statement->user->display_name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $statement->user->email ?? 'N/A' }}</p>
                <p><strong>Account #:</strong> {{ $statement->user->account_number ?? 'N/A' }}</p>
                @if($statement->user->address)
                <p><strong>Address:</strong><br>
                    {{ $statement->user->address }}<br>
                    {{ $statement->user->city }}, {{ $statement->user->state }} {{ $statement->user->zip_code }}
                </p>
                @endif
                <div class="pt-3">
                     <a href="{{ route('admin.users.edit', $statement->user->id) }}" class="text-blue-600 hover:underline text-sm">
                        View/Edit User Profile <i class="fas fa-external-link-alt fa-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let itemIndex = {{ $statement->items->count() }};
    let originalItems = {!! json_encode($statement->items) !!};

    // Toggle between display and edit modes
    $('#edit-items-btn').on('click', function() {
        $('#items-display-mode').hide();
        $('#items-edit-mode').removeClass('hidden');
        $(this).hide();
        $('#edit-page-btn').hide();
    });

    $('#cancel-edit-btn').on('click', function() {
        $('#items-edit-mode').addClass('hidden');
        $('#items-display-mode').show();
        $('#edit-items-btn').show();
        $('#edit-page-btn').show();
        // Reset form to original values
        location.reload(); // Simple way to reset changes
    });

    // Function to update item amount
    function updateAmounts(itemRow) {
        const quantity = parseFloat($(itemRow).find('.item-quantity').val()) || 0;
        const unitPrice = parseFloat($(itemRow).find('.item-unit-price').val()) || 0;
        const amount = quantity * unitPrice;
        $(itemRow).find('.item-amount').text('$' + amount.toFixed(2));
    }

    // Function to handle required fields based on service selection
    function handleRequiredFields(serviceSelect) {
        const itemRow = $(serviceSelect).closest('.line-item');
        const quantityInput = itemRow.find('.item-quantity');
        const unitPriceInput = itemRow.find('.item-unit-price');
        
        if ($(serviceSelect).val()) {
            quantityInput.prop('required', true);
            unitPriceInput.prop('required', true);
        } else {
            quantityInput.prop('required', false);
            unitPriceInput.prop('required', false);
        }
    }

    // Add new item row
    $('#add-item-btn').on('click', function() {
        const newItemHtml = `
        <div class="line-item grid grid-cols-12 gap-2 items-center p-2 border rounded-md">
            <div class="col-span-5">
                <select name="items[${itemIndex}][description]" class="form-select text-sm service-select">
                    <option value="">-- Select Service --</option>
                    <optgroup label="Spectrum TV Services">
                        <option value="Entertainment View">Entertainment View</option>
                        <option value="Sports View">Sports View</option>
                        <option value="Spectrum Tenant">Spectrum Tenant</option>
                    </optgroup>
                    <optgroup label="Spectrum Internet">
                        <option value="Spectrum Internet">Spectrum Internet</option>
                        <option value="Spectrum Internet with WiFi">Spectrum Internet with WiFi</option>
                        <option value="Community WiFi Gig">Community WiFi Gig</option>
                    </optgroup>
                    <optgroup label="Community Solutions Services">
                        <option value="Spectrum TV Select">Spectrum TV Select</option>
                    </optgroup>
                </select>
            </div>
            <div class="col-span-2">
                <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" value="1" class="form-input text-sm item-quantity" min="1">
            </div>
            <div class="col-span-3">
                <input type="number" name="items[${itemIndex}][unit_price]" placeholder="Unit Price" class="form-input text-sm item-unit-price" step="0.01" min="0">
            </div>
            <div class="col-span-1 text-sm item-amount text-right pr-1">
                $0.00
            </div>
            <div class="col-span-1">
                <button type="button" class="btn btn-sm btn-danger remove-item-btn"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
        $('#line-items-container').append(newItemHtml);
        itemIndex++;
        toggleRemoveButtons();
    });

    // Remove item row
    $('#line-items-container').on('click', '.remove-item-btn', function() {
        if ($('#line-items-container .line-item').length > 1) {
            $(this).closest('.line-item').remove();
        }
        toggleRemoveButtons();
    });

    // Calculate amount on quantity or unit price change
    $('#line-items-container').on('input', '.item-quantity, .item-unit-price', function() {
        updateAmounts($(this).closest('.line-item'));
    });

    // Handle required fields when service selection changes
    $('#line-items-container').on('change', '.service-select', function() {
        handleRequiredFields(this);
    });

    // Initial setup
    function toggleRemoveButtons() {
        const items = $('#line-items-container .line-item');
        if (items.length <= 1) {
            items.find('.remove-item-btn').hide();
        } else {
            items.find('.remove-item-btn').show();
        }
    }

    // Initialize calculations and required fields
    $('#line-items-container .line-item').each(function() {
        updateAmounts(this);
        handleRequiredFields($(this).find('.service-select'));
    });
    
    toggleRemoveButtons();
});
</script>
@endpush
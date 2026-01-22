{{-- resources/views/admin/statements/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Statement')

@section('content')
<section class="admin-content px-4 py-4 md:px-6 md:py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-700">
            <i class="fas fa-file-invoice-dollar fa-fw mr-2 text-blue-500"></i> Edit Statement
        </h1>
        <a href="{{ route('admin.statements.index') }}" class="btn btn-secondary text-sm">
            <i class="fas fa-arrow-left fa-fw mr-1"></i> Back to Statements List
        </a>
    </div>
    <hr class="mb-5">

    @if ($errors->any())
        <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">
            <strong class="font-semibold">Update Failed!</strong> Check the errors below.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('status')) <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error') }}</div> @endif

    <div class="widget-card shadow-md border border-gray-100 rounded-lg overflow-hidden">
        <div class="widget-header bg-gray-50 border-b border-gray-200 p-3 md:p-4">
            <h3 class="text-base font-medium text-gray-700">Statement Details</h3>
        </div>

        <form action="{{ route('admin.statements.update', $statement->id) }}" method="POST" class="widget-content bg-white p-4 md:p-6 space-y-4">
            @csrf
            @method('PUT')

            {{-- User (Locked in edit, because update() currently does not update user/date) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <input type="text"
                       value="{{ $statement->user?->display_name ?? 'N/A' }}"
                       class="form-input bg-gray-50"
                       readonly>
                <p class="text-xs text-gray-500 mt-1">User cannot be changed from edit screen.</p>
            </div>

            {{-- Statement Date & Due Date (Display only for now) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statement Date</label>
                    <input type="date"
                           value="{{ old('statement_date', optional($statement->statement_date)->format('Y-m-d')) }}"
                           class="form-input bg-gray-50"
                           readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                    <input type="date"
                           value="{{ old('due_date', optional($statement->due_date)->format('Y-m-d')) }}"
                           class="form-input bg-gray-50"
                           readonly>
                </div>
            </div>

            {{-- Billing Start Date & Billing End Date (Display only, update controller if you want editable) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Billing Start Date</label>
                    <input type="date"
                           value="{{ old('billing_start_date', optional($statement->billing_start_date)->format('Y-m-d')) }}"
                           class="form-input bg-gray-50"
                           readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Billing End Date</label>
                    <input type="date"
                           value="{{ old('billing_end_date', optional($statement->billing_end_date)->format('Y-m-d')) }}"
                           class="form-input bg-gray-50"
                           readonly>
                </div>
            </div>

            {{-- Line Items Section --}}
            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-md font-medium text-gray-700">Line Items <span class="text-red-500">*</span></h4>
                    <button type="button" id="add-item-btn" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus fa-fw mr-1"></i> Add Item
                    </button>
                </div>

                <div id="line-items-container" class="space-y-3">
                    @php
                        $oldItems = old('items');
                        $itemsToRender = is_array($oldItems) ? $oldItems : $statement->items->toArray();
                    @endphp

                    @if(!empty($itemsToRender))
                        @foreach($itemsToRender as $index => $item)
                            <div class="line-item grid grid-cols-12 gap-2 items-center p-2 border rounded-md">
                                <div class="col-span-5">
                                    <select name="items[{{ $index }}][description]" class="form-select text-sm service-select" required>
                                        <option value="">-- Select Service --</option>

                                        <optgroup label="Spectrum TV Services">
                                            <option value="Entertainment View" {{ ($item['description'] ?? '') === 'Entertainment View' ? 'selected' : '' }}>Entertainment View</option>
                                            <option value="Sports View" {{ ($item['description'] ?? '') === 'Sports View' ? 'selected' : '' }}>Sports View</option>
                                            <option value="Spectrum Tenant" {{ ($item['description'] ?? '') === 'Spectrum Tenant' ? 'selected' : '' }}>Spectrum Tenant</option>
                                        </optgroup>

                                        <optgroup label="Spectrum Internet">
                                            <option value="Spectrum Internet" {{ ($item['description'] ?? '') === 'Spectrum Internet' ? 'selected' : '' }}>Spectrum Internet</option>
                                            <option value="Spectrum Internet with WiFi" {{ ($item['description'] ?? '') === 'Spectrum Internet with WiFi' ? 'selected' : '' }}>Spectrum Internet with WiFi</option>
                                            <option value="Community WiFi Gig" {{ ($item['description'] ?? '') === 'Community WiFi Gig' ? 'selected' : '' }}>Community WiFi Gig</option>
                                        </optgroup>

                                        <optgroup label="Community Solutions Services">
                                            <option value="Spectrum TV Select" {{ ($item['description'] ?? '') === 'Spectrum TV Select' ? 'selected' : '' }}>Spectrum TV Select</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="col-span-2">
                                    <input type="number"
                                           name="items[{{ $index }}][quantity]"
                                           placeholder="Qty"
                                           value="{{ $item['quantity'] ?? 1 }}"
                                           class="form-input text-sm item-quantity"
                                           min="1"
                                           required>
                                </div>

                                <div class="col-span-3">
                                    <input type="number"
                                           name="items[{{ $index }}][unit_price]"
                                           placeholder="Unit Price"
                                           value="{{ $item['unit_price'] ?? 0 }}"
                                           class="form-input text-sm item-unit-price"
                                           step="0.01"
                                           min="0"
                                           required>
                                </div>

                                <div class="col-span-1 text-sm item-amount text-right pr-1">
                                    ${{ number_format(((float)($item['quantity'] ?? 0)) * ((float)($item['unit_price'] ?? 0)), 2) }}
                                </div>

                                <div class="col-span-1">
                                    <button type="button" class="btn btn-sm btn-danger remove-item-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Fallback --}}
                        <div class="line-item grid grid-cols-12 gap-2 items-center p-2 border rounded-md">
                            <div class="col-span-5">
                                <select name="items[0][description]" class="form-select text-sm service-select" required>
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
                                <input type="number" name="items[0][quantity]" placeholder="Qty" value="1" class="form-input text-sm item-quantity" min="1" required>
                            </div>
                            <div class="col-span-3">
                                <input type="number" name="items[0][unit_price]" placeholder="Unit Price" class="form-input text-sm item-unit-price" step="0.01" min="0" required>
                            </div>
                            <div class="col-span-1 text-sm item-amount text-right pr-1">$0.00</div>
                            <div class="col-span-1">
                                <button type="button" class="btn btn-sm btn-danger remove-item-btn" style="display:none;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                @error('items') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('items.*.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-3 text-right">
                <button type="submit" class="btn btn-primary shadow-md hover:shadow-lg">
                    <i class="fas fa-save fa-fw mr-1"></i> Update Statement
                </button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .form-input, .form-select { border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); width: 100%; }
    .form-input:focus, .form-select:focus { outline: none; border-color: var(--primary-color, #6366f1); box-shadow: 0 0 0 2px var(--primary-color-light, #a5b4fc); }
    .alert { border: 1px solid transparent; }
    .alert-danger { background-color: #fee2e2; border-color: #fecaca; color: #991b1b; }
    .alert-success { background-color: #d1fae5; border-color: #a7f3d0; color: #065f46; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    let itemIndex = {{ is_array(old('items')) ? count(old('items')) : ($statement->items->count() ?: 1) }};

    function updateAmounts(itemRow) {
        const quantity = parseFloat($(itemRow).find('.item-quantity').val()) || 0;
        const unitPrice = parseFloat($(itemRow).find('.item-unit-price').val()) || 0;
        const amount = quantity * unitPrice;
        $(itemRow).find('.item-amount').text('$' + amount.toFixed(2));
    }

    $('#add-item-btn').on('click', function () {
        const newItemHtml = `
        <div class="line-item grid grid-cols-12 gap-2 items-center p-2 border rounded-md">
            <div class="col-span-5">
                <select name="items[${itemIndex}][description]" class="form-select text-sm service-select" required>
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
                <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" value="1" class="form-input text-sm item-quantity" min="1" required>
            </div>
            <div class="col-span-3">
                <input type="number" name="items[${itemIndex}][unit_price]" placeholder="Unit Price" class="form-input text-sm item-unit-price" step="0.01" min="0" required>
            </div>
            <div class="col-span-1 text-sm item-amount text-right pr-1">$0.00</div>
            <div class="col-span-1">
                <button type="button" class="btn btn-sm btn-danger remove-item-btn"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
        $('#line-items-container').append(newItemHtml);
        itemIndex++;
        toggleRemoveButtons();
    });

    $('#line-items-container').on('click', '.remove-item-btn', function () {
        if ($('#line-items-container .line-item').length > 1) {
            $(this).closest('.line-item').remove();
        }
        toggleRemoveButtons();
    });

    $('#line-items-container').on('input', '.item-quantity, .item-unit-price', function () {
        updateAmounts($(this).closest('.line-item'));
    });

    $('#line-items-container .line-item').each(function () {
        updateAmounts(this);
    });

    function toggleRemoveButtons() {
        const items = $('#line-items-container .line-item');
        if (items.length <= 1) {
            items.find('.remove-item-btn').hide();
        } else {
            items.find('.remove-item-btn').show();
        }
    }

    toggleRemoveButtons();
});
</script>
@endpush

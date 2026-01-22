{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.admin') {{-- Use your admin layout --}}

@section('title', 'Create New User')

@section('content')
<section class="admin-content px-4 py-4 md:px-6 md:py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-700">
            <i class="fas fa-user-plus fa-fw mr-2 text-teal-500"></i> Create New User
        </h1>
         <a href="{{ route('admin.users.index') }}" class="btn btn-secondary text-sm">
             <i class="fas fa-arrow-left fa-fw mr-1"></i> Back to User List
         </a>
    </div>
    <hr class="mb-5">

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">
            <strong class="font-semibold">Whoops!</strong> There were problems with the input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Create User Form --}}
    <div class="widget-card shadow-md border border-gray-100 rounded-lg overflow-hidden">
         <div class="widget-header bg-gray-50 border-b border-gray-200 p-3 md:p-4">
             <h3 class="text-base font-medium text-gray-700">User Details</h3>
         </div>
         <form action="{{ route('admin.users.store') }}" method="POST" class="widget-content bg-white p-4 md:p-6 space-y-4" id="userForm">
            @csrf {{-- CSRF Protection --}}

            {{-- Name Field --}}
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="first_name" id="first_name" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('first_name') }}" required>
                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Hidden Last Name Field --}}
            <input type="hidden" name="last_name" id="last_name" value="{{ old('last_name') }}">

            {{-- Secondary First Name Field --}}
            <div>
                <label for="secondary_first_name" class="block text-sm font-medium text-gray-700 mb-1">Secondary Name</label>
                <input type="text" name="secondary_first_name" id="secondary_first_name" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('secondary_first_name') }}">
                @error('secondary_first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Secondary Last Name Field --}}
            <!--<div>-->
            <!--    <label for="secondary_last_name" class="block text-sm font-medium text-gray-700 mb-1">Secondary Last Name</label>-->
            <!--    <input type="text" name="secondary_last_name" id="secondary_last_name" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('secondary_last_name') }}">-->
            <!--    @error('secondary_last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror-->
            <!--</div>-->

            {{-- Username Field --}}
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="username" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('username') }}" required>
                 <p class="text-xs text-gray-500 mt-1">Must be unique.</p>
                @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
              {{-- Account number Field --}}
            <div>
                <label for="account_number" class="block text-sm font-medium text-gray-700 mb-1">Account Number <span class="text-red-500">*</span></label>
                <input type="text" name="account_number" id="account_number" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('account_number') }}" required>
                 <p class="text-xs text-gray-500 mt-1">Must be unique.</p>
                @error('account_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email Field --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('email') }}" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password Field --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" id="password" class="form-input w-full rounded-md border-gray-300 shadow-sm" required autocomplete="new-password">
                <p class="text-xs text-gray-500 mt-1">Minimum 8 characters recommended.</p>
                 @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password Confirmation Field --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input w-full rounded-md border-gray-300 shadow-sm" required autocomplete="new-password">
                 @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Address Field --}}
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <input type="text" name="address" id="address" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('address') }}">
                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- City Field --}}
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <input type="text" name="city" id="city" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('city') }}">
                @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- State Field --}}
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                <input type="text" name="state" id="state" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('state') }}">
                @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Phone Number Field --}}
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('phone_number') }}">
                @error('phone_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Service Type Field --}}
            <div>
                <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                <select name="service_type" id="service_type" class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select a Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->services }}" {{ old('service_type') == $service->services ? 'selected' : '' }}>
                            {{ $service->services }}
                        </option>
                    @endforeach
                </select>
                @error('service_type') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Role Field --}}
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role" id="role" class="form-select w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    {{-- Add other roles if needed --}}
                </select>
                 @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Submit Button --}}
            <div class="pt-3 text-right">
                <button type="submit" class="btn btn-primary shadow-md hover:shadow-lg">
                    <i class="fas fa-plus fa-fw mr-1"></i> Create User
                </button>
            </div>

        </form>
    </div>

</section>
@endsection

{{-- Add common form styles if not globally available --}}
@push('styles')
<style>
    .form-input, .form-select { border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); width: 100%;}
    .form-input:focus, .form-select:focus { outline: none; border-color: var(--primary-color, #6366f1); box-shadow: 0 0 0 2px var(--primary-color-light, #a5b4fc); }
    .alert-danger { background-color: #fee2e2; border-color: #fecaca; color: #991b1b; }
</style>
@endpush

{{-- Add JavaScript to split name --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');
    
    form.addEventListener('submit', function(e) {
        // Split the name when form is submitted
        const fullName = firstNameInput.value.trim();
        
        if (fullName) {
            // Split by first space only
            const nameParts = fullName.split(' ');
            
            if (nameParts.length > 1) {
                // First part is first name, rest is last name
                const firstName = nameParts[0];
                const lastName = nameParts.slice(1).join(' ');
                
                // Update the hidden fields
                firstNameInput.value = firstName;
                lastNameInput.value = lastName;
            } else {
                // Only one word - set as first name, last name empty
                lastNameInput.value = '';
            }
        }
    });
});
</script>
@endpush
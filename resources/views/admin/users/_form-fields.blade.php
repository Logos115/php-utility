{{-- resources/views/admin/users/_form-fields.blade.php --}}
{{-- Expects optional $user variable for editing --}}

{{-- Name Field --}}
<div>
    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
    <input type="text" name="first_name" id="first_name" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('first_name', isset($user) ? $user->first_name . ' ' . $user->last_name : '') }}" required>
    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Hidden Last Name Field --}}
<input type="hidden" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name ?? '') }}">

{{-- Secondary First Name Field --}}
<div>
    <label for="secondary_first_name" class="block text-sm font-medium text-gray-700 mb-1">Secondary Name</label>
    <input type="text" name="secondary_first_name" id="secondary_first_name" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('secondary_first_name', $user->secondary_first_name ?? '') }}">
    @error('secondary_first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Username Field --}}
<div>
    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
    <input type="text" name="username" id="username" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('username', $user->username ?? '') }}" required>
     <p class="text-xs text-gray-500 mt-1">Must be unique.</p>
    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
{{-- Account numberField --}}
<div>
    <label for="account_number" class="block text-sm font-medium text-gray-700 mb-1">Account Number <span class="text-red-500">*</span></label>
    <input type="account_number" name="account_number" id="account_number" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('account_number', $user->account_number ?? '') }}" required>
    @error('account_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Email Field --}}
<div>
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
    <input type="email" name="email" id="email" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Password Field --}}
<div>
    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password @isset($user)<span class="text-gray-500 text-xs">(Leave blank to keep current)</span>@else<span class="text-red-500">*</span>@endisset</label>
    <input type="password" name="password" id="password" class="form-input w-full rounded-md border-gray-300 shadow-sm" {{ isset($user) ? '' : 'required' }} autocomplete="new-password">
    @if(!isset($user))
        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters recommended.</p>
    @endif
    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Password Confirmation Field --}}
<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password @isset($user)<span class="text-gray-500 text-xs">(Required if changing password)</span>@else<span class="text-red-500">*</span>@endisset</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input w-full rounded-md border-gray-300 shadow-sm" {{ isset($user) ? '' : 'required' }} autocomplete="new-password">
    @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Address Field --}}
<div>
    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
    <input type="text" name="address" id="address" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('address', $user->address ?? '') }}">
    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- City Field --}}
<div>
    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
    <input type="text" name="city" id="city" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('city', $user->city ?? '') }}">
    @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- State Field --}}
<div>
    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
    <input type="text" name="state" id="state" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('state', $user->state ?? '') }}">
    @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Phone Number Field --}}
<div>
    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
    <input type="text" name="phone_number" id="phone_number" class="form-input w-full rounded-md border-gray-300 shadow-sm" value="{{ old('phone_number', $user->phone_number ?? '') }}">
    @error('phone_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Service Type Field --}}
<div>
    <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
    <select name="service_type" id="service_type" class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <option value="">Select a Service</option>
        @foreach($services as $service)
            <option value="{{ $service->services }}" {{ old('service_type', $user->service_type ?? '') == $service->services ? 'selected' : '' }}>
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
        <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
     @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
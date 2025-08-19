@extends('components.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('messages.adminRoleEdit.title') }}</h2>

            <form action="{{ route('admin-role.update', $admin->id) }}" method="POST" enctype="multipart/form-data" id="updateAdminForm">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.adminRoleEdit.name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" 
                           value="{{ old('name', $admin->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.adminRoleEdit.email') }}</label>
                    <input type="email" name="email" class="form-control" id="email" 
                           value="{{ old('email', $admin->email) }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.adminRoleEdit.password') }}</label>
                    <input type="password" name="password" class="form-control" id="password" 
                           placeholder="{{ __('messages.adminRoleEdit.password_placeholder') }}">
                    <small class="form-text text-muted">{{ __('messages.adminRoleEdit.password_note') }}</small>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Roles select --}}
                <div class="mb-3">
                    <label for="role" class="form-label">{{ __('messages.adminRoleEdit.roles') }}</label>
                    <select name="role" id="role" class="form-control" style="color: black;">
                        <option value="" disabled>{{ __('messages.adminRoleEdit.roles_placeholder') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" 
                                {{ old('role', $admin->role) == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Is Admin Checkbox --}}
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_Admin" class="form-check-input" id="is_Admin" value="1"
                        {{ old('is_Admin', $admin->is_Admin) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_Admin">{{ __('messages.adminRoleEdit.is_admin') }}</label>
                </div>

                {{-- Actions --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{ __('messages.adminRoleEdit.submit') }}</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('messages.adminRoleEdit.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

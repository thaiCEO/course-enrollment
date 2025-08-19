@extends('components.master')
@section('content')

<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.adminRoleCreate.mainTitle') }}</h5>
        <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
                <a href="{{ route('admin-role.index') }}"> <i class="fa fa-home"></i> </a>
            </li>
            <li class="breadcrumb-item">
                <a href="#!">{{ __('messages.adminRoleCreate.mainTitleDashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#!">{{ __('messages.adminRoleCreate.create') }}</a>
            </li>
        </ul>
    </div>
</div>
<!-- Page-header end -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin-role.store') }}" method="POST" id="Form_addAdmin" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.adminRoleCreate.name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" 
                           placeholder="{{ __('messages.adminRoleCreate.name_placeholder') }}" 
                           value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.adminRoleCreate.email') }}</label>
                    <input type="email" name="email" class="form-control" id="email" 
                           placeholder="{{ __('messages.adminRoleCreate.email_placeholder') }}" 
                           value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.adminRoleCreate.password') }}</label>
                    <input type="password" name="password" class="form-control" id="password" 
                           placeholder="{{ __('messages.adminRoleCreate.password_placeholder') }}">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password Confirmation --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('messages.adminRoleCreate.password_confirmation') }}</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" 
                           placeholder="{{ __('messages.adminRoleCreate.password_confirmation_placeholder') }}">
                </div>


                {{-- Roles select --}}
              <div class="mb-3">
                <label for="roles" class="form-label">{{ __('messages.adminRoleCreate.roles') }}</label>
                <select name="roles[]" id="roles" class="form-control" multiple size="5" style="color: black;">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ (collect(old('roles'))->contains($role->name)) ? 'selected':'' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted d-block mt-1">Hold Ctrl (Windows) or Command (Mac) to select multiple roles</small>
                @error('roles')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>






                {{-- Is Admin Checkbox --}}
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="is_Admin" id="is_Admin" value="1">
                    <label class="form-check-label" for="is_Admin">{{ __('messages.adminRoleCreate.is_admin') }}</label>
                </div>

                {{-- Actions --}}
                <button type="submit" class="btn btn-primary">{{ __('messages.adminRoleCreate.submit') }}</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('messages.adminRoleCreate.back') }}</a>
            </form>
        </div>
    </div>
</div>

@endsection




@extends('components.master')

@section('content')

    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">{{ __('messages.roleEdit.mainTitle') }}</h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item">
                    <a href="{{ route('roles.index') }}"> <i class="fa fa-home"></i> </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#!">{{ __('messages.roleEdit.mainTitleDashboard') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#!">{{ __('messages.roleEdit.edit') }}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ __('messages.roleEdit.title') }}</h2>

                <form action="{{ route('roles.update', $role->id) }}" method="POST" id="updateRoleForm">
                    @csrf
                    @method('PUT')

                    {{-- 👉 Role Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('messages.roleEdit.name') }}</label>
                        <input type="text" name="name" class="form-control" id="name" 
                               value="{{ old('name', $role->name) }}" 
                               placeholder="{{ __('messages.roleEdit.name_placeholder') }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- 👉 Assign Permissions --}}
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.roleEdit.permissions') }}</label>
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}" 
                                               id="perm_{{ $permission->id }}"
                                               {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('permissions')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- 👉 Actions --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">{{ __('messages.roleEdit.submit') }}</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('messages.roleEdit.back') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

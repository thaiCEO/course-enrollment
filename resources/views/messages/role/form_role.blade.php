@extends('components.master')
@section('content')

    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">{{ __('messages.roleCreate.mainTitle') }}</h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item">
                    <a href="{{ route('roles.index') }}"> <i class="fa fa-home"></i> </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#!">{{ __('messages.roleCreate.mainTitleDashboard') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#!">{{ __('messages.roleCreate.create') }}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('roles.store') }}" method="POST" id="Form_addRole">
                    @csrf

                    {{-- 👉 Role Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('messages.roleCreate.name') }}</label>
                        <input type="text" name="name" class="form-control" id="name" 
                               placeholder="{{ __('messages.roleCreate.name_placeholder') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- 👉 Assign Permissions --}}
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.roleCreate.permissions') }}</label>
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}" 
                                               id="perm_{{ $permission->id }}">
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
                    <button type="submit" class="btn btn-primary">
                        {{ __('messages.roleCreate.submit') }}
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        {{ __('messages.roleCreate.back') }}
                    </a>
                </form>
            </div>
        </div>
    </div>

@endsection

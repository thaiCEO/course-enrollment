@extends('components.master')

@section('content')

<a href="{{ route('admin-role.index') }}" class="btn btn-primary mt-3">
    {{ __('messages.showAdmin.back') }}
</a>

<div class="container mt-5 shadow rounded p-4" style="max-width: 1200px;">
    <h3 class="text-center mb-4">{{ __('messages.showAdmin.title') }}</h3>

    <div class="row">
        {{-- Left Column: Admin Info --}}
        <div class="col-md-8">
            <div class="mb-3">
                <strong>{{ __('messages.showAdmin.name') }}:</strong>
                <span>{{ $admin->name }}</span>
            </div>

            <div class="mb-3">
                <strong>{{ __('messages.showAdmin.email') }}:</strong>
                <span>{{ $admin->email }}</span>
            </div>

          

            {{-- Roles --}}
            <div class="mb-3">
                <strong>{{ __('messages.showAdmin.roles') }}:</strong>
                @if($roles && count($roles) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($roles as $role)
                            <li class="list-group-item p-1">{{ $role }}</li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-muted">{{ __('messages.showAdmin.no_roles') }}</span>
                @endif
            </div>

            {{-- Permissions --}}
            <div class="mb-3">
                <strong>{{ __('messages.showAdmin.permissions') }}:</strong>
                @if($permissions && count($permissions) > 0)
                    <div class="row mt-2">
                        @foreach($permissions as $permission)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           disabled
                                           id="perm_{{ $permission->id }}"
                                           @if(in_array($permission->name, $adminPermissions ?? [])) checked @endif>
                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @else
                        <span class="text-muted">{{ __('messages.showAdmin.no_permissions') }}</span>
                    @endif
                 </div>
              </div>

        {{-- Right Column: Optional Profile Image --}}
        {{-- <div class="col-md-4 text-center">
            <div class="mt-2">
                @if($admin->profile_image)
                    <img src="{{ asset('profile_admin/' . $admin->profile_image) }}" alt="Profile Image"
                        class="img-fluid rounded mb-3" style="max-width: 100%;">
                @else
                    <p class="text-muted">{{ __('messages.showAdmin.no_image') }}</p>
                @endif
            </div>
        </div> --}}
    </div>
</div>

@endsection

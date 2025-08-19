@extends('components.master')

@section('content')

<a href="{{ route('roles.index') }}" class="btn btn-primary mt-3">
    {{ __('messages.showRole.back') }}
</a>

<div class="container mt-5 shadow rounded p-4" style="max-width: 900px;">
    <h3 class="text-center mb-4">{{ __('messages.showRole.title') }}</h3>

    <div class="row">
        {{-- Left Column: Role Info --}}
        <div class="col-md-8">
            <div class="mb-3">
                <strong>{{ __('messages.showRole.id') }}:</strong>
                <span>{{ $role->id }}</span>
            </div>

            <div class="mb-3">
                <strong>{{ __('messages.showRole.name') }}:</strong>
                <span>{{ $role->name }}</span>
            </div>

            <div class="mb-3">
                <strong>{{ __('messages.showRole.guard') }}:</strong>
                <span>{{ $role->guard_name }}</span>
            </div>

            {{-- 👉 Role Permissions --}}
            <div class="mb-3">
                <strong>{{ __('messages.showRole.permissions') }}:</strong>
                @if($role->permissions->isNotEmpty())
                    <ul>
                        @foreach($role->permissions as $permission)
                            <li>{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-muted">{{ __('messages.showRole.no_permissions') }}</span>
                @endif
            </div>
        </div>

        {{-- Right Column: Icon or Placeholder --}}
        <div class="col-md-4 text-center">
            <div class="mt-4">
                <i class="fa fa-user-shield fa-5x text-muted"></i>
                <p class="mt-2">{{ __('messages.showRole.icon_text') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

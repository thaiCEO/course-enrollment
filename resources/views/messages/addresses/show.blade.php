@extends('components.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <!-- Card Header -->
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">{{ __('messages.viewaddresses.title') }}</h4>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <!-- Student Name -->
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewaddresses.name') }}:</label>
                <div class="col-sm-8">
                    {{ $address->addressable->username ?? $address->addressable->name ?? __('messages.viewaddresses.na') }}
                </div>
            </div>

            <!-- Address Line -->
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewaddresses.address_line') }}:</label>
                <div class="col-sm-8">{{ $address->address_line }}</div>
            </div>

            <!-- City -->
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewaddresses.city') }}:</label>
                <div class="col-sm-8">{{ $address->city }}</div>
            </div>

            <!-- Phone -->
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewaddresses.phone') }}:</label>
                <div class="col-sm-8">{{ $address->phone }}</div>
            </div>

            <!-- Address Type -->
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewaddresses.address_type') }}:</label>
                <div class="col-sm-8">
                    @if($address->is_main)
                        <span class="badge bg-success">{{ __('messages.viewaddresses.main') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('messages.viewaddresses.secondary') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="card-footer text-center">
            <a href="{{ route('addresses.index') }}" class="btn btn-secondary">
                {{ __('messages.viewaddresses.back') }}
            </a>
        </div>
    </div>
</div>
@endsection

@extends('components.master')

@section('content')
<div class="container mx-auto mt-10 max-w-lg bg-white shadow-md rounded p-6">
    <h1 class="text-2xl font-bold mb-6 text-center">{{ __('messages.viewaddresses.title') }}</h1>

    <div class="mb-4">
        <label class="font-semibold">{{ __('messages.viewaddresses.student') }}:</label>
        <p>{{ $address->addressable->username ?? $address->addressable->name ?? __('messages.viewaddresses.na') }}</p>
    </div>

    <div class="mb-4">
        <label class="font-semibold">{{ __('messages.viewaddresses.address_line') }}:</label>
        <p>{{ $address->address_line }}</p>
    </div>

    <div class="mb-4">
        <label class="font-semibold">{{ __('messages.viewaddresses.city') }}:</label>
        <p>{{ $address->city }}</p>
    </div>

    <div class="mb-4">
        <label class="font-semibold">{{ __('messages.viewaddresses.phone') }}:</label>
        <p>{{ $address->phone }}</p>
    </div>

    <div class="mb-4">
        <label class="font-semibold">{{ __('messages.viewaddresses.address_type') }}:</label>
        <p>{{ $address->is_main ? __('messages.viewaddresses.main') : __('messages.viewaddresses.secondary') }}</p>
    </div>

    <div class="text-center mt-6">
        <a href="{{ route('addresses.index') }}" class="btn btn-primary">{{ __('messages.viewaddresses.back') }}</a>
    </div>
</div>
@endsection

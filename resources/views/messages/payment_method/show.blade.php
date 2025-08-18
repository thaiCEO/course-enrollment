@extends('components.master')

@section('content')
<div class="container">
    <h2>{{ __('messages.viewPaymentMethod.title') }}</h2>

    <div class="mb-3"><strong>{{ __('messages.viewPaymentMethod.id') }}:</strong> {{ $paymentMethod->id }}</div>
    <div class="mb-3"><strong>{{ __('messages.viewPaymentMethod.name') }}:</strong> {{ $paymentMethod->name }}</div>

    <a href="{{ route('payment-method.index') }}" class="btn btn-secondary">{{ __('messages.viewPaymentMethod.back') }}</a>
</div>
@endsection

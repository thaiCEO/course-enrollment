{{-- resources/views/payment/show.blade.php --}}
@extends('components.master')

@section('content')
<div class="container">
    <h2>{{ __('messages.viewPayment.title') }}</h2>

    <div class="mb-3"><strong>{{ __('messages.viewPayment.id') }}:</strong> {{ $payment->id }}</div>
    <div class="mb-3"><strong>{{ __('messages.viewPayment.course') }}:</strong> {{ $payment->enrollment->course->title ?? 'N/A' }}</div>
    <div class="mb-3"><strong>{{ __('messages.viewPayment.amount') }}:</strong> ${{ $payment->amount }}</div>
    <div class="mb-3"><strong>{{ __('messages.viewPayment.status') }}:</strong> {{ $payment->status }}</div>
    <div class="mb-3"><strong>{{ __('messages.viewPayment.paymentMethod') }}:</strong> {{ $payment->paymentMethod->name }}</div>
    <div class="mb-3"><strong>{{ __('messages.viewPayment.paidAt') }}:</strong> {{ $payment->paid_at }}</div>

    <a href="{{ route('payment.index') }}" class="btn btn-secondary">{{ __('messages.viewPayment.back') }}</a>
</div>
@endsection

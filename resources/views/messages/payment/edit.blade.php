@extends('components.master')
@section('content')
<div class="container">
    <h2>{{ __('messages.editPayment.title') }}</h2>
    
    <form action="{{ route('payment.update', $payment->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="enrollment_id">{{ __('messages.editPayment.enrollmentId') }}</label>
            <input type="number" name="enrollment_id" class="form-control" value="{{ $payment->enrollment_id }}" required>
        </div>

        <div class="mb-3">
            <label for="amount">{{ __('messages.editPayment.amount') }}</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ $payment->amount }}" required>
        </div>

        <div class="mb-3">
            <label for="status">{{ __('messages.editPayment.status') }}</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>
                    {{ __('messages.editPayment.statusOptions.pending') }}
                </option>
                <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>
                    {{ __('messages.editPayment.statusOptions.paid') }}
                </option>
            </select>
        </div>

       <div class="mb-3">
            <label for="payment_method_id">{{ __('messages.editPayment.paymentMethod') }}</label>
            <select name="payment_method_id" id="payment_method_id" class="form-control" required>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}" {{ $payment->payment_method_id == $method->id ? 'selected' : '' }}>
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <button class="btn btn-primary" type="submit">{{ __('messages.editPayment.updateButton') }}</button>
        <a href="{{ route('payment.index') }}" class="btn btn-secondary">{{ __('messages.editPayment.back') }}</a>
    </form>
</div>
@endsection

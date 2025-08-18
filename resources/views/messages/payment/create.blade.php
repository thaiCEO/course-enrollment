@extends('components.master')

@section('content')
<div class="container">
    <h2>{{ __('messages.createPayment.title') }}</h2>

    <form action="{{ route('payment.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="enrollment_id" class="form-label">{{ __('messages.createPayment.enrollment') }}</label>
            <select name="enrollment_id" id="enrollment_id" class="form-control" required>
                <option value="">{{ __('messages.createPayment.selectEnrollment') }}</option>
                @foreach($enrollments as $enrollment)
                    <option value="{{ $enrollment->id }}" {{ old('enrollment_id') == $enrollment->id ? 'selected' : '' }}>
                        {{ __('messages.createPayment.courseLabel', ['course' => $enrollment->course->title, 'student' => $enrollment->student->username ?? 'N/A']) }}
                    </option>
                @endforeach
            </select>
            @error('enrollment_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">{{ __('messages.createPayment.status') }}</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('messages.createPayment.pending') }}</option>
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>{{ __('messages.createPayment.paid') }}</option>
            </select>
            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="payment_method_id" class="form-label">{{ __('messages.createPayment.paymentMethod') }}</label>
            <select name="payment_method_id" id="payment_method_id" class="form-control" required>
                <option value="">{{ __('messages.createPayment.selectPaymentMethod') }}</option>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>
            @error('payment_method_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="paid_at" class="form-label">{{ __('messages.createPayment.paidAt') }}</label>
            <input type="datetime-local" name="paid_at" id="paid_at" class="form-control" value="{{ old('paid_at') }}">
            @error('paid_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.createPayment.save') }}</button>
        <a href="{{ route('payment.index') }}" class="btn btn-secondary">{{ __('messages.createPayment.back') }}</a>
    </form>
</div>
@endsection

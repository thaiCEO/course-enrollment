@extends('components.master')

@section('content')
<div class="container">
    <h2>{{ __('messages.editPaymentMethod.title') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('payment-method.update', $paymentMethod->id) }}" method="POST">
        @csrf
        {{-- If using POST for update instead of PUT/PATCH --}}

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('messages.editPaymentMethod.name') }}</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $paymentMethod->name) }}" required>
            @error('name') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.editPaymentMethod.update') }}</button>
        <a href="{{ route('payment-method.index') }}" class="btn btn-secondary">{{ __('messages.editPaymentMethod.back') }}</a>
    </form>
</div>
@endsection

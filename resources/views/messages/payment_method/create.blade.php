@extends('components.master')

@section('content')
<div class="container">
    <h2>{{ __('messages.createPaymentMethod.title') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('payment-method.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('messages.createPaymentMethod.name_label') }}</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name') }}"
                   placeholder="{{ __('messages.createPaymentMethod.name_placeholder') }}" required>
            @error('name') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.createPaymentMethod.save') }}</button>
        <a href="{{ route('payment-method.index') }}" class="btn btn-secondary">{{ __('messages.createPaymentMethod.back') }}</a>
    </form>
</div>
@endsection

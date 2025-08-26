@extends('components.master')

@section('content')



<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.createPaymentMethod.title') }}</h5>
        <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
                <a href="index.html"><i class="fa fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
               <a href="{{ route('dashboard.index') }}">{{ __('messages.createFormStudent.dashboard') }}</a>
            </li>
        </ul>
    </div>
</div>
<!-- Page-header end -->


<div class="container">

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

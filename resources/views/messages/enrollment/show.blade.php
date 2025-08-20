@extends('components.master')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>{{ __('messages.viewEnrollment.title', ['id' => $enrollment->id]) }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">{{ __('messages.viewEnrollment.student') }}:</div>
                <div class="col-md-9">{{ $enrollment->student->username ?? $enrollment->student->name ?? 'N/A' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">{{ __('messages.viewEnrollment.course') }}:</div>
                <div class="col-md-9">{{ $enrollment->course->title ?? 'N/A' }}</div>
            </div>

               {{-- ✅ Room --}}
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Room:</div>
                <div class="col-md-9">{{ $enrollment->room->name ?? 'Not Assigned' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">{{ __('messages.viewEnrollment.enrolledDate') }}:</div>
                <div class="col-md-9">{{ $enrollment->enrolled_date }}</div>
            </div>

            <div class="mt-4">
                <a href="{{ route('enrollments.List') }}" class="btn btn-secondary">
                    {{ __('messages.viewEnrollment.back') }}
                </a>
                <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="btn btn-primary">
                    {{ __('messages.viewEnrollment.edit') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

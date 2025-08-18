@extends('components.master')

@section('content')

<a href="{{ route('teacher.list') }}" class="btn btn-primary mt-3">
    {{ __('messages.showTeacher.back') }}
</a>

<div class="container mt-5 shadow rounded p-4" style="max-width: 1200px;">
    <h3 class="text-center mb-4">{{ __('messages.showTeacher.title') }}</h3>

    <div class="row">
        {{-- Left Column: Teacher Info --}}
        <div class="col-md-8">
            <div class="mb-3">
                <strong>{{ __('messages.showTeacher.name') }}:</strong>
                <span>{{ $teacher->name }}</span>
            </div>

            <div class="mb-3">
                <strong>{{ __('messages.showTeacher.email') }}:</strong>
                <span>{{ $teacher->email }}</span>
            </div>

            <div class="mb-3">
                <strong>{{ __('messages.showTeacher.phone') }}:</strong>
                <span>{{ $teacher->phone }}</span>
            </div>

            <div class="mb-3">
                <strong>{{ __('messages.showTeacher.specialization') }}:</strong>
                <span>{{ $teacher->specialization ?? '-' }}</span>
            </div>


            
            {{-- 👉 Teacher Address --}}
            @if($teacher->addresses->isNotEmpty())
                @foreach($teacher->addresses as $address)
                    <div class="mb-3">
                        <strong>{{ __('messages.showTeacher.address_line') }}:</strong>
                        <span>{{ $address->address_line }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>{{ __('messages.showTeacher.city') }}:</strong>
                        <span>{{ $address->city }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>{{ __('messages.showTeacher.is_main') }}:</strong>
                        <span>
                            {{ $address->is_main ? __('messages.showTeacher.main_address') : __('messages.showTeacher.secondary_address') }}
                        </span>
                    </div>
                @endforeach
            @else
                <div class="mb-3">
                    <span class="text-muted">{{ __('messages.showTeacher.no_address') }}</span>
                </div>
            @endif


            
        </div>

        {{-- Right Column: Profile Image --}}
        <div class="col-md-4 text-center">

            <div class="mt-2">
                @if($teacher->profile_image)
                    <img src="{{ asset('profile_teacher/' . $teacher->profile_image) }}" alt="Profile Image"
                        class="img-fluid rounded mb-3" style="max-width: 100%;">
                @else
                    <p class="text-muted">{{ __('messages.showTeacher.no_image') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

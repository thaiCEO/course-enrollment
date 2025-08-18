@extends('components.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('messages.teacherEdit.title') }}</h2>

            <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data" id="updateTeacherForm">
                @csrf

                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.teacherEdit.name') }}</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $teacher->name }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('messages.teacherEdit.email') }}</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ $teacher->email }}">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('messages.teacherEdit.phone') }}</label>
                            <input type="text" name="phone" class="form-control" id="phone" value="{{ $teacher->phone }}">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="specialization" class="form-label">{{ __('messages.teacherEdit.specialization') }}</label>
                            <input type="text" name="specialization" class="form-control" id="specialization" value="{{ $teacher->specialization }}">
                            @error('specialization')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">{{ __('messages.teacherEdit.profile_image') }}</label>
                            <input type="hidden" name="old_image" value="{{ $teacher->profile_image }}">
                            <input type="file" name="profile_image" class="form-control" id="profile_image">
                            @if($teacher->profile_image)
                                <img src="{{ asset('profile_teacher/' . $teacher->profile_image) }}" alt="Profile Image" class="img-thumbnail mt-2" width="200">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{ __('messages.teacherEdit.submit') }}</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('messages.teacherCreate.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

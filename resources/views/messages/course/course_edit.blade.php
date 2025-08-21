@extends('components.master')
@section('content')

<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.createCourse.editCourse') }}</h5>
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

    <form action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">{{ __('messages.editCourse.title') }}</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $course->title) }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">{{ __('messages.editCourse.description') }}</label>
            <textarea name="description" class="form-control" id="description">{{ old('description', $course->description) }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Teacher --}}
        <div class="mb-3">
            <label for="teacher_id" class="form-label">{{ __('messages.editCourse.teacher') }}</label>
            <select name="teacher_id" class="form-control" id="teacher_id">
                <option value="">{{ __('messages.editCourse.selectTeacher') }}</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
            @error('teacher_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label for="price" class="form-label">{{ __('messages.editCourse.price') }}</label>
            <input type="number" name="price" class="form-control" id="price" step="0.01" value="{{ old('price', $course->price) }}">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Course Image --}}
        <div class="mb-3">
            <label for="course_image" class="form-label">{{ __('messages.editCourse.courseImage') }}</label>
            <input type="file" name="course_image" class="form-control" id="course_image">
            @if ($course->course_image)
                <img src="{{ asset('courses/' . $course->course_image) }}" class="img-thumbnail mt-2" width="200">
            @endif
            @error('course_image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Is Active --}}
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">{{ __('messages.editCourse.isActive') }}</label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">{{ __('messages.editCourse.submit') }}</button>
        <a href="{{ route('courses.List') }}" class="btn btn-secondary">{{ __('messages.editCourse.back') }}</a>
    </form>
</div>

@endsection

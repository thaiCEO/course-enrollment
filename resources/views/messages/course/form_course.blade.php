@extends('components.master')
@section('content')


<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.createCourse.mainTitle') }}</h5>
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

    <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">{{ __('messages.createCourse.title') }}</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">{{ __('messages.createCourse.description') }}</label>
            <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Teacher --}}
        <div class="mb-3">
            <label for="teacher_id" class="form-label">{{ __('messages.createCourse.teacher') }}</label>
            <select name="teacher_id" class="form-control" id="teacher_id">
                <option value="">{{ __('messages.createCourse.selectTeacher') }}</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
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
            <label for="price" class="form-label">{{ __('messages.createCourse.price') }}</label>
            <input type="number" name="price" class="form-control" id="price" step="0.01" value="{{ old('price') }}">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Course Image --}}
        <div class="mb-3">
            <label for="course_image" class="form-label">{{ __('messages.createCourse.courseImage') }}</label>
            <input type="file" name="course_image" class="form-control" id="course_image">
            @error('course_image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Is Active --}}
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">{{ __('messages.createCourse.isActive') }}</label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">{{ __('messages.createCourse.submit') }}</button>
        <a href="{{ route('courses.List') }}" class="btn btn-secondary">{{ __('messages.createCourse.back') }}</a>
    </form>
</div>

@endsection

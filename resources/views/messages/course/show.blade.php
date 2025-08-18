@extends('components.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">{{ __('messages.viewCourse.header') }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewCourse.title') }}:</label>
                <div class="col-sm-8">{{ $course->title }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewCourse.teacher') }}:</label>
                <div class="col-sm-8">{{ $course->teacher->name ?? __('messages.viewCourse.noTeacher') }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewCourse.price') }}:</label>
                <div class="col-sm-8">${{ number_format($course->price, 2) }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewCourse.status') }}:</label>
                <div class="col-sm-8">
                    @if($course->is_active)
                        <span class="badge bg-success">{{ __('messages.viewCourse.active') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('messages.viewCourse.inactive') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewCourse.description') }}:</label>
                <div class="col-sm-8">{{ $course->description ?? __('messages.viewCourse.noDescription') }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewCourse.courseImage') }}:</label>
                <div class="col-sm-8">
                    @if($course->course_image_url)
                        <img src="{{ $course->course_image_url }}" alt="Course Image" class="img-thumbnail" style="max-width: 200px;">
                    @else
                        <p class="text-muted">{{ __('messages.viewCourse.noImage') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Table Student List Start -->
        <div class="container mt-4">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white text-center">
                    <h5 class="mb-0">{{ __('messages.viewCourse.studentListHeader') }}</h5>
                </div>
                <div class="card-body">
                    @if($students->isEmpty())
                        <p class="text-center text-muted">{{ __('messages.viewCourse.noStudents') }}</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>{{ __('messages.viewCourse.serial') }}</th>
                                        <th>{{ __('messages.viewCourse.studentId') }}</th>
                                        <th>{{ __('messages.viewCourse.studentName') }}</th>
                                        <th>{{ __('messages.viewCourse.gender') }}</th>
                                        <th>{{ __('messages.viewCourse.dob') }}</th>
                                        <th>{{ __('messages.viewCourse.enrolledDate') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $key => $student)
                                        <tr class="text-center">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $student->student_number }}</td>
                                            <td>{{ $student->username }}</td>
                                            <td>{{ $student->gender }}</td>
                                            <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($student->pivot->enrolled_date)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Table Student List End -->

        <div class="card-footer text-center">
            <a href="{{ route('courses.List') }}" class="btn btn-secondary">{{ __('messages.viewCourse.back') }}</a>
        </div>
    </div>
</div>
@endsection

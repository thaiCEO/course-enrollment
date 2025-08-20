@extends('components.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">

        <!-- Room Header -->
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">{{ __('messages.showRoom.title') }}: {{ $room->name }}</h4>
        </div>

        <!-- Room Details -->
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.showRoom.name') }}:</label>
                <div class="col-sm-8">{{ $room->name }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.showRoom.capacity') }}:</label>
                <div class="col-sm-8">{{ $room->capacity }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.showRoom.remaining') }}:</label>
                <div class="col-sm-8">{{ $room->remainingCapacity() }}</div>
            </div>
        </div>

        <!-- Courses Info (from enrollments) -->
        <div class="card-body">
            @php
                $courses = $room->enrollments->map(function($enrollment){
                    return $enrollment->course;
                })->unique('id');
            @endphp

            @foreach($courses as $course)
                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewRoomCourse.title') }}:</label>
                    <div class="col-sm-8">{{ $course->title }}</div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewRoomCourse.teacher') }}:</label>
                    <div class="col-sm-8">{{ $course->teacher->name ?? __('messages.viewRoomCourse.noTeacher') }}</div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewRoomCourse.price') }}:</label>
                    <div class="col-sm-8">${{ number_format($course->price, 2) }}</div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewRoomCourse.status') }}:</label>
                    <div class="col-sm-8">
                        @if($course->is_active)
                            <span class="badge bg-success">{{ __('messages.viewRoomCourse.active') }}</span>
                        @else
                            <span class="badge bg-danger">{{ __('messages.viewRoomCourse.inactive') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewRoomCourse.description') }}:</label>
                    <div class="col-sm-8">{{ $course->description ?? __('messages.viewRoomCourse.noDescription') }}</div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewRoomCourse.courseImage') }}:</label>
                    <div class="col-sm-8">
                        @if($course->course_image_url)
                            <img src="{{ $course->course_image_url }}" alt="Course Image" class="img-thumbnail" style="max-width: 200px;">
                        @else
                            <p class="text-muted">{{ __('messages.viewRoomCourse.noImage') }}</p>
                        @endif
                    </div>
                </div>
                <hr>
            @endforeach
        </div>


        

        <!-- Enrolled Students Table -->
        <div class="container mt-4">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white text-center">
                    <h5 class="mb-0">{{ __('messages.showRoom.enrolledStudents') }}</h5>
                </div>
                <div class="card-body">
                    @if($room->enrollments->isEmpty())
                        <p class="text-center text-muted">{{ __('messages.showRoom.noStudents') }}</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>

                                        <th>{{ __('messages.viewRoomCourse.serial') }}</th>
                                        <th>{{ __('messages.viewRoomCourse.studentId') }}</th>
                                        <th>{{ __('messages.viewRoomCourse.studentName') }}</th>
                                        <th>{{ __('messages.viewRoomCourse.gender') }}</th>
                                        <th>{{ __('messages.viewRoomCourse.dob') }}</th>
                                        <th>{{ __('messages.viewRoomCourse.enrolledDate') }}</th>
                                        <th>{{ __('messages.viewRoomCourse.courseTitle') }}</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($room->enrollments as $key => $enrollment)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $enrollment->student->student_number ?? '-' }}</td>
                                            <td>{{ $enrollment->student->username ?? $enrollment->student->name }}</td>
                                            <td>{{ $enrollment->student->gender ?? '-' }}</td>
                                            <td>{{ $enrollment->student->date_of_birth ? \Carbon\Carbon::parse($enrollment->student->date_of_birth)->format('d-m-Y') : '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($enrollment->enrolled_date)->format('d-m-Y') }}</td>
                                            <td>{{ $enrollment->course->title ?? '-' }}</td>
                                        
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="card-footer text-center">
            <a href="{{ route('room.index') }}" class="btn btn-secondary">{{ __('messages.showRoom.back') }}</a>
        </div>

    </div>
</div>
@endsection

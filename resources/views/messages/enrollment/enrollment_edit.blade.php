@extends('components.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('messages.editEnrollment.title') }}</h2>

            <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="student_id" class="form-label">{{ __('messages.editEnrollment.selectStudent') }}</label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        <option value="">{{ __('messages.editEnrollment.selectStudentPlaceholder') }}</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ $student->id == $enrollment->student_id ? 'selected' : '' }}>
                                {{ $student->username ?? $student->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="course_id" class="form-label">{{ __('messages.editEnrollment.selectCourse') }}</label>
                    <select name="course_id" id="course_id" class="form-control" required>
                        <option value="">{{ __('messages.editEnrollment.selectCoursePlaceholder') }}</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ $course->id == $enrollment->course_id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                   {{-- ✅ New Room Dropdown --}}
                <div class="mb-3">
                    <label for="room_id" class="form-label">Select Room</label>
                    <select name="room_id" id="room_id" class="form-control" required>
                        <option value="">-- Select Room --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ $room->id == $enrollment->room_id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                

                <div class="mb-3">
                    <label for="enrolled_date" class="form-label">{{ __('messages.editEnrollment.enrolledDate') }}</label>
                    <input type="date" name="enrolled_date" id="enrolled_date" class="form-control"
                        value="{{ $enrollment->enrolled_date }}" required>
                    @error('enrolled_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ __('messages.editEnrollment.updateButton') }}</button>
            </form>

        </div>
    </div>
</div>
@endsection

@extends('components.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">

        <!-- Study Time Header -->
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">{{ __('messages.viewStudyTime.title') }}: {{ $studyTime->course->title ?? '-' }}</h4>
        </div>

        <!-- Study Time Details -->
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudyTime.course') }}:</label>
                <div class="col-sm-8">{{ $studyTime->course->title ?? '-' }}</div>
            </div>


            <!-- Teacher -->
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudyTime.teachingBy') }}:</label>
                <div class="col-sm-8">{{ $studyTime->course->teacher->name ?? '-' }}</div>
            </div>


            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.studytimeList.room') }}:</label>
                <div class="col-sm-8">{{ $studyTime->room->name ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudyTime.day') }}:</label>
                <div class="col-sm-8">
                    {{ $studyTime->day_type == 'weekday' 
                        ? __('messages.viewStudyTime.weekday')   // EN/KM from lang file
                        : __('messages.viewStudyTime.weekend') 
                    }}
                </div>
            </div>

        {{-- study time  --}}
         <div class="row mb-3">
            <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudyTime.startTime') }}:</label>
            <div class="col-sm-8">
                {{ \Carbon\Carbon::parse($studyTime->start_time)->format('H:i') }} 
                (
                @php
                    $hour = \Carbon\Carbon::parse($studyTime->start_time)->hour;
                @endphp
                {{ $hour < 12 
                    ? __('messages.viewStudyTime.morning') 
                    : ($hour < 18 
                        ? __('messages.viewStudyTime.afternoon') 
                        : __('messages.viewStudyTime.night')) 
                }}
                )
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudyTime.endTime') }}:</label>
            <div class="col-sm-8">{{ \Carbon\Carbon::parse($studyTime->end_time)->format('H:i') }}</div>
        </div>






            {{-- <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudyTime.status') }}:</label>
                <div class="col-sm-8">
                    @if($studyTime->is_active)
                        <span class="badge bg-success">{{ __('messages.viewStudyTime.active') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('messages.viewStudyTime.inactive') }}</span>
                    @endif
                </div>
            </div> --}}

            {{-- <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudyTime.description') }}:</label>
                <div class="col-sm-8">{{ $studyTime->description ?? __('messages.viewStudyTime.noDescription') }}</div>
            </div> --}}
        </div>

        <!-- Enrolled Students Table -->
        <div class="container mt-4">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white text-center">
                    <h5 class="mb-0">{{ __('messages.viewStudyTime.Students') }}</h5>
                </div>
                <div class="card-body">
                    @if($studyTime->room->enrollments->isEmpty())
                        <p class="text-center text-muted">{{ __('messages.showRoom.noStudents') }}</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">{{ __('messages.viewRoomCourse.serial') }}</th>
                                        <th class="text-center">{{ __('messages.viewRoomCourse.studentId') }}</th>
                                        <th class="text-center">{{ __('messages.viewRoomCourse.studentName') }}</th>
                                        <th class="text-center">{{ __('messages.viewRoomCourse.gender') }}</th>
                                        <th class="text-center">{{ __('messages.viewRoomCourse.dob') }}</th>
                                        <th class="text-center">{{ __('messages.viewRoomCourse.enrolledDate') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studyTime->room->enrollments as $key => $enrollment)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $enrollment->student->student_number ?? '-' }}</td>
                                            <td>{{ $enrollment->student->username ?? $enrollment->student->name }}</td>
                                            <td>{{ $enrollment->student->gender ?? '-' }}</td>
                                            <td>{{ $enrollment->student->date_of_birth ? \Carbon\Carbon::parse($enrollment->student->date_of_birth)->format('d-m-Y') : '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($enrollment->enrolled_date)->format('d-m-Y') }}</td>
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
            <a href="{{ route('study-time.index') }}" class="btn btn-secondary">{{ __('messages.studytimeList.back') }}</a>
        </div>

    </div>
</div>
@endsection

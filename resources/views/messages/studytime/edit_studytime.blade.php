@extends('components.master')
@section('content')

<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.studytimeEdit.mainTitle') }}</h5>
        <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
                <a href="{{ route('study-time.index') }}"> <i class="fa fa-home"></i> </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">{{ __('messages.studytimeEdit.mainTitleDashboard') }}</a>
            </li>
          
        </ul>
    </div>
</div>
<!-- Page-header end -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('study-time.update', $studyTime->id) }}" method="POST" id="Form_editStudyTime">
                @csrf
                @method('PUT')

                {{-- Course --}}
                <div class="mb-3">
                    <label for="course_id" class="form-label">{{ __('messages.studytimeEdit.course') }}</label>
                    <select name="course_id" id="course_id" class="form-control">
                        <option value="">{{ __('messages.studytimeEdit.course_placeholder') }}</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" 
                                {{ old('course_id', $studyTime->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Room --}}
                <div class="mb-3">
                    <label for="room_id" class="form-label">{{ __('messages.studytimeEdit.room') }}</label>
                    <select name="room_id" id="room_id" class="form-control">
                        <option value="">{{ __('messages.studytimeEdit.room_placeholder') }}</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" 
                                {{ old('room_id', $studyTime->room_id) == $room->id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Day Type --}}
                <div class="mb-3">
                    <label for="day_type" class="form-label">{{ __('messages.studytimeEdit.day_type') }}</label>
                    <select name="day_type" id="day_type" class="form-control">
                        <option value="">{{ __('messages.studytimeEdit.day_type_placeholder') }}</option>
                        <option value="weekday" {{ old('day_type', $studyTime->day_type) == 'weekday' ? 'selected' : '' }}>
                            {{ __('messages.studytimeEdit.weekday') }}
                        </option>
                        <option value="weekend" {{ old('day_type', $studyTime->day_type) == 'weekend' ? 'selected' : '' }}>
                            {{ __('messages.studytimeEdit.weekend') }}
                        </option>
                    </select>
                    @error('day_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

             {{-- Start Time --}}
                <div class="mb-3">
                    <label for="start_time" class="form-label">{{ __('messages.studytimeEdit.start_time') }}</label>
                    <input type="time" name="start_time" id="start_time" class="form-control"
                        value="{{ old('start_time', \Carbon\Carbon::parse($studyTime->start_time)->format('H:i')) }}">
                    @error('start_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- End Time --}}
                <div class="mb-3">
                    <label for="end_time" class="form-label">{{ __('messages.studytimeEdit.end_time') }}</label>
                    <input type="time" name="end_time" id="end_time" class="form-control"
                        value="{{ old('end_time', \Carbon\Carbon::parse($studyTime->end_time)->format('H:i')) }}">
                    @error('end_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Actions --}}
                <button type="submit" class="btn btn-primary">{{ __('messages.studytimeEdit.update') }}</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('messages.studytimeEdit.back') }}</a>
            </form>
        </div>
    </div>
</div>

@endsection

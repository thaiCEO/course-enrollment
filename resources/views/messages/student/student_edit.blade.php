@extends('components.master')

@section('content')


<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.editStudent.page_title') }}</h5>
        <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
                <a href="index.html"><i class="fa fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('messages.createFormStudent.dashboard') }}</a></li>
        </ul>
    </div>
</div>
<!-- Page-header end -->


<div class="container">
    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data" id="updateStudentForm">
                @csrf

                <div class="row">
                    <!-- Left Side: Form Fields (col-9) -->
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="username" class="form-label">{{ __('messages.editStudent.name') }}</label>
                            <input type="text" name="username" class="form-control" id="username" value="{{ $student->username }}">
                            @error('username')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">{{ __('messages.editStudent.date_of_birth') }}</label>
                            <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="{{ $student->date_of_birth }}">
                            @error('date_of_birth')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                       <div class="mb-3">
                            <label for="gender" class="form-label">ភេទ</label>
                            <select class="form-select" id="gender" name="gender" >
                                <option value="ប្រុស" {{ $student->gender == 'ប្រុស' ? 'selected' : '' }}>{{ __('messages.editStudent.male') }}</option>
                                <option value="ស្រី" {{ $student->gender == 'ស្រី' ? 'selected' : '' }}>{{ __('messages.editStudent.female') }}</option>
                            </select>
                            @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('messages.editStudent.address') }}</label>
                            <input type="text" name="address" class="form-control" id="address" value="{{ $student->address }}">
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">{{ __('messages.editStudent.phone') }}</label>
                            <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ $student->phone_number }}">
                            @error('phone_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Side: Profile Image (col-3) -->
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            <label for="profile_student" class="form-label">{{ __('messages.editStudent.profile_image') }}</label>
                            <input type="hidden" name="old_image" value="{{ $student->profile_student }}">
                            <input type="file" name="profile_student" class="form-control" id="profile_student">
                            @if($student->profile_student)
                                <img src="{{ asset('profile_student/' . $student->profile_student) }}" alt="Profile Image" class="img-thumbnail mt-2" width="300">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{ __('messages.editStudent.submit') }}</button>
                    <a href="{{ route('student.list') }}" class="btn btn-secondary">{{ __('messages.editCourse.back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

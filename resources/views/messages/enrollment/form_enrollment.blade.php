@extends('components.master')
@section('content')

<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.createEnrollment.title') }}</h5>
        <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}"> <i class="fa fa-home"></i> </a>
            </li>
            <li class="breadcrumb-item">
                <a href="#!">{{ __('messages.createEnrollment.dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#!">{{ __('messages.createEnrollment.breadcrumb') }}</a>
            </li>
        </ul>
    </div>
</div>
<!-- Page-header end -->

<div class="container">
    <div class="row">
        <div class="container">

            <form action="{{ route('enrollments.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="student_id" class="form-label">{{ __('messages.createEnrollment.selectStudent') }}</label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        <option value="">{{ __('messages.createEnrollment.selectStudentPlaceholder') }}</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->username ?? $student->name }}</option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="course_id" class="form-label">{{ __('messages.createEnrollment.selectCourse') }}</label>
                    <select name="course_id" id="course_id" class="form-control" required>
                        <option value="">{{ __('messages.createEnrollment.selectCoursePlaceholder') }}</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="enrolled_date" class="form-label">{{ __('messages.createEnrollment.enrolledDate') }}</label>
                    <input type="date" name="enrolled_date" class="form-control" id="enrolled_date" required>
                    @error('enrolled_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ __('messages.createEnrollment.submitButton') }}</button>
            </form>

        </div>
    </div>
</div>

<div id="toastBox"></div>

@endsection




@section('script')
 <script>
     const crateStudent = (form) => {
         const formData = new FormData($(form)[0]);

        $.ajax({
            type: "POST",
            url: "{{ route('student.store') }}",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.status == 200) {
                  $(form).trigger('reset');

                  $('#username').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                  $('#gender').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                  $('#date_of_birth').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                  $('#phone_number').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                  $('#address').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');


                //   Swal.fire({
                //             title: response.message,
                //             icon: "success",
                //             confirmButtonText: "OK"
                //         });
                
                  //redirect to student list page
                  window.location.href = "{{ route('student.list')}}";

                }else {
                    let errors = response.errors;

                // Clear previous error messages
                $('#username').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                $('#gender').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                $('#date_of_birth').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                $('#phone_number').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');
                $('#address').removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');

                // Display error messages
                if (errors.username) {
                    $('#username').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.username);
                }
                if (errors.gender) {
                    $('#gender').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.gender);
                }
                if (errors.date_of_birth) {
                    $('#date_of_birth').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.date_of_birth);
                }
                if (errors.phone_number) {
                    $('#phone_number').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.phone_number);
                }
                if (errors.address) {
                    $('#address').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.address);
                }

                }
            }
        });
     }

     $(document).ready(function () {
    $.ajax({
        url: "{{ route('student.data') }}",
        type: "POST",
        dataType: "json",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
            let classRoomSelect = $("#class_room"); // Correct variable name
            classRoomSelect.empty();
            classRoomSelect.append('<option selected>ជ្រើសរើស</option>');

            response.forEach(class_room => {
                classRoomSelect.append(`<option value="${class_room.id}">${class_room.room_name}</option>`);
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
});



 </script>
@endsection

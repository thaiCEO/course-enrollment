@extends('components.master')
@section('content')


<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.createFormStudent.mainTitle') }}</h5>
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
        <div class="container">
            <form action="" method="POST" id="Form_addUser" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">{{ __('messages.createFormStudent.username') }}</label>
                    <input type="text" name="username" class="form-control" id="username"
                        placeholder="{{ __('messages.createFormStudent.username') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="student_number" class="form-label">{{ __('messages.createFormStudent.student_number') }}</label>
                    <input type="text" name="student_number" class="form-control" id="student_number"
                        placeholder="{{ __('messages.createFormStudent.student_number') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">{{ __('messages.createFormStudent.date_of_birth') }}</label>
                    <input type="date" name="date_of_birth" class="form-control" id="date_of_birth"
                        placeholder="{{ __('messages.createFormStudent.date_of_birth') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">{{ __('messages.createFormStudent.gender') }}</label>
                    <select class="form-select" id="gender" name="gender">
                        <option selected>{{ __('messages.createFormStudent.select_gender') }}</option>
                        <option value="ប្រុស">{{ __('messages.createFormStudent.male') }}</option>
                        <option value="ស្រី">{{ __('messages.createFormStudent.female') }}</option>
                    </select>
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">{{ __('messages.createFormStudent.address') }}</label>
                    <input type="text" name="address" class="form-control" id="address"
                        placeholder="{{ __('messages.createFormStudent.address') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">{{ __('messages.createFormStudent.phone_number') }}</label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number"
                        placeholder="{{ __('messages.createFormStudent.phone_number') }}">
                    <p></p>
                </div>

                <div class="mb-3">
                    <label for="profile_student" class="form-label">{{ __('messages.createFormStudent.profile_student') }}</label>
                    <input type="file" name="profile_student" class="form-control" id="photo">
                </div>

                <button onclick="crateStudent('#Form_addUser')" type="button" class="btn btn-primary">
                    {{ __('messages.createFormStudent.save') }}
                </button>
                <a href="{{ route('student.list') }}" class="btn btn-secondary">
                    {{ __('messages.createFormStudent.back') }}
                </a>
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

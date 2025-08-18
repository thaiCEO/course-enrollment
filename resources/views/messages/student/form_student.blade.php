@extends('components.master')
@section('content')



    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">Form Student</h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item">
                    <a href="index.html"> <i class="fa fa-home"></i> </a>
                </li>
               <li class="breadcrumb-item"><a href="#!">dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!"></a>
                        </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->

    <div class="container">
        <div class="row">
         <div class="container">
            <form action="" method="POST" id="Form_addUser" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="username" class="form-label">គោត្តនាម​ / នាម</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                <p></p>
              </div>

              <div class="mb-3">
                <label for="student_number" class="form-label">លេខសម្គាល់សិស្ស</label>
                <input type="text" name="student_number" class="form-control" id="student_number" placeholder="Student Number">
                <p></p>
             </div>

              <div class="mb-3">
                <label for="date_of_birth" class="form-label">ថ្ងៃ/ខែ/ឆ្នាំ/កំណើត</label>
                <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" placeholder="Birth year">
                <p></p>
              </div>

              <div class="mb-3">
                <label for="gender" class="form-label">ភេទ</label>
                <select class="form-select" id="gender" name="gender" aria-label="Gender select">
                  <option selected>ជ្រើសរើស</option>
                  <option value="ប្រុស">ប្រុស</option>
                  <option value="ស្រី">ស្រី</option>
                </select>
                <p></p>
              </div>


              {{-- <div class="mb-3">
                <label for="job" class="form-label">មុខរបប</label>
                <input type="text" name="job" class="form-control" id="job" placeholder="Job">
              </div> --}}

              <div class="mb-3">
                <label for="address" class="form-label">អាស័យដ្ឋាន បច្ចុប្បន្ន</label>
                <input type="text" name="address" class="form-control" id="address" placeholder="Address">
                <p></p>
              </div>

              <div class="mb-3">
                <label for="phone_number" class="form-label">លេខ​ ទូរស័ព្ទ</label>
                <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="Tell">
                <p></p>
              </div>

            
             <div class="col-md-4">
              <div class="mb-3">
                <label for="profile_student" class="form-label">រូបថត</label>
                <input type="file" name="profile_student" class="form-control" id="photo">
              </div>


              <button onclick="crateStudent('#Form_addUser')" type="button" class="btn btn-primary">Save User</button>
            </form>
          </div>



            <!-- <button type="button" class="btn btn-primary mb-3">Upload Image</button>

            <div class="preview_img">
            </div> -->
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

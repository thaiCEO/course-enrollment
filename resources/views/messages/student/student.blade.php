@extends('components.master')
@section('content')

        @if(Session::has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "{{ Session::get('success') }}",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500,
                });
            });
        </script>
        @endif

     <!-- tabs card start -->
     <div class="col-sm-12">
        <div class="card tabs-card">
            <div class="card-block p-0">
                <!-- Nav tabs -->
               <ul class="nav nav-tabs md-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home3" role="tab">
                            <i class="ti-id-badge"></i> {{ __('messages.studentList.tab_home') }}
                        </a>
                        <div class="slide"></div>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile3" role="tab">
                            <i class="fa fa-key"></i> {{ __('messages.studentList.tab_security') }}
                        </a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#messages3" role="tab">
                            <i class="fa fa-play-circle"></i> {{ __('messages.studentList.tab_entertainment') }}
                        </a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">
                            <i class="fa fa-database"></i> {{ __('messages.studentList.tab_bigdata') }}
                        </a>
                        <div class="slide"></div>
                    </li> --}}
                </ul>


                <!-- Tab panes -->
                <div class="tab-content card-block">
                    <div class="tab-pane active" id="home3" role="tabpanel">

                    @can('create student')
                      <a href="{{ route('student.create') }}" class="btn btn-primary mb-3">+ {{ __('messages.studentList.addStudent') }}</a>
                    @endcan
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>{{ __('messages.studentList.id') }}</th>
                                    <th>{{ __('messages.studentList.image') }}</th>
                                    <th>{{ __('messages.studentList.username') }}</th>
                                    <th>{{ __('messages.studentList.gender') }}</th>
                                    <th>{{ __('messages.studentList.dob') }}</th>
                                    <th>{{ __('messages.studentList.phone') }}</th>
                                    <th>{{ __('messages.studentList.address') }}</th>
                                    <th>{{ __('messages.studentList.actions') }}</th>

                                </tr>
                                @foreach ( $students as $student )

                                <tr>
                                    <td>

                                     ST{{ $loop->iteration }}
                                     
                                        <input onchange="handleSelect()" student_ids="" type="checkbox" name="student_id" value="{{$student->id}}">
                                    </td>
                                    <td><img style="width: 50px; height: 50px;" src="{{asset('profile_student/'.$student->profile_student)}}" alt="prod img" class="img-fluid"></td>
                                    <td>{{$student->username}}</td>
                                    <td>{{$student->gender}}</td>
                                    <td>{{$student->date_of_birth}}</td>
                                    <td><span class="label label-primary">{{$student->phone_number}}</span></td>
                                    <td>{{$student->address}}</td>
                                    
                                    <td>

                                        @can('read student')
                                        <a href="{{route('student.show' , $student->id)}}" class="btn btn-sm btn-warning">{{ __('messages.studentList.view') }}</a>
                                        @endcan
                                          <!-- Edit Button -->

                                        @can('update student')
                                        <!-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateStudentModal" onclick="editTeacher">Edit</button> -->
                                        <a class="btn btn-sm btn-primary" href="{{route('student.edit' , $student->id )}}">{{ __('messages.studentList.edit') }}</a>
                                        @endcan

                                        @can('delete student')
  
                                          <form action="{{ route('student.delete', $student->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-student-btn">
                                                    {{ __('messages.studentList.delete') }}
                                                </button>
                                            </form>

                                        @endcan
                                    </td>
                                </tr>

                                @endforeach
                            </table>
                        </div>
                        <div class="btn-wrapper d-flex justify-content-between align-items-center">

                            <div class="">
                                {{$students->links()}}
                            </div>
                            <div class="seleteStudent">
                                <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none"> {{ __('messages.studentList.delete_selected') }}</button>
                            </div>

                        </div>
                    </div>
                    {{-- <div class="tab-pane" id="profile3" role="tabpanel">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Image</th>
                                    <th>Product Code</th>
                                    <th>Customer</th>
                                    <th>Purchased On</th>
                                    <th>Status</th>
                                    <th>Transaction ID</th>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/product/prod3.jpg" alt="prod img" class="img-fluid"></td>
                                    <td>PNG002653</td>
                                    <td>Eugine Turner</td>
                                    <td>04-01-2017</td>
                                    <td><span class="label label-success">Delivered</span></td>
                                    <td>#7234417</td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/product/prod4.jpg" alt="prod img" class="img-fluid"></td>
                                    <td>PNG002156</td>
                                    <td>Jacqueline Howell</td>
                                    <td>03-01-2017</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td>#7234454</td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages3" role="tabpanel">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Image</th>
                                    <th>Product Code</th>
                                    <th>Customer</th>
                                    <th>Purchased On</th>
                                    <th>Status</th>
                                    <th>Transaction ID</th>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/product/prod1.jpg" alt="prod img" class="img-fluid"></td>
                                    <td>PNG002413</td>
                                    <td>Jane Elliott</td>
                                    <td>06-01-2017</td>
                                    <td><span class="label label-primary">Shipping</span></td>
                                    <td>#7234421</td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/product/prod4.jpg" alt="prod img" class="img-fluid"></td>
                                    <td>PNG002156</td>
                                    <td>Jacqueline Howell</td>
                                    <td>03-01-2017</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td>#7234454</td>
                                </tr>
                            </table>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                        </div>
                    </div>
                    <div class="tab-pane" id="settings3" role="tabpanel"> --}}

                        {{-- <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Image</th>
                                    <th>Product Code</th>
                                    <th>Customer</th>
                                    <th>Purchased On</th>
                                    <th>Status</th>
                                    <th>Transaction ID</th>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/product/prod1.jpg" alt="prod img" class="img-fluid"></td>
                                    <td>PNG002413</td>
                                    <td>Jane Elliott</td>
                                    <td>06-01-2017</td>
                                    <td><span class="label label-primary">Shipping</span></td>
                                    <td>#7234421</td>
                                </tr>
                                <tr>
                                    <td><img src="assets/images/product/prod2.jpg" alt="prod img" class="img-fluid"></td>
                                    <td>PNG002344</td>
                                    <td>John Deo</td>
                                    <td>05-01-2017</td>
                                    <td><span class="label label-danger">Faild</span></td>
                                    <td>#7234486</td>
                                </tr>
                            </table>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-outline-primary btn-round btn-sm"></button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tabs card end -->


@endsection


@section('script')
<script>
    const handleSelect = () => {
        let selectedStudent = [];

        $('input[type="checkbox"]:checked').each(function () {
            selectedStudent.push($(this).val());
        });

        let student_ids = selectedStudent.join(',');

        if(selectedStudent.length >= 1){
            $('#deleteSelected').removeClass('d-none');
            $("#deleteSelected").attr("student_ids", student_ids);
        } else {
            $('#deleteSelected').addClass('d-none');
        }
    }

const deleteSelected = () => {
    const selectedIds = Array.from(document.querySelectorAll('input[name="student_id"]:checked'))
                             .map(cb => cb.value);

    if (selectedIds.length === 0) {
        Swal.fire({
            icon: 'info',
            title: '{{ __("messages.deleteStudentSelect.no_selected") }}',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    const deleteBtn = document.getElementById('deleteSelected');
    deleteBtn.disabled = true;

    Swal.fire({
        title: '{{ __("messages.deleteStudentSelect.delete_selected_confirm") }}',
        text: '{{ __("messages.deleteStudentSelect.delete_count_text", ["count" => "__COUNT__"]) }}'.replace('__COUNT__', selectedIds.length),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("messages.deleteStudentSelect.yes_delete") }}',
        cancelButtonText: '{{ __("messages.deleteStudentSelect.cancel") }}'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                type: "POST",
                url: "{{ route('student.deleteSeletedStudent') }}",
                data: {
                    selected_id: selectedIds.join(','),
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response){
                    if(response.status == 200){
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("messages.deleteStudentSelect.deleted_success") }}',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href="{{ route('student.list') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.deleteStudentSelect.error_delete") }}'
                        });
                    }
                },
                error: function(xhr){
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("messages.deleteStudentSelect.error_delete") }}',
                        text: xhr.responseText
                    });
                },
                complete: function() {
                    deleteBtn.disabled = false;
                }
            });
        } else {
            deleteBtn.disabled = false;
        }
    });
}


    //delete student
    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-student-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: '{{ __("messages.deleteStudent.confirm_title") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __("messages.deleteStudent.confirm_button") }}',
                cancelButtonText: '{{ __("messages.deleteStudent.cancel_button") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection

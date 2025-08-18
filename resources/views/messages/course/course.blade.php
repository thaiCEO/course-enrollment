@extends('components.master')
@section('content')

@if(Session::has('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "{{ Session::get('success') }}",
            icon: "success",
            showConfirmButton: false,
            timer: 2000,
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
                        <i class="fa fa-home"></i> {{ __('messages.courseList.tabs.courses') }}
                    </a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile3" role="tab">
                        <i class="fa fa-key"></i> {{ __('messages.courseList.tabs.security') }}
                    </a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages3" role="tab">
                        <i class="fa fa-play-circle"></i> {{ __('messages.courseList.tabs.entertainment') }}
                    </a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">
                        <i class="fa fa-database"></i> {{ __('messages.courseList.tabs.bigData') }}
                    </a>
                    <div class="slide"></div>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="home3" role="tabpanel">

                    <a href="{{ route('course.create') }}" class="btn btn-primary mb-3">
                        {{ __('messages.courseList.addCourse') }}
                    </a>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.courseList.table.id') }}</th>
                                    <th>{{ __('messages.courseList.table.image') }}</th>
                                    <th>{{ __('messages.courseList.table.title') }}</th>
                                    <th>{{ __('messages.courseList.table.description') }}</th>
                                    <th>{{ __('messages.courseList.table.teacher') }}</th>
                                    <th>{{ __('messages.courseList.table.price') }}</th>
                                    <th>{{ __('messages.courseList.table.active') }}</th>
                                    <th>{{ __('messages.courseList.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                <tr>
                                    <td>CO{{ $course->id }}</td>
                                    <td>
                                        @if ($course->course_image)
                                            <img src="{{ asset('courses/' . $course->course_image) }}" width="60" class="img-thumbnail">
                                        @else
                                            <span>{{ __('messages.courseList.table.noImage') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $course->title }}</td>
                                    <td>{{ Str::limit($course->description, 60) }}</td>
                                    <td>{{ $course->teacher->name ?? '-' }}</td>
                                    <td>${{ number_format($course->price, 2) }}</td>
                                    <td>{{ $course->is_active ? __('messages.courseList.table.yes') : __('messages.courseList.table.no') }}</td>
                                    <td>
                                        <a href="{{ route('course.show', $course->id) }}" class="btn btn-sm btn-warning">
                                            {{ __('messages.courseList.table.view') }}
                                        </a>
                                        <a href="{{ route('course.edit', $course->id) }}" class="btn btn-sm btn-primary">
                                            {{ __('messages.courseList.table.edit') }}
                                        </a>

                                        <form action="{{ route('course.destroy', $course->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('{{ __('messages.courseList.table.confirmDelete') }}')" class="btn btn-sm btn-danger">
                                                {{ __('messages.courseList.table.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-wrapper d-flex justify-content-between align-items-center">
                        <div class="">
                            {{ $courses->links() }}
                        </div>
                        <div class="seleteStudent">
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-round btn-sm d-none">
                                {{ __('messages.courseList.table.delete') }} Selected
                            </button>
                        </div>
                    </div>

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
        let seletedStudent = [];

        $('input[type="checkbox"]:checked').each(function () {
            seletedStudent.push($(this).val());
        });


        let student_ids = seletedStudent.join(',');

        if(seletedStudent.length >= 1){
            $('#deleteSelected').removeClass('d-none');
            $("#deleteSelected").attr("student_ids",student_ids);
        }else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    const deleteSelected = () => {
        if(confirm('Are you sure you want to delete?')) {
            let student_ids = $('#deleteSelected').attr('student_ids');

            $.ajax({
                type: "POST",
                url: "{{ route('student.deleteSeletedStudent') }}",
                data: {
                    selected_id: student_ids, // Corrected key to match controller
                    _token: '{{ csrf_token() }}' // Add CSRF token
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == 200) {
                        window.location.href="{{ route('student.list')}}";
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }
</script>
@endsection

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
                       <i class="ti-book"></i> {{ __('messages.courseList.tabs.courses') }}
                    </a>
                    <div class="slide"></div>
                </li>
                {{-- <li class="nav-item">
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
                </li> --}}
            </ul>

            <!-- Tab panes -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="home3" role="tabpanel">

                    @can('create course')
                    <a href="{{ route('course.create') }}" class="btn btn-primary mb-3">
                        {{ __('messages.courseList.addCourse') }}
                    </a>
                    @endcan

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
                                   <td>
                                        C{{ $loop->iteration }}
                                        <input onchange="handleSelect()" course_ids="" type="checkbox" name="course_id" value="{{ $course->id }}">
                                    </td>

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
                                    {{-- View Course --}}
                                    @can('read course')
                                        <a href="{{ route('course.show', $course->id) }}" 
                                        class="btn btn-sm btn-warning">
                                            {{ __('messages.courseList.table.view') }}
                                        </a>
                                    @endcan

                                    {{-- Edit Course --}}
                                    @can('update course')
                                        <a href="{{ route('course.edit', $course->id) }}" 
                                        class="btn btn-sm btn-primary">
                                            {{ __('messages.courseList.table.edit') }}
                                        </a>
                                    @endcan

                                    {{-- Delete Course --}}
                                    @can('delete course')
                                       <form action="{{ route('course.destroy', $course->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-course-btn">
                                                {{ __('messages.courseList.table.delete') }}
                                            </button>
                                        </form>
                                    @endcan
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
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">
                                {{ __('messages.deleteCourseSelect.delete_selected') }}
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
    let selectedCourses = [];

    $('input[name="course_id"]:checked').each(function () {
        selectedCourses.push($(this).val());
    });

    let course_ids = selectedCourses.join(',');

    if(selectedCourses.length >= 1){
        $('#deleteSelected').removeClass('d-none');
        $("#deleteSelected").attr("course_ids", course_ids);
    } else {
        $('#deleteSelected').addClass('d-none');
    }
}

const deleteSelected = () => {
    const selectedIds = Array.from(document.querySelectorAll('input[name="course_id"]:checked'))
                             .map(cb => cb.value);

    if(selectedIds.length === 0){
        Swal.fire({
            icon: 'info',
            title: '{{ __("messages.deleteCourseSelect.no_selected") }}',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    const deleteBtn = document.getElementById('deleteSelected');
    deleteBtn.disabled = true;

    Swal.fire({
        title: '{{ __("messages.deleteCourseSelect.delete_selected_confirm") }}',
        text: '{{ __("messages.deleteCourseSelect.delete_count_text", ["count" => "__COUNT__"]) }}'.replace('__COUNT__', selectedIds.length),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("messages.deleteCourseSelect.yes_delete") }}',
        cancelButtonText: '{{ __("messages.deleteCourseSelect.cancel") }}'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                type: "POST",
                url: "{{ route('course.deleteSelectedCourse') }}",
                data: {
                    selected_id: selectedIds.join(','),
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response){
                    if(response.status == 200){
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("messages.deleteCourseSelect.deleted_success") }}',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href="{{ route('courses.List') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.deleteCourseSelect.error_delete") }}'
                        });
                    }
                },
                error: function(xhr){
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("messages.deleteCourseSelect.error_delete") }}',
                        text: xhr.responseText
                    });
                },
                complete: function(){
                    deleteBtn.disabled = false;
                }
            });
        } else {
            deleteBtn.disabled = false;
        }
    });
}


    //delete course
    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-course-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: '{{ __("messages.deleteCourse.confirm_title") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __("messages.deleteCourse.confirm_button") }}',
                cancelButtonText: '{{ __("messages.deleteCourse.cancel_button") }}'
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

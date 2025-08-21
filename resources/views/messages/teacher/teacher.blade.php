@extends('components.master')

@section('content')

@if(Session::has('success'))
<script>

    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: "{{ Session::get('success') }}",
            icon: "success",
            showConfirmButton: false,
            timer: 1500,
        });
    });

    
</script>
@endif

<div class="col-sm-12">
    <div class="card tabs-card">
        <div class="card-block p-0">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs md-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#teachers-tab" role="tab">
                        <i class="fa fa-user"></i> {{ __('messages.teacherList.title') }}
                    </a>
                    <div class="slide"></div>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="teachers-tab" role="tabpanel">
                    @can('create teacher')
                    <a href="{{ route('teacher.create') }}" class="btn btn-primary mb-3">+ {{ __('messages.teacherList.add_teacher') }}</a>
                    @endcan

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.teacherList.id') }}</th>
                                    <th>{{ __('messages.teacherList.image') }}</th>
                                    <th>{{ __('messages.teacherList.name') }}</th>
                                    <th>{{ __('messages.teacherList.email') }}</th>
                                    <th>{{ __('messages.teacherList.phone') }}</th>
                                    <th>{{ __('messages.teacherList.specialization') }}</th>
                                    <th>{{ __('messages.teacherList.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $teacher)
                                <tr>
                                    <td>
                                        T{{ $loop->iteration }}
                                        <input onchange="handleSelect()" type="checkbox" name="teacher_id" value="{{ $teacher->id }}">
                                    </td>
                                    <td>
                                        <img style="width: 50px; height: 50px;" class="img-fluid rounded-circle"
                                            src="{{ $teacher->profile_image ? asset('profile_teacher/' . $teacher->profile_image) : asset('images/default.png') }}"
                                            alt="Profile">
                                    </td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td><span class="label label-primary">{{ $teacher->phone }}</span></td>
                                    <td>{{ $teacher->specialization ?? '-' }}</td>
                                  <td>
                                        {{-- View Teacher --}}
                                        @can('read teacher')
                                            <a href="{{ route('teacher.show', $teacher->id) }}" 
                                            class="btn btn-sm btn-warning">
                                                {{ __('messages.teacherList.view') }}
                                            </a>
                                        @endcan

                                        {{-- Edit Teacher --}}
                                        @can('update teacher')
                                            <a href="{{ route('teacher.edit', $teacher->id) }}" 
                                            class="btn btn-sm btn-primary">
                                                {{ __('messages.teacherList.edit') }}
                                            </a>
                                        @endcan

                                        {{-- Delete Teacher --}}
                                        @can('delete teacher')
                                           <form action="{{ route('teacher.delete', $teacher->id) }}" 
                                                method="POST" 
                                                class="d-inline delete-teacher-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-teacher-btn">
                                                    {{ __('messages.teacherList.delete') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">{{ __('messages.teacherList.no_data') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-wrapper d-flex justify-content-between align-items-center mt-3">
                        <div>{{ $teachers->links() }}</div>
                       <div class="selectTeacher">
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">
                                {{ __('messages.teacherList.delete_selected') }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@section('script')
<script>

    // Handle checkbox selection
    const handleSelect = () => {
        let selectedTeacher = [];

        $('input[name="teacher_id"]:checked').each(function () {
            selectedTeacher.push($(this).val());
        });

        let teacher_ids = selectedTeacher.join(',');

        if (selectedTeacher.length > 0) {
            $('#deleteSelected').removeClass('d-none');
            $('#deleteSelected').attr('teacher_ids', teacher_ids);
        } else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    // Delete selected teachers
  const deleteSelected = () => {
    const selectedIds = Array.from(document.querySelectorAll('input[name="teacher_id"]:checked'))
                             .map(cb => cb.value);

    if (selectedIds.length === 0) {
        Swal.fire({
            icon: 'info',
            title: '{{ __("messages.deleteTeacherSelect.no_selected") }}',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    const deleteBtn = document.getElementById('deleteSelected');
    deleteBtn.disabled = true;

    Swal.fire({
        title: '{{ __("messages.deleteTeacherSelect.delete_selected_confirm") }}',
        text: '{{ __("messages.deleteTeacherSelect.delete_count_text", ["count" => "__COUNT__"]) }}'.replace('__COUNT__', selectedIds.length),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("messages.deleteTeacherSelect.yes_delete") }}',
        cancelButtonText: '{{ __("messages.deleteTeacherSelect.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ route('teacher.deleteSelectedTeacher') }}",
                data: {
                    selected_id: selectedIds.join(','),
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("messages.deleteTeacherSelect.deleted_success") }}',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.deleteTeacherSelect.error_delete") }}'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("messages.deleteTeacherSelect.error_delete") }}',
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




// Delete Teacher with sweet alert

document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-teacher-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form'); // find the parent form

            Swal.fire({
                title: '{{ __("messages.deleteTeacher.confirm_title") }}',
              
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __("messages.deleteTeacher.confirm_button") }}',
                cancelButtonText: '{{ __("messages.deleteTeacher.cancel_button") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // submit the form if confirmed
                }
            });
        });
    });
});



</script>
@endsection

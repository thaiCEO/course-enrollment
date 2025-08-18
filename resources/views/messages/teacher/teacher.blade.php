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
                    <a href="{{ route('teacher.create') }}" class="btn btn-primary mb-3">+ {{ __('messages.teacherList.add_teacher') }}</a>

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
                                        TC{{ $loop->iteration }}
                                        <input onchange="handleSelect()" type="checkbox" name="teacher_id" value="{{ $teacher->id }}">
                                    </td>
                                    <td>
                                        <img style="width: 50px; height: 50px;" class="img-fluid rounded-circle"
                                            src="{{ $teacher->profile_image ? asset('profile_teacher/' . $teacher->profile_image) : asset('images/default.png') }}"
                                            alt="Profile">
                                    </td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td><span class="label label-danger">{{ $teacher->phone }}</span></td>
                                    <td>{{ $teacher->specialization ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('teacher.show', $teacher->id) }}" class="btn btn-sm btn-warning">{{ __('messages.teacherList.view') }}</a>
                                        <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-sm btn-primary">{{ __('messages.teacherList.edit') }}</a>


                                           <form action="{{ route('teacher.delete', $teacher->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this teacher?')">
                                                 {{ __('messages.teacherList.delete') }}
                                            </button>
                                        </form>
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
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">{{ __('messages.teacherList.delete_selected') }}</button>
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
    const handleSelect = () => {
        let selected = [];

        $('input[name="teacher_id"]:checked').each(function () {
            selected.push($(this).val());
        });

        let teacher_ids = selected.join(',');

        if (selected.length > 0) {
            $('#deleteSelected').removeClass('d-none');
            $('#deleteSelected').attr('teacher_ids', teacher_ids);
        } else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    const deleteSelected = () => {
        if (confirm('Are you sure you want to delete selected teachers?')) {
            let teacher_ids = $('#deleteSelected').attr('teacher_ids');

            $.ajax({
                type: "POST",
                url: "{{ route('teacher.deleteSelectedTeacher') }}",
                data: {
                    selected_id: teacher_ids,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        window.location.href = "{{ route('teacher.list') }}";
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>
@endsection

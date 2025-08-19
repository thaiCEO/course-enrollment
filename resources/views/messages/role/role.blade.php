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
                    <a class="nav-link active" data-toggle="tab" href="#roles-tab" role="tab">
                        <i class="fa fa-lock"></i> {{ __('messages.roleList.title') }}
                    </a>
                    <div class="slide"></div>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="roles-tab" role="tabpanel">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">+ {{ __('messages.roleList.add_role') }}</a>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.roleList.id') }}</th>
                                    <th>{{ __('messages.roleList.name') }}</th>
                                    <th>{{ __('messages.roleList.guard') }}</th>
                                    <th>{{ __('messages.roleList.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                <tr>
                                    <td>
                                        RL{{ $loop->iteration }}
                                        <input onchange="handleSelect()" type="checkbox" name="role_id" value="{{ $role->id }}">
                                    </td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>
                                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-warning">{{ __('messages.roleList.view') }}</a>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">{{ __('messages.roleList.edit') }}</a>

                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this role?')">
                                                {{ __('messages.roleList.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">{{ __('messages.roleList.no_data') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-wrapper d-flex justify-content-between align-items-center mt-3">
                        <div>{{ $roles->links() }}</div>
                        <div class="selectRole">
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">{{ __('messages.roleList.delete_selected') }}</button>
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

        $('input[name="role_id"]:checked').each(function () {
            selected.push($(this).val());
        });

        let role_ids = selected.join(',');

        if (selected.length > 0) {
            $('#deleteSelected').removeClass('d-none');
            $('#deleteSelected').attr('role_ids', role_ids);
        } else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    const deleteSelected = () => {
        if (confirm('Are you sure you want to delete selected roles?')) {
            let role_ids = $('#deleteSelected').attr('role_ids');

            $.ajax({
                type: "POST",
                url: "{{ route('roles.deleteSelectedRole') }}",
                data: {
                    selected_id: role_ids,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        window.location.href = "{{ route('roles.index') }}";
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

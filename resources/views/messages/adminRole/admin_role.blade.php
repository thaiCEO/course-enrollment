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
                    <a class="nav-link active" data-toggle="tab" href="#admins-tab" role="tab">
                        <i class="fa fa-user-shield"></i> {{ __('messages.adminRoleList.title') }}
                    </a>
                    <div class="slide"></div>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="admins-tab" role="tabpanel">
                    <a href="{{ route('admin-role.create') }}" class="btn btn-primary mb-3">
                        + {{ __('messages.adminRoleList.add_admin') }}
                    </a>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.adminRoleList.id') }}</th>
                                    <th>{{ __('messages.adminRoleList.name') }}</th>
                                    <th>{{ __('messages.adminRoleList.email') }}</th>
                                    <th>{{ __('messages.adminRoleList.is_admin') }}</th>
                                    <th>{{ __('messages.adminRoleList.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $admin)
                                <tr>
                                    <td>
                                        AD{{ $loop->iteration }}
                                        <input onchange="handleSelect()" type="checkbox" name="admin_id" value="{{ $admin->id }}">
                                    </td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->is_Admin ? __('messages.adminRoleList.admin') : __('messages.adminRoleList.user') }}</td>
                                    <td>
                                        <a href="{{ route('admin-role.show', $admin->id) }}" class="btn btn-sm btn-warning">
                                            {{ __('messages.adminRoleList.view') }}
                                        </a>
                                        <a href="{{ route('admin-role.edit', $admin->id) }}" class="btn btn-sm btn-primary">
                                            {{ __('messages.adminRoleList.edit') }}
                                        </a>

                                        <form action="{{ route('admin-role.destroy', $admin->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('{{ __('messages.adminRoleList.delete_confirm') }}')">
                                                {{ __('messages.adminRoleList.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">{{ __('messages.adminRoleList.no_data') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-wrapper d-flex justify-content-between align-items-center mt-3">
                        <div>{{ $admins->links() }}</div>
                        <div class="selectAdmin">
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">
                                {{ __('messages.adminRoleList.delete_selected') }}
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
    const handleSelect = () => {
        let selected = [];

        $('input[name="admin_id"]:checked').each(function () {
            selected.push($(this).val());
        });

        let admin_ids = selected.join(',');

        if (selected.length > 0) {
            $('#deleteSelected').removeClass('d-none');
            $('#deleteSelected').attr('admin_ids', admin_ids);
        } else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    const deleteSelected = () => {
        if (confirm('{{ __("messages.adminRoleList.delete_selected_confirm") }}')) {
            let admin_ids = $('#deleteSelected').attr('admin_ids');

            $.ajax({
                type: "POST",
                url: "{{ route('admin-role.deleteSelectedRole') }}",
                data: {
                    selected_id: admin_ids,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        window.location.href = "{{ route('admin-role.index') }}";
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

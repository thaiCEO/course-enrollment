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
                    <a class="nav-link active" data-toggle="tab" href="#rooms-tab" role="tab">
                        <i class="fa fa-door-open"></i> {{ __('messages.roomList.title') }}
                    </a>
                    <div class="slide"></div>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="rooms-tab" role="tabpanel">
                    <a href="{{ route('room.create') }}" class="btn btn-primary mb-3">
                        + {{ __('messages.roomList.add_room') }}
                    </a>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.roomList.id') }}</th>
                                    <th>{{ __('messages.roomList.name') }}</th>
                                    <th>{{ __('messages.roomList.capacity') }}</th>
                                    <th>{{ __('messages.roomList.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $room)
                                <tr>
                                    <td>
                                        RM{{ $loop->iteration }}
                                        <input onchange="handleSelect()" type="checkbox" name="room_id" value="{{ $room->id }}">
                                    </td>
                                    <td>{{ $room->name }}</td>
                                    <td>{{ $room->capacity }}</td>
                                    <td>
                                        <a href="{{ route('room.show', $room->id) }}" class="btn btn-sm btn-warning">
                                            {{ __('messages.roomList.view') }}
                                        </a>
                                        <a href="{{ route('room.edit', $room->id) }}" class="btn btn-sm btn-primary">
                                            {{ __('messages.roomList.edit') }}
                                        </a>

                                        <form action="{{ route('room.destroy', $room->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('{{ __('messages.roomList.delete_confirm') }}')">
                                                {{ __('messages.roomList.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">{{ __('messages.roomList.no_data') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-wrapper d-flex justify-content-between align-items-center mt-3">
                        <div>{{ $rooms->links() }}</div>
                        <div class="selectRoom">
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">
                                {{ __('messages.roomList.delete_selected') }}
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

        $('input[name="room_id"]:checked').each(function () {
            selected.push($(this).val());
        });

        let room_ids = selected.join(',');

        if (selected.length > 0) {
            $('#deleteSelected').removeClass('d-none');
            $('#deleteSelected').attr('room_ids', room_ids);
        } else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    const deleteSelected = () => {
        if (confirm('{{ __("messages.roomList.delete_selected_confirm") }}')) {
            let room_ids = $('#deleteSelected').attr('room_ids');

            $.ajax({
                type: "POST",
                url: "{{ route('room.deleteSelected') }}",
                data: {
                    selected_id: room_ids,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        window.location.href = "{{ route('room.index') }}";
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

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
                        <i class="ti-home"></i> {{ __('messages.roomList.title') }}
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
                                            <button type="button"
                                                class="btn btn-sm btn-danger delete-room-btn"
                                                data-message="{{ __('messages.deleteRoom.confirm_message') }}">
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
    let selectedRooms = [];

    $('input[name="room_id"]:checked').each(function () {
        selectedRooms.push($(this).val());
    });

    let room_ids = selectedRooms.join(',');

    if (selectedRooms.length >= 1) {
        $('#deleteSelected').removeClass('d-none');
        $("#deleteSelected").attr("room_ids", room_ids);
    } else {
        $('#deleteSelected').addClass('d-none');
    }
};

const deleteSelected = () => {
    const selectedIds = Array.from(document.querySelectorAll('input[name="room_id"]:checked'))
                             .map(cb => cb.value);

    if (selectedIds.length === 0) {
        Swal.fire({
            icon: 'info',
            title: '{{ __("messages.deleteRoomSelect.no_selected") }}',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    const deleteBtn = document.getElementById('deleteSelected');
    deleteBtn.disabled = true;

    Swal.fire({
        title: '{{ __("messages.deleteRoomSelect.delete_selected_confirm") }}',
        text: '{{ __("messages.deleteRoomSelect.delete_count_text", ["count" => "__COUNT__"]) }}'.replace('__COUNT__', selectedIds.length),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("messages.deleteRoomSelect.yes_delete") }}',
        cancelButtonText: '{{ __("messages.deleteRoomSelect.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ route('room.deleteSelected') }}",
                data: {
                    selected_id: selectedIds.join(','),
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("messages.deleteRoomSelect.deleted_success") }}',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('room.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.deleteRoomSelect.error_delete") }}'
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("messages.deleteRoomSelect.error_delete") }}',
                        text: xhr.responseText
                    });
                },
                complete: function () {
                    deleteBtn.disabled = false;
                }
            });
        } else {
            deleteBtn.disabled = false;
        }
    });
};



//delete room 
   document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-room-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form'); // Get parent form
                const message = this.dataset.message;

                Swal.fire({
                    title: '{{ __("messages.deleteRoom.title") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("messages.deleteRoom.confirm_button") }}',
                    cancelButtonText: '{{ __("messages.deleteRoom.cancel_button") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form if confirmed
                    }
                });
            });
        });
    });
</script>
@endsection

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
                    <a class="nav-link active" data-toggle="tab" href="#studytime-tab" role="tab">
                        <i class="fa fa-clock"></i> {{ __('messages.studytimeData.title') }}
                    </a>
                    <div class="slide"></div>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="studytime-tab" role="tabpanel">
                    <a href="{{ route('study-time.create') }}" class="btn btn-primary mb-3">
                        + {{ __('messages.studytimeData.add_studytime') }}
                    </a>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.studytimeData.id') }}</th>
                                    <th>{{ __('messages.studytimeData.course') }}</th>
                                    <th>{{ __('messages.studytimeData.room') }}</th>
                                    <th>{{ __('messages.studytimeData.day_type') }}</th>
                                    <th>{{ __('messages.studytimeData.start_time') }}</th>
                                    <th>{{ __('messages.studytimeData.end_time') }}</th>
                                    <th>{{ __('messages.studytimeData.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($studyTimes as $studyTime)
                                <tr>
                                    <td>
                                        T{{ $loop->iteration }}
                                        <input onchange="handleSelect()" type="checkbox" name="studytime_id" value="{{ $studyTime->id }}">
                                    </td>
                                    <td>{{ $studyTime->course->title ?? '-' }}</td>
                                    <td>{{ $studyTime->room->name ?? '-' }}</td>
                                    <td>
                                        @if($studyTime->day_type === 'weekday')
                                            {{ __('messages.studytimeCreate.weekday') }}
                                        @elseif($studyTime->day_type === 'weekend')
                                            {{ __('messages.studytimeCreate.weekend') }}
                                        @else
                                            {{ ucfirst($studyTime->day_type) }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($studyTime->start_time)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($studyTime->end_time)->format('H:i') }}</td>
                                    <td>
                                        <a href="{{ route('study-time.show', $studyTime->id) }}" class="btn btn-sm btn-warning">
                                            {{ __('messages.studytimeData.view') }}
                                        </a>
                                        <a href="{{ route('study-time.edit', $studyTime->id) }}" class="btn btn-sm btn-primary">
                                            {{ __('messages.studytimeData.edit') }}
                                        </a>

                                       <form action="{{ route('study-time.destroy', $studyTime->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-studytime-btn">
                                                {{ __('messages.studytimeData.delete') }}
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">{{ __('messages.studytimeData.no_data') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-wrapper d-flex justify-content-between align-items-center mt-3">
                        <div>{{ $studyTimes->links() }}</div>
                        <div class="selectStudyTime">
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">
                                {{ __('messages.studytimeData.delete_selected') }}
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
    let selectedStudyTimes = [];

    $('input[name="studytime_id"]:checked').each(function () {
        selectedStudyTimes.push($(this).val());
    });

    let studytime_ids = selectedStudyTimes.join(',');

    if (selectedStudyTimes.length >= 1) {
        $('#deleteSelected').removeClass('d-none');
        $("#deleteSelected").attr("studytime_ids", studytime_ids);
    } else {
        $('#deleteSelected').addClass('d-none');
    }
}

const deleteSelected = () => {
    const selectedIds = Array.from(document.querySelectorAll('input[name="studytime_id"]:checked'))
                             .map(cb => cb.value);

    if (selectedIds.length === 0) {
        Swal.fire({
            icon: 'info',
            title: '{{ __("messages.deleteStudyTimeSelect.no_selected") }}',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    const deleteBtn = document.getElementById('deleteSelected');
    deleteBtn.disabled = true;

    Swal.fire({
        title: '{{ __("messages.deleteStudyTimeSelect.delete_selected_confirm") }}',
        text: '{{ __("messages.deleteStudyTimeSelect.delete_count_text", ["count" => "__COUNT__"]) }}'
                .replace('__COUNT__', selectedIds.length),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("messages.deleteStudyTimeSelect.yes_delete") }}',
        cancelButtonText: '{{ __("messages.deleteStudyTimeSelect.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ route('study-time.deleteSelected') }}",
                data: {
                    selected_id: selectedIds.join(','),
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("messages.deleteStudyTimeSelect.deleted_success") }}',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('study-time.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.deleteStudyTimeSelect.error_delete") }}'
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("messages.deleteStudyTimeSelect.error_delete") }}',
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
}

//delete study time 
   document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-studytime-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');

                Swal.fire({
                    title: '{{ __("messages.deleteStudyTime.confirm_title") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("messages.deleteStudyTime.confirm_button") }}',
                    cancelButtonText: '{{ __("messages.deleteStudyTime.cancel_button") }}'
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

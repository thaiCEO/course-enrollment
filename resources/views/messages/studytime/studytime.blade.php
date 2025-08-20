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
                                        ST{{ $loop->iteration }}
                                        <input onchange="handleSelect()" type="checkbox" name="studytime_id" value="{{ $studyTime->id }}">
                                    </td>
                                    <td>{{ $studyTime->course->title ?? '-' }}</td>
                                    <td>{{ $studyTime->room->name ?? '-' }}</td>
                                    <td>{{ ucfirst($studyTime->day_type) }}</td>
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
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('{{ __('messages.studytimeData.delete_confirm') }}')">
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
        let selected = [];

        $('input[name="studytime_id"]:checked').each(function () {
            selected.push($(this).val());
        });

        let studytime_ids = selected.join(',');

        if (selected.length > 0) {
            $('#deleteSelected').removeClass('d-none');
            $('#deleteSelected').attr('studytime_ids', studytime_ids);
        } else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    const deleteSelected = () => {
        if (confirm('{{ __("messages.studytimeData.delete_selected_confirm") }}')) {
            let studytime_ids = $('#deleteSelected').attr('studytime_ids');

            $.ajax({
                type: "POST",
                url: "{{ route('study-time.deleteSelected') }}",
                data: {
                    selected_id: studytime_ids,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        window.location.href = "{{ route('study-time.index') }}";
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

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
                        <i class="ti-agenda"></i> {{ __('messages.enrollmentList.tab1') }}
                    </a>
                    <div class="slide"></div>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile3" role="tab">
                        <i class="fa fa-key"></i> {{ __('messages.enrollmentList.tab2') }}
                    </a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages3" role="tab">
                        <i class="fa fa-play-circle"></i> {{ __('messages.enrollmentList.tab3') }}
                    </a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#settings3" role="tab">
                        <i class="fa fa-database"></i> {{ __('messages.enrollmentList.tab4') }}
                    </a>
                    <div class="slide"></div>
                </li> --}}
            </ul>

            <!-- Tab panes -->
            <div class="tab-content card-block">
                <div class="tab-pane active" id="home3" role="tabpanel">

                    <div class="table-responsive">

                        @can('create enrollment')
                            <a href="{{ route('enrollments.create') }}" class="btn btn-primary mb-3">
                                {{ __('messages.enrollmentList.addButton') }}
                            </a>
                        @endcan

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.enrollmentList.table.id') }}</th>
                                    <th>{{ __('messages.enrollmentList.table.studentName') }}</th>
                                    <th>{{ __('messages.enrollmentList.table.courseTitle') }}</th>
                                    <th>Room</th>
                                    <th>{{ __('messages.enrollmentList.table.enrolledDate') }}</th>
                                    <th>{{ __('messages.enrollmentList.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($enrollments as $enrollment)
                                    <tr>
                                        <td>

                                            E{{ $loop->iteration }}
                                        
                                            <input onchange="handleSelect()" enrollment_ids="" type="checkbox" name="enrollment_id" value="{{$enrollment->id}}">
                                        </td>
                                        <td>{{ $enrollment->student->username ?? $enrollment->student->name }}</td>
                                        <td>{{ $enrollment->course->title }}</td>
                                          {{-- ✅ Display Room Name --}}
                                        <td>
                                            @if($enrollment->room)
                                                {{ $enrollment->room->name }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        <td>{{ $enrollment->enrolled_date }}</td>
                                        <td>
                                            {{-- View Enrollment --}}
                                            @can('read enrollment')
                                                <a href="{{ route('enrollments.show', $enrollment->id) }}" 
                                                class="btn btn-sm btn-warning">
                                                    {{ __('messages.enrollmentList.action.view') }}
                                                </a>
                                            @endcan

                                            {{-- Edit Enrollment --}}
                                            @can('update enrollment')
                                                <a href="{{ route('enrollments.edit', $enrollment->id) }}" 
                                                class="btn btn-sm btn-primary">
                                                    {{ __('messages.enrollmentList.action.edit') }}
                                                </a>
                                            @endcan

                                            {{-- Delete Enrollment --}}
                                            @can('delete enrollment')

                                             <form action="{{ route('enrollments.destroy', $enrollment->id) }}" 
                                                    method="POST" 
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger delete-enrollment-btn"
                                                            data-message="{{ __('messages.enrollmentList.action.confirmDelete') }}">
                                                        {{ __('messages.enrollmentList.action.delete') }}
                                                    </button>
                                                </form>

                                            @endcan
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('messages.enrollmentList.empty') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="btn-wrapper d-flex justify-content-between align-items-center">
                        <div class="">
                            {{ $enrollments->links() }}
                        </div>
                        <div class="seleteStudent">
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">
                                {{ __('messages.enrollmentList.deleteSelected') }}
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
    let selectedEnrollments = [];

    $('input[name="enrollment_id"]:checked').each(function () {
        selectedEnrollments.push($(this).val());
    });

    let enrollment_ids = selectedEnrollments.join(',');

    if(selectedEnrollments.length >= 1){
        $('#deleteSelected').removeClass('d-none');
        $("#deleteSelected").attr("enrollment_ids", enrollment_ids);
    } else {
        $('#deleteSelected').addClass('d-none');
    }
}

const deleteSelected = () => {
    const selectedIds = Array.from(document.querySelectorAll('input[name="enrollment_id"]:checked'))
                             .map(cb => cb.value);

    if(selectedIds.length === 0){
        Swal.fire({
            icon: 'info',
            title: '{{ __("messages.deleteEnrollmentSelect.no_selected") }}',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    const deleteBtn = document.getElementById('deleteSelected');
    deleteBtn.disabled = true;

    Swal.fire({
        title: '{{ __("messages.deleteEnrollmentSelect.delete_selected_confirm") }}',
        text: '{{ __("messages.deleteEnrollmentSelect.delete_count_text", ["count" => "__COUNT__"]) }}'.replace('__COUNT__', selectedIds.length),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("messages.deleteEnrollmentSelect.yes_delete") }}',
        cancelButtonText: '{{ __("messages.deleteEnrollmentSelect.cancel") }}'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                type: "POST",
                url: "{{ route('enrollments.deleteSelectedEnrollment') }}",
                data: {
                    selected_id: selectedIds.join(','),
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response){
                    if(response.status == 200){
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("messages.deleteEnrollmentSelect.deleted_success") }}',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href="{{ route('enrollments.List') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.deleteEnrollmentSelect.error_delete") }}'
                        });
                    }
                },
                error: function(xhr){
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("messages.deleteEnrollmentSelect.error_delete") }}',
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


//delete enrollment confirmation
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-enrollment-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form'); // parent form
            const message = this.dataset.message;

            Swal.fire({
                title: '{{ __("messages.deleteEnrollment.delete_confirm_title") }}',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __("messages.deleteEnrollment.yes_delete") }}',
                cancelButtonText: '{{ __("messages.deleteEnrollment.cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // submit if confirmed
                }
            });
        });
    });
});


</script>
@endsection

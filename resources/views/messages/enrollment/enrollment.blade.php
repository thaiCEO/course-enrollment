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
                        <i class="fa fa-home"></i> {{ __('messages.enrollmentList.tab1') }}
                    </a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
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
                </li>
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
                                        <td>{{ $enrollment->id }}</td>
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
                                                    <button class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('{{ __('messages.enrollmentList.action.confirmDelete') }}')">
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
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-round btn-sm d-none">
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
        let seletedStudent = [];

        $('input[type="checkbox"]:checked').each(function () {
            seletedStudent.push($(this).val());
        });


        let student_ids = seletedStudent.join(',');

        if(seletedStudent.length >= 1){
            $('#deleteSelected').removeClass('d-none');
            $("#deleteSelected").attr("student_ids",student_ids);
        }else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    const deleteSelected = () => {
        if(confirm('Are you sure you want to delete?')) {
            let student_ids = $('#deleteSelected').attr('student_ids');

            $.ajax({
                type: "POST",
                url: "{{ route('student.deleteSeletedStudent') }}",
                data: {
                    selected_id: student_ids, // Corrected key to match controller
                    _token: '{{ csrf_token() }}' // Add CSRF token
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == 200) {
                        window.location.href="{{ route('student.list')}}";
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }
</script>
@endsection

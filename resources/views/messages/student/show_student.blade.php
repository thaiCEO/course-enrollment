@extends('components.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">{{ __('messages.viewStudent.page_title') }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudent.student_number') }}:</label>
                <div class="col-sm-8">{{ $student->student_number ?? __('messages.viewStudent.no_data') }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudent.name') }}:</label>
                <div class="col-sm-8">{{ $student->username }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudent.gender') }}:</label>
                <div class="col-sm-8">{{ ucfirst($student->gender) }}</div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudent.date_of_birth') }}:</label>
                <div class="col-sm-8">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d-M-Y') }}</div>
            </div>

            @if ($student->addresses)
                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudent.phone') }}:</label>
                    <div class="col-sm-8">{{ $student->addresses->first()->phone ?? 'មិនមានទិន្នន័យ' }}</div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudent.address') }}:</label>
                    <div class="col-sm-8">{{ $student->addresses->first()->address_line ?? 'មិនមានទិន្នន័យ'}}, {{ $student->addresses->first()->city ?? ''}}</div>
                </div>
            @else
                <div class="row mb-3">
                    <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudent.address') }}:</label>
                    <div class="col-sm-8 text-muted">{{ __('messages.viewStudent.no_main_address') }}</div>
                </div>
            @endif

            <div class="row mb-4">
                <label class="col-sm-4 fw-semibold">{{ __('messages.viewStudent.profile_image') }}:</label>
                <div class="col-sm-8">
                    @if($student->profile_student)
                        <img src="{{ asset('profile_student/' . $student->profile_student) }}" alt="Profile Image" class="img-thumbnail" style="max-width: 200px;">
                    @else
                        <p class="text-muted">{{ __('messages.viewStudent.no_image') }}</p>
                    @endif
                </div>
            </div>

            <hr>
            <h5 class="text-primary mb-3">{{ __('messages.viewStudent.payment_info') }}</h5>

            @if($student->enrollments->isNotEmpty())
                @foreach($student->enrollments as $enrollment)
                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('messages.viewStudent.course') }}: {{ $enrollment->course->title ?? __('messages.viewStudent.not_specified') }}</h6>

                        @if($enrollment->payments->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('messages.viewStudent.amount') }}</th>
                                            <th>{{ __('messages.viewStudent.payment_method') }}</th>
                                            <th>{{ __('messages.viewStudent.status') }}</th>
                                            <th>{{ __('messages.viewStudent.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($enrollment->payments as $index => $payment)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ number_format($payment->amount, 2) }} ៛</td>
                                                <td>{{ $payment->paymentMethod->name ?? 'NA' }}</td>
                                                <td>
                                                    @if($payment->status === 'paid')
                                                        <span class="badge bg-success">{{ __('messages.viewStudent.paid') }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ __('messages.viewStudent.unpaid') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d-M-Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">{{ __('messages.viewStudent.no_payment') }}</p>
                        @endif
                    </div>
                @endforeach
            @else
                <p class="text-muted">{{ __('messages.viewStudent.no_enrollment') }}</p>
            @endif
        </div>

        <div class="card-footer text-center">
            <a href="{{ route('student.list') }}" class="btn btn-secondary">{{ __('messages.viewStudent.back') }}</a>
        </div>
    </div>
</div>
@endsection

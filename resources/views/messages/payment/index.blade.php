@extends('components.master')

@section('content')

@if(Session::has('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: "{{ __('messages.paymentList.success') }}",
            icon: "success",
            text: "{{ Session::get('success') }}",
            showConfirmButton: false,
            timer: 2000,
        });
    });
</script>
@endif

<div class="col-sm-12">
    <div class="card tabs-card">
        <div class="card-block p-0">

            <ul class="nav nav-tabs md-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#payments-tab" role="tab">
                        <i class="fa fa-credit-card"></i> {{ __('messages.paymentList.title') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content card-block">
                <div class="tab-pane active" id="payments-tab" role="tabpanel">
                    
                    @can('create payment')
                     <a href="{{ route('payment.create') }}" class="btn btn-primary mb-3">+ {{ __('messages.paymentList.addPayment') }}</a>
                    @endcan

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.paymentList.id') }}</th>
                                    <th>{{ __('messages.paymentList.student') }}</th>
                                    <th>{{ __('messages.paymentList.amount') }}</th>
                                    <th>{{ __('messages.paymentList.status') }}</th>
                                    <th>{{ __('messages.paymentList.method') }}</th>
                                    <th>{{ __('messages.paymentList.date') }}</th>
                                    <th>{{ __('messages.paymentList.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $payment->enrollment->student->username ?? 'N/A' }}</td>
                                    <td>${{ number_format($payment->enrollment->course->price, 2)}}</td>
                                    <td>
                                        <span class="badge {{ $payment->status === 'paid' ? 'bg-primary' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->paymentMethod->name }}</td>
                                    <td>{{ $payment->paid_at ?? '-' }}</td>
                                    <td>
                                        {{-- View Payment --}}
                                        @can('read payment')
                                            <a href="{{ route('payment.show', $payment->id) }}" 
                                            class="btn btn-sm btn-warning">
                                                {{ __('messages.paymentList.view') }}
                                            </a>
                                        @endcan

                                        {{-- Edit Payment --}}
                                        @can('update payment')
                                            <a href="{{ route('payment.edit', $payment->id) }}" 
                                            class="btn btn-sm btn-primary">
                                                {{ __('messages.paymentList.edit') }}
                                            </a>
                                        @endcan

                                        {{-- Delete Payment --}}
                                        @can('delete payment')
                                            <form action="{{ route('payment.destroy', $payment->id) }}" 
                                                method="POST" 
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('messages.paymentList.deleteConfirm') }}')">
                                                    {{ __('messages.paymentList.delete') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">{{ __('messages.paymentList.noData') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $payments->links() }}</div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

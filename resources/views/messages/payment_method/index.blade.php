@extends('components.master')

@section('content')

@if(Session::has('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: "{{ Session::get('success') }}",
            icon: "success",
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
                    <a class="nav-link active" href="#methods-tab" role="tab">
                        <i class="fa fa-credit-card"></i> {{ __('messages.paymentmethodList.title') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content card-block">
                <div class="tab-pane active" id="methods-tab" role="tabpanel">

                    @can('create paymentmethod')
                        <a href="{{ route('payment-method.create') }}" class="btn btn-primary mb-3">
                            {{ __('messages.paymentmethodList.add') }}
                        </a>
                    @endcan

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.paymentmethodList.table.no') }}</th>
                                    <th>{{ __('messages.paymentmethodList.table.name') }}</th>
                                    <th>{{ __('messages.paymentmethodList.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paymentMethods as $method)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $method->name }}</td>
                                    <td>
                                        {{-- View Payment Method --}}
                                        @can('read paymentmethod')
                                            <a href="{{ route('payment-method.show', $method->id) }}" 
                                            class="btn btn-sm btn-warning">
                                                {{ __('messages.paymentmethodList.table.view') }}
                                            </a>
                                        @endcan

                                        {{-- Edit Payment Method --}}
                                        @can('update paymentmethod')
                                            <a href="{{ route('payment-method.edit', $method->id) }}" 
                                            class="btn btn-sm btn-primary">
                                                {{ __('messages.paymentmethodList.table.edit') }}
                                            </a>
                                        @endcan

                                        {{-- Delete Payment Method --}}
                                        @can('delete paymentmethod')
                                            <form action="{{ route('payment-method.destroy', $method->id) }}" 
                                                method="POST" 
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('messages.paymentmethodList.table.delete_confirm') }}')">
                                                    {{ __('messages.paymentmethodList.table.delete') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        {{ __('messages.paymentmethodList.table.empty') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $paymentMethods->links() }}</div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

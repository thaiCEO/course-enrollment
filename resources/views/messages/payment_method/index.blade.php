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
                    <a class="nav-link active" data-toggle="tab" href="#home3" role="tab">
                       <i class="fa fa-credit-card"></i>  {{ __('messages.paymentmethodList.title') }}
                    </a>
                    <div class="slide"></div>
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
                                    <td>
                                        M{{ $loop->iteration }}
                                        <input onchange="handleSelect()" method_ids="" type="checkbox" name="method_id" value="{{ $method->id }}">
                                    </td>
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
                                                <button type="button"  {{-- ← Change from submit to button --}}
                                                        class="btn btn-sm btn-danger delete-paymentmethod-btn">
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

                    <div class="btn-wrapper d-flex justify-content-between align-items-center">
                        <div class="">
                           {{ $paymentMethods->links() }}
                        </div>
                       <div class="seleteStudent">
                            <button id="deleteSelected" onclick="deleteSelected()" class="btn btn-outline-danger btn-sm d-none">
                                {{ __('messages.deletePaymentMethodSelect.delete_selected') }}
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
    let selectedMethods = [];

    // Get all checked checkboxes
    $('input[name="method_id"]:checked').each(function () {
        selectedMethods.push($(this).val());
    });

    let method_ids = selectedMethods.join(',');

    if(selectedMethods.length >= 1){
        $('#deleteSelected').removeClass('d-none');
        $("#deleteSelected").attr("method_ids", method_ids);
    } else {
        $('#deleteSelected').addClass('d-none');
    }
}

const deleteSelected = () => {
    const selectedIds = Array.from(document.querySelectorAll('input[name="method_id"]:checked'))
                             .map(cb => cb.value);

    if(selectedIds.length === 0){
        Swal.fire({
            icon: 'info',
            title: '{{ __("messages.deletePaymentMethodSelect.no_selected") }}',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    const deleteBtn = document.getElementById('deleteSelected');
    deleteBtn.disabled = true;

    Swal.fire({
        title: '{{ __("messages.deletePaymentMethodSelect.delete_selected_confirm") }}',
        text: '{{ __("messages.deletePaymentMethodSelect.delete_count_text", ["count" => "__COUNT__"]) }}'.replace('__COUNT__', selectedIds.length),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("messages.deletePaymentMethodSelect.yes_delete") }}',
        cancelButtonText: '{{ __("messages.deletePaymentMethodSelect.cancel") }}'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                type: "POST",
                url: "{{ route('payment-method.deleteSelected') }}", // <-- New route
                data: {
                    selected_id: selectedIds.join(','), 
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response){
                    if(response.status === 200){
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("messages.deletePaymentMethodSelect.deleted_success") }}',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('payment-method.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.deletePaymentMethodSelect.error_delete") }}'
                        });
                    }
                },
                error: function(xhr){
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("messages.deletePaymentMethodSelect.error_delete") }}',
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

// Single delete confirmation
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-paymentmethod-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: '{{ __("messages.deletePaymentMethod.confirm_title") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __("messages.deletePaymentMethod.confirm_button") }}',
                cancelButtonText: '{{ __("messages.deletePaymentMethod.cancel_button") }}'
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


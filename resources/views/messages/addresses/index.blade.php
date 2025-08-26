@extends('components.master')

@section('content')

@if(Session::has('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: "{{ Session::get('success') }}",
            icon: "success",
            showConfirmButton: false, // remove the OK button
            timer: 1500, // auto close after 1.5 seconds (1500ms)
        });
    });
</script>
@endif

<div class="col-sm-12">
    <div class="card tabs-card">
        <div class="card-block p-0">

            <ul class="nav nav-tabs md-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#addresses-tab" role="tab">
                        <i class="fa fa-map-marker"></i> {{ __('messages.showaddresses.title') }}
                    </a>
                    <div class="slide"></div>
                </li>
            </ul>

            <div class="tab-content card-block">
                <div class="tab-pane active" id="addresses-tab" role="tabpanel">
                    
                    <!-- Search & Add Address Row -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        
                       {{-- SEARCH --}}
                      <form id="searchForm" method="GET" action="{{ route('addresses.index') }}" class="d-flex align-items-center mb-2 mb-md-0">
                            <input type="text"
                                name="search"
                                id="searchInput"
                                value="{{ request('search') }}"
                                class="form-control me-2"
                                placeholder="{{ __('messages.showaddresses.search') }}">
                            <button type="submit" id="searchBtn" class="btn btn-sm btn-outline-primary ms-2">
                                <i class="fa fa-search"></i> {{ __('messages.showaddresses.search') }}
                            </button>
                        </form>



                <div class="d-flex align-items-center gap-2">
                    {{-- ADD ADDRESS --}}
                    @can('create address')
                        <a href="{{ route('addresses.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> {{ __('messages.showaddresses.add') }}
                        </a>
                    @endcan

                    {{-- FILTER DROPDOWN (Bootstrap) --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle"
                                type="button"
                                id="filterDropdownBtn"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            {{-- Show current filter label --}}
                            {{ request('filter') === 'student'
                                ? __('messages.showaddresses.student')
                                : (request('filter') === 'teacher'
                                    ? __('messages.showaddresses.teacher')
                                    : __('messages.showaddresses.all')) }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdownBtn">
                            <li><a class="dropdown-item filter-item" href="#" data-filter="">{{ __('messages.showaddresses.all') }}</a></li>
                            <li><a class="dropdown-item filter-item" href="#" data-filter="student">{{ __('messages.showaddresses.student') }}</a></li>
                            <li><a class="dropdown-item filter-item" href="#" data-filter="teacher">{{ __('messages.showaddresses.teacher') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>


            {{-- TABLE CONTAINER (AJAX will replace this div) --}}
            <div id="addressTable">
                @include('messages.addresses.address_table', ['addresses' => $addresses])
            </div>

                            

@endsection


@section('script')
<script>
    // Handle address checkbox selection
    const handleSelect = () => {
        let selectedAddresses = [];

        $('input[name="address_id"]:checked').each(function () {
            selectedAddresses.push($(this).val());
        });

        let address_ids = selectedAddresses.join(',');

        if(selectedAddresses.length >= 1){
            $('#deleteSelected').removeClass('d-none');
            $("#deleteSelected").attr("address_ids", address_ids);
        } else {
            $('#deleteSelected').addClass('d-none');
        }
    }

    // Bulk delete addresses
    const deleteSelected = () => {
        const selectedIds = Array.from(document.querySelectorAll('input[name="address_id"]:checked'))
                                 .map(cb => cb.value);

        if(selectedIds.length === 0){
            Swal.fire({
                icon: 'info',
                title: '{{ __("messages.deleteAddressSelect.no_selected") }}',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        const deleteBtn = document.getElementById('deleteSelected');
        deleteBtn.disabled = true;

        Swal.fire({
            title: '{{ __("messages.deleteAddressSelect.delete_selected_confirm") }}',
            text: '{{ __("messages.deleteAddressSelect.delete_count_text", ["count" => "__COUNT__"]) }}'.replace('__COUNT__', selectedIds.length),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __("messages.deleteAddressSelect.yes_delete") }}',
            cancelButtonText: '{{ __("messages.deleteAddressSelect.cancel") }}'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    type: "POST",
                    url: "{{ route('addresses.deleteSelected') }}", // <-- ADD ROUTE
                    data: {
                        selected_id: selectedIds.join(','),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    success: function(response){
                        if(response.status == 200){
                            Swal.fire({
                                icon: 'success',
                                title: '{{ __("messages.deleteAddressSelect.deleted_success") }}',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href="{{ route('addresses.index') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("messages.deleteAddressSelect.error_delete") }}'
                            });
                        }
                    },
                    error: function(xhr){
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.deleteAddressSelect.error_delete") }}',
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

    // Single delete confirmation for addresses
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-address-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: '{{ __("messages.deleteAddress.confirm_title") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("messages.deleteAddress.confirm_button") }}',
                    cancelButtonText: '{{ __("messages.deleteAddress.cancel_button") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });


//filter 
$(document).ready(function () {
    let currentFilter = "{{ request('filter', '') }}";

    function fetchAddresses(url = "{{ route('addresses.index') }}") {
        const search = $('#searchInput').val().trim();

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search: search,
                filter: currentFilter
            },
            success: function (html) {
                $('#addressTable').html(html);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Search form submit handler
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        fetchAddresses();
    });

    // Enter key also triggers search
    $('#searchInput').on('keyup', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#searchForm').submit();
        }
    });

    // Filter dropdown handler
    $(document).on('click', '.filter-item', function (e) {
        e.preventDefault();
        currentFilter = $(this).data('filter') || '';
        $('#filterDropdownBtn').text($(this).text());
        fetchAddresses();
    });

    // Pagination handler
    $(document).on('click', '#addressTable .pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        fetchAddresses(url);
    });
});


</script>
@endsection

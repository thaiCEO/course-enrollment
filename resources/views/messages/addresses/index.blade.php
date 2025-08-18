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
                </li>
            </ul>

            <div class="tab-content card-block">
                <div class="tab-pane active" id="addresses-tab" role="tabpanel">

                    <a href="{{ route('addresses.create') }}" class="btn btn-primary mb-3">
                        + {{ __('messages.showaddresses.add') }}
                    </a>

                    <div class="table-responsive">
                       <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.showaddresses.id') }}</th>
                                    <th>{{ __('messages.showaddresses.owner') }}</th>
                                    <th>{{ __('messages.showaddresses.address_line') }}</th>
                                    <th>{{ __('messages.showaddresses.city') }}</th>
                                    <th>{{ __('messages.showaddresses.phone') }}</th>
                                    {{-- <th>{{ __('messages.showaddresses.type') }}</th> --}}
                                    <th>{{ __('messages.showaddresses.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($addresses as $address)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @php $owner = $address->addressable; @endphp
                                            @if ($owner instanceof \App\Models\Student)
                                                {{ __('messages.showaddresses.student') }}: {{ $owner->username ?? 'N/A' }}
                                            @elseif ($owner instanceof \App\Models\Teacher)
                                                {{ __('messages.showaddresses.teacher') }}: {{ $owner->name ?? 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $address->address_line }}</td>
                                        <td>{{ $address->city }}</td>
                                        <td>{{ $address->phone }}</td>
                                        {{-- <td>{{ $address->is_main ? __('messages.showaddresses.main') : __('messages.showaddresses.secondary') }}</td> --}}
                                        <td>
                                            <a href="{{ route('addresses.show', $address->id) }}" class="btn btn-sm btn-warning">
                                                {{ __('messages.showaddresses.view') }}
                                            </a>
                                            <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm btn-primary">
                                                {{ __('messages.showaddresses.edit') }}
                                            </a>
                                            <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('{{ __('messages.showaddresses.confirm_delete') }}')">
                                                    {{ __('messages.showaddresses.delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('messages.showaddresses.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>{{ $addresses->links() }}</div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

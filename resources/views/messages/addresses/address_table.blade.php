<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('messages.showaddresses.id') }}</th>
                <th>{{ __('messages.showaddresses.owner') }}</th>
                <th>{{ __('messages.showaddresses.address_line') }}</th>
                <th>{{ __('messages.showaddresses.city') }}</th>
                <th>{{ __('messages.showaddresses.phone') }}</th>
                <th>{{ __('messages.showaddresses.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($addresses as $address)
                <tr>
                    <td>AD{{ $loop->iteration }}</td>
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
                    <td>
                        @can('read address')
                            <a href="{{ route('addresses.show', $address->id) }}" class="btn btn-sm btn-warning">
                                {{ __('messages.showaddresses.view') }}
                            </a>
                        @endcan
                        @can('update address')
                            <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm btn-primary">
                                {{ __('messages.showaddresses.edit') }}
                            </a>
                        @endcan
                        @can('delete address')
                            <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    {{ __('messages.showaddresses.delete') }}
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        {{ __('messages.showaddresses.no_data') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {!! $addresses->appends(request()->only(['search','filter']))->links() !!}
    </div>
</div>

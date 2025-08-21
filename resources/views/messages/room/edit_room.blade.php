@extends('components.master')
@section('content')

<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">{{ __('messages.roomEdit.mainTitle') }}</h5>
        <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
                <a href="{{ route('room.index') }}"> <i class="fa fa-home"></i> </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">{{ __('messages.roomEdit.mainTitleDashboard') }}</a>
            </li>
        </ul>
    </div>
</div>
<!-- Page-header end -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('room.update', $room->id) }}" method="POST" id="Form_editRoom">
                @csrf
                @method('POST') <!-- You can also use PATCH if you prefer -->

                {{-- Room Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.roomEdit.name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" 
                           placeholder="{{ __('messages.roomEdit.name_placeholder') }}" 
                           value="{{ old('name', $room->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Room Capacity --}}
                <div class="mb-3">
                    <label for="capacity" class="form-label">{{ __('messages.roomEdit.capacity') }}</label>
                    <input type="number" name="capacity" class="form-control" id="capacity" 
                           placeholder="{{ __('messages.roomEdit.capacity_placeholder') }}" 
                           value="{{ old('capacity', $room->capacity) }}" min="1">
                    @error('capacity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Actions --}}
                <button type="submit" class="btn btn-primary">{{ __('messages.roomEdit.submit') }}</button>
                <a href="{{ route('room.index') }}" class="btn btn-secondary">{{ __('messages.roomEdit.back') }}</a>
            </form>
        </div>
    </div>
</div>

@endsection

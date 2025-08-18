@extends('components.master')

@section('content')
<div class="container">
    <h2>{{ __('messages.editaddresses.title') }}</h2>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('addresses.update', $address->id) }}" method="POST">
        @csrf {{-- POST because your route uses POST /{id}/update --}}

        {{-- Type --}}
        <div class="mb-3">
            <label for="user_type" class="form-label">{{ __('messages.editaddresses.user_type') }}</label>
            <select name="addressable_type" id="user_type" class="form-control" required>
                <option value="">{{ __('messages.editaddresses.select_type') }}</option>
                <option value="App\Models\Student" {{ old('addressable_type', $address->addressable_type)=='App\\Models\\Student' ? 'selected':'' }}>
                    {{ __('messages.editaddresses.student') }}
                </option>
                <option value="App\Models\Teacher" {{ old('addressable_type', $address->addressable_type)=='App\\Models\\Teacher' ? 'selected':'' }}>
                    {{ __('messages.editaddresses.teacher') }}
                </option>
            </select>
            @error('addressable_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Student select --}}
        <div class="mb-3" id="student_wrap" style="display:none;">
            <label for="student_id" class="form-label">{{ __('messages.editaddresses.student') }}</label>
            <select id="student_id" class="form-control">
                <option value="">{{ __('messages.editaddresses.select_student') }}</option>
                @foreach($students as $s)
                    <option value="{{ $s->id }}"
                        {{ old('addressable_id', $address->addressable_id)==$s->id && old('addressable_type', $address->addressable_type)=='App\\Models\\Student' ? 'selected':'' }}>
                        {{ $s->username }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Teacher select --}}
        <div class="mb-3" id="teacher_wrap" style="display:none;">
            <label for="teacher_id" class="form-label">{{ __('messages.editaddresses.teacher') }}</label>
            <select id="teacher_id" class="form-control">
                <option value="">{{ __('messages.editaddresses.select_teacher') }}</option>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}"
                        {{ old('addressable_id', $address->addressable_id)==$t->id && old('addressable_type', $address->addressable_type)=='App\\Models\\Teacher' ? 'selected':'' }}>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <input type="hidden" id="addressable_id" name="addressable_id" value="{{ old('addressable_id', $address->addressable_id) }}">

        <div class="mb-3">
            <label for="address_line" class="form-label">{{ __('messages.editaddresses.address') }}</label>
            <input type="text" name="address_line" id="address_line" class="form-control"
                   value="{{ old('address_line', $address->address_line) }}" required>
            @error('address_line') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">{{ __('messages.editaddresses.city') }}</label>
            <input type="text" name="city" id="city" class="form-control"
                   value="{{ old('city', $address->city) }}" required>
            @error('city') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">{{ __('messages.editaddresses.phone') }}</label>
            <input type="text" name="phone" id="phone" class="form-control"
                   value="{{ old('phone', $address->phone) }}" required>
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_main" id="is_main" class="form-check-input" value="1"
                   {{ old('is_main', $address->is_main) ? 'checked':'' }}>
            <label for="is_main" class="form-check-label">{{ __('messages.editaddresses.main_address') }}</label>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.editaddresses.update') }}</button>
        <a href="{{ route('addresses.index') }}" class="btn btn-secondary">{{ __('messages.editaddresses.back') }}</a>
    </form>
</div>

<script>
function syncActiveId() {
    const type = document.getElementById('user_type').value;
    const studentWrap = document.getElementById('student_wrap');
    const teacherWrap = document.getElementById('teacher_wrap');
    const studentSel  = document.getElementById('student_id');
    const teacherSel  = document.getElementById('teacher_id');
    const hiddenId    = document.getElementById('addressable_id');

    if (type === 'App\\Models\\Student') {
        studentWrap.style.display = 'block';
        teacherWrap.style.display = 'none';
        hiddenId.value = studentSel.value || '';
    } else if (type === 'App\\Models\\Teacher') {
        teacherWrap.style.display = 'block';
        studentWrap.style.display = 'none';
        hiddenId.value = teacherSel.value || '';
    } else {
        studentWrap.style.display = 'none';
        teacherWrap.style.display = 'none';
        hiddenId.value = '';
    }
}

document.getElementById('user_type').addEventListener('change', syncActiveId);
document.getElementById('student_id').addEventListener('change', syncActiveId);
document.getElementById('teacher_id').addEventListener('change', syncActiveId);

window.onload = syncActiveId;
</script>
@endsection

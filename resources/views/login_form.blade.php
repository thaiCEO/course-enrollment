@extends('components.login')
@section('content')

@if(Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Success!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif

@if(Session::has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Error!",
                text: "{{ Session::get('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    </script>
@endif

<div class="form login">
    <div class="form-content">
        <header>Admin Login</header>
        <form action="{{ route('login.proccess') }}" method="POST">
            @csrf
            <div class="field input-field">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="input">
                @error('email')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <div class="field input-field">
                <input type="password" name="password" placeholder="Password" class="password">
                <i class='bx bx-hide eye-icon'></i>
                @error('password')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-link">
                <a href="#" class="forgot-pass">Forgot password?</a>
            </div>

            <div class="field button-field">
                <button type="submit">Login</button>
            </div>
        </form>

    </div>
</div>

@endsection

@extends('layout')

@section('content')
<div class="container mt-5" style="max-width: 500px">
    <h3 class="text-center mb-4">Register</h3>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Captcha</label>
            <div class="d-flex align-items-center justify-content-between">
                <span><strong>{{ session('captcha_question') }}</strong></span>
                <a href="{{ route('register') }}" class="btn btn-sm btn-secondary">Refresh</a>
            </div>
            <input type="text" name="captcha_input" class="form-control mt-2" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Register</button>
    </form>
</div>
@endsection

@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Welcome, {{ $user['name'] }}</h2>
    <p>You are logged in as <strong>User</strong>.</p>
    <a href="/logout" class="btn btn-danger">Logout</a>
</div>
@endsection

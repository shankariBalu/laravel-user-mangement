@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Welcome, Admin {{ $user['name'] }}</h2>
    <p>You are logged in as <strong>Admin</strong>.</p>
    <a href="/admin/users" class="btn btn-primary">Manage Users</a>
    <a href="/logout" class="btn btn-danger">Logout</a>
</div>
@endsection

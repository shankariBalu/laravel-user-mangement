@extends('layout')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">User Management</h2>

    <!-- Search Form -->
    <form method="GET" action="/admin/users" class="mb-3 d-flex">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search users...">
        <button type="submit" class="btn btn-outline-primary">Search</button>
    </form>

    <!-- Add User Button -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Add User</button>

    <!-- User Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th style="width: 180px">Actions</th>
            </tr>
        </thead>
        <tbody>
        @isset($users['data'])
            @forelse($users['data'] as $user)
                <tr>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['role'] }}</td>
                    <td>
                        <!-- Edit -->
                        <button class="btn btn-sm btn-warning" onclick="openEdit('{{ $user['id'] }}', '{{ $user['name'] }}', '{{ $user['email'] }}', '{{ $user['role'] }}')">Edit</button>

                        <!-- Delete -->
                        <form action="/admin/users/delete/{{ $user['id'] }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                            @csrf
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No users found.</td>
                </tr>
            @endforelse
        @endisset
        </tbody>
    </table>

    <!-- Pagination -->
    @if(isset($users['links']))
        <div class="d-flex justify-content-center">
            @foreach($users['links'] as $link)
                @if($link['url'])
                    <a href="{{ $link['url'] }}" class="btn btn-sm {{ $link['active'] ? 'btn-primary' : 'btn-outline-secondary' }} mx-1">
                        {!! $link['label'] !!}
                    </a>
                @endif
            @endforeach
        </div>
    @endif
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="/admin/users/create">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Add User</h5></div>
                <div class="modal-body">
                    <input class="form-control mb-2" name="name" placeholder="Name" required>
                    <input class="form-control mb-2" name="email" type="email" placeholder="Email" required>
                    <input class="form-control mb-2" name="password" type="password" placeholder="Password" required>
                    <select name="role" class="form-select">
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="editForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Edit User</h5></div>
                <div class="modal-body">
                    <input class="form-control mb-2" name="name" id="editName" required>
                    <input class="form-control mb-2" name="email" id="editEmail" required>
                    <select name="role" class="form-select" id="editRole">
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id, name, email, role) {
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role;
    document.getElementById('editForm').action = '/admin/users/edit/' + id;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endsection

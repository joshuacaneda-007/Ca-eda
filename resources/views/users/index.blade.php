@extends('layouts.app')
@section('title', 'Users Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold">Users Management</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-plus-lg me-1"></i> Add User
    </button>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($u->profile_picture)
                                <img src="{{ Storage::url($u->profile_picture) }}" class="rounded-circle" width="30" height="30" style="object-fit:cover;">
                            @else
                                <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width:30px;height:30px;font-size:.75rem;font-weight:700;">
                                    {{ strtoupper(substr($u->name,0,1)) }}
                                </div>
                            @endif
                            {{ $u->name }}
                        </div>
                    </td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge {{ $u->role === 'admin' ? 'bg-danger' : 'bg-secondary' }}">{{ ucfirst($u->role) }}</span></td>
                    <td>{{ $u->created_at->format('M d, Y') }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-warning me-1"
                            data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="POST" action="{{ route('users.destroy', $u) }}" class="d-inline"
                            onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background:#1a1a2e;border:1px solid #2d2d4e;">
                            <div class="modal-header" style="border-color:#2d2d4e;">
                                <h6 class="modal-title">Edit User</h6>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('users.update', $u) }}">
                                @csrf @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Role</label>
                                        <select name="role" class="form-select">
                                            <option value="user" {{ $u->role==='user'?'selected':'' }}>User</option>
                                            <option value="admin" {{ $u->role==='admin'?'selected':'' }}>Admin</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">New Password <span class="text-muted">(leave blank to keep)</span></label>
                                        <input type="password" name="password" class="form-control" placeholder="New password">
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-color:#2d2d4e;">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background:#1a1a2e;border:1px solid #2d2d4e;">
            <div class="modal-header" style="border-color:#2d2d4e;">
                <h6 class="modal-title">Add New User</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email address" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Role</label>
                        <select name="role" class="form-select">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-color:#2d2d4e;">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

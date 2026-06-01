@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-bold">My Profile</h6>
            </div>
            <div class="card-body p-4">
                <!-- Avatar -->
                <div class="text-center mb-4">
                    @if($user->profile_picture)
                        <img src="{{ Storage::url($user->profile_picture) }}" class="rounded-circle mb-2"
                            width="90" height="90" style="object-fit:cover;border:3px solid #e94560;">
                    @else
                        <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center mx-auto mb-2"
                            style="width:90px;height:90px;font-size:2rem;font-weight:700;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <h6 class="mb-0">{{ $user->name }}</h6>
                    <small class="text-muted">{{ $user->email }}</small>
                    <div class="mt-1"><span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-secondary' }}">{{ ucfirst($user->role) }}</span></div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label small">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select...</option>
                                @foreach(['Male','Female','Other'] as $g)
                                    <option value="{{ $g }}" {{ old('gender', $user->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label small">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Address</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Your address">{{ old('address', $user->address) }}</textarea>
                    </div>
                    <hr style="border-color:#2d2d4e;">
                    <p class="small text-muted mb-2">Change Password <span class="text-muted">(leave blank to keep current)</span></p>
                    <div class="mb-3">
                        <label class="form-label small">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="New password">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

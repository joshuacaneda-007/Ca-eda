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
                    @if($user->profile_picture_base64)
                        <img src="{{ $user->profile_picture_base64 }}"
                             class="rounded-circle mb-2"
                             width="90" height="90"
                             style="object-fit:cover;border:3px solid #4f6ef7;">
                    @else
                        <div class="avatar-initials mx-auto mb-2"
                             style="width:90px;height:90px;font-size:2rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                    <small class="text-muted">{{ $user->email }}</small>
                    <div class="mt-1">
                        <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select...</option>
                                @foreach(['Male','Female','Other'] as $g)
                                    <option value="{{ $g }}" {{ old('gender', $user->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label">
                                Profile Picture
                                <span class="text-muted">(JPEG/PNG, max 2MB)</span>
                            </label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/jpeg,image/jpg,image/png"
                                   id="picInput" onchange="previewPic(this)">
                        </div>
                    </div>

                    <!-- Live preview -->
                    <div id="picPreviewWrap" class="mb-3 text-center d-none">
                        <img id="picPreview" src="" class="rounded-circle"
                             width="70" height="70" style="object-fit:cover;border:2px solid #4f6ef7;">
                        <div class="small text-muted mt-1">Preview</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Your address">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <hr>
                    <p class="small text-muted mb-2">Change Password <span class="text-muted">(leave blank to keep current)</span></p>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="New password">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewPic(input) {
    const wrap = document.getElementById('picPreviewWrap');
    const img  = document.getElementById('picPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; wrap.classList.remove('d-none'); };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

@extends('admin.layouts.app')

@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">{{ isset($user) ? 'Edit' : 'Create' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3">{{ isset($user) ? 'Edit User' : 'Create User' }}</h1>
            <p class="text-muted mb-0">{{ isset($user) ? 'Update user information and account settings.' : 'Add a new user to the system.' }}</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>
</div>

<form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($user)) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- BASIC INFORMATION -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', $user->name ?? '') }}" required placeholder="Full Name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', $user->email ?? '') }}" required placeholder="email@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                {{ isset($user) ? 'New Password' : 'Password' }} @if(!isset($user)) <span class="text-danger">*</span> @endif
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" {{ !isset($user) ? 'required' : '' }} placeholder="********">
                            </div>
                            <div class="form-text small mt-1">Min. 8 characters with numbers</div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password @if(!isset($user)) <span class="text-danger">*</span> @endif</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" 
                                       name="password_confirmation" placeholder="********">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACCOUNT SETTINGS -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Account Permissions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                <option value="active" @selected(old('status', $user->status ?? '') == 'active')>Active</option>
                                <option value="pending" @selected(old('status', $user->status ?? '') == 'pending')>Pending</option>
                                <option value="banned" @selected(old('status', $user->status ?? '') == 'banned')>Banned</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mt-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="emailVerified" name="email_verified" value="1" 
                                       @checked(isset($user) && $user->email_verified_at)>
                                <label class="form-check-label" for="emailVerified">Email Verified</label>
                                <div class="form-text">Manually verify this user's email address</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- PROFILE PHOTO -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Profile Photo</h5>
                </div>
                <div class="card-body text-center">
                    <div id="photoPreviewContainer" class="mb-3 mx-auto rounded-circle overflow-hidden bg-light d-flex align-items-center justify-content-center border" 
                         style="width: 150px; height: 150px;">
                        @if(isset($user) && $user->avatar)
                            <img id="photo-preview" src="{{ Storage::url($user->avatar) }}" class="w-100 h-100 object-fit-cover">
                        @else
                            <div id="photo-placeholder" class="text-muted">
                                <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                            </div>
                            <img id="photo-preview" src="#" class="w-100 h-100 object-fit-cover d-none">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="avatarInput" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-upload me-2"></i>Upload Photo
                        </label>
                        <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*" onchange="previewPhoto(event)">
                        <div class="form-text small mt-2">JPG, PNG (Max 2MB)</div>
                    </div>
                </div>
            </div>

            @if(isset($user))
            <!-- USER METADATA -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">System Info</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item py-3">
                            <div class="text-muted small mb-1 text-uppercase">User ID</div>
                            <div class="fw-bold">#{{ $user->id }}</div>
                        </li>
                        <li class="list-group-item py-3">
                            <div class="text-muted small mb-1 text-uppercase">Member Since</div>
                            <div class="fw-bold">{{ $user->created_at->format('M d, Y') }}</div>
                            <div class="small text-muted">{{ $user->created_at->diffForHumans() }}</div>
                        </li>
                        <li class="list-group-item py-3">
                            <div class="text-muted small mb-1 text-uppercase">Last Activity</div>
                            <div class="fw-bold">{{ $user->last_seen ? $user->last_seen->format('M d, Y H:i') : 'Never' }}</div>
                            <div class="small text-muted">{{ $user->last_seen ? $user->last_seen->diffForHumans() : '-' }}</div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- QUICK ACTIONS -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-secondary text-start" onclick="resetPassword()">
                            <i class="bi bi-key me-2 text-warning"></i>Reset Password
                        </button>
                        <button type="button" class="btn btn-outline-secondary text-start" onclick="sendEmail()">
                            <i class="bi bi-envelope me-2 text-info"></i>Send Welcome Email
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="bi bi-check-circle me-2"></i>{{ isset($user) ? 'Save Changes' : 'Create User Account' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    function previewPhoto(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('photo-preview');
        const placeholder = document.getElementById('photo-placeholder');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    }


    function resetPassword() {
        if (confirm('Send a password reset link to this user\'s email?')) {
            alert('Password reset email sent');
        }
    }

    function banUser(userId) {
        if (confirm('Are you sure you want to ban this user? They will not be able to login.')) {
            alert('User banned successfully');
        }
    }

    function sendEmail() {
        if (confirm('Send a notification email to this user?')) {
            alert('Email sent successfully');
        }
    }
</script>
@endsection

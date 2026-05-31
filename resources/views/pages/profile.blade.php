@extends('layouts.main')

@section('title', 'My Profile')

@section('content')
<section id="profile-container" class="py-5" style="min-height: 85vh;">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 text-white mb-1">My Profile</h1>
                <p class="text-secondary small mb-0">Manage your account information</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        <div class="row g-4">
            <!-- Left Column — Profile Card -->
            <div class="col-lg-4">
                <div class="glass-card rounded-4 p-4 border border-secondary border-opacity-25 text-center">
                    <!-- Profile Picture -->
                    <div class="profile-picture-wrapper mx-auto mb-3">
                        <img src="{{ asset('uploads/' . ($user->profile_picture_path ?: 'default.webp')) }}"
                             alt="Profile Picture"
                             class="profile-picture-img"
                             id="profilePreview">
                        <button class="profile-picture-overlay" data-bs-toggle="modal" data-bs-target="#changePictureModal">
                            <i class="bi bi-camera-fill fs-4"></i>
                            <span class="small">Change</span>
                        </button>
                    </div>

                    <h4 class="text-white mb-1">{{ $user->name }}</h4>
                    <p class="text-secondary small mb-2">{{ $user->email }}</p>
                    <span class="badge bg-success bg-opacity-25 text-success px-3 py-2">
                        <i class="bi bi-person-check me-1"></i>
                        {{ ucfirst($user->gender ?? 'male') }}
                    </span>

                    <hr class="border-secondary border-opacity-25 my-3">

                    <div class="text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-secondary">Member since</small>
                            <small class="text-white">{{ $user->created_at->format('M d, Y') }}</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-secondary">Last updated</small>
                            <small class="text-white">{{ $user->updated_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column — Edit Profile Form -->
            <div class="col-lg-8">
                <div class="glass-card rounded-4 p-4 border border-secondary border-opacity-25">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="stat-icon-box">
                            <i class="bi bi-pencil-square fs-5"></i>
                        </div>
                        <div>
                            <h5 class="text-white mb-0">Edit Profile</h5>
                            <small class="text-secondary">Update your personal information</small>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit-name" class="form-label text-secondary small">Full Name</label>
                                <input type="text" class="form-control bg-transparent border-secondary text-white @error('name') is-invalid @enderror"
                                       id="edit-name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit-email" class="form-label text-secondary small">Email Address</label>
                                <input type="email" class="form-control bg-transparent border-secondary text-white @error('email') is-invalid @enderror"
                                       id="edit-email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit-gender" class="form-label text-secondary small">Gender</label>
                                <select class="form-select bg-transparent border-secondary text-white glass-select @error('gender') is-invalid @enderror"
                                        id="edit-gender" name="gender">
                                    @php $gender = old('gender', $user->gender ?? 'male'); @endphp
                                    <option value="male" class="bg-dark" {{ $gender === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" class="bg-dark" {{ $gender === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="preferNotToSay" class="bg-dark" {{ $gender === 'preferNotToSay' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="border-secondary border-opacity-25">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-glass-green px-4">
                                <i class="bi bi-check-lg me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Info Card -->
                <div class="glass-card rounded-4 p-4 border border-secondary border-opacity-25 mt-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="stat-icon-box stat-icon-recipe">
                            <i class="bi bi-shield-check fs-5"></i>
                        </div>
                        <div>
                            <h5 class="text-white mb-0">Account Details</h5>
                            <small class="text-secondary">Your account information at a glance</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="profile-info-card p-3 rounded-3">
                                <small class="text-secondary text-uppercase ls-1">User ID</small>
                                <p class="text-white mb-0 fw-semibold mt-1">#{{ $user->id }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="profile-info-card p-3 rounded-3">
                                <small class="text-secondary text-uppercase ls-1">Email Verified</small>
                                <p class="mb-0 mt-1">
                                    @if($user->email_verified_at)
                                        <span class="text-success fw-semibold"><i class="bi bi-check-circle me-1"></i>Verified</span>
                                    @else
                                        <span class="text-warning fw-semibold"><i class="bi bi-clock me-1"></i>Pending</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="profile-info-card p-3 rounded-3">
                                <small class="text-secondary text-uppercase ls-1">Gender</small>
                                <p class="text-white mb-0 fw-semibold mt-1">{{ ucfirst($user->gender ?? 'Male') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════ -->
<!-- CHANGE PROFILE PICTURE MODAL                    -->
<!-- ════════════════════════════════════════════════ -->
<div class="modal fade" id="changePictureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-modal border-secondary border-opacity-25">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white">
                    <i class="bi bi-camera me-2 text-success"></i>Change Profile Picture
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.picture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-center">
                    <div class="profile-picture-wrapper mx-auto mb-3" style="width: 150px; height: 150px;">
                        <img src="{{ asset('uploads/' . ($user->profile_picture_path ?: 'default.webp')) }}"
                             alt="Current Picture"
                             class="profile-picture-img"
                             id="modalPreview">
                    </div>

                    <div class="mb-3">
                        <label for="profile_picture" class="form-label text-secondary small">Choose a new photo</label>
                        <input type="file" class="form-control bg-transparent border-secondary text-white @error('profile_picture') is-invalid @enderror"
                               id="profile_picture" name="profile_picture" accept="image/*" required>
                        @error('profile_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-secondary small mt-2">Max 2MB. Supported: JPEG, PNG, JPG, GIF, WebP</div>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-glass-green px-4">
                        <i class="bi bi-upload me-1"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast Notification -->
@if(session('success'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        {{ session('success') }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>
@endif

@if($errors->any())
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        {{ $errors->first() }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Toast initialization
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    toastElList.map(function(toastEl) {
        var t = new bootstrap.Toast(toastEl, { autohide: true, delay: 5000 });
        t.show();
        return t;
    });

    // Live preview of selected profile picture
    var fileInput = document.getElementById('profile_picture');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('modalPreview').src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Re-open picture modal if there were validation errors
    @if ($errors->has('profile_picture'))
        var picModal = new bootstrap.Modal(document.getElementById('changePictureModal'));
        picModal.show();
    @endif
});
</script>
@endsection

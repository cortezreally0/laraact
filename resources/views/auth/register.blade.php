@extends('layouts.app')

@section('content')
<section class="registration-section d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="registration-card p-4 p-sm-5 rounded-4 shadow-lg">
                    <div class="text-center mb-4">
                        <h2 class="text-white fw-bold">Create Account</h2>
                        <p class="text-secondary small">Join the BSIT community</p>
                    </div>

                    <form action="{{ route('register.post') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-whitesmall">Name</label>
                                <input type="text" name="name" class="form-control bg-transparent text-white border-secondary" placeholder="Enter your name" id="name" required>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-white small">Email Address</label>
                                <input type="email" name="email" class="form-control bg-transparent text-white border-secondary" placeholder="Enter email address" id="email" required>
                                <div class="invalid-feedback">Please provide a valid email.</div>
                                <div class="valid-feedback">Email is valid!</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-white small">Password</label>
                                <input type="password" name="password" class="form-control bg-transparent text-white border-secondary" placeholder="Enter password" id="password" required minlength="8">
                                <div class="invalid-feedback">Min 8 characters.</div>
                                <div class="valid-feedback">Password is valid!</div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-4 mb-3">
                            <label for="genderSelect" class="form-label text-white small">Gender (Optional)</label>
                            <select class="form-select bg-transparent text-white border-secondary glass-select" id="genderSelect" name="gender">
                                <option value="" class="bg-dark" selected>Select gender</option>
                                <option value="male" class="bg-dark">Male</option>
                                <option value="female" class="bg-dark">Female</option>
                                <option value="preferNotToSay" class="bg-dark">Prefer not to say</option>
                            </select>
                        </div>

                        <button class="btn btn-glass-submit w-100 py-3 fw-bold mb-3">
                            Register Now
                        </button>

                    </form>
                    <p class="text-center text-secondary small">
                            Already have an account? <a href="login.php" class="text-success text-decoration-none ">Login</a>
                        </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Toast Notification -->
@if(session('success'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert">
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
        Registration failed. Please check the form.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>
@endif

<script>
  // Loads the toast / Triggers the toast
document.addEventListener("DOMContentLoaded", function() {
    // Select all toast elements
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function(toastEl) {
        var t = new bootstrap.Toast(toastEl, { autohide: true, delay: 5000 });
        t.show();
        return t;
    });
});
</script>
@endsection

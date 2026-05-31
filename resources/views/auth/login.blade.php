@extends('layouts.app')

@section('title')
Login
@endsection

@section('content')
<section class="login-section d-flex align-items-center">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-4">
                <div class="login-card p-4 p-sm-5 rounded-4 shadow-lg">
                    <div class="text-center mb-4">
                        <h2 class="text-white fw-bold">Login</h2>
                        <p class="text-secondary small">Enter your credentials to access Dashboard</p>
                    </div>

                    <form action="{{ route('login.post') }}" class="needs-validation" method="POST" novalidate>
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
                        <div class="mb-3">
                            <label for="email" class="form-label text-white small">Email Address</label>
                            <input type="email" name="email" class="form-control bg-transparent text-white border-secondary" id="email" placeholder="Enter email address" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                            <div class="valid-feedback">email is valid</div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-white small">Password</label>
                            <input type="password" name="password" class="form-control bg-transparent text-white border-secondary" id="password" placeholder="Enter password" required minlength="1">
                        </div>

                        <p class="text-secondary small text-center">Make sure your email and password are correct and complete.</p>

                        <button class="btn btn-glass-submit w-100 py-2 fw-bold mb-3" name="login" type="submit">
                            Sign In
                        </button>

                        <div class="text-center">
                            <a href="#" class="text-success small text-decoration-none">Forgot password?</a>
                        </div>

                        <p class="text-center text-secondary small">
                            Don't have an account? <a href="{{ route('register') }}" class="text-success text-decoration-none">Register</a>
                        </p>

                    </form>
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
        Login failed. Please check your email and password.
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

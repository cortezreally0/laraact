@extends('layouts.app')

@section('content')
<!-- hero -->
<section class="hero-section text-center d-flex align-items-center">
    <div class="container">
        <div class="mb-5">
            <span class="badge-custom">
                <span class="badge bg-success me-2 rounded-1">NEW</span>
                New Registration and Login pages →
            </span>
        </div>

        <h1 class="main-title text-white mb-0">Hero Section</h1>
        <h1 class="main-title gradient-text mb-4">My sample landing page.</h1>
        <p class="description text-muted mb-5 mx-auto">
            This is for my activity in ITEC 106 - Web Development.
        </p>
        <div class="cta-container mx-auto">
            <a href="/login" class="btn btn-signin-green w-100 py-3 fw-bold mb-4">Get Started</a>
            <p class="faq-text mt-3">Laboratory activity 1. See more <a href="/about" class="text-info text-decoration-none">About</a></p>
        </div>
    </div>
</section>

<!-- jumbortton -->
<div class="container my-5">
    <div class="jumbotron-custom p-5 rounded-4 shadow-lg text-center border border-secondary">
        <h1 class="display-4 fw-bold text-white">Jumbotron Sample.</h1>
        <p class="lead text-secondary mt-3">A jumbotron was introduced in Bootstrap 3 as a big padded box for calling extra attention to some special content or information.</p>
        <hr class="my-4 border-secondary opacity-25">
        <div class="d-flex justify-content-center gap-3">
            <a href="about.html" class="btn btn-color-green px-4 py-2 fw-bold">About</a>
            <a href="contact.html" class="btn btn-outline-light px-4 py-2">View Contact</a>
        </div>
    </div>

</div>

<!-- Card -->
<div class="container pb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 app-card">
                <div class="card-body p-4">
                    <div class="icon-box mb-3">➤</div>
                    <h5 class="card-title text-white">Card</h5>
                    <p class="card-text text-secondary">A card in Bootstrap 5 is a bordered box with some padding around its content. It includes options for headers, footers, content, colors, etc.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 app-card">
                <div class="card-body p-4">
                    <div class="icon-box mb-3">☲</div>
                    <h5 class="card-title text-white">Card</h5>
                    <p class="card-text text-secondary">A card in Bootstrap 5 is a bordered box with some padding around its content. It includes options for headers, footers, content, colors, etc.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 app-card">
                <div class="card-body p-4">
                    <div class="icon-box mb-3">✦</div>
                    <h5 class="card-title text-white">Card</h5>
                    <p class="card-text text-secondary">A card in Bootstrap 5 is a bordered box with some padding around its content. It includes options for headers, footers, content, colors, etc.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

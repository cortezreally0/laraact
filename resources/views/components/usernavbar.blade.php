<!-- Nav -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top navbar-glass pt-3">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Overview</a></li>
                <li class="nav-item"><a class="nav-link px-3 {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.show') }}">Profile</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

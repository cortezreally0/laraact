<!-- sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse border-end border-secondary border-opacity-25 vh-100">
            <div class="position-sticky pt-4 px-3">
                <h5 class="text-white mb-4 px-2">Console</h5>
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active-link' : 'text-white-50' }}"
                        href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active-link' : 'text-white-50' }}"
                        href="{{ route('users.index') }}"><i class="bi bi-people me-2"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('recipes.*') ? 'active-link' : 'text-white-50' }}"
                        href="{{ route('recipes.index') }}"><i class="bi bi-journal-bookmark me-2"></i> Recipe List</a>
                    </li>
                </ul>
            </div>
        </nav>

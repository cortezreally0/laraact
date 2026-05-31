@extends('layouts.main')

@section('title', 'Users Management')

@section('content')
<!-- Users Management -->
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <!-- Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary border-opacity-25">
                <h1 class="h2 text-white">Users Management</h1>
                <button class="btn btn-glass-green btn-sm px-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-lg me-1"></i> Add User
                </button>
            </div>

            <!-- Users Table -->
            <div class="glass-card rounded-4 p-4 border border-secondary border-opacity-25">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-white mb-0">All Users</h5>
                    <span class="badge bg-success bg-opacity-25 text-success px-3 py-2">
                        {{ $users->count() }} {{ Str::plural('user', $users->count()) }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0" id="users-table">
                        <thead>
                            <tr class="text-secondary small text-uppercase border-secondary">
                                <th class="ps-3">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-white-50">
                            @forelse ($users as $index => $user)
                            <tr>
                                <td class="ps-3 text-secondary">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar-sm">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <span class="text-white">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-info border-0 me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserModal-{{ $user->id }}"
                                            title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger border-0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal-{{ $user->id }}"
                                            title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">
                                    <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                                    No users found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- ════════════════════════════════════════════════ -->
<!-- ADD USER MODAL                                  -->
<!-- ════════════════════════════════════════════════ -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-modal border-secondary border-opacity-25">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white" id="addUserModalLabel">
                    <i class="bi bi-person-plus me-2 text-success"></i>Add New User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add-name" class="form-label text-secondary small">Name</label>
                        <input type="text" class="form-control bg-transparent border-secondary text-white"
                               id="add-name" name="name" placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label for="add-email" class="form-label text-secondary small">Email</label>
                        <input type="email" class="form-control bg-transparent border-secondary text-white"
                               id="add-email" name="email" placeholder="Enter email address" required>
                    </div>
                    <div class="mb-3">
                        <label for="add-password" class="form-label text-secondary small">Password</label>
                        <input type="password" class="form-control bg-transparent border-secondary text-white"
                               id="add-password" name="password" placeholder="Minimum 8 characters" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-glass-green px-4">
                        <i class="bi bi-check-lg me-1"></i> Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════════ -->
<!-- EDIT & DELETE MODALS (per user)                  -->
<!-- ════════════════════════════════════════════════ -->
@foreach ($users as $user)
<!-- Edit Modal -->
<div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-modal border-secondary border-opacity-25">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white">
                    <i class="bi bi-pencil-square me-2 text-info"></i>Edit User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name-{{ $user->id }}" class="form-label text-secondary small">Name</label>
                        <input type="text" class="form-control bg-transparent border-secondary text-white"
                               id="edit-name-{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-email-{{ $user->id }}" class="form-label text-secondary small">Email</label>
                        <input type="email" class="form-control bg-transparent border-secondary text-white"
                               id="edit-email-{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-glass-info px-4">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteUserModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content glass-modal border-danger border-opacity-25">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white">
                    <i class="bi bi-exclamation-triangle me-2 text-danger"></i>Delete User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="delete-icon-circle mx-auto mb-3">
                    <i class="bi bi-person-x fs-2"></i>
                </div>
                <p class="text-white mb-1">Are you sure you want to delete</p>
                <p class="text-success fw-semibold">{{ $user->name }}?</p>
                <p class="text-secondary small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-secondary border-opacity-25 justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger px-4">
                        <i class="bi bi-trash3 me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

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
    // Loads the toast / Triggers the toast
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function(toastEl) {
        var t = new bootstrap.Toast(toastEl, { autohide: true, delay: 5000 });
        t.show();
        return t;
    });

    // Re-open Add modal if there were validation errors on store
    @if ($errors->any() && old('_method') === null)
        var addModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        addModal.show();
    @endif
});
</script>
@endsection


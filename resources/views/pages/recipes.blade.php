@extends('layouts.main')

@section('title', 'Recipe List')

@section('content')
<!-- Recipe List -->
<div class="container-fluid">
    <div class="row">
        @include('components.sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <!-- Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary border-opacity-25">
                <h1 class="h2 text-white">Recipe List</h1>
                <button class="btn btn-glass-green btn-sm px-3" data-bs-toggle="modal" data-bs-target="#addRecipeModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Recipe
                </button>
            </div>

            <!-- Recipes Table -->
            <div class="glass-card rounded-4 p-4 border border-secondary border-opacity-25">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-white mb-0">My Recipes</h5>
                    <span class="badge bg-success bg-opacity-25 text-success px-3 py-2">
                        {{ $recipes->count() }} {{ Str::plural('recipe', $recipes->count()) }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0" id="recipes-table">
                        <thead>
                            <tr class="text-secondary small text-uppercase border-secondary">
                                <th class="ps-3">#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Prep Time</th>
                                <th>Created Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-white-50">
                            @forelse ($recipes as $index => $recipe)
                            <tr>
                                <td class="ps-3 text-secondary">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="recipe-avatar-sm">
                                            <i class="bi bi-journal-bookmark-fill"></i>
                                        </div>
                                        <span class="text-white">{{ $recipe->title }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-white-50" title="{{ $recipe->description }}">
                                        {{ Str::limit($recipe->description, 40) ?: '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <i class="bi bi-clock me-1"></i>{{ $recipe->prep_time }} min
                                    </span>
                                </td>
                                <td>{{ $recipe->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-info border-0 me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewRecipeModal-{{ $recipe->id }}"
                                            title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning border-0 me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editRecipeModal-{{ $recipe->id }}"
                                            title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger border-0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteRecipeModal-{{ $recipe->id }}"
                                            title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-5">
                                    <i class="bi bi-journal-bookmark fs-1 d-block mb-2 opacity-50"></i>
                                    No recipes yet. Add your first recipe!
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
<!-- ADD RECIPE MODAL                                -->
<!-- ════════════════════════════════════════════════ -->
<div class="modal fade" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-modal border-secondary border-opacity-25">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white" id="addRecipeModalLabel">
                    <i class="bi bi-journal-plus me-2 text-success"></i>Add New Recipe
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('recipes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="add-title" class="form-label text-secondary small">Title</label>
                            <input type="text" class="form-control bg-transparent border-secondary text-white"
                                   id="add-title" name="title" placeholder="Recipe name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="add-prep-time" class="form-label text-secondary small">Prep Time (minutes)</label>
                            <input type="number" class="form-control bg-transparent border-secondary text-white"
                                   id="add-prep-time" name="prep_time" placeholder="e.g. 30" min="1" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add-description" class="form-label text-secondary small">Description <span class="text-secondary opacity-50">(optional)</span></label>
                        <input type="text" class="form-control bg-transparent border-secondary text-white"
                               id="add-description" name="description" placeholder="Brief description">
                    </div>
                    <div class="mb-3">
                        <label for="add-ingredients" class="form-label text-secondary small">Ingredients</label>
                        <textarea class="form-control bg-transparent border-secondary text-white" rows="3"
                                  id="add-ingredients" name="ingredients" placeholder="List ingredients, one per line" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="add-instructions" class="form-label text-secondary small">Instructions</label>
                        <textarea class="form-control bg-transparent border-secondary text-white" rows="3"
                                  id="add-instructions" name="instructions" placeholder="Step-by-step instructions" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-glass-green px-4">
                        <i class="bi bi-check-lg me-1"></i> Add Recipe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════════ -->
<!-- VIEW, EDIT & DELETE MODALS (per recipe)          -->
<!-- ════════════════════════════════════════════════ -->
@foreach ($recipes as $recipe)

<!-- View Modal -->
<div class="modal fade" id="viewRecipeModal-{{ $recipe->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-modal border-secondary border-opacity-25">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white">
                    <i class="bi bi-journal-bookmark me-2 text-info"></i>{{ $recipe->title }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <small class="text-secondary text-uppercase ls-1">Description</small>
                        <p class="text-white mt-1">{{ $recipe->description ?: 'No description provided.' }}</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                            <i class="bi bi-clock me-1"></i>{{ $recipe->prep_time }} min
                        </span>
                    </div>
                </div>
                <hr class="border-secondary border-opacity-25">
                <div class="mb-3">
                    <small class="text-secondary text-uppercase ls-1">Ingredients</small>
                    <div class="text-white-50 mt-1" style="white-space: pre-line;">{{ $recipe->ingredients }}</div>
                </div>
                <hr class="border-secondary border-opacity-25">
                <div class="mb-3">
                    <small class="text-secondary text-uppercase ls-1">Instructions</small>
                    <div class="text-white-50 mt-1" style="white-space: pre-line;">{{ $recipe->instructions }}</div>
                </div>
                <hr class="border-secondary border-opacity-25">
                <small class="text-secondary">Created: {{ $recipe->created_at->format('F d, Y \a\t h:i A') }}</small>
            </div>
            <div class="modal-footer border-secondary border-opacity-25">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editRecipeModal-{{ $recipe->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-modal border-secondary border-opacity-25">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Recipe
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('recipes.update', $recipe->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="edit-title-{{ $recipe->id }}" class="form-label text-secondary small">Title</label>
                            <input type="text" class="form-control bg-transparent border-secondary text-white"
                                   id="edit-title-{{ $recipe->id }}" name="title" value="{{ $recipe->title }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit-prep-time-{{ $recipe->id }}" class="form-label text-secondary small">Prep Time (minutes)</label>
                            <input type="number" class="form-control bg-transparent border-secondary text-white"
                                   id="edit-prep-time-{{ $recipe->id }}" name="prep_time" value="{{ $recipe->prep_time }}" min="1" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description-{{ $recipe->id }}" class="form-label text-secondary small">Description <span class="text-secondary opacity-50">(optional)</span></label>
                        <input type="text" class="form-control bg-transparent border-secondary text-white"
                               id="edit-description-{{ $recipe->id }}" name="description" value="{{ $recipe->description }}">
                    </div>
                    <div class="mb-3">
                        <label for="edit-ingredients-{{ $recipe->id }}" class="form-label text-secondary small">Ingredients</label>
                        <textarea class="form-control bg-transparent border-secondary text-white" rows="3"
                                  id="edit-ingredients-{{ $recipe->id }}" name="ingredients" required>{{ $recipe->ingredients }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-instructions-{{ $recipe->id }}" class="form-label text-secondary small">Instructions</label>
                        <textarea class="form-control bg-transparent border-secondary text-white" rows="3"
                                  id="edit-instructions-{{ $recipe->id }}" name="instructions" required>{{ $recipe->instructions }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-glass-warning px-4">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteRecipeModal-{{ $recipe->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content glass-modal border-danger border-opacity-25">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white">
                    <i class="bi bi-exclamation-triangle me-2 text-danger"></i>Delete Recipe
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="delete-icon-circle mx-auto mb-3">
                    <i class="bi bi-journal-x fs-2"></i>
                </div>
                <p class="text-white mb-1">Are you sure you want to delete</p>
                <p class="text-success fw-semibold">{{ $recipe->title }}?</p>
                <p class="text-secondary small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-secondary border-opacity-25 justify-content-center">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST">
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
        var addModal = new bootstrap.Modal(document.getElementById('addRecipeModal'));
        addModal.show();
    @endif
});
</script>
@endsection

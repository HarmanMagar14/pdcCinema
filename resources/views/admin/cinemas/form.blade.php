@extends('admin.layouts.app')

@section('title', isset($cinema) ? 'Edit Cinema' : 'Create Cinema')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.cinemas.index') }}">Cinemas</a></li>
        <li class="breadcrumb-item active">{{ isset($cinema) ? 'Edit' : 'Create' }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-4">
    <h1 class="h3">{{ isset($cinema) ? 'Edit Cinema' : 'Create New Cinema' }}</h1>
    <p class="text-muted">Fill in the details below to manage cinema locations and halls.</p>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Cinema Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($cinema) ? route('admin.cinemas.update', $cinema) : route('admin.cinemas.store') }}" method="POST">
                    @csrf
                    @if(isset($cinema))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Cinema Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $cinema->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="location" class="form-label">Location</label>
                        <textarea id="location" name="location" class="form-control @error('location') is-invalid @enderror" 
                                  rows="3" required>{{ old('location', $cinema->location ?? '') }}</textarea>
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            {{ isset($cinema) ? 'Update' : 'Create' }} Cinema
                        </button>
                        <a href="{{ route('admin.cinemas.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        @if(isset($cinema))
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Screening Halls</h5>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addHallModal">
                        Add Hall
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Hall Name</th>
                                    <th>Type</th>
                                    <th>Capacity</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cinema->halls as $hall)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $hall->name }}</div>
                                        <div class="small text-muted">{{ $hall->audio_system ?: 'Standard Audio' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $hall->projection_type }}</span>
                                        @if($hall->screen_type)
                                            <div class="small text-muted mt-1">{{ $hall->screen_type }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span>{{ $hall->capacity }}</span>
                                        <span class="small text-muted">seats</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary edit-hall-btn" 
                                                    data-hall="{{ json_encode($hall) }}"
                                                    data-bs-toggle="modal" data-bs-target="#editHallModal">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.halls.destroy', $hall) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Delete this hall?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <p class="text-muted mb-0">No halls configured for this cinema.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card bg-light border-dashed h-100 d-flex align-items-center justify-content-center py-5">
                <div class="text-center text-muted px-4">
                    <h5>Halls Management</h5>
                    <p class="small mb-0">You will be able to add and manage screening halls after creating the cinema.</p>
                </div>
            </div>
        @endif
    </div>
</div>

@if(isset($cinema))
    <!-- Add Hall Modal -->
    <div class="modal fade" id="addHallModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.halls.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cinema_id" value="{{ $cinema->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Hall</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Hall Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Capacity (Seats)</label>
                                <input type="number" name="capacity" class="form-control" required min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Projection Type</label>
                                <select name="projection_type" class="form-select">
                                    <option value="2D">2D</option>
                                    <option value="3D">3D</option>
                                    <option value="IMAX">IMAX</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Screen Type</label>
                                <input type="text" name="screen_type" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Audio System</label>
                                <input type="text" name="audio_system" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Hall</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Hall Modal -->
    <div class="modal fade" id="editHallModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editHallForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Hall</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Hall Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Capacity (Seats)</label>
                                <input type="number" name="capacity" id="edit_capacity" class="form-control" required min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Projection Type</label>
                                <select name="projection_type" id="edit_projection_type" class="form-select">
                                    <option value="2D">2D</option>
                                    <option value="3D">3D</option>
                                    <option value="IMAX">IMAX</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Screen Type</label>
                                <input type="text" name="screen_type" id="edit_screen_type" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Audio System</label>
                                <input type="text" name="audio_system" id="edit_audio_system" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Hall</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtns = document.querySelectorAll('.edit-hall-btn');
            const editForm = document.getElementById('editHallForm');
            
            editBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const hall = JSON.parse(this.dataset.hall);
                    editForm.action = `/admin/halls/${hall.id}`;
                    document.getElementById('edit_name').value = hall.name;
                    document.getElementById('edit_capacity').value = hall.capacity;
                    document.getElementById('edit_projection_type').value = hall.projection_type;
                    document.getElementById('edit_screen_type').value = hall.screen_type || '';
                    document.getElementById('edit_audio_system').value = hall.audio_system || '';
                });
            });
        });
    </script>
    @endpush
@endif
@endsection

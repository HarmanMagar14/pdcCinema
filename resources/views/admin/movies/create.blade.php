@extends('admin.layouts.app')
@section('title', 'Add Movie')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.movies.index') }}">Movies</a></li>
        <li class="breadcrumb-item active">Add Movie</li>
    </ol>
</nav>
@endsection

@section('content')

<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1>Add New Movie</h1>
        <p>Step 1 of 2 — Fill in the movie details below.</p>
    </div>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Movies
    </a>
</div>

{{-- Step indicator --}}
<div class="d-flex mb-4" style="gap:0;">
    <div class="d-flex align-items-center gap-2 px-4 py-2"
         style="background:rgba(232,52,10,0.12);border:1px solid rgba(232,52,10,0.35);border-radius:0.5rem 0 0 0.5rem;">
        <span class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
              style="width:22px;height:22px;font-size:0.7rem;background:var(--accent);">1</span>
        <span class="fw-semibold" style="color:var(--text);font-size:0.9rem;">Movie Details</span>
    </div>
    <div class="d-flex align-items-center gap-2 px-4 py-2"
         style="background:var(--surface2);border:1px solid var(--border);border-left:none;border-radius:0 0.5rem 0.5rem 0;">
        <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
              style="width:22px;height:22px;font-size:0.7rem;background:var(--surface2);border:1px solid var(--border);color:var(--muted);">2</span>
        <span style="color:var(--muted);font-size:0.9rem;">Scheduling</span>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger mb-4">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    Please fix the following errors:
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">

        {{-- LEFT — main fields --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-film me-2" style="color:var(--accent);"></i>Movie Details
                    </h5>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:1.25rem;">

                    <div>
                        <label for="title" class="form-label">Title <span style="color:var(--accent);">*</span></label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title"
                               value="{{ old('title') }}"
                               placeholder="e.g. The Dark Knight" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="description" class="form-label">Description <span style="color:var(--accent);">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description"
                                  rows="5"
                                  placeholder="Enter a brief synopsis of the movie..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="genre_id" class="form-label">Genre <span style="color:var(--accent);">*</span></label>
                            <select class="form-select @error('genre_id') is-invalid @enderror"
                                    id="genre_id" name="genre_id" required>
                                <option value="">Select Genre</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="duration" class="form-label">
                                Duration (mins) <span style="color:var(--accent);">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('duration') is-invalid @enderror"
                                   id="duration" name="duration"
                                   value="{{ old('duration') }}"
                                   placeholder="e.g. 120" min="1" required>
                            @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="release_date" class="form-label">Release Date <span style="color:var(--accent);">*</span></label>
                            <input type="date"
                                   class="form-control @error('release_date') is-invalid @enderror"
                                   id="release_date" name="release_date"
                                   value="{{ old('release_date') }}" required>
                            @error('release_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="trailer_url" class="form-label">
                            Trailer URL <span style="color:var(--muted);font-weight:400;font-size:0.8rem;">(YouTube link, optional)</span>
                        </label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:var(--muted);">
                                <i class="bi bi-youtube"></i>
                            </span>
                            <input type="url"
                                   class="form-control @error('trailer_url') is-invalid @enderror"
                                   id="trailer_url" name="trailer_url"
                                   value="{{ old('trailer_url') }}"
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   style="padding-left:2.2rem;">
                        </div>
                        @error('trailer_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT — poster --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-image me-2" style="color:var(--accent);"></i>Movie Poster
                    </h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center gap-3">
                    <div id="poster-preview-wrap"
                         style="width:100%;aspect-ratio:2/3;background:var(--surface2);border:2px dashed var(--border);border-radius:0.6rem;display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative;">
                        <div id="poster-placeholder" style="text-align:center;color:var(--muted);">
                            <i class="bi bi-image" style="font-size:3rem;display:block;margin-bottom:0.5rem;"></i>
                            <span style="font-size:0.85rem;">No poster selected</span>
                        </div>
                        <img id="poster-preview" src="" alt="Preview"
                             style="width:100%;height:100%;object-fit:cover;border-radius:0.5rem;display:none;">
                    </div>
                    <div style="width:100%;">
                        <label for="poster" style="display:block;width:100%;cursor:pointer;">
                            <div style="background:var(--surface2);border:1px solid var(--border);border-radius:0.45rem;padding:0.65rem 1rem;display:flex;align-items:center;gap:0.6rem;"
                                 onmouseover="this.style.borderColor='rgba(232,52,10,0.5)'"
                                 onmouseout="this.style.borderColor='var(--border)'">
                                <i class="bi bi-upload" style="color:var(--accent);font-size:1rem;"></i>
                                <span id="file-label" style="color:var(--muted);font-size:0.88rem;">Choose poster image</span>
                            </div>
                            <input type="file" id="poster" name="poster" accept="image/*"
                                   class="@error('poster') is-invalid @enderror"
                                   style="display:none;" onchange="previewPoster(this)">
                        </label>
                        @error('poster')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <p style="font-size:0.75rem;color:var(--muted);margin-top:0.4rem;text-align:center;">JPG, PNG, WEBP · Max 2MB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Info notice --}}
    <div class="d-flex align-items-start gap-3 mt-4 p-3"
         style="background:rgba(232,52,10,0.06);border:1px solid rgba(232,52,10,0.2);border-radius:0.6rem;">
        <i class="bi bi-info-circle" style="color:var(--accent);font-size:1.1rem;margin-top:2px;flex-shrink:0;"></i>
        <div>
            <div class="fw-semibold" style="color:var(--text);font-size:0.9rem;">Scheduling comes next</div>
            <div style="color:var(--muted);font-size:0.82rem;margin-top:2px;">
                After saving the movie details you will be taken to Step 2 where you can add showtimes.
                Duration must be set first so end times can be calculated correctly.
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 mt-4 pb-2">
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-arrow-right me-2"></i>Save & Continue to Scheduling
        </button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>

</form>
@endsection

@push('scripts')
<script>
function previewPoster(input) {
    const preview     = document.getElementById('poster-preview');
    const placeholder = document.getElementById('poster-placeholder');
    const label       = document.getElementById('file-label');
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

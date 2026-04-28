@extends('admin.layouts.app')

@section('title', isset($movie) ? 'Edit Movie' : 'Create Movie')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.movies.index') }}">Movies</a></li>
        <li class="breadcrumb-item active">{{ isset($movie) ? 'Edit' : 'Create' }}</li>
    </ol>
</nav>
@endsection

@section('content')

<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1>{{ isset($movie) ? 'Edit Movie' : 'Add Movie' }}</h1>
        <p>{{ isset($movie) ? 'Update the movie details below.' : 'Fill in the details below to add a new movie.' }}</p>
    </div>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Movies
    </a>
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

<form action="{{ isset($movie) ? route('admin.movies.update', $movie) : route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($movie))
        @method('PUT')
    @endif

    <div class="row g-4">

        {{-- LEFT COLUMN: Main fields --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-film me-2" style="color:var(--accent);"></i>Movie Details</h5>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:1.25rem;">

                    {{-- Title --}}
                    <div>
                        <label for="title" class="form-label">Title <span style="color:var(--accent);">*</span></label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title"
                               value="{{ old('title', $movie->title ?? '') }}"
                               placeholder="e.g. The Dark Knight"
                               required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="form-label">Description <span style="color:var(--accent);">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description"
                                  rows="5"
                                  placeholder="Enter a brief synopsis of the movie..."
                                  required>{{ old('description', $movie->description ?? '') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Genre / Duration / Release Date --}}
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="genre_id" class="form-label">Genre <span style="color:var(--accent);">*</span></label>
                            <select class="form-select @error('genre_id') is-invalid @enderror"
                                    id="genre_id" name="genre_id" required>
                                <option value="">Select Genre</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}"
                                        {{ (old('genre_id', $movie->genre_id ?? '') == $genre->id) ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="duration" class="form-label">Duration (mins) <span style="color:var(--accent);">*</span></label>
                            <input type="number"
                                   class="form-control @error('duration') is-invalid @enderror"
                                   id="duration" name="duration"
                                   value="{{ old('duration', $movie->duration ?? '') }}"
                                   placeholder="e.g. 152"
                                   min="1" required>
                            @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label for="release_date" class="form-label">Release Date <span style="color:var(--accent);">*</span></label>
                            <input type="date"
                                   class="form-control @error('release_date') is-invalid @enderror"
                                   id="release_date" name="release_date"
                                   value="{{ old('release_date', isset($movie) && $movie->release_date ? $movie->release_date->format('Y-m-d') : '') }}"
                                   required>
                            @error('release_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Trailer URL --}}
                    <div>
                        <label for="trailer_url" class="form-label">Trailer URL <span style="color:var(--muted);font-weight:400;font-size:0.8rem;">(YouTube link, optional)</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:0.85rem;top:50%;transform:translateY(-50%);color:var(--muted);"><i class="bi bi-youtube"></i></span>
                            <input type="url"
                                   class="form-control @error('trailer_url') is-invalid @enderror"
                                   id="trailer_url" name="trailer_url"
                                   value="{{ old('trailer_url', $movie->trailer_url ?? '') }}"
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   style="padding-left:2.2rem;">
                        </div>
                        @error('trailer_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Poster --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-image me-2" style="color:var(--accent);"></i>Movie Poster</h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center gap-3">

                    {{-- Poster preview --}}
                    <div id="poster-preview-wrap" style="width:100%;aspect-ratio:2/3;background:var(--surface2);border:2px dashed var(--border);border-radius:0.6rem;display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative;">
                        @if(isset($movie) && $movie->poster_url)
                            <img id="poster-preview" src="{{ $movie->poster_url }}" alt="Poster"
                                 style="width:100%;height:100%;object-fit:cover;border-radius:0.5rem;">
                        @else
                            <div id="poster-placeholder" style="text-align:center;color:var(--muted);">
                                <i class="bi bi-image" style="font-size:3rem;display:block;margin-bottom:0.5rem;"></i>
                                <span style="font-size:0.85rem;">No poster selected</span>
                            </div>
                            <img id="poster-preview" src="" alt="Poster"
                                 style="width:100%;height:100%;object-fit:cover;border-radius:0.5rem;display:none;">
                        @endif
                    </div>

                    {{-- Custom file upload button --}}
                    <div style="width:100%;">
                        <label for="poster" style="display:block;width:100%;cursor:pointer;">
                            <div style="background:var(--surface2);border:1px solid var(--border);border-radius:0.45rem;padding:0.65rem 1rem;display:flex;align-items:center;gap:0.6rem;transition:border-color 0.2s;" onmouseover="this.style.borderColor='rgba(232,52,10,0.5)'" onmouseout="this.style.borderColor='var(--border)'">
                                <i class="bi bi-upload" style="color:var(--accent);font-size:1rem;"></i>
                                <span id="file-label" style="color:var(--muted);font-size:0.88rem;">
                                    {{ isset($movie) && $movie->poster ? 'Change poster image' : 'Choose poster image' }}
                                </span>
                            </div>
                            <input type="file" id="poster" name="poster" accept="image/*"
                                   class="@error('poster') is-invalid @enderror"
                                   style="display:none;"
                                   onchange="previewPoster(this)">
                        </label>
                        @error('poster')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <p style="font-size:0.75rem;color:var(--muted);margin-top:0.4rem;text-align:center;">JPG, PNG, WEBP · Max 2MB</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- SHOWTIMES --}}
    <div class="card mt-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0"><i class="bi bi-calendar-event me-2" style="color:var(--accent);"></i>Showtimes</h5>
            <button type="button" class="btn btn-sm btn-primary" id="add-showtime">
                <i class="bi bi-plus-lg me-1"></i>Add Showtime
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="showtimes-table">
                    <thead>
                        <tr>
                            <th style="width:28%;">Cinema</th>
                            <th style="width:20%;">Hall</th>
                            <th style="width:28%;">Start Time</th>
                            <th style="width:14%;">Price (₱)</th>
                            <th style="width:10%;text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="showtimes-body">
                        @if(isset($movie) && $movie->showtimes->count() > 0)
                            @foreach($movie->showtimes as $index => $st)
                                <tr class="showtime-row">
                                    <input type="hidden" name="showtimes[{{ $index }}][id]" value="{{ $st->id }}">
                                    <td>
                                        <select name="showtimes[{{ $index }}][cinema_id]"
                                                class="form-select form-select-sm row-cinema-select" required>
                                            <option value="">Select Cinema</option>
                                            @foreach($cinemas as $cinema)
                                                <option value="{{ $cinema->id }}" @selected($st->hall->cinema_id == $cinema->id)>
                                                    {{ $cinema->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="showtimes[{{ $index }}][hall_id]"
                                                class="form-select form-select-sm row-hall-select" required>
                                            <option value="{{ $st->hall_id }}">{{ $st->hall->name }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="datetime-local"
                                               name="showtimes[{{ $index }}][start_time]"
                                               class="form-control form-control-sm"
                                               value="{{ $st->start_time->format('Y-m-d\TH:i') }}" required>
                                    </td>
                                    <td>
                                        <input type="number"
                                               name="showtimes[{{ $index }}][price]"
                                               class="form-control form-control-sm"
                                               value="{{ $st->price }}"
                                               step="0.01" min="0" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="Remove">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div id="no-showtimes-msg" class="text-center py-4" style="color:var(--muted);font-size:0.9rem;display:{{ (isset($movie) && $movie->showtimes->count() > 0) ? 'none' : 'block' }};">
                    <i class="bi bi-calendar-x me-2"></i>No showtimes added yet. Click "+ Add Showtime" to begin.
                </div>
            </div>
        </div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="d-flex align-items-center gap-3 mt-4 pb-2">
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-{{ isset($movie) ? 'check-lg' : 'plus-lg' }} me-2"></i>
            {{ isset($movie) ? 'Update Movie' : 'Save Movie' }}
        </button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">
            Cancel
        </a>
    </div>

</form>
@endsection

@push('scripts')
<script>
    // Poster preview
    function previewPoster(input) {
        const preview = document.getElementById('poster-preview');
        const placeholder = document.getElementById('poster-placeholder');
        const label = document.getElementById('file-label');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            label.textContent = file.name;

            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const showtimesBody = document.getElementById('showtimes-body');
        const addBtn        = document.getElementById('add-showtime');
        const noMsg         = document.getElementById('no-showtimes-msg');
        let rowCount = {{ isset($movie) ? $movie->showtimes->count() : 0 }};

        const cinemasData       = @json($cinemas);
        const hallsUrlTemplate  = "{{ route('admin.api.cinemas.halls', ['cinema' => ':id']) }}";

        function toggleNoMsg() {
            noMsg.style.display = showtimesBody.children.length === 0 ? 'block' : 'none';
        }

        // Wire up existing rows
        document.querySelectorAll('.showtime-row').forEach(row => {
            wireRow(row);
        });

        addBtn.addEventListener('click', function () {
            const index = rowCount++;
            const tr = document.createElement('tr');
            tr.className = 'showtime-row';

            let cinemaOptions = '<option value="">Select Cinema</option>';
            cinemasData.forEach(c => {
                cinemaOptions += `<option value="${c.id}">${c.name}</option>`;
            });

            tr.innerHTML = `
                <input type="hidden" name="showtimes[${index}][id]" value="">
                <td>
                    <select name="showtimes[${index}][cinema_id]" class="form-select form-select-sm row-cinema-select" required>
                        ${cinemaOptions}
                    </select>
                </td>
                <td>
                    <select name="showtimes[${index}][hall_id]" class="form-select form-select-sm row-hall-select" required>
                        <option value="">Select Cinema First</option>
                    </select>
                </td>
                <td>
                    <input type="datetime-local" name="showtimes[${index}][start_time]" class="form-control form-control-sm" required>
                </td>
                <td>
                    <input type="number" name="showtimes[${index}][price]" class="form-control form-control-sm" step="0.01" min="0" placeholder="0.00" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="Remove">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;

            showtimesBody.appendChild(tr);
            wireRow(tr);
            toggleNoMsg();
        });

        function wireRow(row) {
            const cinemaSelect = row.querySelector('.row-cinema-select');
            const hallSelect   = row.querySelector('.row-hall-select');

            cinemaSelect.addEventListener('change', function () {
                fetchHalls(this.value, hallSelect);
            });

            row.querySelector('.remove-row').addEventListener('click', function () {
                row.remove();
                toggleNoMsg();
            });
        }

        function fetchHalls(cinemaId, selectElement) {
            if (!cinemaId) {
                selectElement.innerHTML = '<option value="">Select Cinema First</option>';
                return;
            }
            const url = hallsUrlTemplate.replace(':id', cinemaId);
            selectElement.innerHTML = '<option value="">Loading halls…</option>';
            fetch(url)
                .then(r => r.json())
                .then(halls => {
                    selectElement.innerHTML = '<option value="">Select Hall</option>';
                    halls.forEach(h => {
                        selectElement.innerHTML += `<option value="${h.id}">${h.name}</option>`;
                    });
                })
                .catch(() => {
                    selectElement.innerHTML = '<option value="">Error loading halls</option>';
                });
        }
    });
</script>
@endpush

@extends('admin.layouts.app')
@section('title', 'Schedule — ' . $movie->title)

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.movies.index') }}">Movies</a></li>
        <li class="breadcrumb-item active">Scheduling</li>
    </ol>
</nav>
@endsection

@section('content')

<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1>Scheduling</h1>
        <p>Step 2 of 2 — Add showtimes for <strong style="color:var(--text);">{{ $movie->title }}</strong></p>
    </div>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Movies
    </a>
</div>

{{-- Step indicator --}}
<div class="d-flex mb-4" style="gap:0;">
    <div class="d-flex align-items-center gap-2 px-4 py-2"
         style="background:rgba(25,135,84,0.1);border:1px solid rgba(25,135,84,0.35);border-radius:0.5rem 0 0 0.5rem;">
        <span class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
              style="width:22px;height:22px;font-size:0.7rem;background:#198754;">
            <i class="bi bi-check" style="font-size:0.7rem;"></i>
        </span>
        <span class="fw-semibold" style="color:#198754;font-size:0.9rem;">Movie Details</span>
    </div>
    <div class="d-flex align-items-center gap-2 px-4 py-2"
         style="background:rgba(232,52,10,0.12);border:1px solid rgba(232,52,10,0.35);border-left:none;border-radius:0 0.5rem 0.5rem 0;">
        <span class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
              style="width:22px;height:22px;font-size:0.7rem;background:var(--accent);">2</span>
        <span class="fw-semibold" style="color:var(--text);font-size:0.9rem;">Scheduling</span>
    </div>
</div>

{{-- Movie info bar --}}
<div class="card mb-4">
    <div class="card-body d-flex align-items-center gap-3 py-3">
        @if($movie->poster_url)
        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}"
             style="width:44px;height:60px;object-fit:cover;border-radius:0.4rem;border:1px solid var(--border);flex-shrink:0;">
        @endif
        <div class="flex-grow-1">
            <div class="fw-semibold" style="color:var(--text);">{{ $movie->title }}</div>
            <div class="d-flex flex-wrap gap-3 mt-1" style="font-size:0.8rem;color:var(--muted);">
                <span><i class="bi bi-tag-fill me-1"></i>{{ $movie->genre->name ?? 'N/A' }}</span>
                <span><i class="bi bi-clock me-1"></i>{{ $movie->duration }} mins</span>
                <span><i class="bi bi-calendar me-1"></i>{{ optional($movie->release_date)->format('M j, Y') }}</span>
            </div>
        </div>
        <a href="{{ route('admin.movies.edit', $movie) }}"
           class="btn btn-sm btn-outline-secondary ms-auto">
            <i class="bi bi-pencil me-1"></i>Edit Details
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success mb-4">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
</div>
@endif

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

<form action="{{ route('admin.movies.showtimes.store', $movie) }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">
                <i class="bi bi-calendar-event me-2" style="color:var(--accent);"></i>
                Showtimes
                <span class="ms-2" style="font-weight:400;font-size:0.8rem;color:var(--muted);">
                    Duration: <strong style="color:var(--text);">{{ $movie->duration }} mins</strong> per screening
                </span>
            </h5>
            <button type="button" class="btn btn-sm btn-primary" id="add-showtime">
                <i class="bi bi-plus-lg me-1"></i>Add Showtime
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="showtimes-table">
                    <thead>
                        <tr>
                            <th style="width:24%;">Cinema</th>
                            <th style="width:18%;">Hall</th>
                            <th style="width:20%;">Start Time</th>
                            <th style="width:8%;">End Time</th>
                            <th style="width:10%;">Price (₱)</th>
                            <th style="width:12%;">Hall Schedule</th>
                            <th style="width:8%;text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="showtimes-body">
                        @foreach($movie->showtimes as $index => $st)
                        <tr class="showtime-row">
                            <td>
                                <input type="hidden" name="showtimes[{{ $index }}][id]" value="{{ $st->id }}">
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
                                       class="form-control form-control-sm showtime-dt"
                                       value="{{ $st->start_time->format('Y-m-d\TH:i') }}" required>
                                @error('showtimes.' . $index . '.start_time')
                                <div class="text-danger" style="font-size:0.75rem;margin-top:2px;">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                                @enderror
                            </td>
                            <td>
                                <span class="end-time-label" style="font-size:0.8rem;color:var(--muted);">
                                    {{ $st->end_time->format('H:i') }}
                                </span>
                            </td>
                            <td>
                                <input type="number"
                                       name="showtimes[{{ $index }}][price]"
                                       class="form-control form-control-sm"
                                       value="{{ $st->price }}"
                                       step="0.01" min="0" required>
                            </td>
                            <td>
                                <div class="avail-panel" style="font-size:0.72rem;color:var(--muted);min-height:28px;">
                                    <span class="avail-text">—</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div id="no-showtimes-msg"
                     class="text-center py-4"
                     style="color:var(--muted);font-size:0.9rem;{{ $movie->showtimes->count() > 0 ? 'display:none;' : '' }}">
                    <i class="bi bi-calendar-x me-2"></i>No showtimes yet. Click "+ Add Showtime" to begin.
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 mt-4 pb-2">
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check-lg me-2"></i>Save Showtimes
        </button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">Skip for now</a>
    </div>

</form>
@endsection

@push('scripts')
<script>
const DURATION      = {{ $movie->duration }};
const CINEMAS       = @json($cinemas);
const ALL_SHOWTIMES = @json($allShowtimes);
const HALLS_URL     = "{{ route('admin.api.cinemas.halls', ['cinema' => ':id']) }}";

const showtimesBody = document.getElementById('showtimes-body');
const addBtn        = document.getElementById('add-showtime');
const noMsg         = document.getElementById('no-showtimes-msg');
let rowCount        = {{ $movie->showtimes->count() }};

function toggleNoMsg() {
    noMsg.style.display = showtimesBody.children.length === 0 ? 'block' : 'none';
}

// Wire existing rows on page load
document.querySelectorAll('.showtime-row').forEach(row => {
    wireRow(row);
    refreshAvailability(row);
});

// Add new row
addBtn.addEventListener('click', () => {
    const index = rowCount++;
    const tr = document.createElement('tr');
    tr.className = 'showtime-row';

    let cinemaOpts = '<option value="">Select Cinema</option>';
    CINEMAS.forEach(c => cinemaOpts += `<option value="${c.id}">${c.name}</option>`);

    tr.innerHTML = `
        <td>
            <input type="hidden" name="showtimes[${index}][id]" value="">
            <select name="showtimes[${index}][cinema_id]" class="form-select form-select-sm row-cinema-select" required>
                ${cinemaOpts}
            </select>
        </td>
        <td>
            <select name="showtimes[${index}][hall_id]" class="form-select form-select-sm row-hall-select" required>
                <option value="">Select Cinema First</option>
            </select>
        </td>
        <td>
            <input type="datetime-local" name="showtimes[${index}][start_time]"
                   class="form-control form-control-sm showtime-dt" required>
        </td>
        <td>
            <span class="end-time-label" style="font-size:0.8rem;color:var(--muted);">—</span>
        </td>
        <td>
            <input type="number" name="showtimes[${index}][price]"
                   class="form-control form-control-sm"
                   step="0.01" min="0" placeholder="0.00" required>
        </td>
        <td>
            <div class="avail-panel" style="font-size:0.72rem;color:var(--muted);min-height:28px;">
                <span class="avail-text">Select a hall and time</span>
            </div>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="Remove">
                <i class="bi bi-trash"></i>
            </button>
        </td>`;

    showtimesBody.appendChild(tr);
    wireRow(tr);
    toggleNoMsg();
});

function wireRow(row) {
    const cinemaSelect = row.querySelector('.row-cinema-select');
    const hallSelect   = row.querySelector('.row-hall-select');
    const dtInput      = row.querySelector('.showtime-dt');

    cinemaSelect.addEventListener('change', function () {
        fetchHalls(this.value, hallSelect, () => refreshAvailability(row));
    });

    hallSelect.addEventListener('change', () => refreshAvailability(row));

    dtInput.addEventListener('change', () => {
        updateEndTime(row);
        refreshAvailability(row);
    });

    row.querySelector('.remove-row').addEventListener('click', () => {
        row.remove();
        toggleNoMsg();
    });

    // Reload halls for existing rows (edit mode)
    if (cinemaSelect.value && hallSelect.options.length <= 1) {
        fetchHalls(cinemaSelect.value, hallSelect, () => refreshAvailability(row));
    }
}

function fetchHalls(cinemaId, selectEl, cb) {
    if (!cinemaId) {
        selectEl.innerHTML = '<option value="">Select Cinema First</option>';
        return;
    }
    const saved = selectEl.value;
    selectEl.innerHTML = '<option value="">Loading halls…</option>';
    fetch(HALLS_URL.replace(':id', cinemaId))
        .then(r => r.json())
        .then(halls => {
            selectEl.innerHTML = '<option value="">Select Hall</option>';
            halls.forEach(h => selectEl.innerHTML += `<option value="${h.id}">${h.name}</option>`);
            if (saved) selectEl.value = saved;
            if (cb) cb();
        })
        .catch(() => selectEl.innerHTML = '<option value="">Error loading halls</option>');
}

function updateEndTime(row) {
    const dt  = row.querySelector('.showtime-dt');
    const lbl = row.querySelector('.end-time-label');
    if (!dt || !dt.value || !lbl) return;
    const end = new Date(new Date(dt.value).getTime() + DURATION * 60000);
    lbl.textContent = end.toTimeString().slice(0, 5);
}

function refreshAvailability(row) {
    const hallId = parseInt(row.querySelector('.row-hall-select')?.value);
    const dtVal  = row.querySelector('.showtime-dt')?.value;
    const panel  = row.querySelector('.avail-panel');
    if (!panel) return;

    if (!hallId || !dtVal) {
        panel.innerHTML = '<span style="color:var(--muted);">Select a hall and time</span>';
        return;
    }

    const datePart = dtVal.split('T')[0];
    const slots    = ALL_SHOWTIMES.filter(s => s.hall_id === hallId && s.start_time.startsWith(datePart));
    panel.innerHTML = renderAvailability(slots, dtVal);
}

function renderAvailability(slots, currentDt) {
    if (!slots.length) {
        return '<span style="color:#198754;font-weight:600;"><i class="bi bi-check-circle-fill"></i> Free all day</span>';
    }
    const newStart = Math.floor(new Date(currentDt).getTime() / 1000);
    const newEnd   = newStart + DURATION * 60;
    let html = '<div style="font-weight:600;color:var(--muted);margin-bottom:2px;">Booked:</div>';
    slots.forEach(s => {
        const overlaps = newStart < s.end_ts && newEnd > s.start_ts;
        const color    = overlaps ? '#dc3545' : 'var(--muted)';
        const icon     = overlaps ? '⚠ ' : '· ';
        html += `<div style="color:${color};line-height:1.5;">${icon}${s.start_time.slice(11,16)}–${s.end_time.slice(11,16)} <span style="opacity:.6;">${s.movie}</span></div>`;
    });
    return html;
}
</script>
@endpush

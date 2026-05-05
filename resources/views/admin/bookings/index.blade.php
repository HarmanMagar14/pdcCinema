@extends('admin.layouts.app')

@section('title', 'Bookings Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Bookings</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="mb-1">Bookings</h1>
        <p class="text-muted mb-0">Manage all ticket bookings across every cinema.</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <span class="badge bg-secondary fs-6">{{ $bookings->total() }} total</span>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- FILTERS --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <label class="form-label small fw-semibold mb-1">Search</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--surface2,#1c1c21);border-color:rgba(255,255,255,.1);color:rgba(240,239,244,.4);">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Customer name or movie title…"
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="confirmed"  {{ request('status') === 'confirmed'  ? 'selected' : '' }}>Confirmed</option>
                    <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
                    <option value="canceled"   {{ request('status') === 'canceled'   ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary" title="Clear">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- STATUS SUMMARY CHIPS --}}
@php
    $statusCounts = [
        'confirmed' => \App\Models\Bookings::where('status','confirmed')->count(),
        'pending'   => \App\Models\Bookings::where('status','pending')->count(),
        'canceled'  => \App\Models\Bookings::where('status','canceled')->count(),
    ];
@endphp
<div class="d-flex gap-3 mb-4 flex-wrap">
    <a href="{{ route('admin.bookings.index', array_merge(request()->except('status','page'))) }}"
       class="text-decoration-none">
        <span class="badge rounded-pill px-3 py-2 fs-6 {{ !request('status') ? 'bg-primary' : 'bg-secondary' }}">
            All &nbsp;<strong>{{ array_sum($statusCounts) }}</strong>
        </span>
    </a>
    <a href="{{ route('admin.bookings.index', array_merge(request()->except('status','page'), ['status'=>'confirmed'])) }}"
       class="text-decoration-none">
        <span class="badge rounded-pill px-3 py-2 fs-6 {{ request('status')==='confirmed' ? 'bg-success' : 'bg-secondary' }}">
            Confirmed &nbsp;<strong>{{ $statusCounts['confirmed'] }}</strong>
        </span>
    </a>
    <a href="{{ route('admin.bookings.index', array_merge(request()->except('status','page'), ['status'=>'pending'])) }}"
       class="text-decoration-none">
        <span class="badge rounded-pill px-3 py-2 fs-6 {{ request('status')==='pending' ? 'bg-warning text-dark' : 'bg-secondary' }}">
            Pending &nbsp;<strong>{{ $statusCounts['pending'] }}</strong>
        </span>
    </a>
    <a href="{{ route('admin.bookings.index', array_merge(request()->except('status','page'), ['status'=>'canceled'])) }}"
       class="text-decoration-none">
        <span class="badge rounded-pill px-3 py-2 fs-6 {{ request('status')==='canceled' ? 'bg-danger' : 'bg-secondary' }}">
            Canceled &nbsp;<strong>{{ $statusCounts['canceled'] }}</strong>
        </span>
    </a>
</div>

{{-- BOOKINGS TABLE --}}
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#ID</th>
                    <th>Customer</th>
                    <th>Movie</th>
                    <th>Cinema / Hall</th>
                    <th>Showtime</th>
                    <th>Seats</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-center pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td class="ps-4">
                            <strong class="text-muted">#{{ $booking->id }}</strong>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                     style="width:32px;height:32px;background:var(--bs-primary);font-size:.8rem;flex-shrink:0;">
                                    {{ strtoupper(substr($booking->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:.9rem;">{{ $booking->user->name ?? 'Unknown' }}</div>
                                    <div class="text-muted" style="font-size:.78rem;">{{ $booking->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold" style="font-size:.9rem;">
                                {{ $booking->showtime->movie->title ?? '—' }}
                            </div>
                        </td>
                        <td style="font-size:.88rem;">
                            {{ $booking->showtime->hall->cinema->name ?? '—' }}<br>
                            <span class="text-muted" style="font-size:.78rem;">{{ $booking->showtime->hall->name ?? '' }}</span>
                        </td>
                        <td style="font-size:.85rem;">
                            @if($booking->showtime)
                                {{ optional($booking->showtime->start_time)->format('M d, Y') }}<br>
                                <span class="text-muted">{{ optional($booking->showtime->start_time)->format('g:i A') }}</span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $booking->bookings_seats->count() }}</span>
                        </td>
                        <td class="fw-semibold" style="font-size:.9rem;">
                            @if($booking->showtime && $booking->bookings_seats->count())
                                ₱{{ number_format($booking->bookings_seats->count() * $booking->showtime->price, 0) }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @php
                                $statusMap = [
                                    'confirmed' => 'success',
                                    'pending'   => 'warning',
                                    'canceled'  => 'danger',
                                ];
                                $color = $statusMap[$booking->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ ucfirst($booking->status) }}</span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if($booking->status !== 'confirmed')
                                        <li>
                                            <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="bi bi-check-circle me-2"></i>Confirm
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                    @if($booking->status !== 'pending')
                                        <li>
                                            <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="dropdown-item text-warning">
                                                    <i class="bi bi-hourglass me-2"></i>Set Pending
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                    @if($booking->status !== 'canceled')
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}"
                                                  onsubmit="return confirm('Cancel booking #{{ $booking->id }}?')">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="canceled">
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-ticket-perforated fs-1 d-block mb-3 opacity-25"></i>
                            No bookings found.
                            @if(request('search') || request('status'))
                                <a href="{{ route('admin.bookings.index') }}">Clear filters</a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center py-3">
            <small class="text-muted">
                Showing {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings
            </small>
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection

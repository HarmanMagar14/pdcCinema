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
<div class="page-header">
    <h1>Bookings</h1>
    <p>View and manage all ticket bookings.</p>
</div>

<!-- FILTERS & SEARCH -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="#" method="GET" class="row g-3">
            <div class="col-md-6 col-lg-8">
                <input type="text" class="form-control" placeholder="Search bookings...">
            </div>
            <div class="col-md-4 col-lg-3">
                <select class="form-select">
                    <option value="">All Status</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-2 col-lg-1">
                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-funnel"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- BOOKINGS TABLE -->
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Booking ID</th>
                    <th>Customer</th>
                    <th>Movie</th>
                    <th>Date</th>
                    <th>Tickets</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>#BK001245</strong></td>
                    <td>John Doe</td>
                    <td>The Dark Knight</td>
                    <td>Apr 22, 2026 8:00 PM</td>
                    <td>2</td>
                    <td>₱722</td>
                    <td><span class="badge bg-success">Confirmed</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary" title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td><strong>#BK001244</strong></td>
                    <td>Jane Smith</td>
                    <td>Inception</td>
                    <td>Apr 23, 2026 6:30 PM</td>
                    <td>3</td>
                    <td>₱1,083</td>
                    <td><span class="badge bg-warning">Pending</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary" title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td><strong>#BK001243</strong></td>
                    <td>Mike Johnson</td>
                    <td>Titanic</td>
                    <td>Apr 20, 2026 9:30 PM</td>
                    <td>2</td>
                    <td>₱760</td>
                    <td><span class="badge bg-danger">Cancelled</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary" title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

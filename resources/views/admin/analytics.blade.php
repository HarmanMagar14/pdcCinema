@extends('admin.layouts.app')

@section('title', 'Analytics Dashboard')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Analytics</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="page-header">
    <h1>Analytics</h1>
    <p>Comprehensive insights into your cinema platform performance.</p>
</div>

<!-- DATE RANGE SELECTOR -->
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center gap-3">
            <span style="font-size:0.8rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);">Date Range</span>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary btn-sm active" onclick="updateDateRange('7')">Last 7 Days</button>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="updateDateRange('30')">Last 30 Days</button>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="updateDateRange('90')">Last 90 Days</button>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="updateDateRange('365')">Last Year</button>
            </div>
        </div>
    </div>
</div>

<!-- KPI CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card accent-red">
            <div class="stat-icon red"><i class="bi bi-ticket-perforated"></i></div>
            <div class="stat-label">Total Bookings</div>
            <div class="stat-value">{{ number_format($totalBookings) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent-green">
            <div class="stat-icon green"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₱{{ number_format($totalRevenue / 1000, 1) }}K</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent-blue">
            <div class="stat-icon blue"><i class="bi bi-tag"></i></div>
            <div class="stat-label">Avg Ticket Price</div>
            <div class="stat-value">₱{{ number_format($avgTicketPrice, 0) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card accent-gold">
            <div class="stat-icon gold"><i class="bi bi-percent"></i></div>
            <div class="stat-label">Occupancy</div>
            <div class="stat-value">{{ $occupancyRate }}%</div>
        </div>
    </div>
</div>

<!-- CHARTS ROW 1 -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 style="margin: 0;">Bookings Trend</h5>
            </div>
            <div class="card-body">
                <canvas id="bookingsTrendChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">Revenue Trend</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueTrendChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS ROW 2 -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">Genre Popularity</h5>
            </div>
            <div class="card-body">
                <canvas id="genreChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">Payment Methods</h5>
            </div>
            <div class="card-body">
                <canvas id="paymentMethodChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- DETAILED ANALYTICS -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cinema Performance</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Cinema</th>
                                <th>Bookings</th>
                                <th>Revenue</th>
                                <th>Occupancy</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cinemaPerformance as $performance)
                            <tr>
                                <td><strong>{{ $performance['name'] }}</strong></td>
                                <td>{{ number_format($performance['bookings']) }}</td>
                                <td>₱{{ number_format($performance['revenue'], 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height: 6px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $performance['occupancy'] }}%"></div>
                                        </div>
                                        <span class="small">{{ $performance['occupancy'] }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Top Movies</h5>
            </div>
            <div class="card-body p-0">
                @foreach($topMovies as $movie)
                <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-weight:600;font-size:0.88rem;">{{ $movie->title }}</div>
                        <small style="color:var(--muted);">{{ $movie->genre->name ?? 'N/A' }}</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">{{ $movie->bookings_count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- USER ANALYTICS -->
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Growth</h5>
            </div>
            <div class="card-body text-center">
                <canvas id="userGrowthChart" height="150"></canvas>
                <p class="mt-2 mb-0" style="color:var(--muted);font-size:0.8rem;">Last 30 days</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Status</h5>
            </div>
            <div class="card-body">
                <canvas id="userStatusChart" height="150"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Repeat Customers</h5>
            </div>
            <div class="card-body text-center py-4">
                <div style="font-family:'Bebas Neue',sans-serif;font-size:3rem;color:var(--accent2);letter-spacing:2px;">68%</div>
                <p style="color:var(--muted);font-size:0.85rem;" class="mb-4">Of users made multiple bookings</p>
                <div class="text-start">
                    <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem;">
                        <span style="color:var(--muted);">1-2 bookings:</span><span style="font-weight:600;">25%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem;">
                        <span style="color:var(--muted);">3-5 bookings:</span><span style="font-weight:600;">28%</span>
                    </div>
                    <div class="d-flex justify-content-between" style="font-size:0.85rem;">
                        <span style="color:var(--muted);">5+ bookings:</span><span style="font-weight:600;">15%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let bookingsTrendChart, revenueTrendChart, genreChart, paymentMethodChart, userGrowthChart, userStatusChart;

    function updateDateRange(days) {
        // Since we are using static variables passed from the controller (last 7 days),
        // we'll highlight that this is the current data.
        // In a full implementation, this would trigger an AJAX call to the controller.
        alert('Date range switching is currently limited to the last 7 days provided by the backend.');
    }

    function initCharts() {
        // Data from Controller
        const labels = @json($days);
        const bookingsData = @json($bookingsTrend);
        const revenueData = @json($revenueTrend);
        const userGrowthData = @json($userGrowth);
        
        const genreLabels = @json($genrePopularity->pluck('name'));
        const genreData = @json($genrePopularity->pluck('bookings_count'));

        const paymentLabels = @json($paymentMethods->pluck('method'));
        const paymentData = @json($paymentMethods->pluck('count'));

        // Bookings Trend
        if (bookingsTrendChart) bookingsTrendChart.destroy();
        bookingsTrendChart = new Chart(document.getElementById('bookingsTrendChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Bookings',
                    data: bookingsData,
                    backgroundColor: 'rgba(232,52,10,0.7)',
                    borderColor: '#e8340a',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(240,239,244,0.06)' }, ticks: { color: 'rgba(240,239,244,0.4)' } },
                    x: { grid: { display: false }, ticks: { color: 'rgba(240,239,244,0.4)' } }
                }
            }
        });

        // Revenue Trend
        if (revenueTrendChart) revenueTrendChart.destroy();
        revenueTrendChart = new Chart(document.getElementById('revenueTrendChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,0.08)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#22c55e',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(240,239,244,0.06)' }, ticks: { color: 'rgba(240,239,244,0.4)' } },
                    x: { grid: { display: false }, ticks: { color: 'rgba(240,239,244,0.4)' } }
                }
            }
        });

        // Genre Chart
        if (genreChart) genreChart.destroy();
        genreChart = new Chart(document.getElementById('genreChart'), {
            type: 'bar',
            data: {
                labels: genreLabels,
                datasets: [{
                    label: 'Bookings by Genre',
                    data: genreData,
                    backgroundColor: ['rgba(232,52,10,0.7)','rgba(255,107,53,0.7)','rgba(245,197,24,0.7)','rgba(34,197,94,0.7)','rgba(59,130,246,0.7)','rgba(168,85,247,0.7)','rgba(236,72,153,0.7)','rgba(20,184,166,0.7)','rgba(249,115,22,0.7)','rgba(14,165,233,0.7)'],
                    borderRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: 'rgba(240,239,244,0.06)' }, ticks: { color: 'rgba(240,239,244,0.4)' } },
                    y: { grid: { display: false }, ticks: { color: 'rgba(240,239,244,0.4)' } }
                }
            }
        });

        // Payment Method Chart
        if (paymentMethodChart) paymentMethodChart.destroy();
        paymentMethodChart = new Chart(document.getElementById('paymentMethodChart'), {
            type: 'doughnut',
            data: {
                labels: paymentLabels,
                datasets: [{
                    data: paymentData,
                    backgroundColor: ['rgba(232,52,10,0.8)','rgba(34,197,94,0.8)','rgba(59,130,246,0.8)','rgba(245,197,24,0.8)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                cutout: '60%',
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom', labels: { color: 'rgba(240,239,244,0.5)', padding: 10 } } }
            }
        });

        // User Growth Chart
        if (userGrowthChart) userGrowthChart.destroy();
        userGrowthChart = new Chart(document.getElementById('userGrowthChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'New Users',
                    data: userGrowthData,
                    backgroundColor: 'rgba(59,130,246,0.08)',
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, color: 'rgba(240,239,244,0.4)' }, grid: { color: 'rgba(240,239,244,0.06)' } },
                    x: { grid: { display: false }, ticks: { color: 'rgba(240,239,244,0.4)' } }
                }
            }
        });

        // User Status Chart
        if (userStatusChart) userStatusChart.destroy();
        userStatusChart = new Chart(document.getElementById('userStatusChart'), {
            type: 'pie',
            data: {
                labels: ['Active', 'Inactive', 'Banned'],
                datasets: [{
                    data: [340, 92, 18],
                    backgroundColor: ['rgba(34,197,94,0.8)','rgba(245,197,24,0.8)','rgba(220,53,69,0.8)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom', labels: { color: 'rgba(240,239,244,0.5)', padding: 10 } } }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initCharts();
    });
</script>
@endsection

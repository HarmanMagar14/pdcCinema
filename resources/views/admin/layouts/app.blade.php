<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — CineMax</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:       #0d0d0f;
            --surface:  #141417;
            --surface2: #1c1c21;
            --surface3: #232329;
            --accent:   #e8340a;
            --accent2:  #ff6b35;
            --gold:     #f5c518;
            --text:     #f0eff4;
            --muted:    rgba(240,239,244,0.5);
            --border:   rgba(240,239,244,0.08);
            --sidebar-w: 240px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── TOPBAR ── */
        .admin-topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 56px;
            background: rgba(13,13,15,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem 0 calc(var(--sidebar-w) + 1.5rem);
            z-index: 200;
        }

        .topbar-brand {
            position: fixed;
            left: 0; top: 0;
            width: var(--sidebar-w);
            height: 56px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0 1.25rem;
            background: rgba(13,13,15,0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            border-right: 1px solid var(--border);
            text-decoration: none;
            z-index: 201;
        }

        .topbar-brand .brand-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            color: var(--accent);
            letter-spacing: 2px;
        }

        .topbar-brand .brand-badge {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            background: rgba(232,52,10,0.15);
            border: 1px solid rgba(232,52,10,0.4);
            color: var(--accent2);
            padding: 0.15rem 0.45rem;
            border-radius: 0.25rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-page-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.15rem;
            letter-spacing: 1.5px;
            color: var(--muted);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .topbar-user .user-name {
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--text);
        }

        .topbar-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--surface2);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 0.85rem;
        }

        .topbar-signout {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 0.3rem 0.8rem;
            border-radius: 0.35rem;
            font-size: 0.8rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
        }

        .topbar-signout:hover {
            border-color: rgba(232,52,10,0.5);
            color: var(--accent2);
        }

        .topbar-view-site {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 0.3rem 0.8rem;
            border-radius: 0.35rem;
            font-size: 0.8rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .topbar-view-site:hover {
            border-color: rgba(240,239,244,0.25);
            color: var(--text);
        }

        /* ── SIDEBAR ── */
        .admin-sidebar {
            position: fixed;
            top: 56px; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 100;
            padding: 1.25rem 0;
        }

        .admin-sidebar::-webkit-scrollbar { width: 4px; }
        .admin-sidebar::-webkit-scrollbar-track { background: transparent; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

        .sidebar-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: rgba(240,239,244,0.25);
            padding: 0.9rem 1.25rem 0.4rem;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.55rem 1.25rem;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            border-left: 3px solid transparent;
            position: relative;
        }

        .sidebar-nav-link i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
        }

        .sidebar-nav-link:hover {
            background: rgba(240,239,244,0.04);
            color: var(--text);
            border-left-color: rgba(232,52,10,0.3);
        }

        .sidebar-nav-link.active {
            background: rgba(232,52,10,0.08);
            color: var(--accent2);
            border-left-color: var(--accent);
        }

        .sidebar-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 0.75rem 0;
        }

        /* ── MAIN CONTENT ── */
        .admin-main {
            margin-left: var(--sidebar-w);
            padding-top: 56px;
            min-height: 100vh;
        }

        .admin-content {
            padding: 2rem 2rem 3rem;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .page-header h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.2rem;
            letter-spacing: 2px;
            color: var(--text);
            margin-bottom: 0.25rem;
        }

        .page-header p {
            color: var(--muted);
            font-size: 0.875rem;
            margin: 0;
        }

        /* ── CARDS ── */
        .card {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            border-radius: 0.75rem !important;
            color: var(--text) !important;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 1rem 1.25rem !important;
            color: var(--text) !important;
        }

        .card-header h5, .card-header h6 {
            color: var(--text) !important;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .card-body {
            color: var(--text) !important;
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            border-radius: 0.75rem;
            padding: 1.25rem;
            transition: transform 0.2s, border-color 0.2s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            border-radius: 0.75rem 0.75rem 0 0;
        }

        .stat-card.accent-red::before   { background: var(--accent); }
        .stat-card.accent-green::before { background: #22c55e; }
        .stat-card.accent-blue::before  { background: #3b82f6; }
        .stat-card.accent-gold::before  { background: var(--gold); }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(240,239,244,0.15) !important;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .stat-icon.red   { background: rgba(232,52,10,0.12);  color: var(--accent2); }
        .stat-icon.green { background: rgba(34,197,94,0.12);   color: #4ade80; }
        .stat-icon.blue  { background: rgba(59,130,246,0.12);  color: #60a5fa; }
        .stat-icon.gold  { background: rgba(245,197,24,0.12);  color: var(--gold); }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.35rem;
        }

        .stat-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 1px;
            color: var(--text);
            line-height: 1;
        }

        /* ── TABLES ── */
        .table {
            color: var(--text) !important;
            --bs-table-bg: transparent;
            --bs-table-hover-bg: rgba(240,239,244,0.04);
            --bs-table-striped-bg: transparent;
        }

        .table thead th {
            color: var(--muted) !important;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border) !important;
            background: transparent !important;
            padding: 0.65rem 0.75rem;
        }

        .table td {
            color: var(--text) !important;
            border-bottom: 1px solid var(--border) !important;
            vertical-align: middle;
            padding: 0.8rem 0.75rem;
        }

        .table-light {
            --bs-table-bg: transparent !important;
        }

        /* ── FORMS ── */
        .form-control, .form-select {
            background: var(--surface2) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            border-radius: 0.4rem !important;
            font-family: 'DM Sans', sans-serif;
        }

        .form-control:focus, .form-select:focus {
            outline: none !important;
            border-color: rgba(232,52,10,0.5) !important;
            box-shadow: 0 0 0 3px rgba(232,52,10,0.1) !important;
            background: var(--surface2) !important;
            color: var(--text) !important;
        }

        .form-control::placeholder { color: var(--muted) !important; }

        .form-label {
            color: var(--muted);
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            margin-bottom: 0.35rem;
        }

        .form-check-input {
            background-color: var(--surface2) !important;
            border-color: rgba(240,239,244,0.2) !important;
        }

        .form-check-input:checked {
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
        }

        .form-text { color: rgba(240,239,244,0.35) !important; }

        /* ── BUTTONS ── */
        .btn-primary, .btn-accent {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: white !important;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            border-radius: 0.4rem !important;
            transition: background 0.2s, transform 0.15s !important;
        }

        .btn-primary:hover, .btn-accent:hover {
            background: #c42908 !important;
            border-color: #c42908 !important;
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            border-color: rgba(232,52,10,0.5) !important;
            color: var(--accent2) !important;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-outline-primary:hover, .btn-outline-primary.active {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: white !important;
        }

        .btn-outline-secondary, .btn-secondary {
            border-color: var(--border) !important;
            color: var(--muted) !important;
            background: transparent !important;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-outline-secondary:hover, .btn-secondary:hover {
            background: var(--surface2) !important;
            color: var(--text) !important;
        }

        .btn-outline-danger {
            border-color: rgba(220,53,69,0.5) !important;
            color: #f87171 !important;
            background: transparent !important;
        }

        .btn-outline-danger:hover {
            background: rgba(220,53,69,0.15) !important;
            color: #fca5a5 !important;
        }

        .btn-sm { font-size: 0.8rem !important; padding: 0.3rem 0.7rem !important; }

        /* ── BADGES ── */
        .badge {
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge.bg-success { background: rgba(34,197,94,0.15) !important; color: #4ade80 !important; border: 1px solid rgba(34,197,94,0.3); }
        .badge.bg-warning { background: rgba(245,197,24,0.15) !important; color: var(--gold) !important; border: 1px solid rgba(245,197,24,0.3); color: var(--gold) !important; }
        .badge.bg-danger  { background: rgba(220,53,69,0.15)  !important; color: #f87171 !important; border: 1px solid rgba(220,53,69,0.3); }
        .badge.bg-primary { background: rgba(232,52,10,0.15)  !important; color: var(--accent2) !important; border: 1px solid rgba(232,52,10,0.3); }
        .badge.bg-info    { background: rgba(14,165,233,0.15) !important; color: #38bdf8 !important; border: 1px solid rgba(14,165,233,0.3); }

        /* ── ALERTS ── */
        .alert-success {
            background: rgba(34,197,94,0.1) !important;
            border: 1px solid rgba(34,197,94,0.3) !important;
            color: #4ade80 !important;
            border-radius: 0.5rem !important;
        }

        .alert-danger {
            background: rgba(220,53,69,0.1) !important;
            border: 1px solid rgba(220,53,69,0.3) !important;
            color: #f87171 !important;
            border-radius: 0.5rem !important;
        }

        .btn-close { filter: invert(1) opacity(0.5); }

        /* ── LIST GROUPS ── */
        .list-group-item {
            background: transparent !important;
            border-color: var(--border) !important;
            color: var(--text) !important;
        }

        /* ── PROGRESS BARS ── */
        .progress {
            background: var(--surface2) !important;
            border-radius: 1rem !important;
        }

        .progress-bar.bg-success { background: #22c55e !important; }

        /* ── BREADCRUMB ── */
        .breadcrumb-item a {
            color: var(--accent2);
            text-decoration: none;
        }

        .breadcrumb-item.active { color: var(--muted); }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--muted); }

        /* ── DANGER ZONE CARD ── */
        .card.border-danger {
            border-color: rgba(220,53,69,0.3) !important;
        }

        .card-header.bg-danger {
            background: rgba(220,53,69,0.15) !important;
            color: #f87171 !important;
        }

        /* ── PAGINATION ── */
        .pagination {
            gap: 0.25rem;
            margin: 0;
        }

        .page-link {
            background: var(--surface2) !important;
            border: 1px solid var(--border) !important;
            color: var(--muted) !important;
            border-radius: 0.35rem !important;
            font-size: 0.82rem;
            padding: 0.35rem 0.65rem;
            transition: background 0.15s, color 0.15s;
        }

        .page-link:hover {
            background: var(--surface3) !important;
            color: var(--text) !important;
            border-color: rgba(232,52,10,0.3) !important;
        }

        .page-item.active .page-link {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: white !important;
        }

        .page-item.disabled .page-link {
            background: var(--surface) !important;
            color: rgba(240,239,244,0.2) !important;
            border-color: var(--border) !important;
        }

        /* Safety: never let an unsized SVG blow up the layout */
        .admin-content svg:not([width]):not([height]):not(.bi) {
            max-width: 24px !important;
            max-height: 24px !important;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(240,239,244,0.15); }

        /* ── FIX: Bootstrap classes that clash with dark theme ── */

        /* text-muted: Bootstrap default is ~#6c757d which is invisible on dark bg */
        .text-muted {
            color: rgba(240,239,244,0.55) !important;
        }

        /* small helper text (used under inputs, etc.) */
        small, .small {
            color: rgba(240,239,244,0.5) !important;
        }

        /* bg-light: Bootstrap default is #f8f9fa (near-white) — breaks dark theme */
        .bg-light {
            background: var(--surface2) !important;
        }

        /* text-dark used inside bg-light contexts */
        .text-dark { color: var(--text) !important; }

        /* h1–h6 inside admin content should always be light */
        .admin-content h1,
        .admin-content h2,
        .admin-content h3,
        .admin-content h4,
        .admin-content h5,
        .admin-content h6 {
            color: var(--text) !important;
        }

        /* paragraph text in admin content */
        .admin-content p {
            color: rgba(240,239,244,0.65) !important;
        }

        /* border-dashed utility used in empty-state cards */
        .border-dashed {
            border: 1px dashed rgba(240,239,244,0.12) !important;
        }

        /* ── MODALS (global dark override) ── */
        .modal-content {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            border-radius: 0.75rem !important;
            color: var(--text) !important;
        }
        .modal-header {
            background: var(--surface2) !important;
            border-bottom: 1px solid var(--border) !important;
            border-radius: 0.75rem 0.75rem 0 0 !important;
        }
        .modal-title { color: var(--text) !important; font-weight: 600; }
        .modal-body  { background: var(--surface) !important; }
        .modal-footer {
            background: var(--surface2) !important;
            border-top: 1px solid var(--border) !important;
            border-radius: 0 0 0.75rem 0.75rem !important;
        }
        .modal .form-select option {
            background: #1c1c21;
            color: #f0eff4;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 767.98px) {
            .admin-sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .admin-topbar { padding-left: 1rem; }
            .topbar-brand { position: static; width: auto; border-right: none; }
        }
    </style>
    @yield('styles')
</head>
<body>

    {{-- TOPBAR --}}
    <div class="admin-topbar">
        <span class="topbar-page-title">@yield('title', 'Dashboard')</span>
        <div class="topbar-right">
            <!--<a href="{{ url('/') }}" class="topbar-view-site">
                <i class="bi bi-box-arrow-up-right"></i> View Site
            </a>-->
            <div class="topbar-user">
                <div class="topbar-avatar"><i class="bi bi-person"></i></div>
                <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="topbar-signout">Sign out</button>
            </form>
        </div>
    </div>

    {{-- BRAND IN TOPBAR (fixed left) --}}
    <a class="topbar-brand" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-play-circle-fill" style="color: var(--accent); font-size: 1.3rem;"></i>
        <span class="brand-logo">CineMax</span>
        <span class="brand-badge">Admin</span>
    </a>

    {{-- SIDEBAR --}}
    <nav class="admin-sidebar" id="adminSidebar">
        <span class="sidebar-section-label">Main</span>
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.movies.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
            <i class="bi bi-film"></i> Movies
        </a>
        <a href="{{ route('admin.cinemas.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.cinemas.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Cinemas
        </a>
        <a href="{{ route('admin.bookings.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="bi bi-ticket-perforated"></i> Bookings
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section-label">Insights</span>
        <a href="{{ route('admin.analytics') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i> Analytics
        </a>

        <hr class="sidebar-divider">
        <span class="sidebar-section-label">System</span>
        <a href="{{ route('admin.settings') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Settings
        </a>
    </nav>

    {{-- MAIN --}}
    <div class="admin-main">
        <div class="admin-content">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>

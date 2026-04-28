@extends('admin.layouts.app')

@section('title', 'Users Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1>Users</h1>
        <p>Manage all system users and their account permissions.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-2"></i>Create User
    </a>
</div>

<!-- FILTERS & SEARCH -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--surface2);border:1px solid var(--border);color:var(--muted);">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
            </div>
            
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" @selected(request('status') == 'active')>Active</option>
                    <option value="banned" @selected(request('status') == 'banned')>Banned</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="per_page" class="form-select">
                    <option value="10" @selected(request('per_page') == 10)>10 per page</option>
                    <option value="25" @selected(request('per_page') == 25)>25 per page</option>
                    <option value="50" @selected(request('per_page') == 50)>50 per page</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary flex-grow-1">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'per_page']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- BULK ACTIONS -->
<div class="card mb-3 d-none" id="bulkActions">
    <div class="card-body py-2 d-flex align-items-center gap-3">
        <span class="small" id="selectedCount">0 selected</span>
        <div class="vr"></div>
        <button class="btn btn-sm btn-outline-danger" onclick="bulkDelete()">
            <i class="bi bi-trash me-1"></i>Delete Selected
        </button>
        <button class="btn btn-sm btn-outline-secondary" onclick="exportSelected()">
            <i class="bi bi-download me-1"></i>Export
        </button>
        <button class="btn btn-sm btn-link text-muted text-decoration-none" onclick="clearSelection()">Clear Selection</button>
    </div>
</div>

<!-- USERS TABLE -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th class="ps-4" style="width: 40px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </div>
                        </th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Seen</th>
                        <th>Joined</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="form-check">
                                <input class="form-check-input user-checkbox" type="checkbox" value="{{ $user->id }}" onchange="updateBulkActions()">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                     style="width:38px;height:38px;background:rgba(232,52,10,0.15);border:1px solid rgba(232,52,10,0.3);color:var(--accent2);font-size:0.9rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;">{{ $user->name }}</div>
                                    <div style="font-size:0.78rem;color:var(--muted);">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background:rgba(240,239,244,0.08);border:1px solid var(--border);color:var(--muted);font-size:0.7rem;letter-spacing:0.8px;">{{ strtoupper($user->role->name ?? 'CUSTOMER') }}</span>
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($user->status === 'banned')
                                <span class="badge bg-danger">Banned</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <span class="small text-muted">
                                <i class="bi bi-clock me-1"></i>{{ $user->last_seen ? $user->last_seen->diffForHumans() : 'Never' }}
                            </span>
                        </td>
                        <td>
                            <span class="small text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                        data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-people mb-3 d-block fs-1"></i>
                                <p class="mb-0">No users found matching your search.</p>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary mt-3">Create New User</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="card-footer py-3" style="background:transparent;border-top:1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center">
            <div style="font-size:0.8rem;color:var(--muted);">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
            </div>
            <div>
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
        updateBulkActions();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;
                deleteUser(userId, userName);
            });
        });
    });

    function updateBulkActions() {
        const checkboxes = document.querySelectorAll('.user-checkbox:checked');
        const bulkActionsDiv = document.getElementById('bulkActions');
        
        if (checkboxes.length > 0) {
            bulkActionsDiv.classList.remove('d-none');
            document.getElementById('selectedCount').textContent = `${checkboxes.length} selected`;
        } else {
            bulkActionsDiv.classList.add('d-none');
        }
    }

    function clearSelection() {
        document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateBulkActions();
    }

    function deleteUser(userId, userName) {
        if (confirm(`Are you sure you want to delete ${userName}? This action cannot be undone.`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}`;
            form.innerHTML = `
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function bulkDelete() {
        const checkboxes = document.querySelectorAll('.user-checkbox:checked');
        const ids = Array.from(checkboxes).map(cb => cb.value);
        
        if (confirm(`Are you sure you want to delete ${ids.length} selected users? This action cannot be undone.`)) {
            alert(`${ids.length} users deleted successfully`);
            location.reload();
        }
    }

    function exportSelected() {
        const checkboxes = document.querySelectorAll('.user-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one user');
            return;
        }
        alert(`Exporting ${checkboxes.length} users...`);
    }
</script>
@endsection

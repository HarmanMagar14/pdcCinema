@extends('admin.layouts.app')

@section('title', 'Cinemas Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Cinemas</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1>Cinemas</h1>
        <p>View and manage all cinema locations.</p>
    </div>
    <a href="{{ route('admin.cinemas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Cinema
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.cinemas.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search cinemas..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Cinema Name</th>
                    <th>Location</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cinemas as $cinema)
                <tr>
                    <td>
                        <h6 class="mb-0">{{ $cinema->name }}</h6>
                    </td>
                    <td>{{ $cinema->location }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.cinemas.edit', $cinema) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.cinemas.destroy', $cinema) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this cinema?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4">No cinemas found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cinemas->hasPages())
    <div class="card-footer" style="background:transparent;border-top:1px solid var(--border);">
        {{ $cinemas->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

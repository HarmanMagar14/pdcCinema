@extends('admin.layouts.app')

@section('title', 'Movies Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        <li class="breadcrumb-item active">Movies</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1>Movies</h1>
        <p>Manage your movie catalog and showtimes.</p>
    </div>
    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Movie
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.movies.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search movies..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Movie</th>
                    <th>Genre</th>
                    <th>Duration</th>
                    <th>Release Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movies as $movie)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="rounded me-3" style="width: 40px; height: 60px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">{{ $movie->title }}</h6>
                            </div>
                        </div>
                    </td>
                    <td>{{ $movie->genre->name ?? 'N/A' }}</td>
                    <td>{{ $movie->duration }} mins</td>
                    <td>{{ $movie->release_date ? $movie->release_date->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this movie?')">
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
                    <td colspan="5" class="text-center py-4">No movies found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($movies->hasPages())
    <div class="card-footer" style="background:transparent;border-top:1px solid var(--border);">
        {{ $movies->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

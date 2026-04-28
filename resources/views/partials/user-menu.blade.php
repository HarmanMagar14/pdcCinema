@if(Auth::check())
    @php
        $name = Auth::user()->name ?? 'U';
        $avatarColor = Auth::user()->avatar_color ?? '#e8340a';
    @endphp
    <div class="dropdown">
        <button
            class="btn btn-outline-light btn-sm d-flex align-items-center gap-2 dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            style="font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 500; letter-spacing: 0.2px;"
        >
            <span style="width: 24px; height: 24px; border-radius: 50%; background: {{ $avatarColor }}; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;">
                {{ strtoupper(substr($name, 0, 1)) }}
            </span>
            <span class="d-none d-md-inline">{{ $name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="font-family: 'DM Sans', sans-serif; font-size: 0.88rem;">
            <li><a class="dropdown-item" href="{{ route('profile.show') }}" style="font-family: inherit;"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item" style="font-family: inherit;"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                </form>
            </li>
        </ul>
    </div>
@else
    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
    <a href="{{ route('register') }}" class="btn btn-light btn-sm">Register</a>
@endif

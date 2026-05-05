<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EduEnroll – Student Enrollment System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'DM Sans', system-ui, sans-serif;
            background: var(--ses-bg-page);
            color: var(--ses-gray-900);
            min-height: 100vh;
            line-height: 1.5;
        }
        button, input, select, textarea { font-family: 'DM Sans', system-ui, sans-serif; }
        a, button { transition: background-color 0.16s ease, color 0.16s ease, box-shadow 0.16s ease; }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid transparent;
            box-shadow: 0 0 0 3px rgba(196, 61, 61, 0.22);
        }
        .ses-navbar {
            background: var(--ses-bg);
            height: var(--ses-header-height);
            padding: 0 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            border-bottom: 1px solid var(--ses-border);
            box-shadow: var(--ses-shadow-sm);
        }
        .ses-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .ses-logo-icon { width: 34px; height: 34px; background: var(--ses-beige); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--ses-border); }
        .ses-logo-icon svg { width: 18px; height: 18px; }
        .ses-logo-text { font-family: 'DM Serif Display', Georgia, serif; font-size: 1.125rem; color: var(--ses-text); letter-spacing: -0.02em; }
        .ses-nav-links { display: flex; align-items: center; }
        .ses-nav-links a {
            color: var(--ses-text-soft); text-decoration: none; font-size: 0.84rem; font-weight: 500;
            padding: 0 14px; height: var(--ses-header-height); display: flex; align-items: center;
            box-shadow: inset 0 -2px 0 transparent;
            border-radius: 0;
        }
        .ses-nav-links a:hover { color: var(--ses-gray-900); background: var(--ses-beige); }
        .ses-nav-links a.active {
            color: var(--ses-red);
            box-shadow: inset 0 -2px 0 var(--ses-red);
            background: rgba(196, 61, 61, 0.04);
        }
        .ses-nav-user { display: flex; align-items: center; gap: 8px; }
        .ses-nav-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--ses-beige); border: 1.5px solid var(--ses-border);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 700; color: var(--ses-red); text-decoration: none;
        }
        .ses-nav-avatar:hover { background: var(--ses-beige-muted); color: var(--ses-red-dark); }
        .ses-nav-user form button {
            background: var(--ses-bg); border: 1px solid var(--ses-border);
            color: var(--ses-text-soft); border-radius: 9px; padding: 6px 14px; font-size: 0.78rem; font-weight: 600;
            cursor: pointer;
        }
        .ses-nav-user form button:hover { border-color: var(--ses-red-100); color: var(--ses-red); background: var(--ses-red-soft); }
        .ses-body {
            min-height: 100vh;
            padding-top: calc(var(--ses-header-height) + var(--ses-content-gap));
            padding-bottom: 2rem;
        }
        .ses-alert { padding: 0.75rem 1rem; border-radius: var(--ses-radius-sm); font-size: 0.85rem; margin-bottom: 1rem; }
        .ses-alert.success { background: var(--ses-success-bg); border: 1px solid var(--ses-success-border); color: var(--ses-success-text); }
        .ses-alert.error { background: var(--ses-red-soft); border: 1px solid var(--ses-red-100); color: var(--ses-red-deep); }
    </style>
@stack('styles')
</head>
<body>

@if(session('student_id'))
<nav class="ses-navbar">
    <a class="ses-logo" href="{{ route('dashboard') }}">
        <div class="ses-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#c43d3d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
        </div>
        <span class="ses-logo-text">EduEnroll</span>
    </a>
    <div class="ses-nav-links">
        <a href="{{ route('dashboard') }}"        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('enrollments.index') }}" class="{{ request()->routeIs('enrollments.*') ? 'active' : '' }}">Enroll</a>
        <a href="{{ route('subjects.index') }}"   class="{{ request()->routeIs('subjects.*') ? 'active' : '' }}">Subjects</a>
    </div>
    <div class="ses-nav-user">
        <a href="{{ route('profile.show') }}" class="ses-nav-avatar" title="My Profile">
            {{ strtoupper(substr(session('student_name', 'S'), 0, 1)) }}
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</nav>
@endif

<div class="ses-body">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

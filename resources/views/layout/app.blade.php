<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EduEnroll – Student Enrollment System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ses-red:      #c0392b;
            --ses-red-dark: #96281b;
            --ses-red-deep: #7f1d1d;
            --ses-red-light:#fef2f2;
            --ses-red-100:  #fecaca;
            --ses-white:    #ffffff;
            --ses-gray-50:  #fafafa;
            --ses-gray-100: #f4f4f4;
            --ses-gray-200: #e5e7eb;
            --ses-gray-400: #9ca3af;
            --ses-gray-600: #4b5563;
            --ses-gray-900: #111827;
        }
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--ses-gray-100); color: var(--ses-gray-900); min-height: 100vh; }
        .ses-navbar {
            background: var(--ses-red-dark);
            height: 56px; padding: 0 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .ses-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .ses-logo-icon { width: 32px; height: 32px; background: var(--ses-white); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .ses-logo-icon svg { width: 18px; height: 18px; }
        .ses-logo-text { font-family: 'DM Serif Display', serif; font-size: 1.15rem; color: var(--ses-white); }
        .ses-nav-links { display: flex; align-items: center; }
        .ses-nav-links a {
            color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.85rem; font-weight: 500;
            padding: 0 14px; height: 56px; display: flex; align-items: center;
            border-bottom: 3px solid transparent; transition: all 0.15s;
        }
        .ses-nav-links a:hover, .ses-nav-links a.active {
            color: var(--ses-white); border-bottom-color: rgba(255,255,255,0.7); background: rgba(255,255,255,0.08);
        }
        .ses-nav-user { display: flex; align-items: center; gap: 6px; }
        .ses-nav-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: rgba(255,255,255,0.2); border: 1.5px solid rgba(255,255,255,0.3);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 700; color: white; text-decoration: none;
        }
        .ses-nav-avatar:hover { background: rgba(255,255,255,0.3); color: white; }
        .ses-nav-user form button {
            background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);
            color: white; border-radius: 6px; padding: 4px 12px; font-size: 0.78rem;
            cursor: pointer; font-family: 'DM Sans', sans-serif;
        }
        .ses-nav-user form button:hover { background: rgba(255,255,255,0.22); }
        .ses-body { padding-top: 56px; }
        .ses-alert { padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.85rem; margin-bottom: 1rem; }
        .ses-alert.success { background: #dcfce7; border: 1px solid #bbf7d0; color: #15803d; }
        .ses-alert.error   { background: #fee2e2; border: 1px solid #fecaca; color: #b91c1c; }
    </style>
    @stack('styles')
</head>
<body>

@if(session('student_id'))
<nav class="ses-navbar">
    <a class="ses-logo" href="{{ route('dashboard') }}">
        <div class="ses-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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

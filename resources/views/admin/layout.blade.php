<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin – EduEnroll')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ses-header-height: 64px; --ses-content-gap: 16px;
            --ses-red: #c0392b; --ses-red-dark: #96281b; --ses-red-deep: #7f1d1d;
            --ses-red-light: #fef2f2; --ses-red-100: #fecaca;
            --ses-accent: #1f4e79; --ses-accent-dark: #163a5b; --ses-accent-light: #ecf2f9;
            --ses-gray-50: #fafafa; --ses-gray-100: #f4f4f4; --ses-gray-200: #e5e7eb;
            --ses-gray-400: #9ca3af; --ses-gray-600: #4b5563; --ses-gray-900: #111827;
        }
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--ses-gray-100); color: var(--ses-gray-900); margin: 0; }
        button, input, select, textarea { font-family: 'DM Sans', sans-serif; }
        a, button { transition: background-color 0.16s ease, color 0.16s ease, box-shadow 0.16s ease; }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid transparent; box-shadow: 0 0 0 3px rgba(31, 78, 121, 0.25);
        }
        .admin-topbar {
            background: #60100b;
            height: var(--ses-header-height); padding: 0 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .admin-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .admin-logo-icon { width: 32px; height: 32px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .admin-logo-icon svg { width: 18px; height: 18px; }
        .admin-logo-text { font-family: 'DM Serif Display', serif; font-size: 1.15rem; color: white; }
        .admin-tag-badge { background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; padding: 3px 10px; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; }
        .admin-layout { display: flex; min-height: calc(100vh - var(--ses-header-height) - var(--ses-content-gap)); margin-top: calc(var(--ses-header-height) + var(--ses-content-gap)); }
        .admin-main { flex: 1; padding: 1.75rem 2rem; background: var(--ses-gray-100); overflow: auto; }
        .admin-sidebar { width: 220px; flex-shrink: 0; background: var(--ses-red-deep); padding: 1.5rem 0; display: flex; flex-direction: column; min-height: calc(100vh - var(--ses-header-height) - var(--ses-content-gap)); }
        .admin-sidebar-top { padding: 0 1.1rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 0.75rem; }
        .admin-sidebar-title { font-family:'DM Serif Display',serif; font-size:1rem; color:white; }
        .admin-sidebar-subtitle { font-size:0.65rem; color:rgba(255,255,255,0.4); margin-top:2px; }
        .admin-sidebar-section-label { font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.14em; color:rgba(255,255,255,0.35); padding:0 1.1rem; margin-bottom:0.3rem; }
        .admin-sidebar-link { display:flex; align-items:center; gap:9px; padding:9px 1.1rem; font-size:0.84rem; color:rgba(255,255,255,0.65); text-decoration:none; border-right:3px solid transparent; }
        .admin-sidebar-link:hover, .admin-sidebar-link.active { background:rgba(255,255,255,0.1); color:white; border-right-color:white; }
        .admin-sidebar-link svg { width: 15px; height: 15px; flex-shrink: 0; }
        .admin-sidebar-footer { padding:0.75rem 1.1rem 0; border-top:1px solid rgba(255,255,255,0.08); margin-top:auto; }
        .admin-sidebar-logout { background:none; border:none; padding:0; display:flex; align-items:center; gap:8px; font-size:0.78rem; color:rgba(255,255,255,0.45); cursor:pointer; width:100%; text-align:left; }
        .admin-sidebar-logout:hover { color: var(--ses-accent-light); }
        .ses-alert { padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.85rem; margin-bottom: 1rem; }
        .ses-alert.success { background: var(--ses-accent-light); border: 1px solid #c7daee; color: var(--ses-accent-dark); }
        .ses-alert.error   { background: #fee2e2; border: 1px solid #fecaca; color: #b91c1c; }
        @stack('styles-raw')
    </style>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('styles')
</head>
<body>

<header class="admin-topbar">
    <a class="admin-logo" href="{{ route('admin.dashboard') }}">
        <div class="admin-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
        </div>
        <span class="admin-logo-text">EduEnroll</span>
    </a>
    <span class="admin-tag-badge">Admin Panel</span>
</header>

<div class="admin-layout">
    @include('admin.partials.sidebar')
    <main class="admin-main">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin – EduEnroll')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', system-ui, sans-serif; background: var(--ses-bg-page); color: var(--ses-gray-900); margin: 0; line-height: 1.5; }
        button, input, select, textarea { font-family: 'DM Sans', system-ui, sans-serif; }
        a, button { transition: background-color 0.16s ease, color 0.16s ease, box-shadow 0.16s ease; }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid transparent; box-shadow: 0 0 0 3px rgba(196, 61, 61, 0.22);
        }
        .admin-topbar {
            background: var(--ses-bg);
            height: var(--ses-header-height); padding: 0 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            border-bottom: 1px solid var(--ses-border);
            box-shadow: var(--ses-shadow-sm);
        }
        .admin-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .admin-logo-icon { width: 34px; height: 34px; background: var(--ses-beige); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--ses-border); }
        .admin-logo-icon svg { width: 18px; height: 18px; }
        .admin-logo-text { font-family: 'DM Serif Display', Georgia, serif; font-size: 1.125rem; color: var(--ses-text); }
        .admin-tag-badge { background: var(--ses-red-soft); color: var(--ses-red-muted); border: 1px solid var(--ses-red-100); border-radius: 8px; padding: 5px 12px; font-size: 0.68rem; font-weight: 600; letter-spacing: 0.06em; }
        .admin-layout { display: flex; min-height: calc(100vh - var(--ses-header-height) - var(--ses-content-gap)); margin-top: calc(var(--ses-header-height) + var(--ses-content-gap)); }
        .admin-main { flex: 1; padding: 2rem 2rem 3rem; background: var(--ses-bg-page); overflow: auto; }
        .admin-sidebar { width: 232px; flex-shrink: 0; background: var(--ses-beige); padding: 1.35rem 0; display: flex; flex-direction: column; border-right: 1px solid var(--ses-border); min-height: calc(100vh - var(--ses-header-height) - var(--ses-content-gap)); }
        .admin-sidebar-top { padding: 0 1rem 1.1rem; border-bottom: 1px solid var(--ses-border); margin-bottom: 0.75rem; }
        .admin-sidebar-title { font-family:'DM Serif Display', Georgia, serif; font-size:1.05rem; color:var(--ses-text); }
        .admin-sidebar-subtitle { font-size:0.68rem; color:var(--ses-text-muted); margin-top:4px; }
        .admin-sidebar-section-label { font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:var(--ses-text-muted); padding:0 1rem; margin-bottom:0.35rem; }
        .admin-sidebar-link { display:flex; align-items:center; gap:10px; padding:10px 1rem; font-size:0.84rem; color:var(--ses-text-soft); text-decoration:none; border-radius:0 10px 10px 0; margin-right: 8px; border-left:3px solid transparent; }
        .admin-sidebar-link:hover { background:rgba(255,255,255,0.72); color:var(--ses-text); }
        .admin-sidebar-link.active { background:var(--ses-bg); color:var(--ses-red); border-left-color:var(--ses-red); box-shadow: var(--ses-shadow-sm); }
        .admin-sidebar-link svg { width: 15px; height: 15px; flex-shrink: 0; }
        .admin-sidebar-footer { padding:0.85rem 1rem 0; border-top:1px solid var(--ses-border); margin-top:auto; }
        .admin-sidebar-logout { background:none; border:none; padding:0; display:flex; align-items:center; gap:8px; font-size:0.78rem; color:var(--ses-text-muted); cursor:pointer; width:100%; text-align:left; font-family: inherit; }
        .admin-sidebar-logout:hover { color:var(--ses-red); }
        .ses-alert { padding: 0.75rem 1rem; border-radius: var(--ses-radius-sm); font-size: 0.85rem; margin-bottom: 1rem; }
        .ses-alert.success { background: var(--ses-success-bg); border: 1px solid var(--ses-success-border); color: var(--ses-success-text); }
        .ses-alert.error { background: var(--ses-red-soft); border: 1px solid var(--ses-red-100); color: var(--ses-red-deep); }
        @stack('styles-raw')
    </style>
@stack('styles')
</head>
<body>

<header class="admin-topbar">
    <a class="admin-logo" href="{{ route('admin.dashboard') }}">
        <div class="admin-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#c43d3d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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

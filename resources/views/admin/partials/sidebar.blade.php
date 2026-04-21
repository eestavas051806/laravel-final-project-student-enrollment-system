{{-- resources/views/admin/partials/sidebar.blade.php --}}
<aside style="width:220px;flex-shrink:0;background:#7f1d1d;padding:1.5rem 0;display:flex;flex-direction:column;min-height:calc(100vh - 56px);">
    <div style="padding:0 1.1rem 1.25rem;border-bottom:1px solid rgba(255,255,255,0.08);margin-bottom:0.75rem;">
        <div style="font-family:'DM Serif Display',serif;font-size:1rem;color:white;">EduEnroll</div>
        <div style="font-size:0.65rem;color:rgba(255,255,255,0.4);margin-top:2px;">Admin Panel</div>
    </div>

    <div style="flex:1;">
        <div style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.14em;color:rgba(255,255,255,0.35);padding:0 1.1rem;margin-bottom:0.3rem;">Overview</div>
        <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:9px;padding:9px 1.1rem;font-size:0.84rem;color:rgba(255,255,255,0.65);text-decoration:none;border-right:3px solid transparent;transition:all 0.15s;{{ request()->routeIs('admin.dashboard') ? 'background:rgba(255,255,255,0.1);color:white;border-right-color:white;' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <div style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.14em;color:rgba(255,255,255,0.35);padding:0.75rem 1.1rem 0.3rem;margin-top:0.5rem;">Management</div>
        <a href="{{ route('admin.students') }}" style="display:flex;align-items:center;gap:9px;padding:9px 1.1rem;font-size:0.84rem;color:rgba(255,255,255,0.65);text-decoration:none;border-right:3px solid transparent;transition:all 0.15s;{{ request()->routeIs('admin.students*') ? 'background:rgba(255,255,255,0.1);color:white;border-right-color:white;' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            Students
        </a>
        <a href="{{ route('admin.subjects') }}" style="display:flex;align-items:center;gap:9px;padding:9px 1.1rem;font-size:0.84rem;color:rgba(255,255,255,0.65);text-decoration:none;border-right:3px solid transparent;transition:all 0.15s;{{ request()->routeIs('admin.subjects*') ? 'background:rgba(255,255,255,0.1);color:white;border-right-color:white;' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
            Subjects
        </a>
        <a href="{{ route('admin.enrollments') }}" style="display:flex;align-items:center;gap:9px;padding:9px 1.1rem;font-size:0.84rem;color:rgba(255,255,255,0.65);text-decoration:none;border-right:3px solid transparent;transition:all 0.15s;{{ request()->routeIs('admin.enrollments') ? 'background:rgba(255,255,255,0.1);color:white;border-right-color:white;' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Enrollments
        </a>
    </div>

    <div style="padding:0.75rem 1.1rem 0;border-top:1px solid rgba(255,255,255,0.08);margin-top:auto;">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" style="background:none;border:none;padding:0;display:flex;align-items:center;gap:8px;font-size:0.78rem;color:rgba(255,255,255,0.45);cursor:pointer;font-family:'DM Sans',sans-serif;width:100%;text-align:left;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

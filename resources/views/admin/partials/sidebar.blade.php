{{-- resources/views/admin/partials/sidebar.blade.php --}}
<aside class="admin-sidebar">
    <div class="admin-sidebar-top">
        <div class="admin-sidebar-title">EduEnroll</div>
        <div class="admin-sidebar-subtitle">Admin Panel</div>
    </div>

    <div style="flex:1;">
        <div class="admin-sidebar-section-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <div class="admin-sidebar-section-label" style="padding-top:0.75rem;margin-top:0.5rem;">Management</div>
        <a href="{{ route('admin.students') }}" class="admin-sidebar-link{{ request()->routeIs('admin.students*') ? ' active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            Students
        </a>
        <a href="{{ route('admin.subjects') }}" class="admin-sidebar-link{{ request()->routeIs('admin.subjects*') ? ' active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
            Subjects
        </a>
        <a href="{{ route('admin.enrollments') }}" class="admin-sidebar-link{{ request()->routeIs('admin.enrollments') ? ' active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Enrollments
        </a>
    </div>

    <div class="admin-sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="admin-sidebar-logout">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

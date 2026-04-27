@extends('layout.app')
@section('title', 'Subjects – EduEnroll')

@push('styles')
<style>
    .dash-layout { display: flex; min-height: calc(100vh - var(--ses-header-height) - var(--ses-content-gap)); }
    .dash-sidebar {
        width: 200px; flex-shrink: 0; background: var(--ses-red-deep);
        padding: 1.5rem 0; display: flex; flex-direction: column;
    }
    .sidebar-section { padding: 0 0 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 0.75rem; }
    .sidebar-label { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.14em; color: rgba(255,255,255,0.35); padding: 0 1.1rem; margin-bottom: 0.3rem; }
    .sidebar-item { display: flex; align-items: center; gap: 9px; padding: 9px 1.1rem; font-size: 0.84rem; color: rgba(255,255,255,0.65); text-decoration: none; border-right: 3px solid transparent; transition: all 0.15s; }
    .sidebar-item:hover, .sidebar-item.active { background: rgba(255,255,255,0.1); color: white; border-right-color: white; }
    .sidebar-item svg { width: 15px; height: 15px; flex-shrink: 0; }
    .sidebar-footer { margin-top: auto; padding: 0.75rem 1.1rem 0; border-top: 1px solid rgba(255,255,255,0.08); }
    .sidebar-logout { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: rgba(255,255,255,0.45); cursor: pointer; }
    .sidebar-logout:hover { color: var(--ses-accent-light); }
    .sidebar-logout svg { width: 13px; height: 13px; }

    .subj-main { flex: 1; padding: 1.75rem 2rem; background: var(--ses-gray-100); }
    .subj-main h2 { font-family: 'DM Serif Display', serif; font-size: 1.3rem; color: var(--ses-gray-900); margin-bottom: 0.15rem; }
    .subj-main p { font-size: 0.78rem; color: var(--ses-gray-400); margin-bottom: 1.25rem; }
    .filter-bar { display: flex; gap: 0.65rem; margin-bottom: 1.1rem; flex-wrap: wrap; }
    .filter-select, .filter-input { height: 36px; border: 1.5px solid var(--ses-gray-200); border-radius: 8px; padding: 0 12px; font-size: 0.82rem; font-family: 'DM Sans', sans-serif; background: white; color: var(--ses-gray-900); outline: none; }
    .filter-input { flex: 1; min-width: 160px; }
    .filter-btn { height: 36px; background: var(--ses-accent); color: white; border: none; border-radius: 8px; padding: 0 16px; font-size: 0.82rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .ses-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; border: 1px solid var(--ses-gray-200); font-size: 0.83rem; }
    .ses-table th { background: var(--ses-red-deep); color: rgba(255,255,255,0.85); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; padding: 10px 14px; text-align: left; }
    .ses-table td { padding: 10px 14px; border-bottom: 1px solid var(--ses-gray-100); color: var(--ses-gray-900); vertical-align: middle; }
    .ses-table tr:last-child td { border-bottom: none; }
    .ses-table tbody tr:hover td { background: var(--ses-accent-light); }
    .subj-code { font-weight: 700; color: var(--ses-red); font-size: 0.8rem; letter-spacing: 0.03em; }
    .dept-pill { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; background: var(--ses-red-light); color: var(--ses-red); }
    .avail { font-size: 0.75rem; color: var(--ses-gray-400); }
    .avail.low { color: var(--ses-red-dark); font-weight: 600; }
    .btn-enroll-link { display: inline-block; padding: 4px 12px; background: var(--ses-red-light); color: var(--ses-red); border: 1px solid var(--ses-red-100); border-radius: 7px; font-size: 0.72rem; font-weight: 600; text-decoration: none; }
    .btn-enroll-link:hover { background: var(--ses-red); color: white; }
</style>
@endpush

@section('content')
<div class="dash-layout">
    <aside class="dash-sidebar">
        <div class="sidebar-section">
            <div class="sidebar-label">Menu</div>
            <a class="sidebar-item" href="{{ route('dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a class="sidebar-item" href="{{ route('enrollments.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Enroll
            </a>
            <a class="sidebar-item active" href="{{ route('subjects.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                Subjects
            </a>
            <a class="sidebar-item{{ request()->routeIs('profile.*') ? ' active' : '' }}" href="{{ route('profile.show') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                My Profile
            </a>
        </div>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout" style="background:none;border:none;padding:0;width:100%;text-align:left;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="subj-main">
        <h2>All subjects</h2>
        <p>Browse all available subjects offered this semester.</p>

        <form method="GET" action="{{ route('subjects.index') }}" class="filter-bar">
            <select name="department" class="filter-select">
                <option value="">All departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                @endforeach
            </select>
            <select name="year_level" class="filter-select">
                <option value="">All year levels</option>
                @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $yr)
                    <option value="{{ $yr }}" {{ request('year_level') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
            <input type="text" name="search" class="filter-input" placeholder="Search by code or name..." value="{{ request('search') }}">
            <button type="submit" class="filter-btn">Search</button>
        </form>

        <table class="ses-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Subject name</th>
                    <th>Department</th>
                    <th>Units</th>
                    <th>Schedule</th>
                    <th>Year level</th>
                    <th>Available slots</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                @php
                    $available = $subject->max_slots - $subject->enrollments_count;
                    $isEnrolled = in_array($subject->id, $enrolledIds);
                @endphp
                <tr>
                    <td><span class="subj-code">{{ $subject->code }}</span></td>
                    <td>{{ $subject->name }}</td>
                    <td><span class="dept-pill">{{ $subject->department }}</span></td>
                    <td style="font-size:0.8rem;color:var(--ses-gray-400);">{{ $subject->units }}</td>
                    <td style="font-size:0.75rem;color:var(--ses-gray-400);">{{ $subject->schedule }}</td>
                    <td style="font-size:0.8rem;">{{ $subject->year_level }}</td>
                    <td>
                        <span class="avail {{ $available <= 5 ? 'low' : '' }}">
                            {{ $available }} / {{ $subject->max_slots }}
                        </span>
                    </td>
                    <td>
                        @if($isEnrolled)
                            <span style="font-size:0.75rem;color:var(--ses-accent-dark);font-weight:600;">✓ Enrolled</span>
                        @elseif($available > 0)
                            <a href="{{ route('enrollments.index') }}" class="btn-enroll-link">Enroll →</a>
                        @else
                            <span style="font-size:0.75rem;color:var(--ses-gray-400);">Full</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2.5rem;color:var(--ses-gray-400);">No subjects found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</div>
@endsection

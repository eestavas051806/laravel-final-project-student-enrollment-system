@extends('layout.app')
@section('title', 'Subject Enrollment – EduEnroll')

@push('styles')
<style>
    .dash-layout { display: flex; min-height: calc(100vh - var(--ses-header-height) - var(--ses-content-gap)); }

    /* ── SIDEBAR ── */
    .dash-sidebar {
        width: 220px;
        flex-shrink: 0;
        background: var(--ses-beige);
        padding: 1.35rem 0;
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--ses-border);
    }
    .sidebar-section {
        padding: 0 0 1rem;
        border-bottom: 1px solid var(--ses-border);
        margin-bottom: 0.75rem;
    }
    .sidebar-label {
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--ses-text-muted);
        padding: 0 1rem;
        margin-bottom: 0.35rem;
    }
    .sidebar-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 1rem;
        font-size: 0.84rem;
        color: var(--ses-text-soft);
        text-decoration: none;
        border-radius: 0 var(--ses-radius-sm) var(--ses-radius-sm) 0;
        margin-right: 8px;
        border-left: 3px solid transparent;
        transition: background 0.15s, color 0.15s;
    }
    .sidebar-item:hover {
        background: rgba(255,255,255,0.72);
        color: var(--ses-gray-900);
    }
    .sidebar-item.active {
        background: var(--ses-bg);
        color: var(--ses-red);
        border-left-color: var(--ses-red);
        box-shadow: var(--ses-shadow-sm);
    }
    .sidebar-item svg { width: 15px; height: 15px; flex-shrink: 0; }
    .sidebar-footer {
        margin-top: auto;
        padding: 0.85rem 1rem 0;
        border-top: 1px solid var(--ses-border);
    }
    .sidebar-logout {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        color: var(--ses-text-muted);
        cursor: pointer;
        font-family: inherit;
    }
    .sidebar-logout:hover { color: var(--ses-red); }
    .sidebar-logout svg { width: 13px; height: 13px; }

    /* ── MAIN ── */
    .enroll-main { flex: 1; padding: 2rem 2.25rem 3rem; background: var(--ses-bg-page); overflow: auto; }
    .enroll-header { margin-bottom: 1.25rem; }
    .enroll-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.3rem; color: var(--ses-gray-900); margin-bottom: 0.15rem; }
    .enroll-header p { font-size: 0.78rem; color: var(--ses-gray-400); }

    /* ── FILTERS ── */
    .filter-bar { display: flex; gap: 0.65rem; margin-bottom: 1.1rem; flex-wrap: wrap; }
    .filter-select, .filter-input {
        height: 38px;
        border: 1.5px solid var(--ses-border);
        border-radius: var(--ses-radius-sm);
        padding: 0 12px;
        font-size: 0.82rem;
        font-family: 'DM Sans', system-ui, sans-serif;
        background: var(--ses-bg);
        color: var(--ses-gray-900);
        outline: none;
        transition: border-color 0.15s;
    }
    .filter-select:focus, .filter-input:focus { border-color: rgba(196, 61, 61, 0.45); box-shadow: 0 0 0 3px rgba(196, 61, 61, 0.08); }
    .filter-input { flex: 1; min-width: 160px; }
    .filter-btn {
        height: 38px;
        background: var(--ses-red);
        color: white;
        border: none;
        border-radius: var(--ses-radius-sm);
        padding: 0 18px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'DM Sans', system-ui, sans-serif;
    }
    .filter-btn:hover { background: var(--ses-red-hover); }

    /* ── SUBJECT TABLE ── */
    .subj-table-wrap {
        background: var(--ses-bg);
        border-radius: var(--ses-radius-md);
        border: 1px solid var(--ses-border);
        overflow: hidden;
        margin-bottom: 0;
        box-shadow: var(--ses-shadow-sm);
    }
    .ses-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }
    .ses-table th {
        background: var(--ses-beige-muted);
        color: var(--ses-text-soft);
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        padding: 11px 16px;
        text-align: left;
        border-bottom: 1px solid var(--ses-border);
    }
    .ses-table td {
        padding: 10px 14px;
        border-bottom: 1px solid var(--ses-gray-100);
        color: var(--ses-gray-900);
        vertical-align: middle;
    }
    .ses-table tr:last-child td { border-bottom: none; }
    .ses-table tbody tr:hover td { background: var(--ses-beige); }
    .subj-code { font-weight: 700; color: var(--ses-red); font-size: 0.8rem; letter-spacing: 0.03em; }
    .slots-text { font-size: 0.75rem; color: var(--ses-gray-400); }
    .slots-text.full { color: var(--ses-red-dark); font-weight: 600; }

    .btn-add {
        padding: 4px 13px;
        border-radius: 7px;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
    }
    .btn-add.add-btn {
        background: var(--ses-red-light);
        color: var(--ses-red);
        border: 1px solid var(--ses-red-100);
    }
    .btn-add.add-btn:hover { background: var(--ses-red); color: white; }
    .btn-add.added-btn {
        background: var(--ses-beige-muted);
        color: var(--ses-text-soft);
        border: 1px solid var(--ses-border);
        cursor: default;
    }
    .btn-remove {
        padding: 4px 10px;
        border-radius: 7px;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
        background: var(--ses-red-light);
        color: var(--ses-red-dark);
        border: 1px solid #fecaca;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
        margin-left: 4px;
    }
    .btn-remove:hover { background: #b91c1c; color: white; }

    /* ── FOOTER SUMMARY ── */
    .enroll-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.15rem;
        background: var(--ses-beige);
        border-top: 1px solid var(--ses-border);
        border-radius: 0 0 var(--ses-radius-md) var(--ses-radius-md);
        border-left: 1px solid var(--ses-border);
        border-right: 1px solid var(--ses-border);
        border-bottom: 1px solid var(--ses-border);
        border-top: none;
        margin-top: -1px;
    }
    .enroll-summary { font-size: 0.8rem; color: var(--ses-gray-600); }
    .enroll-summary strong { color: var(--ses-gray-900); }
    .unit-bar {
        height: 6px;
        background: var(--ses-gray-200);
        border-radius: 3px;
        overflow: hidden;
        width: 100px;
        display: inline-block;
        margin: 0 6px;
        vertical-align: middle;
    }
    .unit-fill { height: 100%; background: var(--ses-red); border-radius: 3px; transition: width 0.3s; }
    .btn-confirm {
        height: 38px;
        background: var(--ses-red);
        color: white;
        border: none;
        border-radius: 9px;
        font-size: 0.84rem;
        font-weight: 600;
        padding: 0 1.25rem;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .btn-confirm:hover { background: var(--ses-red-hover); }
    .btn-confirm:disabled { opacity: 0.5; cursor: not-allowed; }
</style>
@endpush

@section('content')
<div class="dash-layout">

    {{-- SIDEBAR --}}
    <aside class="dash-sidebar">
        <div class="sidebar-section">
            <div class="sidebar-label">Menu</div>
            <a class="sidebar-item" href="{{ route('dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a class="sidebar-item active" href="{{ route('enrollments.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                Enroll
            </a>
            <a class="sidebar-item" href="{{ route('subjects.index') }}">
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

    {{-- MAIN --}}
    <main class="enroll-main">
        <div class="enroll-header">
            <h2>Subject enrollment</h2>
            <p>Select subjects for AY 2025–2026, 2nd Semester. Maximum of 24 units.</p>
        </div>

        @if(session('success'))
            <div class="ses-alert success" style="margin-bottom:1rem;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="ses-alert error" style="margin-bottom:1rem;">{{ session('error') }}</div>
        @endif

        {{-- FILTERS --}}
        <form method="GET" action="{{ route('enrollments.index') }}" class="filter-bar">
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
            <input type="text" name="search" class="filter-input" placeholder="Search subjects..." value="{{ request('search') }}">
            <button type="submit" class="filter-btn">Search</button>
        </form>

        {{-- SUBJECT TABLE --}}
        <div class="subj-table-wrap">
            <table class="ses-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Subject name</th>
                        <th>Units</th>
                        <th>Schedule</th>
                        <th>Slots</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    @php $isEnrolled = in_array($subject->id, $enrolledIds); $isFull = $subject->enrollments_count >= $subject->max_slots; @endphp
                    <tr>
                        <td><span class="subj-code">{{ $subject->code }}</span></td>
                        <td>{{ $subject->name }}</td>
                        <td style="font-size:0.8rem;color:var(--ses-gray-400);">{{ $subject->units }}</td>
                        <td style="font-size:0.75rem;color:var(--ses-gray-400);">{{ $subject->schedule }}</td>
                        <td>
                            <span class="slots-text {{ $isFull ? 'full' : '' }}">
                                {{ $subject->enrollments_count }}/{{ $subject->max_slots }}
                            </span>
                        </td>
                        <td>
                            @if($isEnrolled)
                                <span class="btn-add added-btn">✓ Added</span>
                                <form action="{{ route('enrollments.destroy', $student->enrollments->where('subject_id', $subject->id)->first()?->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove">Remove</button>
                                </form>
                            @elseif($isFull)
                                <span class="btn-add added-btn" style="background:var(--ses-beige);color:var(--ses-text-muted);border-color:var(--ses-border);">Full</span>
                            @else
                                <form action="{{ route('enrollments.store') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                    <button type="submit" class="btn-add add-btn">+ Add</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2.5rem;color:var(--ses-gray-400);">No subjects found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FOOTER SUMMARY --}}
        <div class="enroll-footer">
            <div class="enroll-summary">
                <strong>{{ count($enrolledIds) }} subject(s)</strong> selected &nbsp;·&nbsp;
                <span class="unit-bar"><span class="unit-fill" style="width:{{ min(($totalUnits/24)*100, 100) }}%;"></span></span>
                <strong>{{ $totalUnits }} / 24</strong> units &nbsp;·&nbsp;
                Estimated fee: <strong>₱{{ number_format($totalFee) }}</strong>
            </div>
            <form action="{{ route('enrollments.confirm') }}" method="POST">
                @csrf
                <button type="submit" class="btn-confirm" {{ count($enrolledIds) === 0 ? 'disabled' : '' }}>
                    Confirm enrollment
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </form>
        </div>
    </main>
</div>
@endsection

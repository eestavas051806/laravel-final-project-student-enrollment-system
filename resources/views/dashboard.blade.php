@extends('layout.app')
@section('title', 'Dashboard – EduEnroll')

@push('styles')
<style>
    .dash-layout { display: flex; min-height: calc(100vh - 56px); }

    /* ── SIDEBAR ── */
    .dash-sidebar {
        width: 200px;
        flex-shrink: 0;
        background: #7f1d1d;
        padding: 1.5rem 0;
        display: flex;
        flex-direction: column;
    }
    .sidebar-section {
        padding: 0 0 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        margin-bottom: 0.75rem;
    }
    .sidebar-label {
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: rgba(255,255,255,0.35);
        padding: 0 1.1rem;
        margin-bottom: 0.3rem;
    }
    .sidebar-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 1.1rem;
        font-size: 0.84rem;
        color: rgba(255,255,255,0.65);
        text-decoration: none;
        border-right: 3px solid transparent;
        transition: all 0.15s;
    }
    .sidebar-item:hover,
    .sidebar-item.active {
        background: rgba(255,255,255,0.1);
        color: white;
        border-right-color: white;
    }
    .sidebar-item svg { width: 15px; height: 15px; flex-shrink: 0; }
    .sidebar-footer {
        margin-top: auto;
        padding: 0.75rem 1.1rem 0;
        border-top: 1px solid rgba(255,255,255,0.08);
    }
    .sidebar-logout {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        color: rgba(255,255,255,0.45);
        cursor: pointer;
    }
    .sidebar-logout:hover { color: #fca5a5; }
    .sidebar-logout svg { width: 13px; height: 13px; }

    /* ── MAIN CONTENT ── */
    .dash-main { flex: 1; padding: 1.75rem 2rem; background: var(--ses-gray-100); overflow: auto; }
    .dash-greeting { font-size: 0.75rem; color: var(--ses-gray-400); margin-bottom: 0.1rem; }
    .dash-greeting strong { color: var(--ses-gray-900); font-size: 0.92rem; }
    .dash-period { font-size: 0.7rem; color: var(--ses-red); font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 1.5rem; }

    /* ── STAT CARDS ── */
    .stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.75rem; }
    .stat-card {
        background: white;
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        border: 1px solid var(--ses-gray-200);
        position: relative;
        overflow: hidden;
    }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
    .stat-card.c-red::before { background: var(--ses-red); }
    .stat-card.c-amber::before { background: #f59e0b; }
    .stat-card.c-green::before { background: #22c55e; }
    .stat-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 0.65rem;
        font-size: 15px;
    }
    .stat-icon.red { background: var(--ses-red-light); }
    .stat-icon.amber { background: #fffbeb; }
    .stat-icon.green { background: #f0fdf4; }
    .stat-num { font-family: 'DM Serif Display', serif; font-size: 1.65rem; color: var(--ses-gray-900); line-height: 1; margin-bottom: 2px; }
    .stat-lbl { font-size: 0.68rem; color: var(--ses-gray-400); font-weight: 500; text-transform: uppercase; letter-spacing: 0.07em; }

    /* ── TABLE ── */
    .sec-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--ses-gray-600);
        margin-bottom: 0.65rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .sec-title a { color: var(--ses-red); text-decoration: none; font-size: 0.7rem; font-weight: 500; }
    .sec-title a:hover { text-decoration: underline; }
    .ses-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--ses-gray-200);
        font-size: 0.83rem;
    }
    .ses-table th {
        background: #7f1d1d;
        color: rgba(255,255,255,0.85);
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        padding: 10px 14px;
        text-align: left;
    }
    .ses-table td {
        padding: 10px 14px;
        border-bottom: 1px solid var(--ses-gray-100);
        color: var(--ses-gray-900);
        vertical-align: middle;
    }
    .ses-table tr:last-child td { border-bottom: none; }
    .ses-table tbody tr:hover td { background: var(--ses-red-light); }
    .subj-code { font-weight: 600; color: var(--ses-red); font-family: monospace; font-size: 0.8rem; }
    .pill {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 600;
    }
    .pill.enrolled { background: #dcfce7; color: #15803d; }
    .pill.waitlist  { background: #fef9c3; color: #854d0e; }
    .pill.pending   { background: #fee2e2; color: #b91c1c; }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 12px;
        border: 1px solid var(--ses-gray-200);
    }
    .empty-state p { color: var(--ses-gray-400); margin-bottom: 1rem; }
    .btn-red {
        display: inline-block;
        padding: 9px 20px;
        background: var(--ses-red);
        color: white;
        text-decoration: none;
        border-radius: 9px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .btn-red:hover { background: var(--ses-red-dark); color: white; }
</style>
@endpush

@section('content')
<div class="dash-layout">

    {{-- SIDEBAR --}}
    <aside class="dash-sidebar">
        <div class="sidebar-section">
            <div class="sidebar-label">Menu</div>
            <a class="sidebar-item active" href="{{ route('dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a class="sidebar-item" href="{{ route('enrollments.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                Enroll
            </a>
            <a class="sidebar-item" href="{{ route('subjects.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                Subjects
            </a>
            <a class="sidebar-item" href="#">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Payments
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
    <main class="dash-main">
        <div class="dash-greeting">Good day, <strong>{{ $student->first_name }} {{ $student->last_name }}</strong></div>
        <div class="dash-period">AY 2025–2026 · 2nd Semester</div>

        @if(session('success'))
            <div class="ses-alert success">{{ session('success') }}</div>
        @endif

        {{-- STAT CARDS --}}
        <div class="stat-row">
            <div class="stat-card c-red">
                <div class="stat-icon red">📚</div>
                <div class="stat-num">{{ $totalUnits }}</div>
                <div class="stat-lbl">Units enrolled</div>
            </div>
            <div class="stat-card c-amber">
                <div class="stat-icon amber">💳</div>
                <div class="stat-num">₱{{ number_format($totalFee) }}</div>
                <div class="stat-lbl">Fee this term</div>
            </div>
            <div class="stat-card c-green">
                <div class="stat-icon green">{{ $student->is_enrolled ? '✅' : '⏳' }}</div>
                <div class="stat-num" style="font-size:1.15rem;">{{ $student->is_enrolled ? 'Enrolled' : 'Pending' }}</div>
                <div class="stat-lbl">Official status</div>
            </div>
        </div>

        {{-- ENROLLED SUBJECTS --}}
        <div class="sec-title">
            Enrolled subjects
            <a href="{{ route('enrollments.index') }}">Manage →</a>
        </div>

        @if($enrollments->count() > 0)
            <table class="ses-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Subject name</th>
                        <th>Units</th>
                        <th>Schedule</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                    <tr>
                        <td><span class="subj-code">{{ $enrollment->subject->code }}</span></td>
                        <td>{{ $enrollment->subject->name }}</td>
                        <td>{{ $enrollment->subject->units }}</td>
                        <td style="font-size:0.75rem;color:var(--ses-gray-400);">{{ $enrollment->subject->schedule }}</td>
                        <td><span class="pill enrolled">Enrolled</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>You have no enrolled subjects yet.</p>
                <a href="{{ route('enrollments.index') }}" class="btn-red">Start enrolling →</a>
            </div>
        @endif
    </main>
</div>
@endsection

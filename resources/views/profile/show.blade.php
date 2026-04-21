@extends('layout.app')
@section('title', 'My Profile – EduEnroll')

@push('styles')
<style>
    .dash-layout { display: flex; min-height: calc(100vh - 56px); }
    .dash-sidebar { width: 200px; flex-shrink: 0; background: #7f1d1d; padding: 1.5rem 0; display: flex; flex-direction: column; }
    .sidebar-section { padding: 0 0 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 0.75rem; }
    .sidebar-label { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.14em; color: rgba(255,255,255,0.35); padding: 0 1.1rem; margin-bottom: 0.3rem; }
    .sidebar-item { display: flex; align-items: center; gap: 9px; padding: 9px 1.1rem; font-size: 0.84rem; color: rgba(255,255,255,0.65); text-decoration: none; border-right: 3px solid transparent; transition: all 0.15s; }
    .sidebar-item:hover, .sidebar-item.active { background: rgba(255,255,255,0.1); color: white; border-right-color: white; }
    .sidebar-item svg { width: 15px; height: 15px; flex-shrink: 0; }
    .sidebar-footer { margin-top: auto; padding: 0.75rem 1.1rem 0; border-top: 1px solid rgba(255,255,255,0.08); }
    .sidebar-logout { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: rgba(255,255,255,0.45); cursor: pointer; }
    .sidebar-logout:hover { color: #fca5a5; }

    .profile-main { flex: 1; padding: 1.75rem 2rem; background: var(--ses-gray-100); }
    .profile-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .profile-title { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--ses-gray-900); }
    .btn-edit { padding: 9px 18px; background: var(--ses-red); color: white; border-radius: 9px; font-size: 0.85rem; font-weight: 600; text-decoration: none; }
    .profile-card { background: white; border-radius: 14px; border: 1px solid var(--ses-gray-200); padding: 1.75rem; margin-bottom: 1.25rem; }
    .section-head { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--ses-red); padding-bottom: 0.6rem; border-bottom: 1.5px solid #fecaca; margin-bottom: 1rem; }
    .detail-row { display: flex; padding: 0.5rem 0; border-bottom: 1px solid var(--ses-gray-100); font-size: 0.85rem; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { width: 160px; flex-shrink: 0; color: var(--ses-gray-400); font-size: 0.78rem; font-weight: 500; }
    .avatar-circle { width: 72px; height: 72px; border-radius: 50%; background: var(--ses-red); display: flex; align-items: center; justify-content: center; font-family: 'DM Serif Display', serif; font-size: 1.8rem; color: white; margin-bottom: 0.75rem; }
    .pill { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; }
    .pill.enrolled { background: #dcfce7; color: #15803d; }
    .pill.pending  { background: #fee2e2; color: #b91c1c; }
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
            <a class="sidebar-item" href="{{ route('subjects.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                Subjects
            </a>
            <a class="sidebar-item active" href="{{ route('profile.show') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                My Profile
            </a>
        </div>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout" style="background:none;border:none;padding:0;width:100%;text-align:left;font-family:'DM Sans',sans-serif;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="profile-main">
        <div class="profile-header">
            <div class="profile-title">My Profile</div>
            <a href="{{ route('profile.edit') }}" class="btn-edit">✏️ Edit Profile</a>
        </div>

        @if(session('success'))
            <div class="ses-alert success">{{ session('success') }}</div>
        @endif

        {{-- PROFILE CARD --}}
        <div class="profile-card">
            <div style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid var(--ses-gray-100);">
                <div class="avatar-circle">{{ strtoupper(substr($student->first_name, 0, 1)) }}</div>
                <div>
                    <div style="font-family:'DM Serif Display',serif;font-size:1.3rem;color:var(--ses-gray-900);">{{ $student->first_name }} {{ $student->last_name }}</div>
                    <div style="font-size:0.78rem;color:var(--ses-gray-400);margin-top:2px;">{{ $student->course }} · {{ $student->year_level }}</div>
                    <div style="margin-top:5px;"><span class="pill {{ $student->is_enrolled ? 'enrolled' : 'pending' }}">{{ $student->is_enrolled ? 'Enrolled' : 'Not yet enrolled' }}</span></div>
                </div>
                <div style="margin-left:auto;text-align:right;">
                    <div style="font-family:monospace;font-size:1rem;font-weight:700;color:var(--ses-red);">{{ $student->student_id }}</div>
                    <div style="font-size:0.7rem;color:var(--ses-gray-400);text-transform:uppercase;letter-spacing:0.06em;">Student ID</div>
                </div>
            </div>

            <div class="section-head">Personal Information</div>
            <div class="detail-row"><span class="detail-label">Full name</span><span>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</span></div>
            <div class="detail-row"><span class="detail-label">Date of birth</span><span>{{ $student->date_of_birth }}</span></div>
            <div class="detail-row"><span class="detail-label">Gender</span><span>{{ $student->gender }}</span></div>
            <div class="detail-row"><span class="detail-label">Email</span><span>{{ $student->email }}</span></div>
            <div class="detail-row"><span class="detail-label">Contact number</span><span>{{ $student->contact_number }}</span></div>
            <div class="detail-row"><span class="detail-label">Address</span><span>{{ $student->complete_address }}</span></div>
        </div>

        {{-- ENROLLED SUBJECTS --}}
        @if($student->enrollments->count() > 0)
        <div class="profile-card">
            <div class="section-head">Enrolled Subjects ({{ $student->enrollments->count() }})</div>
            @foreach($student->enrollments as $e)
            <div class="detail-row">
                <span class="detail-label" style="font-family:monospace;font-size:0.8rem;color:var(--ses-red);font-weight:600;">{{ $e->subject->code }}</span>
                <span style="flex:1;">{{ $e->subject->name }}</span>
                <span style="font-size:0.75rem;color:var(--ses-gray-400);">{{ $e->subject->units }} units · {{ $e->subject->schedule }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </main>
</div>
@endsection

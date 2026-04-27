@extends('layout.app')
@section('title', 'Edit Profile – EduEnroll')

@push('styles')
<style>
    .dash-layout { display: flex; min-height: calc(100vh - var(--ses-header-height) - var(--ses-content-gap)); }
    .dash-sidebar { width: 200px; flex-shrink: 0; background: var(--ses-red-deep); padding: 1.5rem 0; display: flex; flex-direction: column; }
    .sidebar-section { padding: 0 0 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 0.75rem; }
    .sidebar-label { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.14em; color: rgba(255,255,255,0.35); padding: 0 1.1rem; margin-bottom: 0.3rem; }
    .sidebar-item { display: flex; align-items: center; gap: 9px; padding: 9px 1.1rem; font-size: 0.84rem; color: rgba(255,255,255,0.65); text-decoration: none; border-right: 3px solid transparent; transition: all 0.15s; }
    .sidebar-item:hover, .sidebar-item.active { background: rgba(255,255,255,0.1); color: white; border-right-color: white; }
    .sidebar-item svg { width: 15px; height: 15px; flex-shrink: 0; }
    .sidebar-footer { margin-top: auto; padding: 0.75rem 1.1rem 0; border-top: 1px solid rgba(255,255,255,0.08); }
    .sidebar-logout { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: rgba(255,255,255,0.45); cursor: pointer; }
    .sidebar-logout:hover { color: var(--ses-accent-light); }

    .profile-main { flex: 1; padding: 1.75rem 2rem; background: var(--ses-gray-100); }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .page-title { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--ses-gray-900); }
    .profile-card { background: white; border-radius: 14px; border: 1px solid var(--ses-gray-200); padding: 1.75rem; margin-bottom: 1.25rem; max-width: 680px; }
    .section-head { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--ses-accent); padding-bottom: 0.6rem; border-bottom: 1.5px solid #c7daee; margin-bottom: 1rem; }
    .ses-label { display: block; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--ses-gray-600); margin-bottom: 4px; }
    .ses-input { width: 100%; height: 40px; border: 1.5px solid var(--ses-gray-200); border-radius: 9px; padding: 0 12px; font-size: 0.87rem; font-family: 'DM Sans', sans-serif; color: var(--ses-gray-900); background: var(--ses-gray-50); outline: none; transition: border-color 0.15s; }
    .ses-input:focus { border-color: var(--ses-accent); background: white; }
    .ses-input.is-error { border-color: var(--ses-red-dark); }
    .ses-input:disabled { opacity: 0.5; cursor: not-allowed; background: var(--ses-gray-100); }
    .ses-textarea { width: 100%; border: 1.5px solid var(--ses-gray-200); border-radius: 9px; padding: 10px 12px; font-size: 0.87rem; font-family: 'DM Sans', sans-serif; color: var(--ses-gray-900); background: var(--ses-gray-50); outline: none; resize: vertical; transition: border-color 0.15s; }
    .ses-textarea:focus { border-color: var(--ses-accent); background: white; }
    .btn-save { height: 42px; background: var(--ses-red); color: white; border: none; border-radius: 9px; font-size: 0.87rem; font-weight: 600; padding: 0 1.5rem; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background 0.15s; }
    .btn-save:hover { background: #7d2317; }
    .btn-cancel { height: 42px; background: var(--ses-gray-100); color: var(--ses-gray-600); border: 1.5px solid var(--ses-gray-200); border-radius: 9px; font-size: 0.87rem; font-weight: 500; padding: 0 1.5rem; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-cancel:hover { background: var(--ses-gray-200); color: var(--ses-gray-900); }
    .hint { font-size: 0.72rem; color: var(--ses-gray-400); margin-top: 3px; }
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

    {{-- MAIN --}}
    <main class="profile-main">
        <div class="page-header">
            <div class="page-title">Edit Profile</div>
            <a href="{{ route('profile.show') }}" class="btn-cancel">← Back to profile</a>
        </div>

        @if(session('success'))
            <div class="ses-alert success" style="max-width:680px;">{{ session('success') }}</div>
        @endif

        {{-- ── PERSONAL INFO FORM ── --}}
        <div class="profile-card">
            <div class="section-head">Personal Information</div>

            @if($errors->hasBag('default') || $errors->any())
                <div class="ses-alert error" style="margin-bottom:1rem;">
                    <ul style="margin:0;padding-left:1rem;">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf @method('PATCH')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="ses-label">First name *</label>
                        <input type="text" name="first_name" class="ses-input {{ $errors->has('first_name') ? 'is-error' : '' }}"
                            value="{{ old('first_name', $student->first_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="ses-label">Last name *</label>
                        <input type="text" name="last_name" class="ses-input {{ $errors->has('last_name') ? 'is-error' : '' }}"
                            value="{{ old('last_name', $student->last_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="ses-label">Middle name</label>
                        <input type="text" name="middle_name" class="ses-input"
                            value="{{ old('middle_name', $student->middle_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="ses-label">Email address *</label>
                        <input type="email" name="email" class="ses-input {{ $errors->has('email') ? 'is-error' : '' }}"
                            value="{{ old('email', $student->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="ses-label">Contact number *</label>
                        <input type="text" name="contact_number" class="ses-input {{ $errors->has('contact_number') ? 'is-error' : '' }}"
                            value="{{ old('contact_number', $student->contact_number) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="ses-label">Student ID</label>
                        <input type="text" class="ses-input" value="{{ $student->student_id }}" disabled>
                        <p class="hint">Student ID cannot be changed.</p>
                    </div>
                    <div class="col-12">
                        <label class="ses-label">Complete address *</label>
                        <textarea name="complete_address" class="ses-textarea" rows="2" required>{{ old('complete_address', $student->complete_address) }}</textarea>
                    </div>
                </div>
                <div style="display:flex;gap:0.75rem;margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--ses-gray-100);">
                    <button type="submit" class="btn-save">Save changes</button>
                    <a href="{{ route('profile.show') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>

        {{-- ── ID PHOTO FORM ── --}}
        <div class="profile-card">
            <div class="section-head">ID Photo</div>
            <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1rem;">
                    @if($student->id_photo)
                        <img src="{{ asset('storage/' . $student->id_photo) }}"
                             style="width:72px;height:72px;border-radius:10px;object-fit:cover;border:1.5px solid var(--ses-gray-200);">
                    @else
                        <div style="width:72px;height:72px;border-radius:10px;background:var(--ses-red-light);border:1.5px dashed var(--ses-red-100);display:flex;align-items:center;justify-content:center;font-family:'DM Serif Display',serif;font-size:1.5rem;color:var(--ses-red);">
                            {{ strtoupper(substr($student->first_name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <label class="ses-label" style="margin-bottom:6px;">Upload new photo</label>
                        <input type="file" name="id_photo" accept="image/*"
                               style="font-size:0.82rem;font-family:'DM Sans',sans-serif;color:var(--ses-gray-600);">
                        <p class="hint">JPG or PNG, max 2MB.</p>
                    </div>
                </div>
                <button type="submit" class="btn-save">Update photo</button>
            </form>
        </div>

        {{-- ── CHANGE PASSWORD FORM ── --}}
        <div class="profile-card">
            <div class="section-head">Change Password</div>

            @if(session('password_success'))
                <div class="ses-alert success" style="margin-bottom:1rem;">{{ session('password_success') }}</div>
            @endif

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf @method('PATCH')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="ses-label">Current password *</label>
                        <input type="password" name="current_password"
                               class="ses-input {{ $errors->has('current_password') ? 'is-error' : '' }}"
                               placeholder="Enter your current password" required>
                        @error('current_password')
                            <p style="color:#b91c1c;font-size:0.75rem;margin-top:3px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="ses-label">New password *</label>
                        <input type="password" name="password"
                               class="ses-input {{ $errors->has('password') ? 'is-error' : '' }}"
                               placeholder="Min. 8 characters" required>
                    </div>
                    <div class="col-md-6">
                        <label class="ses-label">Confirm new password *</label>
                        <input type="password" name="password_confirmation"
                               class="ses-input"
                               placeholder="Re-enter new password" required>
                    </div>
                </div>
                <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--ses-gray-100);">
                    <button type="submit" class="btn-save">Change password</button>
                </div>
            </form>
        </div>

    </main>
</div>
@endsection

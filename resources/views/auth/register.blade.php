@extends('layout.app')
@section('title', 'Register – EduEnroll')

@push('styles')
<style>
    body { background: var(--ses-red-deep) !important; }
    .reg-wrap {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 3rem 1rem;
        background:
            radial-gradient(circle at 20% 20%, rgba(192,57,43,0.4) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(150,40,27,0.5) 0%, transparent 50%),
            #7f1d1d;
    }
    .reg-card {
        background: white;
        border-radius: 20px;
        padding: 2.25rem;
        width: 100%;
        max-width: 680px;
        box-shadow: 0 24px 64px rgba(0,0,0,0.35);
    }
    .reg-title { font-family: 'DM Serif Display', serif; font-size: 1.5rem; color: var(--ses-gray-900); margin-bottom: 0.2rem; }
    .reg-subtitle { font-size: 0.8rem; color: var(--ses-gray-400); margin-bottom: 1.5rem; }
    .section-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--ses-red);
        padding-bottom: 0.6rem;
        border-bottom: 1.5px solid #fecaca;
        margin: 1.25rem 0 0.85rem;
    }
    .ses-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--ses-gray-600);
        margin-bottom: 4px;
    }
    .ses-input, .ses-select {
        width: 100%;
        height: 40px;
        border: 1.5px solid var(--ses-gray-200);
        border-radius: 9px;
        padding: 0 12px;
        font-size: 0.87rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--ses-gray-900);
        background: var(--ses-gray-50);
        outline: none;
        transition: border-color 0.15s;
    }
    .ses-input:focus, .ses-select:focus { border-color: var(--ses-red); background: white; }
    .ses-input.is-error, .ses-select.is-error { border-color: var(--ses-red); }
    .ses-input:disabled { opacity: 0.5; cursor: not-allowed; }
    .id-photo-box {
        border: 1.5px dashed var(--ses-gray-200);
        border-radius: 9px;
        height: 80px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        font-size: 0.75rem;
        color: var(--ses-gray-400);
        gap: 4px;
        cursor: pointer;
        transition: border-color 0.15s;
    }
    .id-photo-box:hover { border-color: var(--ses-red); color: var(--ses-red); }
    .reg-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; }
    .ses-btn-outline {
        flex: 1;
        height: 44px;
        background: white;
        color: var(--ses-gray-600);
        border: 1.5px solid var(--ses-gray-200);
        border-radius: 10px;
        font-size: 0.87rem;
        font-weight: 500;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
    }
    .ses-btn-primary {
        flex: 2;
        height: 44px;
        background: var(--ses-red);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.87rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: background 0.15s;
    }
    .ses-btn-primary:hover { background: var(--ses-red-dark); }
    .ses-link { color: var(--ses-red); text-decoration: none; font-weight: 500; }
</style>
@endpush

@section('content')
<div class="reg-wrap">
    <div class="reg-card">
        <h2 class="reg-title">Student registration</h2>
        <p class="reg-subtitle">Fill in all required information to create your student account.</p>

        @if($errors->any())
            <div class="ses-alert error">
                <ul style="margin:0;padding-left:1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- PERSONAL INFORMATION --}}
            <div class="section-label">Personal Information</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="ses-label">First name *</label>
                    <input type="text" name="first_name" class="ses-input {{ $errors->has('first_name') ? 'is-error' : '' }}" placeholder="Juan" value="{{ old('first_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="ses-label">Last name *</label>
                    <input type="text" name="last_name" class="ses-input {{ $errors->has('last_name') ? 'is-error' : '' }}" placeholder="Dela Cruz" value="{{ old('last_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="ses-label">Middle name</label>
                    <input type="text" name="middle_name" class="ses-input" placeholder="Santos" value="{{ old('middle_name') }}">
                </div>
                <div class="col-md-6">
                    <label class="ses-label">Date of birth *</label>
                    <input type="date" name="date_of_birth" class="ses-input {{ $errors->has('date_of_birth') ? 'is-error' : '' }}" value="{{ old('date_of_birth') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="ses-label">Gender *</label>
                    <select name="gender" class="ses-select {{ $errors->has('gender') ? 'is-error' : '' }}" required>
                        <option value="">Select gender</option>
                        @foreach(['Male','Female','Other'] as $g)
                            <option value="{{ $g }}" {{ old('gender') == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="ses-label">Contact number *</label>
                    <input type="text" name="contact_number" class="ses-input {{ $errors->has('contact_number') ? 'is-error' : '' }}" placeholder="09xx xxx xxxx" value="{{ old('contact_number') }}" required>
                </div>
                <div class="col-12">
                    <label class="ses-label">Complete address *</label>
                    <input type="text" name="complete_address" class="ses-input {{ $errors->has('complete_address') ? 'is-error' : '' }}" placeholder="House no., street, barangay, city, province..." value="{{ old('complete_address') }}" required>
                </div>
            </div>

            {{-- ACCOUNT --}}
            <div class="section-label">Account Credentials</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="ses-label">Email address *</label>
                    <input type="email" name="email" class="ses-input {{ $errors->has('email') ? 'is-error' : '' }}" placeholder="student@school.edu.ph" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="ses-label">Password *</label>
                    <input type="password" name="password" class="ses-input {{ $errors->has('password') ? 'is-error' : '' }}" placeholder="Min. 8 characters" required>
                </div>
                <div class="col-md-6 offset-md-6">
                    <label class="ses-label">Confirm password *</label>
                    <input type="password" name="password_confirmation" class="ses-input" placeholder="Re-enter password" required>
                </div>
            </div>

            {{-- ACADEMIC --}}
            <div class="section-label">Academic Information</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="ses-label">Course / Program *</label>
                    <select name="course" class="ses-select {{ $errors->has('course') ? 'is-error' : '' }}" required>
                        <option value="">Select course</option>
                        @foreach(['BSIT','BSCS','BSECE','BSEE','BSCpE','BSME','BSCE'] as $c)
                            <option value="{{ $c }}" {{ old('course') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="ses-label">Year level *</label>
                    <select name="year_level" class="ses-select {{ $errors->has('year_level') ? 'is-error' : '' }}" required>
                        <option value="">Select year</option>
                        @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $y)
                            <option value="{{ $y }}" {{ old('year_level') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="ses-label">Student ID number</label>
                    <input type="text" class="ses-input" placeholder="Auto-generated" disabled>
                </div>
                <div class="col-md-6">
                    <label class="ses-label">ID photo</label>
                    <label class="id-photo-box" for="id_photo">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Click to upload
                    </label>
                    <input type="file" id="id_photo" name="id_photo" accept="image/*" style="display:none;">
                </div>
            </div>

            <div class="reg-actions">
                <button type="reset" class="ses-btn-outline">Clear form</button>
                <button type="submit" class="ses-btn-primary">Submit registration →</button>
            </div>
        </form>

        <p style="text-align:center;font-size:0.82rem;color:var(--ses-gray-400);margin-top:1.25rem;margin-bottom:0;">
            Already have an account? <a href="{{ route('login') }}" class="ses-link">Sign in here</a>
        </p>
    </div>
</div>
@endsection

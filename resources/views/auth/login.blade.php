@extends('layout.app')
@section('title', 'Login – EduEnroll')

@push('styles')
<style>
    body { background: var(--ses-red-deep) !important; }
    .login-wrap {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background:
            radial-gradient(circle at 20% 20%, rgba(192,57,43,0.4) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(150,40,27,0.5) 0%, transparent 50%),
            #7f1d1d;
    }
    .login-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem 2.25rem;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 24px 64px rgba(0,0,0,0.35);
    }
    .login-badge {
        width: 56px; height: 56px;
        background: var(--ses-red-light);
        border: 2px solid var(--ses-red-100);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
    }
    .login-badge svg { width: 26px; height: 26px; }
    .login-title {
        font-family: 'DM Serif Display', serif;
        font-size: 1.65rem;
        text-align: center;
        color: var(--ses-gray-900);
        margin-bottom: 0.2rem;
    }
    .login-subtitle {
        font-size: 0.8rem;
        color: var(--ses-gray-400);
        text-align: center;
        margin-bottom: 2rem;
    }
    .ses-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--ses-gray-600);
        margin-bottom: 5px;
    }
    .ses-input {
        width: 100%;
        height: 44px;
        border: 1.5px solid var(--ses-gray-200);
        border-radius: 10px;
        padding: 0 14px;
        font-size: 0.9rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--ses-gray-900);
        background: var(--ses-gray-50);
        outline: none;
        transition: border-color 0.15s;
    }
    .ses-input:focus { border-color: var(--ses-red); background: white; }
    .ses-input.is-error { border-color: var(--ses-red); }
    .ses-btn-primary {
        width: 100%;
        height: 46px;
        background: var(--ses-red);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: background 0.15s;
        margin-top: 0.25rem;
    }
    .ses-btn-primary:hover { background: var(--ses-red-dark); }
    .ses-link { color: var(--ses-red); text-decoration: none; font-weight: 500; }
    .ses-link:hover { color: var(--ses-red-dark); }
</style>
@endpush

@section('content')
<div class="login-wrap">
    <div class="login-card">
        <div class="login-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
        </div>
        <h1 class="login-title">Welcome back</h1>
        <p class="login-subtitle">Student Enrollment System — Davao Campus</p>

        @if($errors->any())
            <div class="ses-alert error" style="margin-bottom:1.25rem;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div style="margin-bottom:1rem;">
                <label class="ses-label">Email address</label>
                <input
                    type="email"
                    name="email"
                    class="ses-input {{ $errors->has('email') ? 'is-error' : '' }}"
                    placeholder="student@school.edu.ph"
                    value="{{ old('email') }}"
                    required>
            </div>

            <div style="margin-bottom:1.25rem;">
                <label class="ses-label" style="display:flex;justify-content:space-between;align-items:center;">
                    Password
                    <a href="#" class="ses-link" style="font-size:0.75rem;text-transform:none;letter-spacing:0;">Forgot password?</a>
                </label>
                <input
                    type="password"
                    name="password"
                    class="ses-input {{ $errors->has('password') ? 'is-error' : '' }}"
                    placeholder="••••••••"
                    required>
            </div>

            <button type="submit" class="ses-btn-primary">Sign in →</button>
        </form>

        <p style="text-align:center;font-size:0.82rem;color:var(--ses-gray-400);margin-top:1.25rem;margin-bottom:0;">
            Don't have an account? <a href="{{ route('register') }}" class="ses-link">Register here</a>
        </p>
    </div>
</div>
@endsection

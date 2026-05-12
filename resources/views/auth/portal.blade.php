@extends('layout.app')
@section('title', 'EduEnroll')

@push('styles')
<style>
    body { background: #ffffff !important; }
    .ses-body {
        padding-top: 0;
        padding-bottom: 0;
    }
    .portal-page {
        min-height: 100vh;
        background: #ffffff;
        border-top: 5px solid var(--ses-red);
        display: flex;
        flex-direction: column;
    }
    .portal-header {
        height: 112px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 3.5rem;
        background: #ffffff;
        box-shadow: 0 8px 22px rgba(15, 39, 71, 0.08);
    }
    .portal-logo {
        display: flex;
        align-items: baseline;
        gap: 0.7rem;
        text-decoration: none;
    }
    .portal-logo-main {
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 2.25rem;
        line-height: 1;
        color: var(--ses-red);
        font-weight: 700;
    }
    .portal-logo-sub {
        color: var(--ses-text-muted);
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .portal-nav {
        display: flex;
        align-items: center;
        gap: 2.4rem;
    }
    .portal-nav a {
        color: #6887b6;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 600;
    }
    .portal-nav a:hover {
        color: var(--ses-red);
    }
    .portal-login-btn {
        min-width: 116px;
        height: 48px;
        background: var(--ses-red);
        color: #ffffff !important;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(214, 47, 58, 0.2);
    }
    .portal-login-btn:hover {
        background: var(--ses-red-hover);
    }
    .portal-main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.5rem 4rem;
    }
    .portal-content {
        width: 100%;
        max-width: 540px;
        text-align: center;
        margin-top: 1.5rem;
    }
    .portal-brand {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4rem;
    }
    .portal-brand-name {
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 4.3rem;
        line-height: 0.9;
        color: var(--ses-red);
        font-weight: 700;
    }
    .portal-options {
        display: grid;
        gap: 1.1rem;
    }
    .portal-option {
        display: block;
        width: 100%;
        min-height: 126px;
        padding: 1.45rem 1.5rem;
        border: 1.5px solid #9db1cf;
        border-radius: 5px;
        text-decoration: none;
        color: #6f87a5;
        background: #ffffff;
        transition: border-color 0.16s ease, box-shadow 0.16s ease, transform 0.16s ease;
    }
    .portal-option:hover {
        color: #6f87a5;
        border-color: var(--ses-red);
        box-shadow: 0 12px 28px rgba(15, 39, 71, 0.1);
        transform: translateY(-1px);
    }
    .portal-option-title {
        display: block;
        color: #7389a3;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.7rem;
    }
    .portal-option-text {
        display: block;
        max-width: 360px;
        margin: 0 auto;
        color: #6d86ab;
        font-size: 0.94rem;
        font-weight: 600;
        line-height: 1.35;
    }
    .portal-footer-line {
        height: 10px;
        background: var(--ses-navy);
    }
    @media (max-width: 820px) {
        .portal-header {
            height: auto;
            min-height: 96px;
            padding: 1.2rem 1.25rem;
            align-items: flex-start;
            gap: 1rem;
        }
        .portal-nav {
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .portal-nav a:not(.portal-login-btn) {
            display: none;
        }
        .portal-logo-main {
            font-size: 1.9rem;
        }
        .portal-brand { margin-bottom: 2.5rem; }
        .portal-brand-name {
            font-size: 3.15rem;
        }
    }
    @media (max-width: 480px) {
        .portal-header {
            flex-direction: column;
            align-items: stretch;
        }
        .portal-logo {
            justify-content: center;
        }
        .portal-nav {
            justify-content: center;
        }
        .portal-login-btn {
            width: 100%;
        }
        .portal-main {
            align-items: flex-start;
            padding-top: 3.5rem;
        }
        .portal-brand-name {
            font-size: 2.7rem;
        }
        .portal-option {
            min-height: 118px;
            padding: 1.25rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="portal-page">
    <header class="portal-header">
        <a href="{{ route('portal') }}" class="portal-logo">
            <span class="portal-logo-main">EduEnroll</span>
            <span class="portal-logo-sub">Tagum Campus</span>
        </a>
        <nav class="portal-nav" aria-label="Portal navigation">
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('contact') }}">Contact Us</a>
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}" class="portal-login-btn">Login</a>
        </nav>
    </header>

    <main class="portal-main">
        <div class="portal-content">
            <div class="portal-brand" aria-label="EduEnroll">
                <span class="portal-brand-name">EduEnroll</span>
            </div>

            <div class="portal-options">
                <a href="{{ route('admin.login') }}" class="portal-option">
                    <span class="portal-option-title">Admin Portal</span>
                    <span class="portal-option-text">Access your administrator account.</span>
                </a>

                <a href="{{ route('login') }}" class="portal-option">
                    <span class="portal-option-title">Student Portal</span>
                    <span class="portal-option-text">Sign in to your student account or create a new account.</span>
                </a>
            </div>
        </div>
    </main>

    <div class="portal-footer-line"></div>
</div>
@endsection

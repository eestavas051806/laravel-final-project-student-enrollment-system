@extends('layout.app')
@section('title', 'About Us - EduEnroll')

@push('styles')
<style>
    body { background: #ffffff !important; }
    .ses-body { padding-top: 0; padding-bottom: 0; }
    .public-page {
        min-height: 100vh;
        background: #ffffff;
        border-top: 5px solid var(--ses-red);
        display: flex;
        flex-direction: column;
    }
    .public-header {
        height: 112px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 3.5rem;
        background: #ffffff;
        box-shadow: 0 8px 22px rgba(15, 39, 71, 0.08);
    }
    .public-logo {
        display: flex;
        align-items: baseline;
        gap: 0.7rem;
        text-decoration: none;
    }
    .public-logo-main {
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 2.25rem;
        line-height: 1;
        color: var(--ses-red);
        font-weight: 700;
    }
    .public-logo-sub {
        color: var(--ses-text-muted);
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .public-nav {
        display: flex;
        align-items: center;
        gap: 2.4rem;
    }
    .public-nav a {
        color: #6887b6;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 600;
    }
    .public-nav a:hover,
    .public-nav a.active {
        color: var(--ses-red);
    }
    .public-login-btn {
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
    .public-login-btn:hover { background: var(--ses-red-hover); }
    .public-main {
        flex: 1;
        width: 100%;
        max-width: 1080px;
        margin: 0 auto;
        padding: 4.5rem 1.5rem 5rem;
    }
    .public-kicker {
        color: var(--ses-red);
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }
    .public-title {
        max-width: 760px;
        margin: 0.75rem 0 1rem;
        color: var(--ses-navy);
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 3.4rem;
        line-height: 1;
    }
    .public-lead {
        max-width: 760px;
        margin: 0;
        color: var(--ses-text-soft);
        font-size: 1.05rem;
        line-height: 1.75;
    }
    .about-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
        margin-top: 2.5rem;
    }
    .about-card {
        min-height: 180px;
        padding: 1.35rem;
        border: 1px solid var(--ses-border);
        border-radius: 8px;
        background: var(--ses-gray-50);
        box-shadow: var(--ses-shadow-sm);
    }
    .about-card h2 {
        margin: 0 0 0.65rem;
        color: var(--ses-navy);
        font-size: 1.05rem;
        font-weight: 800;
    }
    .about-card p {
        margin: 0;
        color: var(--ses-text-soft);
        font-size: 0.92rem;
        line-height: 1.65;
    }
    .public-footer-line { height: 10px; background: var(--ses-navy); }
    @media (max-width: 820px) {
        .public-header {
            height: auto;
            min-height: 96px;
            padding: 1.2rem 1.25rem;
            align-items: flex-start;
            gap: 1rem;
        }
        .public-nav {
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .public-nav a:not(.public-login-btn) { display: none; }
        .public-logo-main { font-size: 1.9rem; }
        .public-title { font-size: 2.55rem; }
        .about-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .public-header {
            flex-direction: column;
            align-items: stretch;
        }
        .public-logo,
        .public-nav { justify-content: center; }
        .public-login-btn { width: 100%; }
        .public-main { padding-top: 3.25rem; }
    }
</style>
@endpush

@section('content')
<div class="public-page">
    <header class="public-header">
        <a href="{{ route('portal') }}" class="public-logo">
            <span class="public-logo-main">EduEnroll</span>
            <span class="public-logo-sub">Tagum Campus</span>
        </a>
        <nav class="public-nav" aria-label="Public navigation">
            <a href="{{ route('about') }}" class="active">About Us</a>
            <a href="{{ route('contact') }}">Contact Us</a>
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}" class="public-login-btn">Login</a>
        </nav>
    </header>

    <main class="public-main">
        <span class="public-kicker">About Us</span>
        <h1 class="public-title">Simple enrollment for Tagum Campus students.</h1>
        <p class="public-lead">
            EduEnroll helps students create an account, browse available subjects, submit enrollment requests,
            and track their enrollment status in one organized portal. It also gives administrators a clear
            workspace for managing students, subjects, and enrollment records.
        </p>

        <section class="about-grid" aria-label="EduEnroll services">
            <article class="about-card">
                <h2>Student Access</h2>
                <p>Students can register, sign in, view subject offerings, and submit enrollment requests without needing manual paper forms.</p>
            </article>
            <article class="about-card">
                <h2>Admin Management</h2>
                <p>Administrators can review student profiles, approve enrollment submissions, and keep subject information updated.</p>
            </article>
            <article class="about-card">
                <h2>Campus Workflow</h2>
                <p>The system is built around EduEnroll Tagum Campus enrollment needs, from subject browsing to enrollment status monitoring.</p>
            </article>
        </section>
    </main>

    <div class="public-footer-line"></div>
</div>
@endsection

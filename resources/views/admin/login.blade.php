<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – EduEnroll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            margin: 0;
            background:
                radial-gradient(ellipse 90% 70% at 15% -10%, rgba(196, 61, 61, 0.09) 0%, transparent 55%),
                radial-gradient(ellipse 80% 60% at 100% 100%, rgba(233, 228, 218, 0.95) 0%, transparent 55%),
                var(--ses-bg-page);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;
        }
        .login-card {
            background: var(--ses-bg); border-radius: var(--ses-radius-lg);
            padding: 2.5rem 2.25rem;
            width: 100%; max-width: 400px;
            border: 1px solid var(--ses-border);
            box-shadow: var(--ses-shadow-md);
        }
        .admin-badge {
            width: 56px; height: 56px; background: var(--ses-beige);
            border-radius: 16px; border: 1px solid var(--ses-border);
            display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;
        }
        .login-title { font-family: 'DM Serif Display', Georgia, serif; font-size: 1.65rem; text-align: center; color: var(--ses-text); margin-bottom: 0.25rem; }
        .login-sub { font-size: 0.8rem; color: var(--ses-text-muted); text-align: center; margin-bottom: 2rem; }
        .admin-tag {
            display: inline-block; background: var(--ses-red-soft); color: var(--ses-red-muted);
            font-size: 0.68rem; font-weight: 700; padding: 4px 12px; border-radius: 999px;
            letter-spacing: 0.06em;
        }
        .ses-label { display: block; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.06em; color: var(--ses-text-soft); margin-bottom: 6px; }
        .ses-input {
            width: 100%; height: 44px; border: 1.5px solid var(--ses-border); border-radius: var(--ses-radius-sm);
            padding: 0 14px; font-size: 0.9rem; font-family: inherit;
            color: var(--ses-text); background: var(--ses-beige); outline: none; transition: border-color 0.15s, box-shadow 0.15s;
        }
        .ses-input:focus { border-color: rgba(196, 61, 61, 0.45); background: var(--ses-bg); box-shadow: 0 0 0 3px rgba(196, 61, 61, 0.08); }
        .ses-btn { width: 100%; height: 46px; background: var(--ses-red); color: white; border: none; border-radius: var(--ses-radius-sm); font-size: 0.9rem; font-weight: 600; cursor: pointer; font-family: inherit; transition: background 0.15s; margin-top: 0.35rem; }
        .ses-btn:hover { background: var(--ses-red-hover); }
        .back-link { display: block; text-align: center; font-size: 0.8rem; color: var(--ses-text-muted); margin-top: 1.25rem; text-decoration: none; font-weight: 500; }
        .back-link:hover { color: var(--ses-red); }
        .err-box { background: var(--ses-red-soft); border: 1px solid var(--ses-red-100); color: var(--ses-red-deep); padding: 0.75rem 1rem; border-radius: var(--ses-radius-sm); font-size: 0.85rem; margin-bottom: 1.25rem; }
    </style>
</head>
<body>
<div class="login-card">
    <div style="text-align:center;">
        <div class="admin-badge">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#c43d3d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
        </div>
        <span class="admin-tag">Admin Access</span>
    </div>
    <h1 class="login-title">Admin Panel</h1>
    <p class="login-sub">EduEnroll – Student Enrollment System</p>

    @if($errors->any())
        <div class="err-box">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <form action="{{ route('admin.login.post') }}" method="POST">
        @csrf
        <div style="margin-bottom:1rem;">
            <label class="ses-label">Email address</label>
            <input type="email" name="email" class="ses-input" placeholder="admin@eduenroll.edu.ph" value="{{ old('email') }}" required>
        </div>
        <div style="margin-bottom:1.25rem;">
            <label class="ses-label">Password</label>
            <input type="password" name="password" class="ses-input" placeholder="••••••••" required>
        </div>
        <button type="submit" class="ses-btn">Sign in as Admin →</button>
    </form>
    <a href="{{ route('login') }}" class="back-link">← Back to student login</a>
</div>
</body>
</html>

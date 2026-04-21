<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – EduEnroll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --ses-red: #c0392b; --ses-red-dark: #96281b; --ses-red-deep: #7f1d1d; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(192,57,43,0.4) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(150,40,27,0.5) 0%, transparent 50%), #7f1d1d;
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;
        }
        .login-card {
            background: white; border-radius: 20px; padding: 2.5rem 2.25rem;
            width: 100%; max-width: 400px; box-shadow: 0 24px 64px rgba(0,0,0,0.35);
        }
        .admin-badge {
            width: 56px; height: 56px; background: #fef2f2; border: 2px solid #fecaca;
            border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;
        }
        .login-title { font-family: 'DM Serif Display', serif; font-size: 1.6rem; text-align: center; color: #111827; margin-bottom: 0.2rem; }
        .login-sub { font-size: 0.78rem; color: #9ca3af; text-align: center; margin-bottom: 2rem; }
        .admin-tag {
            display: inline-block; background: #fee2e2; color: var(--ses-red);
            font-size: 0.68rem; font-weight: 700; padding: 2px 10px; border-radius: 20px;
            text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;
        }
        .ses-label { display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #4b5563; margin-bottom: 5px; }
        .ses-input {
            width: 100%; height: 44px; border: 1.5px solid #e5e7eb; border-radius: 10px;
            padding: 0 14px; font-size: 0.9rem; font-family: 'DM Sans', sans-serif;
            color: #111827; background: #fafafa; outline: none; transition: border-color 0.15s;
        }
        .ses-input:focus { border-color: var(--ses-red); background: white; }
        .ses-btn { width: 100%; height: 46px; background: var(--ses-red); color: white; border: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background 0.15s; margin-top: 0.25rem; }
        .ses-btn:hover { background: var(--ses-red-dark); }
        .back-link { display: block; text-align: center; font-size: 0.8rem; color: #9ca3af; margin-top: 1rem; text-decoration: none; }
        .back-link:hover { color: var(--ses-red); }
    </style>
</head>
<body>
<div class="login-card">
    <div style="text-align:center;">
        <div class="admin-badge">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#c0392b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
        </div>
        <span class="admin-tag">Admin Access</span>
    </div>
    <h1 class="login-title">Admin Panel</h1>
    <p class="login-sub">EduEnroll – Student Enrollment System</p>

    @if($errors->any())
        <div style="background:#fee2e2;border:1px solid #fecaca;color:#b91c1c;padding:0.75rem 1rem;border-radius:10px;font-size:0.85rem;margin-bottom:1.25rem;">
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

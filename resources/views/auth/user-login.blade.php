@extends('layouts.app')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #0b1221;
            --panel: #111a2f;
            --primary: #4fd1c5;
            --accent: #8b5cf6;
            --text: #e5e7eb;
            --muted: #9ca3af;
            --border: #1f2937;
        }
        body {
            background: radial-gradient(circle at 20% 20%, rgba(79, 209, 197, 0.12), transparent 25%),
                        radial-gradient(circle at 80% 0%, rgba(139, 92, 246, 0.14), transparent 25%),
                        linear-gradient(135deg, #070c18 0%, #0e1324 60%, #0b1221 100%);
            color: var(--text);
            font-family: 'Inter', 'Figtree', system-ui, -apple-system, sans-serif;
        }
        .auth-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 30px 18px;
            position: relative;
            overflow: hidden;
        }
        .bg-3d {
            position: absolute;
            inset: 0;
            pointer-events: none;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.25));
        }
        .bg-3d::before {
            content: '';
            position: absolute;
            inset: -120px -80px;
            background: repeating-linear-gradient(
                0deg,
                rgba(79, 209, 197, 0.08) 0,
                rgba(79, 209, 197, 0.08) 1px,
                transparent 1px,
                transparent 34px
            ),
            repeating-linear-gradient(
                90deg,
                rgba(139, 92, 246, 0.08) 0,
                rgba(139, 92, 246, 0.08) 1px,
                transparent 1px,
                transparent 34px
            );
            transform: perspective(900px) rotateX(68deg) skewY(-8deg) translateY(-40px);
            opacity: 0.8;
            filter: blur(0.5px);
        }
        .orb {
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.65;
            animation: float 14s ease-in-out infinite;
        }
        .orb-1 {
            background: radial-gradient(circle, rgba(79, 209, 197, 0.6), transparent 60%);
            top: -60px;
            left: -40px;
        }
        .orb-2 {
            background: radial-gradient(circle, rgba(139, 92, 246, 0.5), transparent 65%);
            bottom: -80px;
            right: -20px;
            animation-delay: 3s;
        }
        .orb-3 {
            background: radial-gradient(circle, rgba(59, 130, 246, 0.5), transparent 60%);
            top: 20%;
            right: 45%;
            width: 240px;
            height: 240px;
            animation-delay: 6s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(18px) translateX(12px); }
        }
        .auth-card {
            width: min(1100px, 100%);
            background: rgba(17, 26, 47, 0.9);
            border: 1px solid var(--border);
            border-radius: 18px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            overflow: hidden;
            box-shadow: 0 18px 48px rgba(0, 0, 0, 0.35);
            position: relative;
            z-index: 1;
        }
        .auth-aside {
            padding: 32px;
            background: linear-gradient(180deg, rgba(17, 26, 47, 0.85), rgba(17, 26, 47, 0.6));
            border-right: 1px solid var(--border);
            display: grid;
            gap: 14px;
        }
        .auth-aside .logo {
            height: 46px;
            width: 46px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: grid;
            place-items: center;
            font-weight: 800;
            color: #0b1221;
            box-shadow: 0 10px 30px rgba(79, 209, 197, 0.35);
        }
        .auth-aside h1 {
            margin: 0;
            font-size: 26px;
            line-height: 1.25;
        }
        .auth-aside p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }
        .auth-highlights {
            display: grid;
            gap: 10px;
            margin-top: 12px;
        }
        .chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            color: var(--text);
            font-weight: 600;
            width: fit-content;
        }
        .chip small {
            font-weight: 500;
            color: var(--muted);
        }
        .auth-form {
            padding: 34px 32px 38px;
            display: grid;
            gap: 16px;
        }
        .auth-form header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }
        .auth-form h2 { margin: 0; font-size: 24px; }
        .auth-form a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .auth-form a:hover { color: #6ee7d0; }
        .form-field {
            display: grid;
            gap: 8px;
        }
        label { font-weight: 600; color: var(--text); }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text);
            font-size: 15px;
        }
        input::placeholder { color: var(--muted); }
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        button[type="submit"] {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #0b1221;
            border: none;
            border-radius: 12px;
            padding: 12px 18px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(79, 209, 197, 0.35);
        }
        button[type="submit"]:hover { transform: translateY(-1px); }
        .alert {
            padding: 14px;
            border-radius: 12px;
            border: 1px solid;
            font-weight: 600;
        }
        .alert-success { color: #34d399; background: rgba(52, 211, 153, 0.1); border-color: rgba(52, 211, 153, 0.35); }
        .alert-error { color: #fca5a5; background: rgba(248, 113, 113, 0.08); border-color: rgba(248, 113, 113, 0.3); }
        ul { margin: 0; padding-left: 18px; }
        @media (max-width: 720px) {
            .auth-aside { border-right: none; border-bottom: 1px solid var(--border); }
            .auth-form header { flex-direction: column; align-items: flex-start; }
            .auth-card { box-shadow: 0 10px 26px rgba(0, 0, 0, 0.35); }
        }
    </style>

    <div class="auth-shell">
        <div class="bg-3d">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
        </div>
        <div class="auth-card">
            <div class="auth-aside">
                <div class="logo">TB</div>
                <h1>Welcome back to Tenant Billing System</h1>
                <p>Stay on top of rent schedules, invoices, and tenant communications with the same modern experience from the homepage.</p>
                <div class="auth-highlights">
                    <div class="chip">Real-time balances <small>Track outstanding dues instantly</small></div>
                    <div class="chip">Secure access <small>Protected account sessions</small></div>
                    <div class="chip">Fast payments <small>Log in and settle invoices quickly</small></div>
                </div>
            </div>
            <div class="auth-form">
                <header>
                    <h2>Sign in</h2>
                    <a href="/">Back to welcome</a>
                </header>

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-field">
                        <label for="email">Email address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                    </div>

                    <div class="form-field">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit">Log in</button>
                        <a href="{{ route('register') }}">Create account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

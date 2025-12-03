@extends('layouts.app')

@section('content')
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
            background: radial-gradient(circle at 20% 20%, rgba(79, 209, 197, 0.08), transparent 25%),
                        radial-gradient(circle at 80% 0%, rgba(139, 92, 246, 0.08), transparent 25%),
                        var(--bg);
            color: var(--text);
            font-family: 'Inter', 'Figtree', system-ui, -apple-system, sans-serif;
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 40px 18px;
        }

        .auth-card {
            width: min(520px, 100%);
            background: rgba(17, 26, 47, 0.9);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 18px 48px rgba(0, 0, 0, 0.35);
            display: grid;
            gap: 18px;
        }

        .auth-card h2 {
            margin: 0;
            font-size: 26px;
            text-align: center;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text);
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text);
            font-size: 15px;
        }

        input::placeholder {
            color: var(--muted);
        }

        .alert {
            padding: 14px;
            border-radius: 12px;
            border: 1px solid;
            font-weight: 600;
        }

        .alert-error {
            color: #fca5a5;
            background: rgba(248, 113, 113, 0.08);
            border-color: rgba(248, 113, 113, 0.3);
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #0b1221;
            border: none;
            border-radius: 12px;
            padding: 12px 18px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(79, 209, 197, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
        }
    </style>

    <div class="auth-shell">
        <div class="auth-card">
            <h2>Admin Login</h2>

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="form-field">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
                </div>

                <div class="form-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                </div>

                <div>
                    <button type="submit" class="btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection

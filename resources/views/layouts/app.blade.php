<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tenant Billing System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600;inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        :root {
            --bg: #0b1220;
            --surface: #0f172a;
            --surface-hover: #17223b;
            --border: #1f2a44;
            --muted: #94a3b8;
            --text: #e2e8f0;
            --primary: #f97316;
            --primary-strong: #ea580c;
            --accent: #3b82f6;
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --radius: 16px;
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Figtree', system-ui, -apple-system, sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.08), transparent 25%),
                        radial-gradient(circle at 80% 0%, rgba(249, 115, 22, 0.12), transparent 30%),
                        var(--bg);
            color: var(--text);
            min-height: 100vh;
            margin: 0;
        }

        a { color: inherit; text-decoration: none; }

        .page-shell {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px 48px;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 28px;
            margin: 0 0 6px;
        }

        .page-header p { margin: 0; color: var(--muted); }

        .header-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

        .panel {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.8) 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }

        .panel + .panel { margin-top: 16px; }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .panel-title { font-size: 18px; margin: 0; }
        .panel-sub { color: var(--muted); font-size: 14px; margin: 0; }

        .text-right { text-align: right; }

        .table-wrapper { overflow-x: auto; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid transparent;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
            color: white;
            box-shadow: 0 12px 30px rgba(249, 115, 22, 0.35);
        }

        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 14px 36px rgba(249, 115, 22, 0.45); }

        .btn-secondary {
            background: var(--surface-hover);
            color: var(--text);
            border-color: var(--border);
        }

        .btn-secondary:hover { border-color: var(--muted); }

        .btn-ghost {
            background: transparent;
            border-color: var(--border);
            color: var(--muted);
        }

        .muted-link { color: var(--muted); }
        .muted-link:hover { color: var(--text); }

        .alert { padding: 12px 14px; border-radius: 12px; margin-bottom: 12px; border: 1px solid transparent; }
        .alert-success { background: rgba(34, 197, 94, 0.08); border-color: rgba(34, 197, 94, 0.25); color: #bbf7d0; }
        .alert-error { background: rgba(239, 68, 68, 0.08); border-color: rgba(239, 68, 68, 0.25); color: #fecdd3; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { text-align: left; font-size: 13px; color: var(--muted); padding: 10px 0; border-bottom: 1px solid var(--border); }
        .data-table td { padding: 12px 0; border-bottom: 1px solid var(--border); }
        .data-table tr:hover td { background: rgba(255, 255, 255, 0.02); }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.01em;
            border: 1px solid transparent;
        }

        .status-paid { background: rgba(34, 197, 94, 0.12); color: #86efac; border-color: rgba(34, 197, 94, 0.3); }
        .status-overdue { background: rgba(239, 68, 68, 0.12); color: #fecdd3; border-color: rgba(239, 68, 68, 0.3); }
        .status-pending { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border-color: rgba(245, 158, 11, 0.35); }
        .status-info { background: rgba(59, 130, 246, 0.12); color: #bfdbfe; border-color: rgba(59, 130, 246, 0.3); }

        .table-actions { display: flex; gap: 10px; align-items: center; }

        .form-grid { display: grid; gap: 16px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        .form-control label { display: block; margin-bottom: 6px; color: var(--muted); font-size: 13px; font-weight: 600; }
        .form-control input,
        .form-control select,
        .form-control textarea {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--surface-hover);
            color: var(--text);
            font-size: 14px;
        }

        .form-control textarea { min-height: 120px; resize: vertical; }

        .meta-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; }
        .pill {
            padding: 10px 12px;
            border-radius: 12px;
            background: var(--surface-hover);
            border: 1px solid var(--border);
            color: var(--muted);
            font-size: 13px;
        }

        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border);
            color: var(--muted);
            font-weight: 600;
            font-size: 13px;
        }

        .card-grid { display: grid; gap: 14px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin-top: 8px; }
        .info-card { padding: 16px; border-radius: 14px; border: 1px solid var(--border); background: var(--surface-hover); }
        .info-card small { color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em; }
        .info-card strong { display: block; margin-top: 6px; font-size: 20px; }

        @media (max-width: 720px) {
            .page-header { flex-direction: column; align-items: flex-start; }
            .panel { padding: 18px 16px; }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <main>
        @yield('content')
    </main>
</body>
</html>

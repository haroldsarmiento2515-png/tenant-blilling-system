<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tenant Billing System</title>
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
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(79, 209, 197, 0.08), transparent 25%),
                        radial-gradient(circle at 80% 0%, rgba(139, 92, 246, 0.08), transparent 25%),
                        var(--bg);
            color: var(--text);
            min-height: 100vh;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 28px;
            max-width: 1180px;
            margin: 0 auto;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            letter-spacing: 0.2px;
            color: var(--text);
            text-decoration: none;
        }
        .logo {
            height: 44px;
            width: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: grid;
            place-items: center;
            font-weight: 800;
            color: #0b1221;
            box-shadow: 0 10px 30px rgba(79, 209, 197, 0.35);
        }
        nav { display: flex; gap: 16px; align-items: center; }
        nav a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        nav a:hover { color: var(--text); }
        .btn {
            padding: 12px 18px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: #0b1221;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            box-shadow: 0 8px 24px rgba(79, 209, 197, 0.35);
            text-decoration: none;
        }
        .btn.secondary {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
            box-shadow: none;
        }
        main { max-width: 1180px; margin: 0 auto; padding: 40px 28px 72px; }
        .hero {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
            align-items: center;
        }
        .tag {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(79, 209, 197, 0.1);
            color: var(--primary);
            font-weight: 600;
            border: 1px solid rgba(79, 209, 197, 0.2);
        }
        h1 {
            font-size: clamp(32px, 5vw, 46px);
            margin: 14px 0 14px;
            line-height: 1.15;
            letter-spacing: -0.8px;
        }
        p.lead {
            color: var(--muted);
            font-size: 17px;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .hero-card {
            background: linear-gradient(180deg, rgba(17, 26, 47, 0.75), rgba(17, 26, 47, 0.45));
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: grid;
            gap: 18px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.25);
        }
        .stat {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
        }
        .stat h3 { margin: 0; font-size: 15px; color: var(--muted); }
        .stat p { margin: 8px 0 0; font-size: 22px; font-weight: 700; }
        .grid { display: grid; gap: 18px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-top: 48px; }
        .feature {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            background: rgba(17, 26, 47, 0.8);
        }
        .feature h3 { margin: 8px 0; }
        .feature p { margin: 6px 0 0; color: var(--muted); line-height: 1.6; }
        .cta {
            margin-top: 50px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }
        footer {
            border-top: 1px solid var(--border);
            padding: 20px 28px 30px;
            color: var(--muted);
            max-width: 1180px;
            margin: 0 auto;
        }
        @media (max-width: 640px) {
            header { padding: 20px 18px; }
            main { padding: 28px 18px 56px; }
        }
    </style>
</head>
<body>
<header>
    <a class="brand" href="/">
        <span class="logo">TB</span>
        <span>Tenant Billing System</span>
    </a>
    <nav>
        <a href="#features">Features</a>
        <a href="#security">Security</a>
        <a href="#automation">Automation</a>
        <a class="btn secondary" href="{{ route('login') }}">Login</a>
        <a class="btn" href="{{ route('register') }}">Get Started</a>
    </nav>
</header>
<main>
    <section class="hero">
        <div>
            <span class="tag">Modern tenant billing without the chaos</span>
            <h1>Streamline invoices, track payments, and keep every tenant informed.</h1>
            <p class="lead">
                Tenant Billing System centralizes rent schedules, automates reminders, and gives you visibility into every property—so you can focus on delivering great service instead of chasing spreadsheets.
            </p>
            <div class="cta">
                <a class="btn" href="{{ route('register') }}">Create an account</a>
                <a class="btn secondary" href="{{ route('login') }}">I already have an account</a>
            </div>
        </div>
        <div class="hero-card">
            <div class="stat">
                <h3>On-time collections</h3>
                <p>92% of invoices paid before due date</p>
            </div>
            <div class="stat">
                <h3>Portfolio coverage</h3>
                <p>Multi-property, multi-tenant dashboards</p>
            </div>
            <div class="stat">
                <h3>Automation</h3>
                <p>Rent reminders, late fees, and receipts</p>
            </div>
        </div>
    </section>
    <section id="features" class="grid">
        <div class="feature">
            <h3>Unified tenant profiles</h3>
            <p>Centralize lease terms, billing contacts, and payment history with quick search and filtering for every unit.</p>
        </div>
        <div class="feature">
            <h3>Smart billing workflows</h3>
            <p>Generate recurring invoices, apply late fees automatically, and send branded statements in a few clicks.</p>
        </div>
        <div class="feature">
            <h3 id="automation">Automated reminders</h3>
            <p>Schedule SMS and email nudges for upcoming rent, overdue balances, and expiring leases—no manual follow-ups.</p>
        </div>
        <div class="feature">
            <h3 id="security">Secure payments</h3>
            <p>Give tenants trusted payment options while keeping sensitive billing data encrypted and access-controlled.</p>
        </div>
    </section>
</main>
<footer>
    <div>Built for property teams who want clearer cash flow, faster collections, and happier tenants.</div>
</footer>
</body>
</html>

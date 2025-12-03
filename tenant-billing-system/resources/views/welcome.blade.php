<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tenant Billing System') }} - Simplify Your Property Management</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #10b981;
            --accent-hover: #059669;
            --accent-glow: rgba(16, 185, 129, 0.3);
            --text: #f8fafc;
            --text-muted: #94a3b8;
            --surface: #1e293b;
            --surface-hover: #334155;
            --border: #334155;
            --gradient-start: #0f172a;
            --gradient-end: #1e293b;
        }
        
        html { scroll-behavior: smooth; }
        
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* Animated Background */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
            background-image: 
                radial-gradient(circle at 20% 50%, var(--accent-glow) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 40% 80%, rgba(236, 72, 153, 0.1) 0%, transparent 40%);
        }
        
        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            position: relative;
            z-index: 1;
        }
        
        /* Navigation */
        nav {
            padding: 1.5rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            backdrop-filter: blur(12px);
            background: rgba(15, 23, 42, 0.8);
            border-bottom: 1px solid var(--border);
        }
        
        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text);
            text-decoration: none;
        }
        
        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px var(--accent-glow);
        }
        
        .logo-icon svg {
            width: 24px;
            height: 24px;
            color: white;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: var(--accent);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 20px var(--accent-glow);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px var(--accent-glow);
        }
        
        .btn-secondary {
            background: var(--surface);
            color: var(--text);
            border: 1px solid var(--border);
        }
        
        .btn-secondary:hover {
            background: var(--surface-hover);
            border-color: var(--accent);
        }
        
        /* Hero Section */
        .hero {
            padding: 10rem 0 6rem;
            text-align: center;
            position: relative;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 100px;
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            animation: fadeInUp 0.6s ease;
        }
        
        .hero-badge span {
            color: var(--accent);
            font-weight: 600;
        }
        
        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.6s ease 0.1s both;
        }
        
        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--accent) 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            animation: fadeInUp 0.6s ease 0.2s both;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 0.6s ease 0.3s both;
        }
        
        /* Stats */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
            padding: 4rem 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            margin: 4rem 0;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            color: var(--text-muted);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        /* Features Section */
        .features {
            padding: 6rem 0;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .section-header p {
            color: var(--text-muted);
            font-size: 1.125rem;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }
        
        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #34d399);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px var(--accent-glow);
        }
        
        .feature-icon svg {
            width: 28px;
            height: 28px;
            color: white;
        }
        
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .feature-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
        }
        
        /* How It Works */
        .how-it-works {
            padding: 6rem 0;
            background: var(--surface);
            border-radius: 40px;
            margin: 4rem 0;
        }
        
        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .step {
            text-align: center;
            position: relative;
        }
        
        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 20px var(--accent-glow);
        }
        
        .step h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .step p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        /* CTA Section */
        .cta {
            padding: 6rem 0;
            text-align: center;
        }
        
        .cta-box {
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            border-radius: 30px;
            padding: 4rem 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .cta-box::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        }
        
        .cta-box h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
        }
        
        .cta-box p {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }
        
        .cta-box .btn {
            background: white;
            color: var(--accent);
            position: relative;
        }
        
        .cta-box .btn:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Footer */
        footer {
            padding: 3rem 0;
            border-top: 1px solid var(--border);
            text-align: center;
        }
        
        footer p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        
        footer a {
            color: var(--accent);
            text-decoration: none;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero {
                padding: 8rem 0 4rem;
            }
            
            .hero h1 {
                font-size: 2.25rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
            
            .stat-value {
                font-size: 2rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .how-it-works {
                border-radius: 24px;
                padding: 4rem 1.5rem;
            }
            
            .cta-box {
                padding: 3rem 1.5rem;
            }
            
            .cta-box h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>
    <div class="grid-overlay"></div>
    
    <!-- Navigation -->
    <nav>
        <div class="container nav-content">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                TenantBill
            </a>
            
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#how-it-works">How It Works</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Fast & Reliable</span> Billing Management
            </div>
            
            <h1>
                Simplify Your<br>
                <span class="highlight">Tenant Billing</span> Today
            </h1>
            
            <p>
                Streamline rent collection, automate payment reminders, and manage your properties with ease. The all-in-one solution for modern landlords.
            </p>
            
            <div class="hero-buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            Go to Dashboard
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Start Free Trial
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            Log in to Account
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </section>
    
    <!-- Stats -->
    <div class="container">
        <div class="stats">
            <div class="stat">
                <div class="stat-value">99%</div>
                <div class="stat-label">Uptime</div>
            </div>
            <div class="stat">
                <div class="stat-value">500+</div>
                <div class="stat-label">Properties</div>
            </div>
            <div class="stat">
                <div class="stat-value">₱2M+</div>
                <div class="stat-label">Processed</div>
            </div>
            <div class="stat">
                <div class="stat-value">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>
    </div>
    
    <!-- Features -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Powerful Features</h2>
                <p>Everything you need to manage your rental properties efficiently</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3>Automated Billing</h3>
                    <p>Generate and send invoices automatically each month. Save time and never miss a billing cycle again.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3>Tenant Management</h3>
                    <p>Keep all tenant information organized in one place. Track leases, contacts, and payment history effortlessly.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3>Payment Reminders</h3>
                    <p>Automated email and SMS reminders ensure tenants never forget their due dates. Reduce late payments significantly.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3>Reports & Analytics</h3>
                    <p>Get detailed insights into your rental income, payment trends, and tenant behavior with comprehensive reports.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3>Online Payments</h3>
                    <p>Accept payments online through multiple channels. Make it convenient for tenants to pay on time.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3>Secure & Reliable</h3>
                    <p>Your data is protected with enterprise-grade security. Reliable cloud infrastructure ensures 99.9% uptime.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-header">
                <h2>How It Works</h2>
                <p>Get started in just three simple steps</p>
            </div>
            
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Create Account</h3>
                    <p>Sign up for free and set up your property portfolio in minutes.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Add Tenants</h3>
                    <p>Import or manually add your tenants and their rental details.</p>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Start Billing</h3>
                    <p>Generate invoices and start collecting payments automatically.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-box">
                <h2>Ready to Get Started?</h2>
                <p>Join hundreds of property managers who trust TenantBill for their billing needs.</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn">
                        Create Free Account
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'TenantBill') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
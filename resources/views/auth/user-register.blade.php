<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'TenantBill') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- reCAPTCHA v2 Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
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
            --error: #ef4444;
            --error-bg: rgba(239, 68, 68, 0.1);
            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.1);
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
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
        
        /* Floating Elements */
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -100px;
            animation-delay: 0s;
        }
        
        .floating-shape:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: -50px;
            animation-delay: -2s;
        }
        
        .floating-shape:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 10%;
            animation-delay: -4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        /* Register Container */
        .register-container {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s ease;
        }
        
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
        
        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            text-decoration: none;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px var(--accent-glow);
        }
        
        .logo-icon svg {
            width: 28px;
            height: 28px;
            color: white;
        }
        
        .logo-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text);
        }
        
        /* Register Card */
        .register-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), #34d399);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .register-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .register-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text);
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            background: var(--primary);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        .form-input::placeholder {
            color: var(--text-muted);
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }
        
        .form-input.error {
            border-color: var(--error);
            box-shadow: 0 0 0 3px var(--error-bg);
        }
        
        /* Input with Icon */
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }
        
        .input-icon svg {
            width: 20px;
            height: 20px;
        }
        
        .form-input.with-icon {
            padding-left: 2.75rem;
        }
        
        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--accent);
        }
        
        .password-toggle svg {
            width: 20px;
            height: 20px;
        }
        
        /* Password Strength Indicator */
        .password-strength {
            margin-top: 0.5rem;
        }
        
        .strength-bar {
            height: 4px;
            background: var(--border);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }
        
        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-fill.weak { width: 33%; background: var(--error); }
        .strength-fill.medium { width: 66%; background: #f59e0b; }
        .strength-fill.strong { width: 100%; background: var(--accent); }
        
        .strength-text {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        .strength-text.weak { color: var(--error); }
        .strength-text.medium { color: #f59e0b; }
        .strength-text.strong { color: var(--accent); }
        
        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px var(--accent-glow);
            margin-top: 1.5rem;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px var(--accent-glow);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .btn-submit svg {
            width: 20px;
            height: 20px;
        }
        
        /* reCAPTCHA Container */
        .recaptcha-container {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }
        
        .recaptcha-container > div {
            transform: scale(0.95);
            transform-origin: center;
        }
        
        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }
        
        .login-link p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        .login-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .login-link a:hover {
            color: #34d399;
        }
        
        /* Error Messages */
        .error-message {
            background: var(--error-bg);
            border: 1px solid var(--error);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        
        .error-message svg {
            width: 20px;
            height: 20px;
            color: var(--error);
            flex-shrink: 0;
            margin-top: 1px;
        }
        
        .error-message ul {
            list-style: none;
            font-size: 0.875rem;
            color: var(--error);
        }
        
        .error-message li + li {
            margin-top: 0.25rem;
        }
        
        .field-error {
            font-size: 0.8rem;
            color: var(--error);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        /* Back to Home */
        .back-home {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }
        
        .back-home:hover {
            color: var(--accent);
        }
        
        .back-home svg {
            width: 18px;
            height: 18px;
        }
        
        /* Terms Text */
        .terms-text {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 1rem;
            line-height: 1.5;
        }
        
        .terms-text a {
            color: var(--accent);
            text-decoration: none;
        }
        
        .terms-text a:hover {
            text-decoration: underline;
        }
        
        /* Two Column Row */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        /* Mobile Responsive */
        @media (max-width: 540px) {
            .register-card {
                padding: 2rem 1.5rem;
            }
            
            .register-header h1 {
                font-size: 1.5rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .recaptcha-container > div {
                transform: scale(0.85);
            }
        }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>
    <div class="grid-overlay"></div>
    
    <!-- Floating Shapes -->
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    
    <div class="register-container">
        <!-- Logo -->
        <a href="/" class="logo">
            <div class="logo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="logo-text">TenantBill</span>
        </a>
        
        <!-- Register Card -->
        <div class="register-card">
            <div class="register-header">
                <h1>Create Account</h1>
                <p>Start managing your properties today</p>
            </div>
            
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="error-message">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-input with-icon @error('name') error @enderror" 
                            placeholder="Enter your full name"
                            value="{{ old('name') }}"
                            required 
                            autofocus
                        >
                    </div>
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input with-icon @error('email') error @enderror" 
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input with-icon @error('password') error @enderror" 
                            placeholder="Create a password"
                            required
                            onkeyup="checkPasswordStrength()"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="eye-off-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                        <span class="strength-text" id="strength-text"></span>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="form-input with-icon" 
                            placeholder="Confirm your password"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="eye-off-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- reCAPTCHA -->
                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-theme="dark"></div>
                </div>
                @error('g-recaptcha-response')
                    <span class="field-error" style="justify-content: center; margin-top: 0.5rem;">{{ $message }}</span>
                @enderror
                
                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    Create Account
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
                
                <!-- Terms Text -->
                <p class="terms-text">
                    By creating an account, you agree to our<br>
                    <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </p>
            </form>
            
            <!-- Login Link -->
            <div class="login-link">
                <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
            </div>
        </div>
        
        <!-- Back to Home -->
        <a href="/" class="back-home">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Home
        </a>
    </div>
    
    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const container = passwordInput.parentElement;
            const eyeIcon = container.querySelector('.eye-icon');
            const eyeOffIcon = container.querySelector('.eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }
        
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            strengthFill.className = 'strength-fill';
            strengthText.className = 'strength-text';
            
            if (password.length === 0) {
                strengthFill.className = 'strength-fill';
                strengthText.textContent = '';
            } else if (strength <= 1) {
                strengthFill.className = 'strength-fill weak';
                strengthText.className = 'strength-text weak';
                strengthText.textContent = 'Weak password';
            } else if (strength <= 2) {
                strengthFill.className = 'strength-fill medium';
                strengthText.className = 'strength-text medium';
                strengthText.textContent = 'Medium strength';
            } else {
                strengthFill.className = 'strength-fill strong';
                strengthText.className = 'strength-text strong';
                strengthText.textContent = 'Strong password';
            }
        }
    </script>
</body>
</html>
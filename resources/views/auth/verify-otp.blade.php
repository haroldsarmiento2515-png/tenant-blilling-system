<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email - {{ config('app.name', 'TenantBill') }}</title>
    
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
            --border: #334155;
            --error: #ef4444;
            --error-bg: rgba(239, 68, 68, 0.1);
            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.1);
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--primary);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated Background */
        .bg-gradient {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(16, 185, 129, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 50% 100%, rgba(16, 185, 129, 0.08) 0%, transparent 50%);
            z-index: 0;
        }
        
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent) 0%, transparent 70%);
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }
        
        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }
        
        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            left: -50px;
            animation-delay: -5s;
        }
        
        .shape-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 20%;
            animation-delay: -10s;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            25% { transform: translate(20px, -20px) rotate(5deg) scale(1.05); }
            50% { transform: translate(0, 20px) rotate(0deg) scale(1); }
            75% { transform: translate(-20px, -10px) rotate(-5deg) scale(0.95); }
        }
        
        /* Card */
        .verify-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        
        .verify-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent) 0%, #34d399 100%);
            border-radius: 24px 24px 0 0;
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
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px var(--accent-glow);
        }
        
        .logo-icon svg {
            width: 28px;
            height: 28px;
            color: white;
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
        }
        
        /* Header */
        .verify-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .verify-icon {
            width: 80px;
            height: 80px;
            background: var(--success-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 2px solid var(--accent);
        }
        
        .verify-icon svg {
            width: 40px;
            height: 40px;
            color: var(--accent);
        }
        
        .verify-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .verify-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .user-email {
            color: var(--accent);
            font-weight: 600;
        }
        
        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }
        
        .alert svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }
        
        .alert-error {
            background: var(--error-bg);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--error);
        }
        
        .alert-success {
            background: var(--success-bg);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--success);
        }
        
        /* OTP Input */
        .otp-container {
            margin-bottom: 1.5rem;
        }
        
        .otp-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
            color: var(--text);
        }
        
        .otp-inputs {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }
        
        .otp-input {
            width: 52px;
            height: 60px;
            background: var(--primary);
            border: 2px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .otp-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }
        
        .otp-input.filled {
            border-color: var(--accent);
            background: rgba(16, 185, 129, 0.1);
        }
        
        .otp-input.error {
            border-color: var(--error);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        }
        
        /* Hidden actual input */
        .otp-hidden {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        
        /* Submit Button */
        .btn-verify {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--accent) 0%, #059669 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--accent-glow);
        }
        
        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--accent-glow);
        }
        
        .btn-verify:active {
            transform: translateY(0);
        }
        
        .btn-verify svg {
            width: 20px;
            height: 20px;
        }
        
        /* Resend Section */
        .resend-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }
        
        .resend-text {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }
        
        .btn-resend {
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-resend:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: rgba(16, 185, 129, 0.1);
        }
        
        .btn-resend svg {
            width: 18px;
            height: 18px;
        }
        
        .btn-resend:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .countdown {
            color: var(--accent);
            font-weight: 600;
        }
        
        /* Back Link */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: var(--accent);
        }
        
        .back-link svg {
            width: 18px;
            height: 18px;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .verify-card {
                padding: 2rem 1.5rem;
            }
            
            .otp-input {
                width: 45px;
                height: 54px;
                font-size: 1.25rem;
            }
            
            .otp-inputs {
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="bg-gradient"></div>
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    
    <!-- Verification Card -->
    <div class="verify-card">
        <!-- Logo -->
        <a href="/" class="logo">
            <div class="logo-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="logo-text">TenantBill</span>
        </a>
        
        <!-- Header -->
        <div class="verify-header">
            <div class="verify-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h1>Verify Your Email</h1>
            <p>We've sent a 6-digit verification code to<br><span class="user-email">{{ session('email') ?? 'your email' }}</span></p>
        </div>
        
        <!-- Error Message -->
        @if ($errors->any())
            <div class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        <!-- OTP Form -->
        <form method="POST" action="{{ url('email/verify') }}" id="otpForm"></form>
            @csrf
            
            <!-- OTP Input -->
            <div class="otp-container">
                <label class="otp-label">Enter verification code</label>
                <div class="otp-inputs">
                    <input type="text" class="otp-input" maxlength="1" data-index="0" inputmode="numeric" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" data-index="1" inputmode="numeric" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" data-index="2" inputmode="numeric" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" data-index="3" inputmode="numeric" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" data-index="4" inputmode="numeric" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" data-index="5" inputmode="numeric" autocomplete="off">
                </div>
                <!-- Hidden input for form submission -->
                <input type="hidden" name="otp" id="otpHidden">
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="btn-verify">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verify Email
            </button>
        </form>
        
        <!-- Resend Section -->
        <div class="resend-section">
            <p class="resend-text">Didn't receive the code? <span class="countdown" id="countdown"></span></p>
            <form method="POST" action="{{ url('email/resend') }}" id="resendForm"></form>
                @csrf
                <button type="submit" class="btn-resend" id="resendBtn" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Resend Code
                </button>
            </form>
        </div>
        
        <!-- Back Link -->
        <a href="{{ route('login') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Login
        </a>
    </div>
    
    <script>
        // OTP Input Handler
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpHidden = document.getElementById('otpHidden');
        const otpForm = document.getElementById('otpForm');
        
        // Focus first input on load
        otpInputs[0].focus();
        
        otpInputs.forEach((input, index) => {
            // Only allow numbers
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                
                // Only allow single digit
                if (!/^\d*$/.test(value)) {
                    e.target.value = '';
                    return;
                }
                
                if (value.length === 1) {
                    input.classList.add('filled');
                    // Move to next input
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                } else {
                    input.classList.remove('filled');
                }
                
                updateHiddenInput();
            });
            
            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    otpInputs[index - 1].focus();
                    otpInputs[index - 1].value = '';
                    otpInputs[index - 1].classList.remove('filled');
                }
                
                // Handle arrow keys
                if (e.key === 'ArrowLeft' && index > 0) {
                    otpInputs[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });
            
            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
                
                pastedData.split('').forEach((char, i) => {
                    if (otpInputs[i]) {
                        otpInputs[i].value = char;
                        otpInputs[i].classList.add('filled');
                    }
                });
                
                // Focus last filled or next empty
                const nextIndex = Math.min(pastedData.length, otpInputs.length - 1);
                otpInputs[nextIndex].focus();
                
                updateHiddenInput();
            });
        });
        
        function updateHiddenInput() {
            let otp = '';
            otpInputs.forEach(input => {
                otp += input.value;
            });
            otpHidden.value = otp;
        }
        
        // Form validation
        otpForm.addEventListener('submit', (e) => {
            updateHiddenInput();
            if (otpHidden.value.length !== 6) {
                e.preventDefault();
                otpInputs.forEach(input => {
                    if (!input.value) {
                        input.classList.add('error');
                    }
                });
                setTimeout(() => {
                    otpInputs.forEach(input => input.classList.remove('error'));
                }, 2000);
            }
        });
        
        // Countdown Timer for Resend
        const resendBtn = document.getElementById('resendBtn');
        const countdown = document.getElementById('countdown');
        let timeLeft = 60;
        
        function updateCountdown() {
            if (timeLeft > 0) {
                countdown.textContent = `Wait ${timeLeft}s`;
                resendBtn.disabled = true;
                timeLeft--;
                setTimeout(updateCountdown, 1000);
            } else {
                countdown.textContent = '';
                resendBtn.disabled = false;
            }
        }
        
        updateCountdown();
    </script>
</body>
</html>
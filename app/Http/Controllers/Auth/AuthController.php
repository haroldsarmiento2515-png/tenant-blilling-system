<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    // Show user login form
    public function showUserLoginForm()
    {
        return view('auth.user-login');
    }

    // Handle user login
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Show user registration form
    public function showUserRegistrationForm()
    {
        return view('auth.user-register');
    }

    // Handle user registration
    public function userRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => 'required|string',
        ], [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
        ]);

        // Validate reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $recaptchaResponse
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($verifyUrl, false, $context);
        $response = $result ? json_decode($result) : null;

        if (!$response || empty($response->success)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'reCAPTCHA verification failed.',
            ])->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10); // OTP expires in 10 minutes
        $user->save();

        // Send OTP via email using a styled template
        Mail::send('emails.otp', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Email Verification OTP');
        });

        // Store email in session for verification flow
        $request->session()->put('email', $user->email);

        return redirect()->route('verification.notice');
    }

    // Show OTP verification form
    public function showVerificationForm()
    {
        return view('auth.verify-otp');
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $email = $request->input('email') ?? $request->session()->get('email');
        $request->merge(['email' => $email]);

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if ($user) {
            $user->is_verified = true;
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->email_verified_at = now();
            $user->save();

            return redirect()->route('login')->with('success', 'Email verified successfully. You can now login.');
        }

        return back()->withErrors([
            'otp' => 'Invalid or expired OTP.',
        ])->withInput();
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $email = $request->input('email') ?? $request->session()->get('email');

        if (!$email) {
            return back()->withErrors([
                'email' => 'Unable to identify the account for verification.',
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email address not found.',
            ]);
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::send('emails.otp', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Email Verification OTP');
        });

        $request->session()->put('email', $user->email);

        return back()->with('success', 'A new verification code has been sent to your email.');
    }

    // Show admin login form
    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    // Handle admin login
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle logout for both user and admin
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
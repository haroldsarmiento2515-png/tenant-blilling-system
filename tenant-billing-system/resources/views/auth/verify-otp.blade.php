@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card max-w-md mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Email Verification</h2>
        
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p class="mb-4 text-center">Please check your email for the OTP code and enter it below to verify your account.</p>

        <form method="POST" action="{{ route('verification.notice') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-6">
                <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">OTP Code</label>
                <input type="text" name="otp" id="otp" class="form-input" required>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="btn btn-primary">
                    Verify Email
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
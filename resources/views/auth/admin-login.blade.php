@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card max-w-md mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>
        
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
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" class="form-input" required>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
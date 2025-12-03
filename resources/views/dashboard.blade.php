@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card">
        <h2 class="text-2xl font-bold mb-6">User Dashboard</h2>
        
        <div class="mb-4">
            <p>Welcome, {{ Auth::user()->name }}!</p>
            <p>Email: {{ Auth::user()->email }}</p>
        </div>
        
        <div class="mt-6">
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="btn btn-primary">
                Logout
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
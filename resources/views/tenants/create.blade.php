@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Add New Tenant</h2>
        
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                <input type="text" name="phone" id="phone" class="form-input" value="{{ old('phone') }}">
            </div>
            
            <div class="mb-4">
                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                <textarea name="address" id="address" class="form-input" rows="3">{{ old('address') }}</textarea>
            </div>
            
            <div class="mb-6">
                <label for="company_name" class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-input" value="{{ old('company_name') }}">
            </div>
            
            <div class="flex items-center justify-between">
                <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Tenant</button>
            </div>
        </form>
    </div>
</div>
@endsection
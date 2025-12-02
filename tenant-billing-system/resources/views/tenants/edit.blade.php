@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Edit Tenant</h2>
        
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('tenants.update', $tenant) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $tenant->name) }}" required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $tenant->email) }}" required>
            </div>
            
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                <input type="text" name="phone" id="phone" class="form-input" value="{{ old('phone', $tenant->phone) }}">
            </div>
            
            <div class="mb-4">
                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                <textarea name="address" id="address" class="form-input" rows="3">{{ old('address', $tenant->address) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label for="company_name" class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-input" value="{{ old('company_name', $tenant->company_name) }}">
            </div>
            
            <div class="flex items-center justify-between">
                <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Tenant</button>
            </div>
        </form>
    </div>
</div>
@endsection
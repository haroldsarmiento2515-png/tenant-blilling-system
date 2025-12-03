@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Tenants</h2>
            <a href="{{ route('tenants.create') }}" class="btn btn-primary">Add New Tenant</a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Phone</th>
                        <th class="py-2 px-4 border-b">Company</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenants as $tenant)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $tenant->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $tenant->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $tenant->phone ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $tenant->company_name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('tenants.show', $tenant) }}" class="text-blue-500 hover:text-blue-700 mr-2">View</a>
                                <a href="{{ route('tenants.edit', $tenant) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">Edit</a>
                                <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-2 px-4 border-b text-center">No tenants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
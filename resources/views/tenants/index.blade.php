@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">Tenants</p>
            <h1>Tenant Directory</h1>
            <p>Manage every tenant profile and keep contact details aligned with billing.</p>
        </div>
        <div class="header-actions">
            <div class="stat-chip">Total Tenants: {{ $tenants->count() }}</div>
            <a href="{{ route('tenants.create') }}" class="btn btn-primary">Add New Tenant</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">Profiles</h2>
                <p class="panel-sub">Names, contact info, and company details.</p>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->name }}</td>
                        <td>{{ $tenant->email }}</td>
                        <td>{{ $tenant->phone ?? 'N/A' }}</td>
                        <td>{{ $tenant->company_name ?? 'N/A' }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('tenants.show', $tenant) }}" class="muted-link">View</a>
                                <a href="{{ route('tenants.edit', $tenant) }}" class="muted-link">Edit</a>
                                <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No tenants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">Tenant</p>
            <h1>{{ $tenant->name }}</h1>
            <p>Contact and billing information.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-secondary">Edit</a>
            <a href="{{ route('tenants.index') }}" class="btn btn-ghost">Back to Tenants</a>
        </div>
    </div>

    <div class="panel">
        <div class="card-grid">
            <div class="info-card">
                <small>Email</small>
                <strong>{{ $tenant->email }}</strong>
            </div>
            <div class="info-card">
                <small>Phone</small>
                <strong>{{ $tenant->phone ?? 'N/A' }}</strong>
            </div>
            <div class="info-card">
                <small>Company</small>
                <strong>{{ $tenant->company_name ?? 'N/A' }}</strong>
            </div>
        </div>

        <div style="margin-top: 18px;">
            <p class="panel-sub" style="margin-bottom: 6px;">Address</p>
            <p>{{ $tenant->address ?? 'No address provided.' }}</p>
        </div>
    </div>
</div>
@endsection

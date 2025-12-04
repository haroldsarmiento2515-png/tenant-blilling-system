@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">New Tenant</p>
            <h1>Add Tenant</h1>
            <p>Create a tenant profile to connect with bills and payments.</p>
        </div>
        <a href="{{ route('tenants.index') }}" class="btn btn-ghost">Cancel</a>
    </div>

    <div class="panel">
        <h2 class="panel-title" style="margin-bottom: 12px;">Tenant Details</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-control">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-control">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
                </div>

                <div class="form-control">
                    <label for="company_name">Company</label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}">
                </div>
            </div>

            <div class="form-control" style="margin-top: 12px;">
                <label for="address">Address</label>
                <textarea name="address" id="address" rows="3">{{ old('address') }}</textarea>
            </div>

            <div class="header-actions" style="margin-top: 18px;">
                <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Save Tenant</button>
            </div>
        </form>
    </div>
</div>
@endsection

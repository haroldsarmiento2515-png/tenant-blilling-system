@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">New Bill</p>
            <h1>Create Bill</h1>
            <p>Set up a new charge and assign it to a tenant.</p>
        </div>
        <a href="{{ route('bills.index') }}" class="btn btn-ghost">Cancel</a>
    </div>

    <div class="panel">
        <h2 class="panel-title" style="margin-bottom: 12px;">Bill Details</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bills.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-control">
                    <label for="tenant_id">Tenant</label>
                    <select name="tenant_id" id="tenant_id" required>
                        <option value="">Select a tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->name }} ({{ $tenant->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label for="bill_number">Bill Number</label>
                    <input type="text" name="bill_number" id="bill_number" value="{{ old('bill_number') }}" required>
                </div>

                <div class="form-control">
                    <label for="billing_date">Billing Date</label>
                    <input type="date" name="billing_date" id="billing_date" value="{{ old('billing_date') }}" required>
                </div>

                <div class="form-control">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required>
                </div>

                <div class="form-control">
                    <label for="amount">Amount ($)</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required>
                </div>
            </div>

            <div class="form-control" style="margin-top: 12px;">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="header-actions" style="margin-top: 18px;">
                <a href="{{ route('bills.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Create Bill</button>
            </div>
        </form>
    </div>
</div>
@endsection

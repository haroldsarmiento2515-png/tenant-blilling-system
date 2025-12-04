@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">Update Bill</p>
            <h1>Edit Bill {{ $bill->bill_number }}</h1>
            <p>Adjust billing details, due dates, or tenant assignment.</p>
        </div>
        <a href="{{ route('bills.show', $bill) }}" class="btn btn-ghost">Cancel</a>
    </div>

    <div class="panel">
        <h2 class="panel-title" style="margin-bottom: 12px;">Bill Information</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bills.update', $bill) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-control">
                    <label for="tenant_id">Tenant</label>
                    <select name="tenant_id" id="tenant_id" required>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ old('tenant_id', $bill->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->name }} ({{ $tenant->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label for="bill_number">Bill Number</label>
                    <input type="text" name="bill_number" id="bill_number" value="{{ old('bill_number', $bill->bill_number) }}" required>
                </div>

                <div class="form-control">
                    <label for="billing_date">Billing Date</label>
                    <input type="date" name="billing_date" id="billing_date" value="{{ old('billing_date', $bill->billing_date->format('Y-m-d')) }}" required>
                </div>

                <div class="form-control">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $bill->due_date->format('Y-m-d')) }}" required>
                </div>

                <div class="form-control">
                    <label for="amount">Amount ($)</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $bill->amount) }}" required>
                </div>

                <div class="form-control">
                    <label for="paid_amount">Paid Amount ($)</label>
                    <input type="number" step="0.01" name="paid_amount" id="paid_amount" value="{{ old('paid_amount', $bill->paid_amount) }}" required>
                </div>

                <div class="form-control">
                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        @foreach(['paid', 'pending', 'partial', 'overdue', 'draft'] as $status)
                            <option value="{{ $status }}" {{ old('status', $bill->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-control" style="margin-top: 12px;">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3">{{ old('description', $bill->description) }}</textarea>
            </div>

            <div class="header-actions" style="margin-top: 18px;">
                <a href="{{ route('bills.show', $bill) }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update Bill</button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Edit Bill</h2>
        
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('bills.update', $bill) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="tenant_id" class="block text-gray-700 text-sm font-bold mb-2">Tenant</label>
                <select name="tenant_id" id="tenant_id" class="form-input" required>
                    <option value="">Select a tenant</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ old('tenant_id', $bill->tenant_id) == $tenant->id ? 'selected' : '' }}>
                            {{ $tenant->name }} ({{ $tenant->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="bill_number" class="block text-gray-700 text-sm font-bold mb-2">Bill Number</label>
                <input type="text" name="bill_number" id="bill_number" class="form-input" value="{{ old('bill_number', $bill->bill_number) }}" required>
            </div>
            
            <div class="mb-4">
                <label for="billing_date" class="block text-gray-700 text-sm font-bold mb-2">Billing Date</label>
                <input type="date" name="billing_date" id="billing_date" class="form-input" value="{{ old('billing_date', $bill->billing_date->format('Y-m-d')) }}" required>
            </div>
            
            <div class="mb-4">
                <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-input" value="{{ old('due_date', $bill->due_date->format('Y-m-d')) }}" required>
            </div>
            
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount ($)</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-input" value="{{ old('amount', $bill->amount) }}" required>
            </div>
            
            <div class="mb-4">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select name="status" id="status" class="form-input" required>
                    <option value="pending" {{ old('status', $bill->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ old('status', $bill->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="overdue" {{ old('status', $bill->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" class="form-input" rows="3">{{ old('description', $bill->description) }}</textarea>
            </div>
            
            <div class="flex items-center justify-between">
                <a href="{{ route('bills.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Bill</button>
            </div>
        </form>
    </div>
</div>
@endsection
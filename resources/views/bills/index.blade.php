@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">Billing</p>
            <h1>Invoices & Charges</h1>
            <p>Monitor every tenant bill, payment progress, and due date in one place.</p>
        </div>
        <div class="header-actions">
            <div class="stat-chip">Total Bills: {{ $bills->count() }}</div>
            <div class="stat-chip">Amount Billed: ${{ number_format($bills->sum('amount'), 2) }}</div>
            <a href="{{ route('bills.create') }}" class="btn btn-primary">Create New Bill</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">Billing Ledger</h2>
                <p class="panel-sub">Status, amounts, and due dates across all tenants.</p>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Bill Number</th>
                        <th>Tenant</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $bill)
                        <tr>
                            <td>{{ $bill->bill_number }}</td>
                            <td>{{ $bill->tenant->name }}</td>
                            <td>${{ number_format($bill->amount, 2) }}</td>
                            <td>${{ number_format($bill->paid_amount, 2) }}</td>
                            <td>
                                <span class="status-badge @if($bill->status == 'paid') status-paid @elseif($bill->status == 'overdue') status-overdue @elseif($bill->status == 'pending' || $bill->status == 'partial') status-pending @else status-info @endif">
                                    {{ ucfirst($bill->status) }}
                                </span>
                            </td>
                            <td>{{ $bill->due_date->format('M d, Y') }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('bills.show', $bill) }}" class="muted-link">View</a>
                                    <a href="{{ route('bills.edit', $bill) }}" class="muted-link">Edit</a>
                                    <form action="{{ route('bills.destroy', $bill) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No bills found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

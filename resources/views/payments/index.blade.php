@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">Payments</p>
            <h1>Payment History</h1>
            <p>Review recorded payments across all bills and tenants.</p>
        </div>
        <div class="header-actions">
            <div class="stat-chip">Payments: {{ $payments->count() }}</div>
            <div class="stat-chip">Total Received: ${{ number_format($payments->sum('amount'), 2) }}</div>
            <a href="{{ route('payments.create') }}" class="btn btn-primary">Record New Payment</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">Transactions</h2>
                <p class="panel-sub">Payment method, amount, and allocation per bill.</p>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Bill Number</th>
                    <th>Tenant</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Transaction ID</th>
                    <th>Payment Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->bill->bill_number }}</td>
                        <td>{{ $payment->bill->tenant->name }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                        <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                        <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('payments.show', $payment) }}" class="muted-link">View</a>
                                <a href="{{ route('payments.edit', $payment) }}" class="muted-link">Edit</a>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

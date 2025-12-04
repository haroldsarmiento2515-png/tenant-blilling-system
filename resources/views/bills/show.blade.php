@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">Bill</p>
            <h1>Bill {{ $bill->bill_number }}</h1>
            <p>Overview of the invoice, remaining balance, and associated payments.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('bills.edit', $bill) }}" class="btn btn-secondary">Edit</a>
            <a href="{{ route('bills.index') }}" class="btn btn-ghost">Back to Bills</a>
        </div>
    </div>

    <div class="panel">
        <div class="card-grid">
            <div class="info-card">
                <small>Tenant</small>
                <strong>{{ $bill->tenant->name }}</strong>
            </div>
            <div class="info-card">
                <small>Amount</small>
                <strong>${{ number_format($bill->amount, 2) }}</strong>
            </div>
            <div class="info-card">
                <small>Paid</small>
                <strong>${{ number_format($bill->paid_amount, 2) }}</strong>
            </div>
            <div class="info-card">
                <small>Status</small>
                <span class="status-badge @if($bill->status == 'paid') status-paid @elseif($bill->status == 'overdue') status-overdue @elseif($bill->status == 'pending' || $bill->status == 'partial') status-pending @else status-info @endif">{{ ucfirst($bill->status) }}</span>
            </div>
        </div>

        <div class="meta-grid" style="margin-top: 18px;">
            <div class="pill">Billing Date: {{ $bill->billing_date->format('M d, Y') }}</div>
            <div class="pill">Due Date: {{ $bill->due_date->format('M d, Y') }}</div>
            <div class="pill">Remaining: ${{ number_format($bill->remainingBalance(), 2) }}</div>
        </div>

        <div style="margin-top: 18px;">
            <p class="panel-sub" style="margin-bottom: 6px;">Description</p>
            <p>{{ $bill->description ?? 'No description provided.' }}</p>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">Payments</h2>
                <p class="panel-sub">History of payments made toward this bill.</p>
            </div>
            <a href="{{ route('payments.create') }}?bill_id={{ $bill->id }}" class="btn btn-primary">Add Payment</a>
        </div>

        @if($bill->payments->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bill->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('payments.edit', $payment) }}" class="muted-link">Edit</a>
                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="panel-sub">No payments recorded for this bill.</p>
        @endif
    </div>
</div>
@endsection

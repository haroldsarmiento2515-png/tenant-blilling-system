@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">Payment</p>
            <h1>Payment Details</h1>
            <p>Receipt and allocation summary for bill {{ $payment->bill->bill_number }}.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('payments.edit', $payment) }}" class="btn btn-secondary">Edit</a>
            <a href="{{ route('payments.index') }}" class="btn btn-ghost">Back to Payments</a>
        </div>
    </div>

    <div class="panel">
        <div class="card-grid">
            <div class="info-card">
                <small>Bill Number</small>
                <strong>{{ $payment->bill->bill_number }}</strong>
            </div>
            <div class="info-card">
                <small>Tenant</small>
                <strong>{{ $payment->bill->tenant->name }}</strong>
            </div>
            <div class="info-card">
                <small>Amount</small>
                <strong>${{ number_format($payment->amount, 2) }}</strong>
            </div>
            <div class="info-card">
                <small>Payment Method</small>
                <strong>{{ $payment->payment_method ?? 'N/A' }}</strong>
            </div>
        </div>

        <div class="meta-grid" style="margin-top: 18px;">
            <div class="pill">Transaction ID: {{ $payment->transaction_id ?? 'N/A' }}</div>
            <div class="pill">Payment Date: {{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</div>
        </div>

        <div style="margin-top: 18px;">
            <p class="panel-sub" style="margin-bottom: 6px;">Notes</p>
            <p>{{ $payment->notes ?? 'No notes provided.' }}</p>
        </div>
    </div>
</div>
@endsection

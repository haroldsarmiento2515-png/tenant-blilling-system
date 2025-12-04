@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">Update Payment</p>
            <h1>Edit Payment</h1>
            <p>Update payment details or correct the allocation.</p>
        </div>
        <a href="{{ route('payments.show', $payment) }}" class="btn btn-ghost">Cancel</a>
    </div>

    <div class="panel">
        <h2 class="panel-title" style="margin-bottom: 12px;">Payment Information</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('payments.update', $payment) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-control">
                    <label for="bill_id">Bill</label>
                    <select name="bill_id" id="bill_id" required>
                        @foreach($bills as $bill)
                            <option value="{{ $bill->id }}" {{ old('bill_id', $payment->bill_id) == $bill->id ? 'selected' : '' }}>
                                {{ $bill->bill_number }} — {{ $bill->tenant->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label for="amount">Amount ($)</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}" required>
                </div>

                <div class="form-control">
                    <label for="payment_method">Payment Method</label>
                    <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method', $payment->payment_method) }}">
                </div>

                <div class="form-control">
                    <label for="transaction_id">Transaction ID</label>
                    <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id', $payment->transaction_id) }}">
                </div>

                <div class="form-control">
                    <label for="payment_date">Payment Date</label>
                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', optional($payment->payment_date)->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="form-control" style="margin-top: 12px;">
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" rows="3">{{ old('notes', $payment->notes) }}</textarea>
            </div>

            <div class="header-actions" style="margin-top: 18px;">
                <a href="{{ route('payments.show', $payment) }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection

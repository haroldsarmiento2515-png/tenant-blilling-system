@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <div>
            <p class="muted-link" style="text-transform: uppercase; letter-spacing: 0.08em;">New Payment</p>
            <h1>Record Payment</h1>
            <p>Attach the payment to an existing bill and capture transaction details.</p>
        </div>
        <a href="{{ route('payments.index') }}" class="btn btn-ghost">Cancel</a>
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

        <form method="POST" action="{{ route('payments.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-control">
                    <label for="bill_id">Bill</label>
                    <select name="bill_id" id="bill_id" required>
                        <option value="">Select a bill</option>
                        @foreach($bills as $bill)
                            <option value="{{ $bill->id }}" {{ request('bill_id') == $bill->id || old('bill_id') == $bill->id ? 'selected' : '' }}>
                                {{ $bill->bill_number }} — {{ $bill->tenant->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label for="amount">Amount ($)</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required>
                </div>

                <div class="form-control">
                    <label for="payment_method">Payment Method</label>
                    <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method') }}">
                </div>

                <div class="form-control">
                    <label for="transaction_id">Transaction ID</label>
                    <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}">
                </div>

                <div class="form-control">
                    <label for="payment_date">Payment Date</label>
                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date') }}">
                </div>
            </div>

            <div class="form-control" style="margin-top: 12px;">
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" rows="3">{{ old('notes') }}</textarea>
            </div>

            <div class="header-actions" style="margin-top: 18px;">
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Save Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection

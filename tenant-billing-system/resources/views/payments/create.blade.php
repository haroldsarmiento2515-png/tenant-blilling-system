@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Record New Payment</h2>
        
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            
            <div class="mb-4">
                <label for="bill_id" class="block text-gray-700 text-sm font-bold mb-2">Bill</label>
                <select name="bill_id" id="bill_id" class="form-input" required>
                    <option value="">Select a bill</option>
                    @foreach($bills as $bill)
                        <option value="{{ $bill->id }}" {{ old('bill_id', request('bill_id')) == $bill->id ? 'selected' : '' }}>
                            {{ $bill->bill_number }} - {{ $bill->tenant->name }} (${{ number_format($bill->remainingBalance(), 2) }} remaining)
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount ($)</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-input" value="{{ old('amount') }}" required>
            </div>
            
            <div class="mb-4">
                <label for="payment_method" class="block text-gray-700 text-sm font-bold mb-2">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-input">
                    <option value="">Select a payment method</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="transaction_id" class="block text-gray-700 text-sm font-bold mb-2">Transaction ID</label>
                <input type="text" name="transaction_id" id="transaction_id" class="form-input" value="{{ old('transaction_id') }}">
            </div>
            
            <div class="mb-4">
                <label for="payment_date" class="block text-gray-700 text-sm font-bold mb-2">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" class="form-input" value="{{ old('payment_date', date('Y-m-d')) }}" required>
            </div>
            
            <div class="mb-6">
                <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                <textarea name="notes" id="notes" class="form-input" rows="3">{{ old('notes') }}</textarea>
            </div>
            
            <div class="flex items-center justify-between">
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Record Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection
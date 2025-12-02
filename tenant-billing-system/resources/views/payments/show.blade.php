@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Payment Details</h2>
            <div>
                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-primary mr-2">Edit</a>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back to Payments</a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-3">Payment Information</h3>
                <table class="min-w-full">
                    <tr>
                        <td class="py-2 font-medium">Payment ID:</td>
                        <td class="py-2">{{ $payment->id }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Bill Number:</td>
                        <td class="py-2">{{ $payment->bill->bill_number }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Tenant:</td>
                        <td class="py-2">{{ $payment->bill->tenant->name }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Amount:</td>
                        <td class="py-2">${{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Payment Method:</td>
                        <td class="py-2">{{ $payment->payment_method ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Transaction ID:</td>
                        <td class="py-2">{{ $payment->transaction_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Payment Date:</td>
                        <td class="py-2">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Notes:</td>
                        <td class="py-2">{{ $payment->notes ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-3">Related Bill Information</h3>
                <table class="min-w-full">
                    <tr>
                        <td class="py-2 font-medium">Bill Amount:</td>
                        <td class="py-2">${{ number_format($payment->bill->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Paid Amount:</td>
                        <td class="py-2">${{ number_format($payment->bill->paid_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Remaining Balance:</td>
                        <td class="py-2">${{ number_format($payment->bill->remainingBalance(), 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Status:</td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($payment->bill->status == 'paid') bg-green-100 text-green-800 
                                @elseif($payment->bill->status == 'overdue') bg-red-100 text-red-800 
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($payment->bill->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Due Date:</td>
                        <td class="py-2">{{ $payment->bill->due_date->format('M d, Y') }}</td>
                    </tr>
                </table>
                
                <div class="mt-4">
                    <a href="{{ route('bills.show', $payment->bill) }}" class="btn btn-primary">View Bill Details</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
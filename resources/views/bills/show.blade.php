@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Bill Details</h2>
            <div>
                <a href="{{ route('bills.edit', $bill) }}" class="btn btn-primary mr-2">Edit</a>
                <a href="{{ route('bills.index') }}" class="btn btn-secondary">Back to Bills</a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-3">Bill Information</h3>
                <table class="min-w-full">
                    <tr>
                        <td class="py-2 font-medium">Bill Number:</td>
                        <td class="py-2">{{ $bill->bill_number }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Tenant:</td>
                        <td class="py-2">{{ $bill->tenant->name }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Billing Date:</td>
                        <td class="py-2">{{ $bill->billing_date->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Due Date:</td>
                        <td class="py-2">{{ $bill->due_date->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Amount:</td>
                        <td class="py-2">${{ number_format($bill->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Paid Amount:</td>
                        <td class="py-2">${{ number_format($bill->paid_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Remaining Balance:</td>
                        <td class="py-2">${{ number_format($bill->remainingBalance(), 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Status:</td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($bill->status == 'paid') bg-green-100 text-green-800 
                                @elseif($bill->status == 'overdue') bg-red-100 text-red-800 
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($bill->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Description:</td>
                        <td class="py-2">{{ $bill->description ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Payments</h3>
                    <a href="{{ route('payments.create') }}?bill_id={{ $bill->id }}" class="btn btn-primary text-sm">Add Payment</a>
                </div>
                
                @if($bill->payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Date</th>
                                    <th class="py-2 px-4 border-b">Amount</th>
                                    <th class="py-2 px-4 border-b">Method</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bill->payments as $payment)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                                        <td class="py-2 px-4 border-b">${{ number_format($payment->amount, 2) }}</td>
                                        <td class="py-2 px-4 border-b">{{ $payment->payment_method ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <a href="{{ route('payments.edit', $payment) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">Edit</a>
                                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No payments recorded for this bill.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
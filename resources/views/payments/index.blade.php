@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Payments</h2>
            <a href="{{ route('payments.create') }}" class="btn btn-primary">Record New Payment</a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Bill Number</th>
                        <th class="py-2 px-4 border-b">Tenant</th>
                        <th class="py-2 px-4 border-b">Amount</th>
                        <th class="py-2 px-4 border-b">Payment Method</th>
                        <th class="py-2 px-4 border-b">Transaction ID</th>
                        <th class="py-2 px-4 border-b">Payment Date</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $payment->bill->bill_number }}</td>
                            <td class="py-2 px-4 border-b">{{ $payment->bill->tenant->name }}</td>
                            <td class="py-2 px-4 border-b">${{ number_format($payment->amount, 2) }}</td>
                            <td class="py-2 px-4 border-b">{{ $payment->payment_method ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $payment->transaction_id ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('payments.show', $payment) }}" class="text-blue-500 hover:text-blue-700 mr-2">View</a>
                                <a href="{{ route('payments.edit', $payment) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">Edit</a>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-2 px-4 border-b text-center">No payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
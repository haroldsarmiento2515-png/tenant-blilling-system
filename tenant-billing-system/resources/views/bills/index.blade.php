@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Bills</h2>
            <a href="{{ route('bills.create') }}" class="btn btn-primary">Create New Bill</a>
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
                        <th class="py-2 px-4 border-b">Paid</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Due Date</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $bill)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $bill->bill_number }}</td>
                            <td class="py-2 px-4 border-b">{{ $bill->tenant->name }}</td>
                            <td class="py-2 px-4 border-b">${{ number_format($bill->amount, 2) }}</td>
                            <td class="py-2 px-4 border-b">${{ number_format($bill->paid_amount, 2) }}</td>
                            <td class="py-2 px-4 border-b">
                                <span class="px-2 py-1 rounded text-xs 
                                    @if($bill->status == 'paid') bg-green-100 text-green-800 
                                    @elseif($bill->status == 'overdue') bg-red-100 text-red-800 
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($bill->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border-b">{{ $bill->due_date->format('M d, Y') }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('bills.show', $bill) }}" class="text-blue-500 hover:text-blue-700 mr-2">View</a>
                                <a href="{{ route('bills.edit', $bill) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">Edit</a>
                                <form action="{{ route('bills.destroy', $bill) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-2 px-4 border-b text-center">No bills found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
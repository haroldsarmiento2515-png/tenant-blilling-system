@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Tenant Details</h2>
            <div>
                <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-primary mr-2">Edit</a>
                <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Back to Tenants</a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-3">Tenant Information</h3>
                <table class="min-w-full">
                    <tr>
                        <td class="py-2 font-medium">Name:</td>
                        <td class="py-2">{{ $tenant->name }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Email:</td>
                        <td class="py-2">{{ $tenant->email }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Phone:</td>
                        <td class="py-2">{{ $tenant->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Company:</td>
                        <td class="py-2">{{ $tenant->company_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 font-medium">Address:</td>
                        <td class="py-2">{{ $tenant->address ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-3">Related Bills</h3>
                @if($tenant->bills->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Bill Number</th>
                                    <th class="py-2 px-4 border-b">Amount</th>
                                    <th class="py-2 px-4 border-b">Status</th>
                                    <th class="py-2 px-4 border-b">Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tenant->bills as $bill)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $bill->bill_number }}</td>
                                        <td class="py-2 px-4 border-b">${{ number_format($bill->amount, 2) }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <span class="px-2 py-1 rounded text-xs 
                                                @if($bill->status == 'paid') bg-green-100 text-green-800 
                                                @elseif($bill->status == 'overdue') bg-red-100 text-red-800 
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($bill->status) }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-b">{{ $bill->due_date->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No bills found for this tenant.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
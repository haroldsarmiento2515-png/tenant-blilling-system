@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-blue-50 via-white to-indigo-50 py-10">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-500">Welcome back,</p>
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-white shadow-sm rounded-lg text-sm text-gray-600">
                    <span class="font-semibold">Total Billed:</span> ${{ number_format($totalBilled, 2) }}
                </div>
                <div class="px-4 py-2 bg-white shadow-sm rounded-lg text-sm text-gray-600">
                    <span class="font-semibold">Total Paid:</span> ${{ number_format($totalPaid, 2) }}
                </div>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="btn btn-primary">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="card border border-blue-100">
                <p class="text-sm text-gray-500">Outstanding Balance</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">${{ number_format($outstandingBalance, 2) }}</h3>
                <p class="text-xs text-amber-600 mt-1">Keep payments current to avoid late fees.</p>
            </div>
            <div class="card border border-green-100">
                <p class="text-sm text-gray-500">Payments Recorded</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">${{ number_format($totalPaid, 2) }}</h3>
                <p class="text-xs text-green-600 mt-1">Latest activity synced from your records.</p>
            </div>
            <div class="card border border-indigo-100">
                <p class="text-sm text-gray-500">Active Bills</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $activeBillsCount }}</h3>
                <p class="text-xs text-indigo-600 mt-1">Pending, partial, and overdue invoices.</p>
            </div>
            <div class="card border border-slate-100">
                <p class="text-sm text-gray-500">Tenants on File</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $tenantCount }}</h3>
                <p class="text-xs text-slate-600 mt-1">Based on current database records.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="card lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Latest Bills</h2>
                    <span class="text-sm text-gray-500">Synced from billing table</span>
                </div>
                @if($latestBills->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-500">
                                    <th class="py-2">Bill #</th>
                                    <th class="py-2">Tenant</th>
                                    <th class="py-2">Amount</th>
                                    <th class="py-2">Status</th>
                                    <th class="py-2">Due Date</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-700">
                                @foreach($latestBills as $bill)
                                    <tr class="border-t">
                                        <td class="py-2 font-semibold text-gray-900">{{ $bill->bill_number }}</td>
                                        <td class="py-2">{{ optional($bill->tenant)->name ?? 'Unassigned' }}</td>
                                        <td class="py-2 font-semibold">${{ number_format($bill->amount, 2) }}</td>
                                        <td class="py-2">
                                            <span class="px-2 py-1 rounded-full text-xs
                                                @if($bill->status === 'paid') bg-green-100 text-green-700
                                                @elseif($bill->status === 'overdue') bg-red-100 text-red-700
                                                @elseif($bill->status === 'partial') bg-amber-100 text-amber-700
                                                @else bg-blue-100 text-blue-700 @endif">
                                                {{ ucfirst($bill->status) }}
                                            </span>
                                        </td>
                                        <td class="py-2 text-gray-600">{{ optional($bill->due_date)->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-gray-600">No billing records found yet.</p>
                @endif
            </div>

            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Upcoming Due Dates</h2>
                    <span class="text-sm text-gray-500">Next 5 bills</span>
                </div>
                @if($upcomingBills->count())
                    <div class="space-y-3">
                        @foreach($upcomingBills as $bill)
                            <div class="p-3 border rounded-lg flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $bill->bill_number }}</p>
                                    <p class="text-xs text-gray-600">{{ optional($bill->tenant)->name ?? 'Unassigned' }}</p>
                                    <p class="text-xs text-gray-500">Due {{ optional($bill->due_date)->format('M d, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">${{ number_format($bill->amount, 2) }}</p>
                                    <span class="px-2 py-1 rounded-full text-xs
                                        @if($bill->status === 'overdue') bg-red-100 text-red-700
                                        @elseif($bill->status === 'pending') bg-amber-100 text-amber-700
                                        @else bg-blue-100 text-blue-700 @endif">
                                        {{ ucfirst($bill->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-600">No upcoming bills in the database.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Recent Payments</h2>
                <span class="text-sm text-gray-500">Live from payment history</span>
            </div>
            @if($recentPayments->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-500">
                                <th class="py-2">Bill #</th>
                                <th class="py-2">Tenant</th>
                                <th class="py-2">Amount</th>
                                <th class="py-2">Method</th>
                                <th class="py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach($recentPayments as $payment)
                                <tr class="border-t">
                                    <td class="py-2 font-semibold text-gray-900">{{ optional($payment->bill)->bill_number ?? 'N/A' }}</td>
                                    <td class="py-2">{{ optional(optional($payment->bill)->tenant)->name ?? 'Unassigned' }}</td>
                                    <td class="py-2 font-semibold">${{ number_format($payment->amount, 2) }}</td>
                                    <td class="py-2 text-gray-600">{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                                    <td class="py-2 text-gray-600">{{ optional($payment->payment_date)->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-600">No payment activity recorded.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="card">
        <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
        
        <div class="mb-4">
            <p>Welcome, {{ Auth::guard('admin')->user()->name }}!</p>
            <p>Email: {{ Auth::guard('admin')->user()->email }}</p>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="card bg-blue-50 border border-blue-200">
                <h3 class="text-lg font-bold mb-2">Total Bills</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $billingStats['total_bills'] ?? 0 }}</p>
            </div>
            
            <div class="card bg-green-50 border border-green-200">
                <h3 class="text-lg font-bold mb-2">Paid Bills</h3>
                <p class="text-3xl font-bold text-green-600">{{ $billingStats['paid_bills'] ?? 0 }}</p>
            </div>
            
            <div class="card bg-yellow-50 border border-yellow-200">
                <h3 class="text-lg font-bold mb-2">Pending Bills</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $billingStats['pending_bills'] ?? 0 }}</p>
            </div>
            
            <div class="card bg-red-50 border border-red-200">
                <h3 class="text-lg font-bold mb-2">Overdue Bills</h3>
                <p class="text-3xl font-bold text-red-600">{{ $billingStats['overdue_bills'] ?? 0 }}</p>
            </div>
        </div>
        
        <!-- Collection Rate -->
        <div class="card mb-8">
            <h3 class="text-lg font-bold mb-4">Collection Rate: {{ $billingStats['collection_rate'] ?? 0 }}%</h3>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-green-600 h-4 rounded-full" style="width: {{ $billingStats['collection_rate'] ?? 0 }}%"></div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">System Statistics</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card">
                    <h4 class="text-lg font-bold mb-3">Registered Users</h4>
                    <canvas id="usersChart" width="400" height="200"></canvas>
                </div>
                
                <div class="card">
                    <h4 class="text-lg font-bold mb-3">Billing Overview</h4>
                    <canvas id="billingChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="card">
                <h4 class="text-lg font-bold mb-3">Recent Users</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-2 px-4 border-b text-center">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card">
                <h4 class="text-lg font-bold mb-3">Recent Tenants</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTenants as $tenant)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $tenant->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $tenant->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $tenant->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-2 px-4 border-b text-center">No tenants found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="btn btn-primary">
                Logout
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Users Chart
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    let usersChart = null;
    
    // Billing Chart
    const billingCtx = document.getElementById('billingChart').getContext('2d');
    let billingChart = null;
    
    // Fetch user chart data
    fetch('/admin/dashboard/user-chart-data')
        .then(response => response.json())
        .then(data => {
            usersChart = new Chart(usersCtx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Registered Users',
                        data: data.data,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    
    // Fetch billing chart data
    fetch('/admin/dashboard/billing-chart-data')
        .then(response => response.json())
        .then(data => {
            billingChart = new Chart(billingCtx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Billing Status',
                        data: data.data,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        });
</script>
@endsection
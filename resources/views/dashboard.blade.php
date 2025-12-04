@extends('layouts.app')

@section('content')
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --primary: #0f172a;
        --primary-light: #1e293b;
        --accent: #10b981;
        --accent-hover: #059669;
        --accent-glow: rgba(16, 185, 129, 0.3);
        --accent-orange: #f59e0b;
        --accent-orange-glow: rgba(245, 158, 11, 0.3);
        --text: #f8fafc;
        --text-muted: #94a3b8;
        --surface: #1e293b;
        --surface-hover: #334155;
        --border: #334155;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
    }

    body { background: var(--primary); color: var(--text); }

    .dashboard-layout { display: flex; min-height: 100vh; }
    .sidebar { width: 260px; background: var(--surface); border-right: 1px solid var(--border); padding: 1.5rem; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
    .sidebar-logo { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem; text-decoration: none; }
    .sidebar-logo-icon { width: 42px; height: 42px; background: linear-gradient(135deg, var(--accent-orange) 0%, #ef4444 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px var(--accent-orange-glow); font-weight: 800; }
    .sidebar-logo-text { font-size: 1.25rem; font-weight: 700; color: var(--text); }
    .sidebar-logo-badge { font-size: 0.65rem; background: var(--accent-orange); color: white; padding: 0.15rem 0.5rem; border-radius: 100px; font-weight: 600; margin-left: -0.5rem; }

    .sidebar-menu { list-style: none; }
    .sidebar-menu-title { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 0.75rem; margin-top: 1.5rem; }
    .sidebar-menu-item { margin-bottom: 0.25rem; }
    .sidebar-menu-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 10px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: all 0.3s ease; }
    .sidebar-menu-link:hover { background: var(--surface-hover); color: var(--text); }
    .sidebar-menu-link.active { background: linear-gradient(135deg, var(--accent-orange) 0%, #ef4444 100%); color: white; box-shadow: 0 4px 15px var(--accent-orange-glow); }
    .sidebar-menu-link svg { width: 20px; height: 20px; }

    .main-content { flex: 1; padding: 2rem; }

    .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
    .dashboard-title h1 { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.25rem; }
    .dashboard-title p { color: var(--text-muted); font-size: 0.9rem; }
    .header-actions { display: flex; align-items: center; gap: 1rem; }
    .admin-profile { display: flex; align-items: center; gap: 0.75rem; background: var(--surface); padding: 0.5rem 1rem 0.5rem 0.5rem; border-radius: 100px; border: 1px solid var(--border); }
    .admin-avatar { width: 38px; height: 38px; background: linear-gradient(135deg, var(--accent-orange) 0%, #ef4444 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; }
    .admin-info { line-height: 1.3; }
    .admin-name { font-weight: 600; font-size: 0.875rem; }
    .admin-role { font-size: 0.75rem; color: var(--accent-orange); }
    .btn-logout { display: flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.25rem; background: var(--surface); border: 1px solid var(--border); border-radius: 10px; color: var(--text-muted); font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: all 0.3s ease; text-decoration: none; }
    .btn-logout:hover { background: var(--danger); border-color: var(--danger); color: white; }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
    .stat-card.emerald::before { background: var(--accent); }
    .stat-card.blue::before { background: var(--info); }
    .stat-card.orange::before { background: var(--warning); }
    .stat-card.red::before { background: var(--danger); }
    .stat-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
    .stat-card-title { font-size: 0.875rem; color: var(--text-muted); font-weight: 500; }
    .stat-card-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    .stat-card-icon svg { width: 22px; height: 22px; color: white; }
    .stat-card.emerald .stat-card-icon { background: linear-gradient(135deg, var(--accent) 0%, #059669 100%); }
    .stat-card.blue .stat-card-icon { background: linear-gradient(135deg, var(--info) 0%, #2563eb 100%); }
    .stat-card.orange .stat-card-icon { background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%); }
    .stat-card.red .stat-card-icon { background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%); }
    .stat-card-value { font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem; }
    .stat-card.emerald .stat-card-value { color: var(--accent); }
    .stat-card.blue .stat-card-value { color: var(--info); }
    .stat-card.orange .stat-card-value { color: var(--warning); }
    .stat-card.red .stat-card-value { color: var(--danger); }
    .stat-card-change { font-size: 0.8rem; display: flex; align-items: center; gap: 0.25rem; color: var(--text-muted); }

    .content-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 1.5rem; margin-bottom: 1.5rem; }
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.5rem; }
    .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
    .card-title { font-size: 1.1rem; font-weight: 600; }
    .progress { height: 12px; background: var(--primary); border-radius: 100px; overflow: hidden; }
    .progress-fill { height: 100%; background: linear-gradient(90deg, var(--accent) 0%, #34d399 100%); border-radius: 100px; transition: width 0.5s ease; }
    .kpi-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; }
    .kpi { background: var(--surface-hover); border: 1px solid var(--border); border-radius: 12px; padding: 0.85rem; }
    .kpi h4 { margin: 0; color: var(--text-muted); font-size: 0.9rem; }
    .kpi strong { display: block; margin-top: 0.35rem; font-size: 1.25rem; }

    .table-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
    table { width: 100%; border-collapse: collapse; }
    thead th { text-align: left; font-size: 0.85rem; color: var(--text-muted); padding-bottom: 0.6rem; }
    tbody td { padding: 0.6rem 0; border-top: 1px solid var(--border); font-size: 0.95rem; }
    tbody tr:last-child td { border-bottom: 1px solid var(--border); }
    .badge { padding: 0.35rem 0.7rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
    .badge.success { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); }
    .badge.warning { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); }
    .badge.info { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); }
    .badge.danger { background: rgba(248, 113, 113, 0.15); color: #f87171; border: 1px solid rgba(248, 113, 113, 0.35); }

    .activity-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.5rem; }
    .activity-list { list-style: none; }
    .activity-item { display: flex; align-items: flex-start; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid var(--border); }
    .activity-item:last-child { border-bottom: none; padding-bottom: 0; }
    .activity-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .activity-icon.success { background: rgba(16, 185, 129, 0.15); color: var(--success); }
    .activity-icon.warning { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
    .activity-icon.info { background: rgba(59, 130, 246, 0.15); color: var(--info); }
    .activity-text { font-size: 0.9rem; margin-bottom: 0.25rem; }
    .activity-time { font-size: 0.75rem; color: var(--text-muted); }

    @media (max-width: 1024px) {
        .dashboard-layout { flex-direction: column; }
        .sidebar { width: 100%; height: auto; position: relative; }
        .main-content { margin-left: 0; padding: 1.25rem; }
        .content-grid, .table-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-layout">
    <aside class="sidebar">
        <a href="/" class="sidebar-logo">
            <div class="sidebar-logo-icon">TB</div>
            <span class="sidebar-logo-text">TenantBill</span>
            <span class="sidebar-logo-badge">User</span>
        </a>
        <nav>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-title">Overview</li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-menu-link active">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="sidebar-menu-title">Billing</li>
                <li class="sidebar-menu-item"><a href="{{ route('bills.index') }}" class="sidebar-menu-link">Bills</a></li>
                <li class="sidebar-menu-item"><a href="{{ route('payments.index') }}" class="sidebar-menu-link">Payments</a></li>
                <li class="sidebar-menu-item"><a href="{{ route('tenants.index') }}" class="sidebar-menu-link">Tenants</a></li>
                <li class="sidebar-menu-title">Account</li>
                <li class="sidebar-menu-item"><a href="#" class="sidebar-menu-link">Profile</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header class="dashboard-header">
            <div class="dashboard-title">
                <p class="dashboard-title">Welcome back,</p>
                <h1>{{ $user->name }}</h1>
                <p>Here is your billing performance snapshot.</p>
            </div>
            <div class="header-actions">
                <div class="admin-profile">
                    <div class="admin-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div class="admin-info">
                        <div class="admin-name">{{ $user->name }}</div>
                        <div class="admin-role">{{ $user->email }}</div>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5m-6 7h1" />
                    </svg>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card emerald">
                <div class="stat-card-header">
                    <span class="stat-card-title">Total Bills</span>
                    <div class="stat-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.6 1m-2.6-1V4m0 4c-1.11 0-2.08-.402-2.6-1m2.6 1v4m0 4v2m0-2c-1.11 0-2.08-.402-2.6-1m5.2 0c-.52.598-1.49 1-2.6 1" />
                        </svg>
                    </div>
                </div>
                <div class="stat-card-value">{{ $totalBillsCount }}</div>
                <div class="stat-card-change">All recorded invoices</div>
            </div>

            <div class="stat-card blue">
                <div class="stat-card-header">
                    <span class="stat-card-title">Paid Bills</span>
                    <div class="stat-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="stat-card-value">{{ $paidBillsCount }}</div>
                <div class="stat-card-change">Payments captured successfully</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-card-header">
                    <span class="stat-card-title">Active / Pending</span>
                    <div class="stat-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                        </svg>
                    </div>
                </div>
                <div class="stat-card-value">{{ $activeBillsCount }}</div>
                <div class="stat-card-change">Awaiting payment or overdue</div>
            </div>

            <div class="stat-card red">
                <div class="stat-card-header">
                    <span class="stat-card-title">Outstanding Balance</span>
                    <div class="stat-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.6 1m-2.6-1V4m0 4c-1.11 0-2.08-.402-2.6-1m2.6 1v4m0 4v2m0-2c-1.11 0-2.08-.402-2.6-1m5.2 0c-.52.598-1.49 1-2.6 1" />
                        </svg>
                    </div>
                </div>
                <div class="stat-card-value">${{ number_format($outstandingBalance, 2) }}</div>
                <div class="stat-card-change">Amount remaining to collect</div>
            </div>

            <div class="stat-card emerald">
                <div class="stat-card-header">
                    <span class="stat-card-title">Collection Rate</span>
                    <div class="stat-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                    </div>
                </div>
                <div class="stat-card-value">{{ $collectionRate }}%</div>
                <div class="stat-card-change">Billed vs paid</div>
            </div>

            <div class="stat-card blue">
                <div class="stat-card-header">
                    <span class="stat-card-title">Tenants on File</span>
                    <div class="stat-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div class="stat-card-value">{{ $tenantCount }}</div>
                <div class="stat-card-change">Active tenant records</div>
            </div>
        </section>

        <section class="content-grid">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">Collection Health</h2>
                        <p style="color: var(--text-muted);">Progress based on billed vs paid amounts.</p>
                    </div>
                    <strong style="font-size: 1.4rem;">{{ $collectionRate }}%</strong>
                </div>
                <div class="progress"><div class="progress-fill" style="width: {{ min($collectionRate, 100) }}%;"></div></div>
                <div class="kpi-row" style="margin-top: 1rem;">
                    <div class="kpi"><h4>Total Billed</h4><strong>${{ number_format($totalBilled, 2) }}</strong></div>
                    <div class="kpi"><h4>Total Paid</h4><strong>${{ number_format($totalPaid, 2) }}</strong></div>
                    <div class="kpi"><h4>Outstanding</h4><strong>${{ number_format($outstandingBalance, 2) }}</strong></div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Upcoming Due Dates</h2>
                    <span style="color: var(--text-muted); font-size: 0.9rem;">Next {{ $upcomingBills->count() }} bills</span>
                </div>
                @if($upcomingBills->count())
                    <ul class="activity-list">
                        @foreach($upcomingBills as $bill)
                            <li class="activity-item" style="padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                                <div class="activity-icon {{ $bill->status === 'paid' ? 'success' : ($bill->status === 'overdue' ? 'warning' : 'info') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text" style="margin:0;">{{ $bill->bill_number }} • {{ optional($bill->tenant)->name ?? 'Unassigned' }}</p>
                                    <p class="activity-time" style="margin-top:0.25rem;">Due {{ optional($bill->due_date)->format('M d, Y') }}</p>
                                </div>
                                <div style="text-align:right;">
                                    <p style="margin:0; font-weight:700;">${{ number_format($bill->amount, 2) }}</p>
                                    <span class="badge @if($bill->status === 'paid') success @elseif($bill->status === 'overdue') danger @elseif($bill->status === 'pending' || $bill->status === 'partial') warning @else info @endif">{{ ucfirst($bill->status) }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p style="color: var(--text-muted);">No upcoming bills in the database.</p>
                @endif
            </div>
        </section>

        <section class="table-grid">
            <div class="card">
                <div class="card-header"><h2 class="card-title">Latest Bills</h2><span style="color: var(--text-muted); font-size: 0.9rem;">Synced from billing table</span></div>
                @if($latestBills->count())
                    <div class="table-responsive">
                        <table>
                            <thead><tr><th>Bill #</th><th>Tenant</th><th>Amount</th><th>Status</th><th>Due Date</th></tr></thead>
                            <tbody>
                                @foreach($latestBills as $bill)
                                    <tr>
                                        <td style="font-weight: 700;">{{ $bill->bill_number }}</td>
                                        <td>{{ optional($bill->tenant)->name ?? 'Unassigned' }}</td>
                                        <td style="font-weight: 700;">${{ number_format($bill->amount, 2) }}</td>
                                        <td><span class="badge @if($bill->status === 'paid') success @elseif($bill->status === 'overdue') danger @elseif($bill->status === 'partial' || $bill->status === 'pending') warning @else info @endif">{{ ucfirst($bill->status) }}</span></td>
                                        <td style="color: var(--text-muted);">{{ optional($bill->due_date)->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: var(--text-muted);">No billing records found yet.</p>
                @endif
            </div>

            <div class="card">
                <div class="card-header"><h2 class="card-title">Recent Payments</h2><span style="color: var(--text-muted); font-size: 0.9rem;">Live from payment history</span></div>
                @if($recentPayments->count())
                    <div class="table-responsive">
                        <table>
                            <thead><tr><th>Bill #</th><th>Tenant</th><th>Amount</th><th>Method</th><th>Date</th></tr></thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                    <tr>
                                        <td style="font-weight: 700;">{{ optional($payment->bill)->bill_number ?? 'N/A' }}</td>
                                        <td>{{ optional(optional($payment->bill)->tenant)->name ?? 'Unassigned' }}</td>
                                        <td style="font-weight: 700;">${{ number_format($payment->amount, 2) }}</td>
                                        <td style="color: var(--text-muted);">{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                                        <td style="color: var(--text-muted);">{{ optional($payment->payment_date)->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: var(--text-muted);">No payment activity recorded.</p>
                @endif
            </div>
        </section>

        <section class="activity-card">
            <div class="card-header"><h2 class="card-title">Recent Activity</h2><span style="color: var(--text-muted); font-size: 0.9rem;">Latest updates</span></div>
            @if($activityFeed->count())
                <ul class="activity-list">
                    @foreach($activityFeed as $activity)
                        <li class="activity-item">
                            <div class="activity-icon {{ $activity['type'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">{{ $activity['description'] }}</p>
                                <span class="activity-time">{{ $activity['time'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="color: var(--text-muted);">No recent activity</p>
            @endif
        </section>
    </main>
</div>
@endsection

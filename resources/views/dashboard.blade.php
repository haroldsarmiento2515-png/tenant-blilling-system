@extends('layouts.app')

@section('content')
@php
    $collectionRate = $totalBilled > 0 ? round(($totalPaid / $totalBilled) * 100) : 0;
    $totalBillsCount = $activeBillsCount + $paidBillsCount;
@endphp

<style>
    :root {
        --navy-900: #0f172a;
        --navy-800: #111c38;
        --navy-700: #14223f;
        --navy-600: #1d2c4d;
        --accent-green: #10b981;
        --accent-blue: #38bdf8;
        --accent-orange: #f59e0b;
        --accent-red: #ef4444;
        --muted: #8aa0bf;
        --text: #e9efff;
        --border: #263555;
    }

    body {
        background: radial-gradient(circle at 20% 20%, rgba(16, 185, 129, 0.08), transparent 30%),
            radial-gradient(circle at 80% 0%, rgba(56, 189, 248, 0.12), transparent 25%),
            var(--navy-900);
        color: var(--text);
    }

    .dashboard-shell {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 1.25rem;
        padding: 1.25rem;
    }

    .nav-panel {
        background: linear-gradient(160deg, var(--navy-800), var(--navy-700));
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 1.35rem;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        position: sticky;
        top: 1.25rem;
        height: fit-content;
    }

    .brand-block {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .brand-logo {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        font-weight: 800;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, #f97316, #ef4444);
        color: #0b1221;
        box-shadow: 0 12px 30px rgba(249, 115, 22, 0.35);
    }

    .brand-text { margin: 0; color: var(--muted); font-size: 0.85rem; }
    .brand-title { margin: 0; font-weight: 800; font-size: 1.2rem; }

    .nav-links { display: grid; gap: 0.35rem; }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.7rem 0.8rem;
        border-radius: 12px;
        color: var(--muted);
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.15s ease;
        font-weight: 600;
    }

    .nav-link .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(148, 163, 184, 0.4);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.06);
    }

    .nav-link:hover { color: #fff; border-color: var(--border); background: rgba(255, 255, 255, 0.03); }
    .nav-link.active { color: #fff; border-color: rgba(16, 185, 129, 0.4); background: rgba(16, 185, 129, 0.08); box-shadow: 0 10px 30px rgba(16, 185, 129, 0.2); }
    .nav-link.active .dot { background: var(--accent-green); }

    .support-box {
        margin-top: auto;
        padding: 1rem;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px dashed var(--border);
    }

    .support-box p { margin: 0; color: var(--muted); font-size: 0.9rem; }
    .support-box strong { display: block; margin-top: 0.25rem; }

    .main-area {
        background: linear-gradient(160deg, rgba(17, 24, 39, 0.5), rgba(17, 24, 39, 0.65));
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 1.5rem;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
        display: grid;
        gap: 1.25rem;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .welcome p { margin: 0; color: var(--muted); }
    .welcome h1 { margin: 0.35rem 0 0.25rem; font-size: 1.85rem; }

    .profile { display: flex; align-items: center; gap: 0.85rem; padding: 0.85rem 1rem; border-radius: 14px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); }
    .avatar { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, var(--accent-blue), #2563eb); display: grid; place-items: center; font-weight: 800; color: #0b1221; }
    .profile p { margin: 0; }
    .profile small { color: var(--muted); }

    .action-row { display: flex; gap: 0.65rem; align-items: center; flex-wrap: wrap; }
    .pill { padding: 0.55rem 0.85rem; border-radius: 12px; border: 1px solid var(--border); background: rgba(255, 255, 255, 0.03); color: var(--muted); font-weight: 700; display: inline-flex; align-items: center; gap: 0.4rem; }
    .logout { color: #fff; text-decoration: none; padding: 0.55rem 1rem; border-radius: 12px; background: linear-gradient(135deg, #f97316, #ef4444); font-weight: 700; box-shadow: 0 12px 30px rgba(239, 68, 68, 0.35); }

    .stat-grid { display: grid; gap: 0.85rem; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); }
    .stat-card { background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.01)); border: 1px solid var(--border); border-radius: 16px; padding: 1rem; position: relative; overflow: hidden; }
    .stat-card::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.04), transparent 45%); pointer-events: none; }
    .stat-card .label { margin: 0; color: var(--muted); font-size: 0.9rem; }
    .stat-card .value { margin: 0.35rem 0 0; font-weight: 800; font-size: 1.9rem; }
    .stat-card .hint { margin: 0.15rem 0 0; color: var(--muted); font-size: 0.85rem; }

    .stat-card .icon { width: 38px; height: 38px; border-radius: 12px; display: grid; place-items: center; font-weight: 800; color: #0b1221; }
    .accent-green { background: rgba(16, 185, 129, 0.18); color: #34d399; border: 1px solid rgba(16,185,129,0.4); }
    .accent-blue { background: rgba(56, 189, 248, 0.18); color: #7dd3fc; border: 1px solid rgba(56,189,248,0.4); }
    .accent-orange { background: rgba(245, 158, 11, 0.18); color: #fbbf24; border: 1px solid rgba(245,158,11,0.4); }
    .accent-red { background: rgba(239, 68, 68, 0.18); color: #fca5a5; border: 1px solid rgba(239,68,68,0.4); }

    .section-grid { display: grid; gap: 1rem; grid-template-columns: 1.2fr 0.8fr; align-items: stretch; }
    .panel { background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border); border-radius: 16px; padding: 1rem; }
    .panel h2 { margin: 0 0 0.25rem; }
    .panel p { margin: 0; color: var(--muted); }

    .progress-track { width: 100%; height: 12px; border-radius: 999px; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border); overflow: hidden; margin: 0.65rem 0; }
    .progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #10b981, #22d3ee); }

    .kpi-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.65rem; margin-top: 0.35rem; }
    .kpi { background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); border-radius: 12px; padding: 0.75rem; }
    .kpi h4 { margin: 0; font-size: 0.9rem; color: var(--muted); }
    .kpi strong { display: block; margin-top: 0.25rem; font-size: 1.2rem; }

    .table-flex { display: grid; gap: 1rem; grid-template-columns: 1fr 1fr; }
    .table-card { background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border); border-radius: 16px; padding: 1rem; }

    table { width: 100%; border-collapse: collapse; }
    thead th { text-align: left; font-size: 0.85rem; color: var(--muted); padding-bottom: 0.6rem; }
    tbody td { padding: 0.6rem 0; border-top: 1px solid var(--border); font-size: 0.95rem; }
    tbody tr:last-child td { border-bottom: 1px solid var(--border); }

    .badge { padding: 0.35rem 0.7rem; border-radius: 999px; font-size: 0.75rem; font-weight: 800; display: inline-block; }
    .badge.success { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); }
    .badge.warning { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); }
    .badge.info { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); }
    .badge.danger { background: rgba(248, 113, 113, 0.15); color: #f87171; border: 1px solid rgba(248, 113, 113, 0.35); }

    .list-stack { display: grid; gap: 0.85rem; }
    .list-item { display: flex; justify-content: space-between; gap: 1rem; padding: 0.85rem; border: 1px solid var(--border); border-radius: 14px; background: rgba(255, 255, 255, 0.02); }
    .list-item h4 { margin: 0 0 0.25rem; }
    .list-item p { margin: 0; color: var(--muted); }

    .chart-placeholder { display: flex; align-items: flex-end; gap: 0.4rem; margin-top: 0.75rem; height: 160px; }
    .bar { flex: 1; border-radius: 10px 10px 6px 6px; background: linear-gradient(180deg, rgba(56, 189, 248, 0.45), rgba(37, 99, 235, 0.2)); border: 1px solid rgba(56, 189, 248, 0.35); position: relative; overflow: hidden; }
    .bar.green { background: linear-gradient(180deg, rgba(16, 185, 129, 0.5), rgba(5, 150, 105, 0.25)); border-color: rgba(16, 185, 129, 0.35); }
    .bar.orange { background: linear-gradient(180deg, rgba(245, 158, 11, 0.5), rgba(217, 119, 6, 0.25)); border-color: rgba(245, 158, 11, 0.35); }
    .bar span { position: absolute; top: 8px; left: 8px; font-size: 0.75rem; color: #0b1221; font-weight: 800; }

    @media (max-width: 1100px) {
        .dashboard-shell { grid-template-columns: 1fr; }
        .nav-panel { position: relative; top: auto; }
        .table-flex, .section-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-shell">
    <aside class="nav-panel">
        <div class="brand-block">
            <div class="brand-logo">TB</div>
            <div>
                <p class="brand-text">TenantBill</p>
                <p class="brand-title">Dashboard</p>
            </div>
        </div>
        <nav class="nav-links">
            <a class="nav-link active" href="{{ route('dashboard') }}"><span class="dot"></span> Dashboard</a>
            <a class="nav-link" href="#"><span class="dot"></span> Tenants</a>
            <a class="nav-link" href="#"><span class="dot"></span> Properties</a>
            <a class="nav-link" href="#"><span class="dot"></span> Bills</a>
            <a class="nav-link" href="#"><span class="dot"></span> Payments</a>
            <a class="nav-link" href="#"><span class="dot"></span> Reports</a>
            <a class="nav-link" href="#"><span class="dot"></span> Analytics</a>
            <a class="nav-link" href="#"><span class="dot"></span> Settings</a>
        </nav>
        <div class="support-box">
            <p>Need assistance?</p>
            <strong>Support Center</strong>
            <p style="margin-top: 0.25rem;">We are always here to help.</p>
        </div>
    </aside>

    <section class="main-area">
        <div class="topbar">
            <div class="welcome">
                <p>Welcome back,</p>
                <h1>{{ $user->name }}</h1>
                <p>Here's what's happening today.</p>
            </div>
            <div class="action-row">
                <div class="pill">Total billed <strong>${{ number_format($totalBilled, 2) }}</strong></div>
                <div class="pill">Total paid <strong>${{ number_format($totalPaid, 2) }}</strong></div>
                <div class="profile">
                    <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div>
                        <p style="font-weight: 700;">{{ $user->name }}</p>
                        <small>{{ $user->email }}</small>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="icon accent-green">$</div>
                <p class="label">Total Bills</p>
                <p class="value">{{ $totalBillsCount }}</p>
                <p class="hint">All recorded invoices</p>
            </div>
            <div class="stat-card">
                <div class="icon accent-blue">✓</div>
                <p class="label">Paid Bills</p>
                <p class="value">{{ $paidBillsCount }}</p>
                <p class="hint">Payments captured successfully</p>
            </div>
            <div class="stat-card">
                <div class="icon accent-orange">!</div>
                <p class="label">Pending / Active</p>
                <p class="value">{{ $activeBillsCount }}</p>
                <p class="hint">Awaiting payment or overdue</p>
            </div>
            <div class="stat-card">
                <div class="icon accent-red">$</div>
                <p class="label">Outstanding Balance</p>
                <p class="value">${{ number_format($outstandingBalance, 2) }}</p>
                <p class="hint">Amount remaining to be collected</p>
            </div>
            <div class="stat-card">
                <div class="icon accent-blue">👥</div>
                <p class="label">Tenants on File</p>
                <p class="value">{{ $tenantCount }}</p>
                <p class="hint">Active records in database</p>
            </div>
            <div class="stat-card">
                <div class="icon accent-green">%</div>
                <p class="label">Collection Rate</p>
                <p class="value">{{ $collectionRate }}%</p>
                <p class="hint">Based on billed vs paid</p>
            </div>
        </div>

        <div class="section-grid">
            <div class="panel">
                <div style="display:flex; justify-content: space-between; align-items: baseline;">
                    <div>
                        <h2>Collection Rate</h2>
                        <p>Keep payments current to avoid late fees.</p>
                    </div>
                    <strong style="font-size: 1.4rem;">{{ $collectionRate }}%</strong>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ min($collectionRate, 100) }}%;"></div>
                </div>
                <div class="kpi-row">
                    <div class="kpi">
                        <h4>Total Billed</h4>
                        <strong>${{ number_format($totalBilled, 2) }}</strong>
                    </div>
                    <div class="kpi">
                        <h4>Total Paid</h4>
                        <strong>${{ number_format($totalPaid, 2) }}</strong>
                    </div>
                    <div class="kpi">
                        <h4>Outstanding</h4>
                        <strong>${{ number_format($outstandingBalance, 2) }}</strong>
                    </div>
                </div>
            </div>
            <div class="panel">
                <h2>Recent Activity Snapshot</h2>
                <p>Latest billing and payment momentum.</p>
                @php
                    $activityBars = collect($latestBills)->take(5)->map(function($bill) { return [
                        'label' => $bill->bill_number,
                        'height' => min(max(($bill->amount ?? 0) / 10, 8), 120),
                        'status' => $bill->status,
                    ]; });
                @endphp
                <div class="chart-placeholder">
                    @forelse($activityBars as $bar)
                        <div class="bar {{ $bar['status'] === 'paid' ? 'green' : ($bar['status'] === 'overdue' ? 'orange' : '') }}" style="height: {{ $bar['height'] }}px;">
                            <span>{{ $bar['label'] }}</span>
                        </div>
                    @empty
                        <p style="color: var(--muted);">No billing data to visualize yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="table-flex">
            <div class="table-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <h2 style="margin: 0;">Latest Bills</h2>
                    <span style="color: var(--muted); font-size: 0.9rem;">Synced from billing table</span>
                </div>
                @if($latestBills->count())
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Bill #</th>
                                    <th>Tenant</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestBills as $bill)
                                    <tr>
                                        <td style="font-weight: 700;">{{ $bill->bill_number }}</td>
                                        <td>{{ optional($bill->tenant)->name ?? 'Unassigned' }}</td>
                                        <td style="font-weight: 700;">${{ number_format($bill->amount, 2) }}</td>
                                        <td>
                                            <span class="badge
                                                @if($bill->status === 'paid') success
                                                @elseif($bill->status === 'overdue') danger
                                                @elseif($bill->status === 'partial' || $bill->status === 'pending') warning
                                                @else info @endif">
                                                {{ ucfirst($bill->status) }}
                                            </span>
                                        </td>
                                        <td style="color: var(--muted);">{{ optional($bill->due_date)->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: var(--muted);">No billing records found yet.</p>
                @endif
            </div>

            <div class="table-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <h2 style="margin: 0;">Upcoming Due Dates</h2>
                    <span style="color: var(--muted); font-size: 0.9rem;">Next 5 bills</span>
                </div>
                @if($upcomingBills->count())
                    <div class="list-stack">
                        @foreach($upcomingBills as $bill)
                            <div class="list-item">
                                <div>
                                    <h4 style="margin: 0;">{{ $bill->bill_number }}</h4>
                                    <p>{{ optional($bill->tenant)->name ?? 'Unassigned' }}</p>
                                    <p>Due {{ optional($bill->due_date)->format('M d, Y') }}</p>
                                </div>
                                <div style="text-align: right;">
                                    <p style="margin: 0; font-weight: 800;">${{ number_format($bill->amount, 2) }}</p>
                                    <span class="badge
                                        @if($bill->status === 'overdue') danger
                                        @elseif($bill->status === 'pending' || $bill->status === 'partial') warning
                                        @else info @endif">
                                        {{ ucfirst($bill->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--muted);">No upcoming bills in the database.</p>
                @endif
            </div>
        </div>

        <div class="table-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <h2 style="margin: 0;">Recent Payments</h2>
                <span style="color: var(--muted); font-size: 0.9rem;">Live from payment history</span>
            </div>
            @if($recentPayments->count())
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Bill #</th>
                                <th>Tenant</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPayments as $payment)
                                <tr>
                                    <td style="font-weight: 700;">{{ optional($payment->bill)->bill_number ?? 'N/A' }}</td>
                                    <td>{{ optional(optional($payment->bill)->tenant)->name ?? 'Unassigned' }}</td>
                                    <td style="font-weight: 700;">${{ number_format($payment->amount, 2) }}</td>
                                    <td style="color: var(--muted);">{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                                    <td style="color: var(--muted);">{{ optional($payment->payment_date)->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color: var(--muted);">No payment activity recorded.</p>
            @endif
        </div>
    </section>
</div>
@endsection

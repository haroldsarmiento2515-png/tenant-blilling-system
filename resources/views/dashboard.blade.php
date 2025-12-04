@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #0f172a;
        --primary-light: #1e293b;
        --accent: #10b981;
        --accent-hover: #059669;
        --accent-glow: rgba(16, 185, 129, 0.3);
        --warning: #f59e0b;
        --warning-glow: rgba(245, 158, 11, 0.3);
        --text: #f8fafc;
        --muted: #94a3b8;
        --surface: #1e293b;
        --surface-light: #243349;
        --border: #334155;
    }

    body {
        background: radial-gradient(circle at 20% 20%, rgba(16, 185, 129, 0.08), transparent 30%),
                    radial-gradient(circle at 80% 0%, rgba(59, 130, 246, 0.12), transparent 25%),
                    var(--primary);
        color: var(--text);
    }

    .user-dashboard {
        display: grid;
        grid-template-columns: 260px 1fr;
        min-height: calc(100vh - 40px);
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .sidebar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 1.5rem;
        position: sticky;
        top: 1.5rem;
        align-self: start;
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.25);
    }

    .sidebar .brand {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1.5rem;
        text-decoration: none;
    }

    .sidebar .brand .logo {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        font-weight: 800;
        background: linear-gradient(135deg, var(--warning) 0%, #ef4444 100%);
        color: #0b1221;
        box-shadow: 0 10px 30px var(--warning-glow);
    }

    .sidebar .brand strong {
        color: var(--text);
        font-size: 1.1rem;
    }

    .sidebar .stat {
        background: var(--surface-light);
        border: 1px solid var(--border);
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .sidebar .stat h4 {
        margin: 0 0 0.25rem;
        font-size: 0.95rem;
        color: var(--muted);
    }

    .sidebar .stat p {
        margin: 0;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .main-panel {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 1.5rem;
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.25);
    }

    .panel-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .user-meta p { margin: 0; color: var(--muted); }
    .user-meta h1 { margin: 0.15rem 0; font-size: 1.9rem; }

    .chip {
        display: inline-flex;
        gap: 0.35rem;
        align-items: center;
        padding: 0.55rem 0.75rem;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        font-weight: 600;
    }

    .chip strong { color: var(--text); }
    .chip span { color: var(--muted); }

    .logout {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1rem;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--warning) 0%, #ef4444 100%);
        color: #0b1221;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 30px var(--warning-glow);
    }

    .metric-grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 1.5rem; }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.02);
    }

    .card h3 { margin: 0 0 0.35rem; font-size: 1rem; color: var(--muted); }
    .card .value { font-size: 1.75rem; font-weight: 800; margin: 0; }
    .card .note { margin: 0.35rem 0 0; font-size: 0.85rem; color: var(--muted); }

    .data-grid { display: grid; gap: 1rem; grid-template-columns: 1.5fr 1fr; margin-bottom: 1rem; }
    .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 1.25rem; }

    table { width: 100%; border-collapse: collapse; }
    thead th { text-align: left; font-size: 0.85rem; color: var(--muted); padding-bottom: 0.75rem; }
    tbody td { padding: 0.75rem 0; border-top: 1px solid var(--border); font-size: 0.95rem; }
    tbody tr:last-child td { border-bottom: 1px solid var(--border); }

    .badge {
        padding: 0.35rem 0.65rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }

    .badge.success { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); }
    .badge.warning { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); }
    .badge.info { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); }
    .badge.danger { background: rgba(248, 113, 113, 0.15); color: #f87171; border: 1px solid rgba(248, 113, 113, 0.35); }

    .list-stack { display: grid; gap: 0.75rem; }
    .list-item { display: flex; justify-content: space-between; gap: 1rem; padding: 0.85rem; border: 1px solid var(--border); border-radius: 12px; background: var(--surface-light); }
    .list-item h4 { margin: 0 0 0.25rem; }
    .list-item p { margin: 0; color: var(--muted); }

    @media (max-width: 960px) {
        .user-dashboard { grid-template-columns: 1fr; }
        .sidebar { position: relative; top: auto; }
        .data-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="user-dashboard">
    <aside class="sidebar">
        <a href="#" class="brand">
            <span class="logo">TB</span>
            <div>
                <strong>Tenant Billing</strong>
                <p style="margin: 0; color: var(--muted); font-size: 0.85rem;">User Dashboard</p>
            </div>
        </a>
        <div class="stat">
            <h4>Total Billed</h4>
            <p>${{ number_format($totalBilled, 2) }}</p>
        </div>
        <div class="stat">
            <h4>Total Paid</h4>
            <p>${{ number_format($totalPaid, 2) }}</p>
        </div>
        <div class="stat">
            <h4>Tenants on File</h4>
            <p>{{ $tenantCount }}</p>
        </div>
    </aside>

    <section class="main-panel">
        <div class="panel-header">
            <div class="user-meta">
                <p>Welcome back,</p>
                <h1>{{ $user->name }}</h1>
                <p>{{ $user->email }}</p>
            </div>
            <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                <div class="chip"><span>Total Billed</span><strong>${{ number_format($totalBilled, 2) }}</strong></div>
                <div class="chip"><span>Total Paid</span><strong>${{ number_format($totalPaid, 2) }}</strong></div>
                <a href="{{ route('logout') }}" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

        <div class="metric-grid">
            <div class="card">
                <h3>Outstanding Balance</h3>
                <p class="value">${{ number_format($outstandingBalance, 2) }}</p>
                <p class="note">Keep payments current to avoid late fees.</p>
            </div>
            <div class="card">
                <h3>Payments Recorded</h3>
                <p class="value">${{ number_format($totalPaid, 2) }}</p>
                <p class="note">Latest activity synced from your records.</p>
            </div>
            <div class="card">
                <h3>Active Bills</h3>
                <p class="value">{{ $activeBillsCount }}</p>
                <p class="note">Pending, partial, and overdue invoices.</p>
            </div>
            <div class="card">
                <h3>Tenants on File</h3>
                <p class="value">{{ $tenantCount }}</p>
                <p class="note">Based on current database records.</p>
            </div>
        </div>

        <div class="data-grid">
            <div class="table-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
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
                                                @elseif($bill->status === 'partial') warning
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
                    <p class="note">No billing records found yet.</p>
                @endif
            </div>

            <div class="table-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="margin: 0;">Upcoming Due Dates</h2>
                    <span style="color: var(--muted); font-size: 0.9rem;">Next 5 bills</span>
                </div>
                @if($upcomingBills->count())
                    <div class="list-stack">
                        @foreach($upcomingBills as $bill)
                            <div class="list-item">
                                <div>
                                    <h4>{{ $bill->bill_number }}</h4>
                                    <p>{{ optional($bill->tenant)->name ?? 'Unassigned' }}</p>
                                    <p>Due {{ optional($bill->due_date)->format('M d, Y') }}</p>
                                </div>
                                <div style="text-align: right;">
                                    <p style="margin: 0; font-weight: 800;">${{ number_format($bill->amount, 2) }}</p>
                                    <span class="badge
                                        @if($bill->status === 'overdue') danger
                                        @elseif($bill->status === 'pending') warning
                                        @else info @endif">
                                        {{ ucfirst($bill->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="note">No upcoming bills in the database.</p>
                @endif
            </div>
        </div>

        <div class="table-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
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
                <p class="note">No payment activity recorded.</p>
            @endif
        </div>
    </section>
</div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - {{ config('app.name', 'TenantBill') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
        
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--primary);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.6;
        }
        
        /* Layout */
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--surface);
            border-right: 1px solid var(--border);
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            text-decoration: none;
        }
        
        .sidebar-logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--accent-orange) 0%, #ef4444 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px var(--accent-orange-glow);
        }
        
        .sidebar-logo-icon svg {
            width: 24px;
            height: 24px;
            color: white;
        }
        
        .sidebar-logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text);
        }
        
        .sidebar-logo-badge {
            font-size: 0.65rem;
            background: var(--accent-orange);
            color: white;
            padding: 0.15rem 0.5rem;
            border-radius: 100px;
            font-weight: 600;
            margin-left: -0.5rem;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .sidebar-menu-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
            margin-top: 1.5rem;
        }
        
        .sidebar-menu-item {
            margin-bottom: 0.25rem;
        }
        
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu-link:hover {
            background: var(--surface-hover);
            color: var(--text);
        }
        
        .sidebar-menu-link.active {
            background: linear-gradient(135deg, var(--accent-orange) 0%, #ef4444 100%);
            color: white;
            box-shadow: 0 4px 15px var(--accent-orange-glow);
        }
        
        .sidebar-menu-link svg {
            width: 20px;
            height: 20px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }
        
        /* Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .dashboard-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .dashboard-title p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--surface);
            padding: 0.5rem 1rem 0.5rem 0.5rem;
            border-radius: 100px;
            border: 1px solid var(--border);
        }
        
        .admin-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--accent-orange) 0%, #ef4444 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .admin-info {
            line-height: 1.3;
        }
        
        .admin-name {
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .admin-role {
            font-size: 0.75rem;
            color: var(--accent-orange);
        }
        
        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.25rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-logout:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
        }
        
        .btn-logout svg {
            width: 18px;
            height: 18px;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }
        
        .stat-card.emerald::before { background: var(--accent); }
        .stat-card.blue::before { background: var(--info); }
        .stat-card.orange::before { background: var(--warning); }
        .stat-card.red::before { background: var(--danger); }
        
        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .stat-card-title {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        
        .stat-card-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stat-card-icon svg {
            width: 22px;
            height: 22px;
            color: white;
        }
        
        .stat-card.emerald .stat-card-icon { background: linear-gradient(135deg, var(--accent) 0%, #059669 100%); }
        .stat-card.blue .stat-card-icon { background: linear-gradient(135deg, var(--info) 0%, #2563eb 100%); }
        .stat-card.orange .stat-card-icon { background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%); }
        .stat-card.red .stat-card-icon { background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%); }
        
        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-card.emerald .stat-card-value { color: var(--accent); }
        .stat-card.blue .stat-card-value { color: var(--info); }
        .stat-card.orange .stat-card-value { color: var(--warning); }
        .stat-card.red .stat-card-value { color: var(--danger); }
        
        .stat-card-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .stat-card-change.up { color: var(--success); }
        .stat-card-change.down { color: var(--danger); }
        
        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .chart-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
        }
        
        .chart-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .chart-card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .chart-card-subtitle {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        .chart-container {
            position: relative;
            height: 280px;
        }
        
        /* Progress Card */
        .progress-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .progress-title {
            font-size: 1rem;
            font-weight: 600;
        }
        
        .progress-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent);
        }
        
        .progress-bar {
            height: 12px;
            background: var(--primary);
            border-radius: 100px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent) 0%, #34d399 100%);
            border-radius: 100px;
            transition: width 0.5s ease;
        }
        
        /* Recent Activity */
        .activity-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
        }
        
        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .activity-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .activity-list {
            list-style: none;
        }
        
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }
        
        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .activity-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .activity-icon.success { background: rgba(16, 185, 129, 0.15); color: var(--success); }
        .activity-icon.warning { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
        .activity-icon.info { background: rgba(59, 130, 246, 0.15); color: var(--info); }
        
        .activity-icon svg {
            width: 18px;
            height: 18px;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-text {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .activity-time {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted);
        }
        
        .empty-state svg {
            width: 48px;
            height: 48px;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: flex;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="/" class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="sidebar-logo-text">TenantBill</span>
                <span class="sidebar-logo-badge">Admin</span>
            </a>
            
            <nav>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-title">Main Menu</li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link active">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-title">Management</li>
                    <li class="sidebar-menu-item">
                        <a href="#" class="sidebar-menu-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Tenants
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="#" class="sidebar-menu-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Properties
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-title">Billing</li>
                    <li class="sidebar-menu-item">
                        <a href="#" class="sidebar-menu-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Bills
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="#" class="sidebar-menu-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Payments
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-title">Reports</li>
                    <li class="sidebar-menu-item">
                        <a href="#" class="sidebar-menu-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Analytics
                        </a>
                    </li>
                    
                    <li class="sidebar-menu-title">Settings</li>
                    <li class="sidebar-menu-item">
                        <a href="#" class="sidebar-menu-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="dashboard-header">
                <div class="dashboard-title">
                    <h1>Dashboard</h1>
                    <p>Welcome back, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}! Here's what's happening today.</p>
                </div>
                
                <div class="header-actions">
                    <div class="admin-profile">
                        <div class="admin-avatar">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="admin-info">
                            <div class="admin-name">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</div>
                            <div class="admin-role">{{ ucfirst(Auth::guard('admin')->user()->role ?? 'Admin') }}</div>
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </header>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card emerald">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Users</span>
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card-value">{{ $totalUsers ?? 0 }}</div>
                    <div class="stat-card-change up">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        Registered Users
                    </div>
                </div>
                
                <div class="stat-card blue">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Bills</span>
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card-value">{{ $totalBills ?? 0 }}</div>
                    <div class="stat-card-change">All Time</div>
                </div>
                
                <div class="stat-card orange">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Pending Bills</span>
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card-value">{{ $pendingBills ?? 0 }}</div>
                    <div class="stat-card-change">Awaiting Payment</div>
                </div>
                
                <div class="stat-card red">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Overdue Bills</span>
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card-value">{{ $overdueBills ?? 0 }}</div>
                    <div class="stat-card-change down">Needs Attention</div>
                </div>
            </div>
            
            <!-- Collection Rate Progress -->
            <div class="progress-card">
                <div class="progress-header">
                    <span class="progress-title">Collection Rate</span>
                    <span class="progress-value">{{ $collectionRate ?? 0 }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $collectionRate ?? 0 }}%"></div>
                </div>
            </div>
            
            <!-- Charts -->
            <div class="charts-grid">
                <div class="chart-card">
                    <div class="chart-card-header">
                        <div>
                            <div class="chart-card-title">Registered Users</div>
                            <div class="chart-card-subtitle">Monthly registration trends</div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-card">
                    <div class="chart-card-header">
                        <div>
                            <div class="chart-card-title">Billing Overview</div>
                            <div class="chart-card-subtitle">Payment status distribution</div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="billingChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="activity-card">
                <div class="activity-header">
                    <h3 class="activity-title">Recent Activity</h3>
                </div>
                
                @if(isset($recentActivities) && count($recentActivities) > 0)
                    <ul class="activity-list">
                        @foreach($recentActivities as $activity)
                            <li class="activity-item">
                                <div class="activity-icon {{ $activity->type }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">{{ $activity->description }}</p>
                                    <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p>No recent activity</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
    
    <script>
        // Users Chart
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($userChartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                datasets: [{
                    label: 'Registered Users',
                    data: {!! json_encode($userChartData ?? [0, 0, 0, 0, 0, 0]) !!},
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
        
        // Billing Chart
        const billingCtx = document.getElementById('billingChart').getContext('2d');
        new Chart(billingCtx, {
            type: 'doughnut',
            data: {
                labels: ['Paid', 'Pending', 'Overdue'],
                datasets: [{
                    data: {!! json_encode($billingChartData ?? [0, 0, 0]) !!},
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '65%'
            }
        });
    </script>
</body>
</html>
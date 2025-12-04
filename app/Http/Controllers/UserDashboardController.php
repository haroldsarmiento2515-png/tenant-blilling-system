<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard with key billing insights.
     */
    public function index()
    {
        $user = Auth::user();

        $tenantCount = Tenant::count();
        $activeBillsCount = Bill::whereIn('status', ['pending', 'partial', 'overdue'])->count();
        $paidBillsCount = Bill::where('status', 'paid')->count();

        $totalBilled = Bill::sum('amount');
        $totalPaid = Payment::sum('amount');
        $outstandingBalance = max($totalBilled - $totalPaid, 0);

        $latestBills = Bill::with('tenant')
            ->latest()
            ->take(5)
            ->get();

        $upcomingBills = Bill::with('tenant')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $recentPayments = Payment::with('bill.tenant')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'tenantCount',
            'activeBillsCount',
            'paidBillsCount',
            'outstandingBalance',
            'latestBills',
            'upcomingBills',
            'recentPayments',
            'totalPaid',
            'totalBilled'
        ));
    }
}

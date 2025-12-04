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
        $totalBillsCount = Bill::count();
        $activeBillsCount = Bill::whereIn('status', ['pending', 'partial', 'overdue'])->count();
        $paidBillsCount = Bill::where('status', 'paid')->count();

        $totalBilled = Bill::sum('amount');
        $totalPaid = Payment::sum('amount');
        $outstandingBalance = max($totalBilled - $totalPaid, 0);
        $collectionRate = $totalBilled > 0 ? round(($totalPaid / $totalBilled) * 100) : 0;

        $latestBills = Bill::with('tenant')
            ->latest()
            ->take(5)
            ->get();

        $upcomingBills = Bill::with('tenant')
            ->whereDate('due_date', '>=', now())
            ->where('status', '!=', 'paid')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $recentPayments = Payment::with('bill.tenant')
            ->latest()
            ->take(5)
            ->get();

        $activityFeed = $latestBills->map(function ($bill) {
            return [
                'description' => "Bill {$bill->bill_number} for " . (optional($bill->tenant)->name ?? 'Unassigned'),
                'time' => optional($bill->created_at)->diffForHumans() ?? 'Recently',
                'type' => $bill->status === 'paid' ? 'success' : ($bill->status === 'overdue' ? 'warning' : 'info'),
            ];
        });

        return view('dashboard', compact(
            'user',
            'tenantCount',
            'totalBillsCount',
            'activeBillsCount',
            'paidBillsCount',
            'outstandingBalance',
            'latestBills',
            'upcomingBills',
            'recentPayments',
            'totalPaid',
            'totalBilled',
            'collectionRate',
            'activityFeed'
        ));
    }
}

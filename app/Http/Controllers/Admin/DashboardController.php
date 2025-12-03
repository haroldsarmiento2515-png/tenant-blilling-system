<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get statistics
        $totalUsers = User::count();
        $totalBills = Bill::count();
        $paidBills = Bill::where('status', 'paid')->count();
        $pendingBills = Bill::where('status', 'pending')->count();
        $overdueBills = Bill::where('status', 'overdue')->count();
        
        // Calculate collection rate
        $collectionRate = $totalBills > 0 
            ? round(($paidBills / $totalBills) * 100, 1) 
            : 0;
        
        // Get user registration data for chart (last 6 months)
        $userChartLabels = [];
        $userChartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $userChartLabels[] = $date->format('M');
            $userChartData[] = User::whereYear('created_at', $date->year)
                                   ->whereMonth('created_at', $date->month)
                                   ->count();
        }
        
        // Get billing data for chart
        $billingChartData = [
            $paidBills,
            $pendingBills,
            $overdueBills
        ];
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBills',
            'paidBills',
            'pendingBills',
            'overdueBills',
            'collectionRate',
            'userChartLabels',
            'userChartData',
            'billingChartData'
        ));
    }
    
    /**
     * Get user chart data via AJAX (real-time)
     */
    public function getUserChartData()
    {
        $userChartLabels = [];
        $userChartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $userChartLabels[] = $date->format('M');
            $userChartData[] = User::whereYear('created_at', $date->year)
                                   ->whereMonth('created_at', $date->month)
                                   ->count();
        }
        
        return response()->json([
            'labels' => $userChartLabels,
            'data' => $userChartData
        ]);
    }
    
    /**
     * Get billing chart data via AJAX (real-time)
     */
    public function getBillingChartData()
    {
        $paidBills = Bill::where('status', 'paid')->count();
        $pendingBills = Bill::where('status', 'pending')->count();
        $overdueBills = Bill::where('status', 'overdue')->count();
        
        return response()->json([
            'labels' => ['Paid', 'Pending', 'Overdue'],
            'data' => [$paidBills, $pendingBills, $overdueBills]
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get user registration statistics
        $userStats = $this->getUserRegistrationStats();
        
        // Get billing statistics
        $billingStats = $this->getBillingStats();
        
        // Get recent activities
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recentTenants = Tenant::orderBy('created_at', 'desc')->limit(5)->get();
        
        return View::make('admin.dashboard', compact('userStats', 'billingStats', 'recentUsers', 'recentTenants'));
    }
    
    /**
     * Get user registration statistics.
     */
    private function getUserRegistrationStats()
    {
        // Get monthly user registrations for the last 6 months
        $stats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = User::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
            
            $stats[] = [
                'month' => $month->format('M Y'),
                'count' => $count
            ];
        }
        
        return $stats;
    }
    
    /**
     * Get billing statistics.
     */
    private function getBillingStats()
    {
        $totalBills = Bill::count();
        $paidBills = Bill::where('status', 'paid')->count();
        $pendingBills = Bill::where('status', 'pending')->count();
        $overdueBills = Bill::where('status', 'overdue')->count();
        
        $totalAmount = Bill::sum('amount');
        $paidAmount = Bill::where('status', 'paid')->sum('amount');
        
        return [
            'total_bills' => $totalBills,
            'paid_bills' => $paidBills,
            'pending_bills' => $pendingBills,
            'overdue_bills' => $overdueBills,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'collection_rate' => $totalBills > 0 ? round(($paidBills / $totalBills) * 100, 2) : 0
        ];
    }
    
    /**
     * Get chart data for user registrations.
     */
    public function getUserChartData()
    {
        $stats = $this->getUserRegistrationStats();
        
        $labels = array_column($stats, 'month');
        $data = array_column($stats, 'count');
        
        return Response::json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
    
    /**
     * Get chart data for billing statistics.
     */
    public function getBillingChartData()
    {
        $billingStats = $this->getBillingStats();
        
        $labels = ['Paid', 'Pending', 'Overdue'];
        $data = [$billingStats['paid_bills'], $billingStats['pending_bills'], $billingStats['overdue_bills']];
        
        return Response::json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
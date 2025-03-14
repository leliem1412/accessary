<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\OrderPaymentHistory;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();
        $totalCustomers = Customer::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalSalesOrders = SalesOrder::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalRevenue = OrderPaymentHistory::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        $revenueByMonth = OrderPaymentHistory::selectRaw('sum(amount) as revenue, DATE_FORMAT(created_at, "%d-%m-%Y") as date')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = [
            'totalCustomers' => $totalCustomers,
            'totalSalesOrders' => $totalSalesOrders,
            'totalRevenue' => $totalRevenue,
            'revenueByMonth' => $revenueByMonth,
        ];

        return view('dashboard.index', $data);
    }
}

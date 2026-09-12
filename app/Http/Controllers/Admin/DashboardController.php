<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'cars'      => Car::count(),
            'customers' => Customer::where('role', 'user')->count(),
            'orders'    => Order::count(),
            'revenue'   => Order::sum('total'),
        ];

        $recentOrders = Order::with('customer')->latest()->take(5)->get();

        $topCars = Car::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)->get();

        $statusBreakdown = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        $regularCount = Customer::where('is_regular', true)->count();
        $newCount     = Customer::where('is_regular', false)->where('role', 'user')->count();

        // Monthly revenue for simple bar chart (last 6 months)
        $monthly = Order::select(
                DB::raw("DATE_FORMAT(sale_date, '%Y-%m') as ym"),
                DB::raw('SUM(total) as total')
            )
            ->where('sale_date', '>=', now()->subMonths(6))
            ->groupBy('ym')->orderBy('ym')->pluck('total', 'ym');

        return view('admin.dashboard', compact(
            'stats', 'recentOrders', 'topCars', 'statusBreakdown',
            'regularCount', 'newCount', 'monthly'
        ));
    }
}
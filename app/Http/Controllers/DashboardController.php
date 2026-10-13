<?php

namespace App\Http\Controllers;

use App\Models\CateringBooking;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $lowStock = Product::whereColumn('quantity', '<=', 'reorder_level')->orderBy('quantity')->get();
        $todaySales = Sale::whereDate('sale_date', now()->toDateString())->sum('total');
        $monthSales = Sale::whereMonth('sale_date', now()->month)->whereYear('sale_date', now()->year)->sum('total');
        $pendingOrders = Sale::where('status', 'pending')->where('channel', 'online')->count();
        $pendingBookingRequests = CateringBooking::where('status', 'pending')->where('source', 'customer')->count();
        $upcomingBookings = CateringBooking::with('customer')
            ->where('event_date', '>=', now()->toDateString())
            ->where('status', '!=', 'cancelled')
            ->orderBy('event_date')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'productCount', 'lowStock', 'todaySales', 'monthSales', 'upcomingBookings', 'pendingOrders', 'pendingBookingRequests'
        ));
    }
}

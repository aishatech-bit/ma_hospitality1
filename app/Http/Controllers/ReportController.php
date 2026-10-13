<?php

namespace App\Http\Controllers;

use App\Models\CateringBooking;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());

        $salesTotal = Sale::whereBetween('sale_date', [$from, $to])->sum('total');
        $salesCount = Sale::whereBetween('sale_date', [$from, $to])->count();

        $topProducts = Product::withSum(['saleItems as sold_qty' => function ($q) use ($from, $to) {
                $q->whereHas('sale', fn ($s) => $s->whereBetween('sale_date', [$from, $to]));
            }], 'quantity')
            ->orderByDesc('sold_qty')
            ->take(5)
            ->get();

        $lowStock = Product::whereColumn('quantity', '<=', 'reorder_level')->orderBy('quantity')->get();

        $bookings = CateringBooking::whereBetween('event_date', [$from, $to])
            ->orderBy('event_date')
            ->get();

        $bookingsByStatus = $bookings->groupBy('status')->map->count();

        return view('reports.index', compact(
            'from', 'to', 'salesTotal', 'salesCount', 'topProducts', 'lowStock', 'bookings', 'bookingsByStatus'
        ));
    }
}

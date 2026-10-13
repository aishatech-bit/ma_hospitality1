<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $sales = Sale::with('customer', 'items.product')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('sale_date', $request->date))
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();

        return view('sales.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:customers,id'],
            'sale_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:255'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        // Validate stock availability up front so we can show a friendly error.
        foreach ($data['products'] as $line) {
            $product = Product::find($line['product_id']);
            if ($product && $product->quantity < (int) $line['quantity']) {
                return back()
                    ->withErrors(['products' => "Insufficient stock for {$product->name}. Only {$product->quantity} left."])
                    ->withInput();
            }
        }

        $sale = DB::transaction(function () use ($data) {
            $sale = Sale::create([
                'customer_id' => $data['customer_id'] ?? null,
                'channel' => 'in_store',
                'status' => 'completed',
                'sale_date' => $data['sale_date'],
                'notes' => $data['notes'] ?? null,
                'total' => 0,
            ]);

            $total = 0;

            foreach ($data['products'] as $line) {
                $product = Product::findOrFail($line['product_id']);
                $qty = (int) $line['quantity'];

                $subtotal = $product->price * $qty;
                $total += $subtotal;

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->reduceStock($qty);
            }

            $sale->update(['total' => $total]);

            return $sale;
        });

        return redirect()->route('sales.index')->with('status', 'Sale #'.$sale->id.' recorded successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');

        return view('sales.show', compact('sale'));
    }

    /**
     * Mark a pending online order as fulfilled once staff have prepared
     * and handed it over / dispatched it for delivery.
     */
    public function fulfil(Sale $sale)
    {
        $sale->update(['status' => 'completed']);

        return back()->with('status', 'Order #'.$sale->id.' marked as fulfilled.');
    }
}

<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create(CartController $cart)
    {
        [$items, $total] = $cart->cartItems();

        if (empty($items)) {
            return redirect()->route('storefront.cart')->with('status', 'Your cart is empty.');
        }

        return view('storefront.checkout.create', compact('items', 'total'));
    }

    public function store(Request $request, CartController $cart)
    {
        [$items, $total] = $cart->cartItems();

        if (empty($items)) {
            return redirect()->route('storefront.cart')->with('status', 'Your cart is empty.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'delivery_address' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        // Re-check stock at the point of checkout in case it changed.
        foreach ($items as $line) {
            $fresh = Product::find($line['product']->id);
            if (! $fresh || $fresh->quantity < $line['quantity']) {
                return back()->withErrors([
                    'stock' => "Sorry, {$line['product']->name} no longer has enough stock. Please update your cart.",
                ])->withInput();
            }
        }

        $sale = DB::transaction(function () use ($data, $items, $total) {
            $customer = Customer::firstOrCreate(
                ['phone' => $data['phone']],
                ['name' => $data['name'], 'email' => $data['email'] ?? null, 'address' => $data['delivery_address']]
            );

            $sale = Sale::create([
                'customer_id' => $customer->id,
                'channel' => 'online',
                'status' => 'pending',
                'customer_phone' => $data['phone'],
                'delivery_address' => $data['delivery_address'],
                'sale_date' => now()->toDateString(),
                'notes' => $data['notes'] ?? null,
                'total' => 0,
            ]);

            $runningTotal = 0;

            foreach ($items as $line) {
                $product = Product::findOrFail($line['product']->id);
                $subtotal = $product->price * $line['quantity'];
                $runningTotal += $subtotal;

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $line['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->reduceStock($line['quantity']);
            }

            $sale->update(['total' => $runningTotal]);

            return $sale;
        });

        session(['cart' => []]);

        return redirect()->route('storefront.order.confirmation', $sale)->with('status', 'Order placed!');
    }

    public function confirmation(Sale $sale)
    {
        $sale->load('customer', 'items.product');

        return view('storefront.checkout.confirmation', compact('sale'));
    }
}

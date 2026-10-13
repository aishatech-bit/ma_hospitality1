<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        [$items, $total] = $this->cartItems();

        return view('storefront.cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('quantity', 1));

        $cart = session('cart', []);
        $cart[$product->id] = min(($cart[$product->id] ?? 0) + $qty, $product->quantity ?: $qty);
        session(['cart' => $cart]);

        return back()->with('status', $product->name.' added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $qty = (int) $request->input('quantity', 1);
        $cart = session('cart', []);

        if ($qty <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = min($qty, max($product->quantity, 1));
        }

        session(['cart' => $cart]);

        return back()->with('status', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back()->with('status', 'Item removed from cart.');
    }

    /**
     * Resolve the current cart into product + line-total data, dropping
     * any items whose product no longer exists or is out of stock.
     */
    public function cartItems(): array
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if (! $product || $qty < 1) {
                continue;
            }
            $qty = min($qty, max($product->quantity, 0));
            if ($qty < 1) {
                continue;
            }
            $subtotal = $product->price * $qty;
            $items[] = ['product' => $product, 'quantity' => $qty, 'subtotal' => $subtotal];
            $total += $subtotal;
        }

        return [$items, $total];
    }
}

<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = $request->string('search');
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('category', 'like', "%{$term}%");
            })
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        $categories = Product::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('storefront.shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $related = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('storefront.shop.show', compact('product', 'related'));
    }
}

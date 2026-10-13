<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::where('quantity', '>', 0)->orderByDesc('id')->take(6)->get();

        return view('storefront.home', compact('featured'));
    }
}

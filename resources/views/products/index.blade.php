@extends('layouts.app')

@section('title', 'Inventory')
@section('subtitle', 'Manage products and monitor stock levels.')
@section('actions')
    <a href="{{ route('products.create') }}" class="bg-[#111318] text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-black">+ Add Product</a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-black/5">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, SKU or category..."
                   class="flex-1 rounded-lg border border-black/10 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
            <button class="bg-[#F6F5F2] px-4 py-2 rounded-lg text-sm font-medium border border-black/10">Search</button>
        </form>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-[#F6F5F2] text-[#6B6862] text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-3">Product</th>
                <th class="text-left px-4 py-3">Category</th>
                <th class="text-left px-4 py-3">SKU</th>
                <th class="text-right px-4 py-3">Price</th>
                <th class="text-right px-4 py-3">Stock</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($products as $product)
                <tr class="{{ $product->isLowStock() ? 'bg-red-50/50' : '' }}">
                    <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-[#6B6862]">{{ $product->category ?? '—' }}</td>
                    <td class="px-4 py-3 text-[#6B6862]">{{ $product->sku ?? '—' }}</td>
                    <td class="px-4 py-3 text-right">&#8358;{{ number_format($product->price, 2) }}</td>
                    <td class="px-4 py-3 text-right font-medium {{ $product->isLowStock() ? 'text-red-600' : '' }}">
                        {{ $product->quantity }}
                        @if ($product->isLowStock())
                            <span class="text-[10px] uppercase font-semibold ml-1">low</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap">
                        <a href="{{ route('products.edit', $product) }}" class="text-[#C9A24B] font-medium hover:underline">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" onsubmit="return confirm('Remove this product?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 font-medium hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-[#8C8A85]">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-black/5">{{ $products->links() }}</div>
</div>
@endsection

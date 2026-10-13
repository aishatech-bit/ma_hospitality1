@extends('layouts.storefront')

@section('title', 'Your Cart')

@section('content')
<div class="mb-8 flex items-center justify-between gap-3">
    <div>
        <p class="text-xs uppercase tracking-[0.28em] text-[#8C8A85] font-semibold">Shopping cart</p>
        <h1 class="mt-2 text-3xl font-extrabold">My Cart</h1>
    </div>
    <a href="{{ route('storefront.shop') }}" class="text-sm font-semibold text-[#111318] hover:text-[#C9A24B]">Continue shopping &rarr;</a>
</div>

@if (empty($items))
    <div class="rounded-[28px] border border-[#E7E5E2] bg-white p-10 text-center shadow-sm">
        <div class="text-5xl mb-4">🛍️</div>
        <p class="text-lg font-semibold text-[#111318] mb-2">Your cart is empty</p>
        <p class="text-sm text-[#6B6862] mb-6">Start adding products to build your next order.</p>
        <a href="{{ route('storefront.shop') }}" class="inline-block rounded-xl bg-[#111318] px-5 py-2.5 text-sm font-semibold text-white hover:bg-black">Browse the shop</a>
    </div>
@else
    <div class="grid gap-8 lg:grid-cols-[1.5fr_0.7fr]">
        <div class="overflow-hidden rounded-[28px] border border-[#E7E5E2] bg-white shadow-sm">
            @foreach ($items as $line)
                <div class="flex flex-col gap-4 border-b border-[#F0EEE9] p-4 md:flex-row md:items-center md:p-5">
                    <img src="{{ $line['product']->imageUrl() }}" alt="{{ $line['product']->name }}" class="h-24 w-24 rounded-2xl object-cover">
                    <div class="flex-1">
                        <div class="text-xs uppercase tracking-[0.2em] text-[#8C8A85]">{{ $line['product']->category ?? 'General' }}</div>
                        <div class="mt-1 text-lg font-semibold text-[#111318]">{{ $line['product']->name }}</div>
                        <div class="mt-1 text-sm text-[#6B6862]">&#8358;{{ number_format($line['product']->price, 2) }} each</div>
                    </div>
                    <div class="flex flex-col items-start gap-3 md:items-end">
                        <form method="POST" action="{{ route('storefront.cart.update', $line['product']) }}" class="flex items-center gap-2">
                            @csrf
                            <label class="text-xs uppercase tracking-[0.2em] text-[#8C8A85]">Qty</label>
                            <input type="number" name="quantity" value="{{ $line['quantity'] }}" min="1" max="{{ $line['product']->quantity }}"
                                   class="w-16 rounded-xl border border-[#E7E5E2] px-2 py-1.5 text-center text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
                            <button class="rounded-lg bg-[#F7F6F4] px-2.5 py-1.5 text-xs font-semibold text-[#111318] hover:bg-[#efeae0]">Update</button>
                        </form>
                        <div class="flex items-center gap-4">
                            <div class="text-lg font-extrabold text-[#111318]">&#8358;{{ number_format($line['subtotal'], 2) }}</div>
                            <form method="POST" action="{{ route('storefront.cart.remove', $line['product']) }}">
                                @csrf
                                <button class="text-xs font-semibold text-red-600 hover:text-red-700">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <aside class="rounded-[28px] border border-[#E7E5E2] bg-white p-6 shadow-sm">
            <h2 class="text-xl font-extrabold">Order summary</h2>
            <div class="mt-5 space-y-3 text-sm text-[#6B6862]">
                <div class="flex items-center justify-between"><span>Subtotal</span><span class="font-medium text-[#111318]">&#8358;{{ number_format($total, 2) }}</span></div>
                <div class="flex items-center justify-between"><span>Delivery</span><span class="font-medium text-[#111318]">Free</span></div>
                <div class="flex items-center justify-between"><span>Taxes</span><span class="font-medium text-[#111318]">Calculated at checkout</span></div>
            </div>
            <div class="mt-6 flex items-center justify-between border-t border-[#F0EEE9] pt-5">
                <span class="text-lg font-bold">Total</span>
                <span class="text-2xl font-extrabold text-[#111318]">&#8358;{{ number_format($total, 2) }}</span>
            </div>
            <a href="{{ route('storefront.checkout') }}" class="mt-6 block rounded-xl bg-[#111318] px-5 py-3 text-center text-sm font-semibold text-white hover:bg-black">Proceed to checkout</a>
        </aside>
    </div>
@endif
@endsection

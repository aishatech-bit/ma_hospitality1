@extends('layouts.storefront')

@section('title', 'Order Confirmed')

@section('content')
<div class="mx-auto max-w-2xl py-8 text-center">
    <div class="mb-5 text-6xl">✅</div>
    <p class="text-xs uppercase tracking-[0.28em] text-[#8C8A85] font-semibold">Order received</p>
    <h1 class="mt-3 text-3xl font-extrabold">Order #{{ $sale->id }} confirmed</h1>
    <p class="mt-4 text-[#6B6862]">Thanks, {{ $sale->customer->name ?? 'friend' }}. Our team will confirm and prepare your order shortly. We'll reach out on {{ $sale->customer_phone }} if needed.</p>

    <div class="mt-8 rounded-[28px] border border-[#E7E5E2] bg-white p-6 text-left shadow-sm">
        <div class="space-y-3">
            @foreach ($sale->items as $item)
                <div class="flex items-center justify-between border-b border-[#F0EEE9] pb-3 last:border-0 last:pb-0">
                    <div>
                        <div class="font-semibold text-[#111318]">{{ $item->product->name ?? 'Product' }}</div>
                        <div class="text-xs text-[#6B6862]">Qty {{ $item->quantity }}</div>
                    </div>
                    <div class="font-bold text-[#111318]">&#8358;{{ number_format($item->subtotal, 2) }}</div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 flex items-center justify-between border-t border-[#F0EEE9] pt-4">
            <span class="font-semibold">Total</span>
            <span class="text-xl font-extrabold text-[#111318]">&#8358;{{ number_format($sale->total, 2) }}</span>
        </div>
        <div class="mt-5 rounded-2xl bg-[#F7F6F4] p-3 text-sm text-[#6B6862]">
            Delivery to: {{ $sale->delivery_address }}
        </div>
    </div>

    <a href="{{ route('storefront.shop') }}" class="mt-8 inline-block text-sm font-semibold text-[#111318] hover:text-[#C9A24B]">&larr; Continue shopping</a>
</div>
@endsection

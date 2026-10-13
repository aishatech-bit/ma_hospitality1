@extends('layouts.storefront')

@section('title', 'Checkout')

@section('content')
<div class="mb-8">
    <p class="text-xs uppercase tracking-[0.28em] text-[#8C8A85] font-semibold">Secure checkout</p>
    <h1 class="mt-2 text-3xl font-extrabold">Place your order</h1>
</div>

<div class="grid gap-8 lg:grid-cols-[1.4fr_0.8fr]">
    <div class="rounded-[28px] border border-[#E7E5E2] bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('storefront.checkout.store') }}" class="space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-[#6B6862]">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-[#E7E5E2] bg-[#F7F6F4] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
                </div>
                <div>
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-[#6B6862]">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full rounded-xl border border-[#E7E5E2] bg-[#F7F6F4] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
                </div>
            </div>
            <div>
                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-[#6B6862]">Email (optional)</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border border-[#E7E5E2] bg-[#F7F6F4] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
            </div>
            <div>
                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-[#6B6862]">Delivery Address</label>
                <input type="text" name="delivery_address" value="{{ old('delivery_address') }}" required placeholder="Where should we deliver this?" class="w-full rounded-xl border border-[#E7E5E2] bg-[#F7F6F4] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
            </div>
            <div>
                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-[#6B6862]">Order Notes (optional)</label>
                <input type="text" name="notes" value="{{ old('notes') }}" class="w-full rounded-xl border border-[#E7E5E2] bg-[#F7F6F4] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
            </div>
            <div class="rounded-2xl border border-[#E7E5E2] bg-[#F7F6F4] p-4 text-sm text-[#6B6862]">
                Payment is currently on delivery or pickup — our team will confirm the total and payment method once your order is reviewed.
            </div>
            <button class="rounded-xl bg-[#111318] px-6 py-3 text-sm font-semibold text-white hover:bg-black">Place Order</button>
        </form>
    </div>

    <aside class="rounded-[28px] border border-[#E7E5E2] bg-white p-6 shadow-sm">
        <h2 class="text-xl font-extrabold">Order summary</h2>
        <div class="mt-5 space-y-4">
            @foreach ($items as $line)
                <div class="flex items-center gap-3 border-b border-[#F0EEE9] pb-3 last:border-0 last:pb-0">
                    <img src="{{ $line['product']->imageUrl() }}" alt="{{ $line['product']->name }}" class="h-14 w-14 rounded-xl object-cover">
                    <div class="flex-1">
                        <div class="text-sm font-semibold text-[#111318]">{{ $line['product']->name }}</div>
                        <div class="text-xs text-[#6B6862]">Qty {{ $line['quantity'] }}</div>
                    </div>
                    <div class="text-sm font-bold text-[#111318]">&#8358;{{ number_format($line['subtotal'], 2) }}</div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 border-t border-[#F0EEE9] pt-5">
            <div class="flex items-center justify-between text-sm text-[#6B6862]">
                <span>Subtotal</span>
                <span class="font-medium text-[#111318]">&#8358;{{ number_format($total, 2) }}</span>
            </div>
            <div class="mt-3 flex items-center justify-between text-sm text-[#6B6862]">
                <span>Delivery</span>
                <span class="font-medium text-[#111318]">Free</span>
            </div>
            <div class="mt-5 flex items-center justify-between border-t border-[#F0EEE9] pt-4">
                <span class="text-lg font-bold">Total</span>
                <span class="text-2xl font-extrabold text-[#111318]">&#8358;{{ number_format($total, 2) }}</span>
            </div>
        </div>
    </aside>
</div>
@endsection

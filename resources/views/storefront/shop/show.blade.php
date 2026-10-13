@extends('layouts.storefront')

@section('title', $product->name)

@section('content')
<a href="{{ route('storefront.shop') }}" class="text-sm font-medium text-[#6B6862] hover:text-[#C9A24B]">&larr; Back to shop</a>

<div class="mt-5 grid grid-cols-1 gap-10 md:grid-cols-2">
    <div class="overflow-hidden rounded-[28px] border border-[#E7E5E2] bg-white p-3 shadow-sm">
        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-full min-h-[420px] w-full rounded-[20px] object-cover">
    </div>

    <div class="rounded-[28px] border border-[#E7E5E2] bg-white p-6 shadow-sm">
        <div class="text-xs uppercase tracking-[0.28em] text-[#8C8A85] font-semibold">{{ $product->category ?? 'General' }}</div>
        <h1 class="mt-3 text-3xl font-extrabold leading-tight">{{ $product->name }}</h1>
        <div class="mt-4 flex items-center gap-2 text-[#F6A41C] text-sm">
            <span>★★★★★</span>
            <span class="text-[#6B6862]">4.8 rating</span>
        </div>
        <div class="mt-5 text-3xl font-extrabold text-[#111318]">&#8358;{{ number_format($product->price, 2) }}</div>
        <div class="mt-2 text-sm text-[#6B6862]">Free delivery on orders over ₦50,000</div>

        @if ($product->quantity > 0)
            <p class="mt-6 text-sm font-medium text-emerald-600">In stock &middot; {{ $product->quantity }} available</p>
            <form method="POST" action="{{ route('storefront.cart.add', $product) }}" class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                @csrf
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}"
                       class="w-24 rounded-xl border border-[#E7E5E2] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
                <button class="rounded-xl bg-[#111318] px-6 py-2.5 text-sm font-semibold text-white hover:bg-black">Add to Cart</button>
            </form>
        @else
            <p class="mt-6 text-sm font-medium text-red-500">Currently out of stock</p>
        @endif

        <div class="mt-8 space-y-3 border-t border-[#F0EEE9] pt-6 text-sm text-[#6B6862]">
            <div class="flex items-center justify-between"><span>Delivery</span><span class="font-medium text-[#111318]">Same day available</span></div>
            <div class="flex items-center justify-between"><span>Return policy</span><span class="font-medium text-[#111318]">7 days</span></div>
            <div class="flex items-center justify-between"><span>Quality</span><span class="font-medium text-[#111318]">Trusted supplier</span></div>
        </div>
    </div>
</div>

@if ($related->count())
    <div class="mt-14">
        <h2 class="text-2xl font-extrabold mb-5">You may also like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach ($related as $item)
                @include('storefront.shop._card', ['product' => $item])
            @endforeach
        </div>
    </div>
@endif
@endsection

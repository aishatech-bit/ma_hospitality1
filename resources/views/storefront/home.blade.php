@extends('layouts.storefront')

@section('title', 'Home')

@section('content')
<div class="mb-10 rounded-[28px] bg-gradient-to-r from-[#11312d] via-[#1d4f44] to-[#e7b75d] p-6 md:p-10 text-white overflow-hidden shadow-lg">
    <div class="grid md:grid-cols-[1.2fr_0.8fr] gap-8 items-center">
        <div>
            <span class="inline-flex rounded-full border border-white/25 bg-white/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-[#f8d788]">New season essentials</span>
            <h1 class="mt-5 text-3xl md:text-5xl font-extrabold leading-tight">Your everyday grocery run, upgraded.</h1>
            <p class="mt-4 max-w-lg text-sm md:text-base text-white/80">Fresh staples, event-ready supplies, and fast delivery from one dependable shop — built for busy homes and premium hospitality.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('storefront.shop') }}" class="bg-[#F6C76E] text-[#111318] font-bold px-5 py-2.5 rounded-xl text-sm hover:bg-[#f7d68d] transition">Shop Now</a>
                <a href="{{ route('storefront.booking.create') }}" class="bg-white/10 border border-white/20 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-white/15 transition">Book Catering</a>
            </div>
        </div>
        <div class="hidden md:block">
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-4 border border-white/15">
                <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=900&q=80" alt="Market essentials" class="h-[280px] w-full rounded-2xl object-cover">
            </div>
        </div>
    </div>
</div>

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <p class="text-xs uppercase tracking-[0.28em] text-[#8C8A85] font-semibold">Top picks</p>
        <h2 class="text-2xl font-extrabold mt-1">Featured Products</h2>
    </div>
    <a href="{{ route('storefront.shop') }}" class="text-sm font-semibold text-[#111318] hover:text-[#C9A24B]">View all &rarr;</a>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5">
    @forelse ($featured as $product)
        @include('storefront.shop._card', ['product' => $product])
    @empty
        <p class="text-sm text-[#8C8A85] col-span-full">No products available right now — check back soon.</p>
    @endforelse
</div>
@endsection

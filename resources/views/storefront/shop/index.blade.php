@extends('layouts.storefront')

@section('title', 'Shop')

@section('content')
<div class="mb-8 rounded-3xl border border-[#E7E5E2] bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.28em] text-[#8C8A85] font-semibold">Shop our catalog</p>
            <h1 class="mt-2 text-3xl font-extrabold">Everything you need, beautifully packed.</h1>
        </div>
        <div class="text-sm text-[#6B6862]">{{ $products->total() }} items available</div>
    </div>
</div>

<form method="GET" class="mb-8 flex flex-wrap gap-3 rounded-2xl border border-[#E7E5E2] bg-white p-3 shadow-sm">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
           class="flex-1 min-w-[220px] rounded-xl border border-[#E7E5E2] bg-[#F7F6F4] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
    <select name="category" onchange="this.form.submit()" class="rounded-xl border border-[#E7E5E2] bg-[#F7F6F4] px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F6C76E]">
        <option value="">All categories</option>
        @foreach ($categories as $category)
            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
        @endforeach
    </select>
    <button class="rounded-xl bg-[#111318] px-5 py-2.5 text-sm font-semibold text-white hover:bg-black">Search</button>
</form>

<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5 mb-8">
    @forelse ($products as $product)
        @include('storefront.shop._card', ['product' => $product])
    @empty
        <p class="text-sm text-[#8C8A85] col-span-full">No products match your search.</p>
    @endforelse
</div>

<div class="rounded-2xl bg-white p-3 shadow-sm border border-[#E7E5E2]">
    {{ $products->links() }}
</div>
@endsection

<div class="group flex flex-col overflow-hidden rounded-2xl border border-[#E7E5E2] bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">
    <a href="{{ route('storefront.shop.show', $product) }}" class="relative block overflow-hidden bg-[#F3F2EE]">
        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-52 w-full object-cover transition duration-300 group-hover:scale-105">
        <span class="absolute left-3 top-3 rounded-full bg-[#F6C76E] px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-[#111318]">Hot deal</span>
    </a>
    <div class="flex flex-1 flex-col p-4">
        <div class="mb-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#8C8A85]">{{ $product->category ?? 'General' }}</div>
        <a href="{{ route('storefront.shop.show', $product) }}" class="line-clamp-2 text-sm font-semibold text-[#111318] hover:text-[#C9A24B]">{{ $product->name }}</a>
        <div class="mt-3 flex items-center gap-1 text-[#F6A41C] text-xs">
            <span>★★★★★</span>
            <span class="text-[#6B6862]">(4.8)</span>
        </div>
        <div class="mt-4 flex items-end justify-between gap-3">
            <div>
                <div class="text-lg font-extrabold text-[#111318]">&#8358;{{ number_format($product->price, 2) }}</div>
                <div class="text-[11px] text-[#6B6862]">Free delivery</div>
            </div>
            @if ($product->quantity > 0)
                <form method="POST" action="{{ route('storefront.cart.add', $product) }}">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button class="rounded-xl bg-[#111318] px-3 py-2 text-[11px] font-semibold text-white hover:bg-black">Add to cart</button>
                </form>
            @else
                <span class="rounded-xl bg-red-50 px-2.5 py-2 text-[11px] font-semibold text-red-600">Out of stock</span>
            @endif
        </div>
    </div>
</div>

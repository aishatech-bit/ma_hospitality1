@php $p = $product ?? null; @endphp
<div>
    <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Product Name</label>
    <input type="text" name="name" value="{{ old('name', $p->name ?? '') }}" required
           class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Category</label>
        <input type="text" name="category" value="{{ old('category', $p->category ?? '') }}"
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
    </div>
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">SKU</label>
        <input type="text" name="sku" value="{{ old('sku', $p->sku ?? '') }}"
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
    </div>
</div>
<div class="grid grid-cols-3 gap-4">
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Price (&#8358;)</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $p->price ?? '') }}" required
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
    </div>
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Quantity</label>
        <input type="number" min="0" name="quantity" value="{{ old('quantity', $p->quantity ?? 0) }}" required
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
    </div>
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Reorder Level</label>
        <input type="number" min="0" name="reorder_level" value="{{ old('reorder_level', $p->reorder_level ?? 5) }}" required
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A24B]">
    </div>
</div>

@extends('layouts.app')

@section('title', 'Record Sale')

@section('content')
<div class="bg-white rounded-xl border border-black/5 shadow-sm p-6 max-w-3xl">
    <form method="POST" action="{{ route('sales.store') }}" class="space-y-5">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Customer (optional)</label>
                <select name="customer_id" class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
                    <option value="">Walk-in customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Sale Date</label>
                <input type="date" name="sale_date" value="{{ old('sale_date', now()->toDateString()) }}" required
                       class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-medium text-[#6B6862]">Items</label>
                <button type="button" id="add-line" class="text-xs text-[#C9A24B] font-medium hover:underline">+ Add another item</button>
            </div>
            <div id="lines" class="space-y-3"></div>
        </div>

        <div class="flex items-center justify-between border-t border-black/5 pt-4">
            <span class="text-sm text-[#6B6862]">Estimated Total</span>
            <span id="grand-total" class="text-lg font-bold">&#8358;0.00</span>
        </div>

        <div>
            <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Notes</label>
            <input type="text" name="notes" value="{{ old('notes') }}" class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
        </div>

        <button class="bg-[#111318] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-black">Record Sale</button>
    </form>
</div>

<template id="line-template">
    <div class="line grid grid-cols-12 gap-2 items-center">
        <select name="products[__i__][product_id]" class="product-select col-span-6 rounded-lg border border-black/10 px-3 py-2.5 text-sm" required>
            <option value="">Select product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}">
                    {{ $product->name }} (&#8358;{{ number_format($product->price, 2) }} · {{ $product->quantity }} in stock)
                </option>
            @endforeach
        </select>
        <input type="number" name="products[__i__][quantity]" min="1" value="1" class="qty-input col-span-2 rounded-lg border border-black/10 px-3 py-2.5 text-sm" required>
        <div class="line-subtotal col-span-3 text-sm text-[#6B6862] text-right">&#8358;0.00</div>
        <button type="button" class="remove-line col-span-1 text-red-600 text-sm">&times;</button>
    </div>
</template>

<script>
(function () {
    const linesEl = document.getElementById('lines');
    const template = document.getElementById('line-template');
    const grandTotalEl = document.getElementById('grand-total');
    let i = 0;

    function formatNaira(n) {
        return '\u20a6' + n.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function recalc() {
        let total = 0;
        linesEl.querySelectorAll('.line').forEach((line) => {
            const select = line.querySelector('.product-select');
            const qty = parseFloat(line.querySelector('.qty-input').value || 0);
            const opt = select.options[select.selectedIndex];
            const price = opt ? parseFloat(opt.dataset.price || 0) : 0;
            const subtotal = price * qty;
            line.querySelector('.line-subtotal').textContent = formatNaira(subtotal);
            total += subtotal;
        });
        grandTotalEl.textContent = formatNaira(total);
    }

    function addLine() {
        const html = template.innerHTML.replaceAll('__i__', i++);
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html.trim();
        const line = wrapper.firstElementChild;
        line.querySelector('.remove-line').addEventListener('click', () => {
            line.remove();
            recalc();
        });
        line.querySelector('.product-select').addEventListener('change', recalc);
        line.querySelector('.qty-input').addEventListener('input', recalc);
        linesEl.appendChild(line);
        recalc();
    }

    document.getElementById('add-line').addEventListener('click', addLine);
    addLine();
})();
</script>
@endsection

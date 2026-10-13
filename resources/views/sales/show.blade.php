@extends('layouts.app')

@section('title', 'Sale #' . $sale->id)

@section('content')
<div class="bg-white rounded-xl border border-black/5 shadow-sm p-6 max-w-2xl">
    <div class="flex justify-between mb-6">
        <div>
            <div class="text-sm text-[#6B6862]">Customer</div>
            <div class="font-medium">{{ $sale->customer->name ?? 'Walk-in customer' }}</div>
        </div>
        <div class="text-right">
            <div class="text-sm text-[#6B6862]">Date</div>
            <div class="font-medium">{{ $sale->sale_date->format('d M Y') }}</div>
        </div>
    </div>

    <table class="w-full text-sm mb-6">
        <thead class="text-[#6B6862] text-xs uppercase border-b border-black/5">
            <tr>
                <th class="text-left py-2">Product</th>
                <th class="text-right py-2">Qty</th>
                <th class="text-right py-2">Unit Price</th>
                <th class="text-right py-2">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach ($sale->items as $item)
                <tr>
                    <td class="py-2">{{ $item->product->name ?? 'Deleted product' }}</td>
                    <td class="py-2 text-right">{{ $item->quantity }}</td>
                    <td class="py-2 text-right">&#8358;{{ number_format($item->unit_price, 2) }}</td>
                    <td class="py-2 text-right">&#8358;{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-between border-t border-black/10 pt-4">
        <span class="font-semibold">Total</span>
        <span class="text-lg font-bold">&#8358;{{ number_format($sale->total, 2) }}</span>
    </div>

    @if ($sale->notes)
        <p class="text-sm text-[#6B6862] mt-4">Note: {{ $sale->notes }}</p>
    @endif

    <a href="{{ route('sales.index') }}" class="inline-block mt-6 text-sm text-[#C9A24B] font-medium hover:underline">&larr; Back to sales</a>
</div>
@endsection

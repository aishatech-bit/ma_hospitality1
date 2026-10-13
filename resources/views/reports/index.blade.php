@extends('layouts.app')

@section('title', 'Reports')
@section('subtitle', 'Sales, stock and catering summaries for a chosen period.')

@section('content')
<form method="GET" class="flex flex-wrap items-end gap-3 mb-6 bg-white rounded-xl border border-black/5 shadow-sm p-4">
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">From</label>
        <input type="date" name="from" value="{{ $from }}" class="rounded-lg border border-black/10 px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">To</label>
        <input type="date" name="to" value="{{ $to }}" class="rounded-lg border border-black/10 px-3 py-2 text-sm">
    </div>
    <button class="bg-[#111318] text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-black">Update</button>
</form>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-black/5 p-5 shadow-sm">
        <div class="text-xs text-[#6B6862] uppercase tracking-wide">Sales Total (period)</div>
        <div class="text-2xl font-bold mt-1">&#8358;{{ number_format($salesTotal, 2) }}</div>
        <div class="text-xs text-[#8C8A85] mt-1">{{ $salesCount }} transaction(s)</div>
    </div>
    <div class="bg-white rounded-xl border border-black/5 p-5 shadow-sm">
        <div class="text-xs text-[#6B6862] uppercase tracking-wide">Catering Bookings (period)</div>
        <div class="text-2xl font-bold mt-1">{{ $bookings->count() }}</div>
        <div class="text-xs text-[#8C8A85] mt-1">
            {{ $bookingsByStatus->get('confirmed', 0) }} confirmed &middot;
            {{ $bookingsByStatus->get('pending', 0) }} pending &middot;
            {{ $bookingsByStatus->get('cancelled', 0) }} cancelled
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-black/5 p-6 shadow-sm">
        <h2 class="font-semibold mb-4">Top Selling Products</h2>
        @forelse ($topProducts as $product)
            <div class="flex items-center justify-between py-2 border-b border-black/5 last:border-0">
                <span class="text-sm">{{ $product->name }}</span>
                <span class="text-sm font-medium">{{ $product->sold_qty ?? 0 }} sold</span>
            </div>
        @empty
            <p class="text-sm text-[#8C8A85]">No sales in this period yet.</p>
        @endforelse
    </div>

    <div class="bg-white rounded-xl border border-black/5 p-6 shadow-sm">
        <h2 class="font-semibold mb-4">Low Stock Items</h2>
        @forelse ($lowStock as $product)
            <div class="flex items-center justify-between py-2 border-b border-black/5 last:border-0">
                <span class="text-sm">{{ $product->name }}</span>
                <span class="text-sm font-medium text-red-600">{{ $product->quantity }} left</span>
            </div>
        @empty
            <p class="text-sm text-[#8C8A85]">All stock levels look healthy.</p>
        @endforelse
    </div>
</div>

<div class="bg-white rounded-xl border border-black/5 shadow-sm mt-6 overflow-hidden">
    <div class="p-4 border-b border-black/5 font-semibold text-sm">Catering Bookings in Period</div>
    <table class="w-full text-sm">
        <thead class="bg-[#F6F5F2] text-[#6B6862] text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-3">Event Date</th>
                <th class="text-left px-4 py-3">Customer</th>
                <th class="text-right px-4 py-3">Guests</th>
                <th class="text-left px-4 py-3">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($bookings as $booking)
                <tr>
                    <td class="px-4 py-3">{{ $booking->event_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $booking->customer->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-right">{{ $booking->guests }}</td>
                    <td class="px-4 py-3 capitalize">{{ $booking->status }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-[#8C8A85]">No bookings in this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

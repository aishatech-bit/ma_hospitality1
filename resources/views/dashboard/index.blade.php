@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Welcome back, ' . auth()->user()->name . '. Here is what is happening today.')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-black/5 p-5 shadow-sm">
        <div class="text-xs text-[#6B6862] uppercase tracking-wide">Products</div>
        <div class="text-2xl font-bold mt-1">{{ $productCount }}</div>
    </div>
    <div class="bg-white rounded-xl border border-black/5 p-5 shadow-sm">
        <div class="text-xs text-[#6B6862] uppercase tracking-wide">Low Stock Items</div>
        <div class="text-2xl font-bold mt-1 {{ $lowStock->count() ? 'text-red-600' : '' }}">{{ $lowStock->count() }}</div>
    </div>
    <div class="bg-white rounded-xl border border-black/5 p-5 shadow-sm">
        <div class="text-xs text-[#6B6862] uppercase tracking-wide">Today's Sales</div>
        <div class="text-2xl font-bold mt-1">&#8358;{{ number_format($todaySales, 2) }}</div>
    </div>
    <div class="bg-white rounded-xl border border-black/5 p-5 shadow-sm">
        <div class="text-xs text-[#6B6862] uppercase tracking-wide">This Month's Sales</div>
        <div class="text-2xl font-bold mt-1">&#8358;{{ number_format($monthSales, 2) }}</div>
    </div>
</div>

@if ($pendingOrders > 0 || $pendingBookingRequests > 0)
<div class="mb-8 rounded-xl bg-amber-50 border border-amber-200 p-5 flex flex-wrap items-center gap-4">
    <span class="text-amber-800 font-medium text-sm">Needs attention:</span>
    @if ($pendingOrders > 0)
        <a href="{{ route('sales.index') }}" class="text-sm text-amber-900 underline">{{ $pendingOrders }} pending online order(s)</a>
    @endif
    @if ($pendingBookingRequests > 0)
        <a href="{{ route('bookings.index') }}" class="text-sm text-amber-900 underline">{{ $pendingBookingRequests }} new catering request(s) from customers</a>
    @endif
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-black/5 p-6 shadow-sm">
        <h2 class="font-semibold mb-4">Upcoming Catering Events</h2>
        @forelse ($upcomingBookings as $booking)
            <div class="flex items-center justify-between py-2.5 border-b border-black/5 last:border-0">
                <div>
                    <div class="font-medium text-sm">{{ $booking->customer->name ?? 'Walk-in' }}</div>
                    <div class="text-xs text-[#6B6862]">{{ $booking->event_type ?? 'Event' }} &middot; {{ $booking->guests }} guests</div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-medium">{{ $booking->event_date->format('d M Y') }}</div>
                    <span class="text-xs px-2 py-0.5 rounded-full
                        {{ $booking->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-sm text-[#8C8A85]">No upcoming catering bookings.</p>
        @endforelse
        <a href="{{ route('bookings.index') }}" class="inline-block mt-4 text-sm text-[#C9A24B] font-medium hover:underline">View all bookings &rarr;</a>
    </div>

    <div class="bg-white rounded-xl border border-black/5 p-6 shadow-sm">
        <h2 class="font-semibold mb-4">Low Stock Alerts</h2>
        @forelse ($lowStock as $product)
            <div class="flex items-center justify-between py-2.5 border-b border-black/5 last:border-0">
                <div>
                    <div class="font-medium text-sm">{{ $product->name }}</div>
                    <div class="text-xs text-[#6B6862]">{{ $product->category }}</div>
                </div>
                <div class="text-sm font-semibold text-red-600">{{ $product->quantity }} left</div>
            </div>
        @empty
            <p class="text-sm text-[#8C8A85]">All stock levels look healthy.</p>
        @endforelse
        <a href="{{ route('products.index') }}" class="inline-block mt-4 text-sm text-[#C9A24B] font-medium hover:underline">Manage inventory &rarr;</a>
    </div>
</div>
@endsection

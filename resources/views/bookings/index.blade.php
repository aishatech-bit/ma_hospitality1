@extends('layouts.app')

@section('title', 'Catering Bookings')
@section('subtitle', 'Upcoming and past catering events. Dates are checked automatically to prevent double-booking.')
@section('actions')
    <a href="{{ route('bookings.create') }}" class="bg-[#111318] text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-black">+ New Booking</a>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-black/5 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-black/5">
        <form method="GET" class="flex gap-2 items-center">
            <select name="status" class="rounded-lg border border-black/10 px-3 py-2 text-sm" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach (['pending', 'confirmed', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-[#F6F5F2] text-[#6B6862] text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-3">Event Date</th>
                <th class="text-left px-4 py-3">Customer</th>
                <th class="text-left px-4 py-3">Type</th>
                <th class="text-right px-4 py-3">Guests</th>
                <th class="text-left px-4 py-3">Source</th>
                <th class="text-left px-4 py-3">Status</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($bookings as $booking)
                <tr class="{{ $booking->status === 'pending' && $booking->source === 'customer' ? 'bg-amber-50/50' : '' }}">
                    <td class="px-4 py-3 font-medium">{{ $booking->event_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $booking->customer->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-[#6B6862]">{{ $booking->event_type ?? '—' }}</td>
                    <td class="px-4 py-3 text-right">{{ $booking->guests }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $booking->source === 'customer' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $booking->source === 'customer' ? 'Customer request' : 'Staff' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $booking->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700' : ($booking->status === 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap">
                        <a href="{{ route('bookings.edit', $booking) }}" class="text-[#C9A24B] font-medium hover:underline">Edit</a>
                        <form method="POST" action="{{ route('bookings.destroy', $booking) }}" class="inline" onsubmit="return confirm('Delete this booking?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 font-medium hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-[#8C8A85]">No catering bookings found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-black/5">{{ $bookings->links() }}</div>
</div>
@endsection

@extends('layouts.storefront')

@section('title', 'Booking Requested')

@section('content')
<div class="max-w-xl mx-auto text-center py-8">
    <div class="text-5xl mb-4">&#128197;</div>
    <h1 class="text-2xl font-bold mb-2">Booking request received!</h1>
    <p class="text-[#6B6862] mb-8">Thanks, {{ $booking->customer->name ?? 'friend' }}. Your request for {{ $booking->event_date->format('d M Y') }} is pending confirmation — our team will reach out shortly.</p>

    <div class="bg-white rounded-xl border border-black/5 shadow-sm p-6 text-left space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-[#6B6862]">Event Date</span><span class="font-medium">{{ $booking->event_date->format('d M Y') }}</span></div>
        <div class="flex justify-between"><span class="text-[#6B6862]">Event Type</span><span class="font-medium">{{ $booking->event_type ?? '—' }}</span></div>
        <div class="flex justify-between"><span class="text-[#6B6862]">Guests</span><span class="font-medium">{{ $booking->guests }}</span></div>
        <div class="flex justify-between"><span class="text-[#6B6862]">Status</span><span class="font-medium capitalize">{{ $booking->status }}</span></div>
    </div>

    <a href="{{ route('storefront.home') }}" class="inline-block mt-8 text-sm text-[#C9A24B] font-medium hover:underline">&larr; Back to home</a>
</div>
@endsection

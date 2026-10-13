@extends('layouts.storefront')

@section('title', 'Book Catering')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-1">Book Catering</h1>
    <p class="text-sm text-[#6B6862] mb-6">Tell us about your event. We'll check your date instantly — no double-bookings, guaranteed.</p>

    <form method="POST" action="{{ route('storefront.booking.store') }}" class="bg-white rounded-xl border border-black/5 shadow-sm p-6 space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Email (optional)</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Event Date</label>
                <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}" required
                       min="{{ now()->toDateString() }}"
                       data-check-url="{{ route('storefront.booking.check') }}"
                       class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
                <p id="availability-note" class="text-xs mt-1.5"></p>
            </div>
            <div>
                <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Event Type</label>
                <input type="text" name="event_type" value="{{ old('event_type') }}" placeholder="e.g. Wedding, Birthday"
                       class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Number of Guests</label>
            <input type="number" min="1" name="guests" value="{{ old('guests') }}" required class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Notes</label>
            <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Anything we should know?" class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
        </div>
        <p class="text-xs text-[#8C8A85]">Submitting sends a request — our team will confirm it shortly.</p>
        <button id="submit-btn" class="bg-[#111318] text-white text-sm font-medium px-6 py-2.5 rounded-lg hover:bg-black">Request Booking</button>
    </form>
</div>

<script>
(function () {
    const dateInput = document.getElementById('event_date');
    const note = document.getElementById('availability-note');
    const submitBtn = document.getElementById('submit-btn');
    const url = dateInput.dataset.checkUrl;
    let timer;

    dateInput.addEventListener('change', function () {
        clearTimeout(timer);
        const date = dateInput.value;
        submitBtn.disabled = false;
        if (!date) { note.textContent = ''; return; }

        note.textContent = 'Checking availability…';
        note.className = 'text-xs mt-1.5 text-[#8C8A85]';

        timer = setTimeout(() => {
            const qs = new URLSearchParams({ event_date: date });
            fetch(url + '?' + qs.toString(), { headers: { 'Accept': 'application/json' } })
                .then((r) => r.json())
                .then((data) => {
                    if (data.available) {
                        note.textContent = '✓ This date is available.';
                        note.className = 'text-xs mt-1.5 text-emerald-600';
                        submitBtn.disabled = false;
                    } else {
                        note.textContent = '⚠ This date is already booked. Please pick another.';
                        note.className = 'text-xs mt-1.5 text-red-600';
                    }
                })
                .catch(() => { note.textContent = ''; });
        }, 300);
    });

    if (dateInput.value) {
        dateInput.dispatchEvent(new Event('change'));
    }
})();
</script>
@endsection

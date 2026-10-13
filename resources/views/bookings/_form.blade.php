@php $b = $booking ?? null; @endphp

<div>
    <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Customer</label>
    <select name="customer_id" required class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
        <option value="">Select customer</option>
        @foreach ($customers as $customer)
            <option value="{{ $customer->id }}" @selected(old('customer_id', $b->customer_id ?? null) == $customer->id)>{{ $customer->name }}</option>
        @endforeach
    </select>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Event Date</label>
        <input type="date" id="event_date" name="event_date"
               value="{{ old('event_date', isset($b) ? $b->event_date->toDateString() : '') }}" required
               data-check-url="{{ route('bookings.check') }}"
               data-current-id="{{ $b->id ?? '' }}"
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
        <p id="availability-note" class="text-xs mt-1.5"></p>
    </div>
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Event Type</label>
        <input type="text" name="event_type" value="{{ old('event_type', $b->event_type ?? '') }}" placeholder="e.g. Wedding, Birthday"
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
    </div>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Number of Guests</label>
        <input type="number" min="1" name="guests" value="{{ old('guests', $b->guests ?? '') }}" required
               class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Status</label>
        <select name="status" class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
            @foreach (['pending' => 'Pending', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $b->status ?? 'pending') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label class="block text-xs font-medium text-[#6B6862] mb-1.5">Notes</label>
    <input type="text" name="notes" value="{{ old('notes', $b->notes ?? '') }}" class="w-full rounded-lg border border-black/10 px-3 py-2.5 text-sm">
</div>

<script>
(function () {
    const dateInput = document.getElementById('event_date');
    const note = document.getElementById('availability-note');
    const url = dateInput.dataset.checkUrl;
    const currentId = dateInput.dataset.currentId;
    let timer;

    dateInput.addEventListener('change', function () {
        clearTimeout(timer);
        const date = dateInput.value;
        if (!date) { note.textContent = ''; return; }

        note.textContent = 'Checking availability…';
        note.className = 'text-xs mt-1.5 text-[#8C8A85]';

        timer = setTimeout(() => {
            const qs = new URLSearchParams({ event_date: date, ignore: currentId || '' });
            fetch(url + '?' + qs.toString(), { headers: { 'Accept': 'application/json' } })
                .then((r) => r.json())
                .then((data) => {
                    if (data.available) {
                        note.textContent = '✓ This date is available.';
                        note.className = 'text-xs mt-1.5 text-emerald-600';
                    } else {
                        note.textContent = '⚠ This date is already booked for another event.';
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

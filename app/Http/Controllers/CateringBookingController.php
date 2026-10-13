<?php

namespace App\Http\Controllers;

use App\Models\CateringBooking;
use App\Models\Customer;
use Illuminate\Http\Request;

class CateringBookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = CateringBooking::with('customer')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderBy('event_date')
            ->paginate(10)
            ->withQueryString();

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        return view('bookings.create', compact('customers'));
    }

    /**
     * AJAX endpoint used by the booking form to live-check a date before
     * submit. Mirrors CateringBooking::checkAvailability() from the design.
     */
    public function checkAvailability(Request $request)
    {
        $request->validate(['event_date' => ['required', 'date']]);

        $available = CateringBooking::isDateAvailable($request->event_date, $request->input('ignore') ?: null);

        return response()->json(['available' => $available]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'event_date' => ['required', 'date'],
            'event_type' => ['nullable', 'string', 'max:255'],
            'guests' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:pending,confirmed,cancelled'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        // Core requirement: prevent double-booking the same event date.
        if ($data['status'] !== 'cancelled' && ! CateringBooking::isDateAvailable($data['event_date'])) {
            return back()
                ->withErrors(['event_date' => 'That date is already booked for another catering event. Please choose another date.'])
                ->withInput();
        }

        $booking = CateringBooking::create($data);

        return redirect()->route('bookings.index')->with('status', 'Catering booking #'.$booking->id.' created.');
    }

    public function edit(CateringBooking $booking)
    {
        $customers = Customer::orderBy('name')->get();

        return view('bookings.edit', compact('booking', 'customers'));
    }

    public function update(Request $request, CateringBooking $booking)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'event_date' => ['required', 'date'],
            'event_type' => ['nullable', 'string', 'max:255'],
            'guests' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:pending,confirmed,cancelled'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        if ($data['status'] !== 'cancelled' && ! CateringBooking::isDateAvailable($data['event_date'], $booking->id)) {
            return back()
                ->withErrors(['event_date' => 'That date is already booked for another catering event. Please choose another date.'])
                ->withInput();
        }

        $booking->update($data);

        return redirect()->route('bookings.index')->with('status', 'Booking #'.$booking->id.' updated.');
    }

    public function destroy(CateringBooking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('status', 'Booking cancelled and removed.');
    }
}

<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\CateringBooking;
use App\Models\Customer;
use Illuminate\Http\Request;

class CateringRequestController extends Controller
{
    public function create()
    {
        return view('storefront.booking.create');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate(['event_date' => ['required', 'date']]);

        $available = CateringBooking::isDateAvailable($request->event_date);

        return response()->json(['available' => $available]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_type' => ['nullable', 'string', 'max:255'],
            'guests' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        if (! CateringBooking::isDateAvailable($data['event_date'])) {
            return back()
                ->withErrors(['event_date' => 'Sorry, that date is already booked for another catering event. Please choose another date.'])
                ->withInput();
        }

        $customer = Customer::firstOrCreate(
            ['phone' => $data['phone']],
            ['name' => $data['name'], 'email' => $data['email'] ?? null]
        );

        $booking = CateringBooking::create([
            'customer_id' => $customer->id,
            'event_date' => $data['event_date'],
            'event_type' => $data['event_type'] ?? null,
            'guests' => $data['guests'],
            'status' => 'pending',
            'source' => 'customer',
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('storefront.booking.confirmation', $booking)->with('status', 'Booking request received!');
    }

    public function confirmation(CateringBooking $booking)
    {
        $booking->load('customer');

        return view('storefront.booking.confirmation', compact('booking'));
    }
}

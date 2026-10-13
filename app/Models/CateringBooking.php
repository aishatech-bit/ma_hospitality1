<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateringBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'event_date',
        'event_type',
        'guests',
        'status',
        'source',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'guests' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Check whether the given date already has a non-cancelled booking.
     * Mirrors the CateringBooking::checkAvailability() method from the
     * project's OOP class design.
     */
    public static function isDateAvailable(string $eventDate, ?int $ignoreId = null): bool
    {
        return ! static::where('event_date', $eventDate)
            ->where('status', '!=', 'cancelled')
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();
    }
}

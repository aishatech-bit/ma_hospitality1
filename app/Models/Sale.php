<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'channel',
        'status',
        'customer_phone',
        'delivery_address',
        'sale_date',
        'total',
        'notes',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function calculateTotal(): float
    {
        return (float) $this->items()->sum('subtotal');
    }
}

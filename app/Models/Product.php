<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'image_url',
        'sku',
        'price',
        'quantity',
        'reorder_level',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'reorder_level' => 'integer',
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    public function imageUrl(): string
    {
        return $this->image_url ?: $this->fallbackImageUrl();
    }

    public function fallbackImageUrl(): string
    {
        $categoryKey = strtolower((string) ($this->category ?? 'general'));

        $fallbacks = [
            'grains' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=900&q=80',
            'cooking' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?auto=format&fit=crop&w=900&q=80',
            'protein' => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?auto=format&fit=crop&w=900&q=80',
            'beverages' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?auto=format&fit=crop&w=900&q=80',
            'catering supplies' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=900&q=80',
            'general' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=900&q=80',
        ];

        $key = $fallbacks[$categoryKey] ?? $fallbacks['general'];

        if (str_contains(strtolower($this->name), 'rice')) {
            return 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=900&q=80';
        }

        if (str_contains(strtolower($this->name), 'oil') || str_contains(strtolower($this->name), 'cooking')) {
            return 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?auto=format&fit=crop&w=900&q=80';
        }

        if (str_contains(strtolower($this->name), 'chicken') || str_contains(strtolower($this->name), 'protein')) {
            return 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?auto=format&fit=crop&w=900&q=80';
        }

        if (str_contains(strtolower($this->name), 'drink') || str_contains(strtolower($this->name), 'beverage')) {
            return 'https://images.unsplash.com/photo-1544145945-f90425340c7e?auto=format&fit=crop&w=900&q=80';
        }

        return $key;
    }

    public function reduceStock(int $qty): void
    {
        $this->decrement('quantity', $qty);
    }

    public function increaseStock(int $qty): void
    {
        $this->increment('quantity', $qty);
    }
}

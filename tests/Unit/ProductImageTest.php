<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductImageTest extends TestCase
{
    public function test_it_uses_a_product_image_fallback_for_storefront_cards(): void
    {
        $product = new Product([
            'name' => 'Rice (50kg bag)',
            'category' => 'Grains',
            'price' => 65000,
            'quantity' => 12,
        ]);

        $this->assertStringContainsString('images.unsplash.com', $product->imageUrl());
        $this->assertNotSame('', trim($product->imageUrl()));
    }
}

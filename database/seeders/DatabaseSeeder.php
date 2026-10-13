<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default admin login for the PSA demo/defence.
        User::firstOrCreate(
            ['email' => 'admin@mahospitalityandmart.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@mahospitalityandmart.test'],
            [
                'name' => 'Staff',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        $products = [
            ['name' => 'Rice (50kg bag)', 'category' => 'Grains', 'image_url' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=900&q=80', 'sku' => 'GR-001', 'price' => 65000, 'quantity' => 12, 'reorder_level' => 5],
            ['name' => 'Vegetable Oil (5L)', 'category' => 'Cooking', 'image_url' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?auto=format&fit=crop&w=900&q=80', 'sku' => 'CK-002', 'price' => 9500, 'quantity' => 20, 'reorder_level' => 8],
            ['name' => 'Chicken (kg)', 'category' => 'Protein', 'image_url' => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?auto=format&fit=crop&w=900&q=80', 'sku' => 'PR-003', 'price' => 3500, 'quantity' => 4, 'reorder_level' => 10],
            ['name' => 'Soft Drinks (crate)', 'category' => 'Beverages', 'image_url' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?auto=format&fit=crop&w=900&q=80', 'sku' => 'BV-004', 'price' => 4200, 'quantity' => 15, 'reorder_level' => 6],
            ['name' => 'Disposable Packs (100pcs)', 'category' => 'Catering Supplies', 'image_url' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=900&q=80', 'sku' => 'CS-005', 'price' => 5000, 'quantity' => 3, 'reorder_level' => 5],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }

        $customers = [
            ['name' => 'Halima Yusuf', 'phone' => '08031112222', 'email' => 'halima@example.com', 'address' => 'Wuse 2, Abuja'],
            ['name' => 'Emeka Obi', 'phone' => '08099993333', 'email' => 'emeka@example.com', 'address' => 'Garki, Abuja'],
        ];

        foreach ($customers as $customer) {
            Customer::firstOrCreate(['email' => $customer['email']], $customer);
        }
    }
}

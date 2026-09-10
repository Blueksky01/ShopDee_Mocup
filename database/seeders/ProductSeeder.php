<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('slug', 'electronics-gadgets')->first();
        $fashion = Category::where('slug', 'fashion-apparel')->first();
        $home = Category::where('slug', 'home-kitchen')->first();

        $products = [
            [
                'category_id' => $electronics->id,
                'name' => 'Wireless Noise-Canceling Headphones',
                'description' => 'High quality sound experience with active noise cancellation and 30-hour battery life.',
                'price' => 2990.00,
                'stock' => 15,
                'image' => null,
            ],
            [
                'category_id' => $electronics->id,
                'name' => 'Smart Watch Pro',
                'description' => 'Track your daily fitness activities, heart rate, and sleep quality with clear AMOLED display.',
                'price' => 1890.00,
                'stock' => 3, // Low stock for testing low stock alert!
                'image' => null,
            ],
            [
                'category_id' => $fashion->id,
                'name' => 'Classic Cotton T-Shirt',
                'description' => '100% Premium cotton t-shirt for maximum comfort and durability.',
                'price' => 390.00,
                'stock' => 50,
                'image' => null,
            ],
            [
                'category_id' => $home->id,
                'name' => 'Automatic Coffee Maker',
                'description' => 'Brew fresh espresso and cappuccino at home in under 2 minutes.',
                'price' => 4500.00,
                'stock' => 8,
                'image' => null,
            ],
            [
                'category_id' => $electronics->id,
                'name' => 'Portable Bluetooth Speaker',
                'description' => 'Waterproof IPX7 speaker with deep bass and compact design for outdoor adventures.',
                'price' => 1250.00,
                'stock' => 2, // Low stock!
                'image' => null,
            ],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $item['category_id'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'image' => $item['image'],
                    'is_active' => true,
                ]
            );
        }
    }
}

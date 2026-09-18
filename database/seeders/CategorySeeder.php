<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'เสื้อผ้า (Clothing)' => 'clothing-apparel',
            'กางเกง (Pants)' => 'pants-trousers',
            'รองเท้า (Shoes)' => 'shoes-footwear',
            'กระเป๋า (Bags)' => 'bags-backpacks',
            'หมวก & แอคเซสซอรี (Hats & Accessories)' => 'hats-accessories',
            'อุปกรณ์อิเล็กทรอนิกส์ (Electronics)' => 'electronics-gadgets',
            'ของใช้ในบ้าน (Home & Living)' => 'home-kitchen',
        ];

        foreach ($categories as $name => $slug) {
            Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }
}

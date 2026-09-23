<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Additional sample users for reviews
        $users = [
            User::firstOrCreate(
                ['email' => 'somchai@example.com'],
                ['name' => 'สมชาย รักการแต่งตัว', 'password' => Hash::make('password123'), 'role' => 'customer']
            ),
            User::firstOrCreate(
                ['email' => 'linna@example.com'],
                ['name' => 'ลินดา แฟชั่นนิสต้า', 'password' => Hash::make('password123'), 'role' => 'customer']
            ),
            User::firstOrCreate(
                ['email' => 'thanawat@example.com'],
                ['name' => 'ธนวัฒน์ สไตล์มินิมอล', 'password' => Hash::make('password123'), 'role' => 'customer']
            ),
        ];

        $customer = User::where('email', 'customer@shopdee.com')->first();
        if ($customer) {
            $users[] = $customer;
        }

        $sampleComments = [
            5 => [
                'เนื้อผ้าดีมากครับ สัมผัสพรีเมียม ใส่แล้วอุ่นและเบาสบายมาก คุ้มค่าเกินราคา!',
                'สวยงามตามรูปเลยค่ะ สีตรงปกมาก การตัดเย็บประณีตเรียบร้อย ชอบมากค่ะ 10/10',
                'ใส่แล้วดูดี มั่นใจขึ้นเยอะ จัดส่งรวดเร็ว แพ็คของมาอย่างดี แนะนำเลยครับ!',
                'ประทับใจสุดๆ ดีไซน์โมเดิร์นทันสมัย น้ำหนักเบาแต่กันหนาวได้ดีเยี่ยม!',
            ],
            4 => [
                'คุณภาพดี คุ้มราคาครับ ทรงสวยพอดีตัว แต่การจัดส่งช้ากว่าที่คิดนิดหน่อย โดยรวมโอเคมากครับ',
                'สินค้าสวยงาม งานเย็บดี วัสดุดีมากค่ะ ใส่สบายเหมาะกับอากาศหนาว',
                'ทรงสวยถูกใจมากครับ สีสวยสดใส เนื้อผ้าคุณภาพดีเลย',
            ],
            5 => [
                'ประทับใจมากครับ แบรนด์นี้ไม่เคยทำให้ผิดหวัง สั่งซ้ำแน่นอน!',
                'ได้รับของแล้ว คุณภาพยอดเยี่ยม เกินความคาดหมายค่ะ',
            ]
        ];

        $products = Product::all();

        foreach ($products as $product) {
            // Add 2 - 4 reviews per product
            $numReviews = rand(2, 4);
            $selectedUsers = collect($users)->shuffle()->take($numReviews);

            foreach ($selectedUsers as $user) {
                $rating = rand(4, 5); // mostly 4 or 5 stars
                $commentList = $sampleComments[$rating] ?? $sampleComments[5];
                $comment = $commentList[array_rand($commentList)];

                Review::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'rating' => $rating,
                        'comment' => $comment,
                    ]
                );
            }
        }
    }
}

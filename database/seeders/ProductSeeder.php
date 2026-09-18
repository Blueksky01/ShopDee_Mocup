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
        $clothingCategory = Category::where('slug', 'clothing-apparel')->first();
        $pantsCategory = Category::where('slug', 'pants-trousers')->first();
        $shoesCategory = Category::where('slug', 'shoes-footwear')->first();
        $bagsCategory = Category::where('slug', 'bags-backpacks')->first();
        $hatsCategory = Category::where('slug', 'hats-accessories')->first();
        $electronicsCategory = Category::where('slug', 'electronics-gadgets')->first();
        $homeCategory = Category::where('slug', 'home-kitchen')->first();

        // Fallback to first available category if needed
        $defaultCat = Category::first();

        $products = [
            // --- 1. เสื้อผ้า (Clothing) ---
            [
                'category_id' => $clothingCategory ? $clothingCategory->id : $defaultCat->id,
                'name' => 'Signature Orange Puffer Jacket',
                'description' => "เสื้อแจ็กเก็ตกันหนาวบวมสีส้มเทอราคอตตา น้ำหนักเบา อบอุ่น สวมใส่สบาย โดดเด่นทุกมุมมองด้วยสไตล์ Warm Industrial-Earth",
                'price' => 4990.00,
                'stock' => 12,
                'image' => 'images/orange_puffer_hero.jpg',
            ],
            [
                'category_id' => $clothingCategory ? $clothingCategory->id : $defaultCat->id,
                'name' => 'Noir Glossy Black Puffer Jacket',
                'description' => 'เสื้อแจ็กเก็ตกันหนาวสีดำเงา นุ่มเบา สไตล์เรียบหรู คลาสสิก ยกระดับลุคเรียบง่ายให้ดูมีมิติ',
                'price' => 5490.00,
                'stock' => 8,
                'image' => 'images/black_puffer_thumb.jpg',
            ],
            [
                'category_id' => $clothingCategory ? $clothingCategory->id : $defaultCat->id,
                'name' => 'Crimson Ruby Red Puffer Jacket',
                'description' => 'เสื้อแจ็กเก็ตกันหนาวสีแดงคริมสัน โดดเด่น ท้าทายสายตา พร้อมความอบอุ่นระดับพรีเมียม',
                'price' => 5790.00,
                'stock' => 5,
                'image' => 'images/red_puffer_thumb.jpg',
            ],
            [
                'category_id' => $clothingCategory ? $clothingCategory->id : $defaultCat->id,
                'name' => 'Oversized Terracotta Heavyweight Hoodie',
                'description' => 'เสื้อฮู้ดดี้ทรงโอเวอร์ไซส์ สีเทอราคอตตา ตัดเย็บจากผ้าคอตตอนเนื้อหนาพิเศษ 450 GSM ผ้านุ่มสบาย นุ่มอุ่นตลอดวัน',
                'price' => 1890.00,
                'stock' => 20,
                'image' => 'images/terracotta_hoodie.jpg',
            ],
            [
                'category_id' => $clothingCategory ? $clothingCategory->id : $defaultCat->id,
                'name' => 'Industrial Vintage Denim Jacket',
                'description' => 'เสื้อแจ็กเก็ตยีนส์ฟอกทรงอินดัสเทรียล เดินด้ายสีส้มทอง แต่งรอยฟอกสวยงาม แมตช์เข้ากับกางเกงทุกสไตล์',
                'price' => 2490.00,
                'stock' => 15,
                'image' => 'images/denim_jacket.jpg',
            ],
            [
                'category_id' => $clothingCategory ? $clothingCategory->id : $defaultCat->id,
                'name' => 'Classic Earth-Tone Cotton Graphic Tee',
                'description' => 'เสื้อยืดคอตตอนแท้ 100% สกรีนลายกราฟิก Minimal Earth Tone ระบายอากาศดีเยี่ยม สวมใส่สบายได้ทุกวัน',
                'price' => 590.00,
                'stock' => 50,
                'image' => 'images/cotton_tee.jpg',
            ],

            // --- 2. กางเกง (Pants) ---
            [
                'category_id' => $pantsCategory ? $pantsCategory->id : $defaultCat->id,
                'name' => 'Utility Multi-Pocket Cargo Pants',
                'description' => 'กางเกงคาร์โก้ทรงสตรีทสไตล์ยูนิตี้ มีกระเป๋าข้างอเนกประสงค์ 6 ช่อง สีเขียวโอลิฟดาร์ก ทนทาน ลุยได้ทุกสถานการณ์',
                'price' => 1690.00,
                'stock' => 18,
                'image' => 'images/cargo_pants.jpg',
            ],
            [
                'category_id' => $pantsCategory ? $pantsCategory->id : $defaultCat->id,
                'name' => 'Vintage Slim-Fit Raw Denim Jeans',
                'description' => 'กางเกงยีนส์ผ้าดิบ Japanese Selvedge 14oz ทรงสลิมฟิต เฟดสีสวยงามตามการใช้งาน ยิ่งใส่ยิ่งทรงสวย',
                'price' => 2190.00,
                'stock' => 14,
                'image' => 'images/denim_jeans.jpg',
            ],
            [
                'category_id' => $pantsCategory ? $pantsCategory->id : $defaultCat->id,
                'name' => 'Relaxed Earth-Tone Chino Pants',
                'description' => 'กางเกงชิโน่ทรงรีแลกซ์ ผ้านุ่มยืดหยุ่นสูง สีไลม์สโตน สวมใส่สบาย เหมาะสำหรับลุคลำลองและวันทำงาน',
                'price' => 1290.00,
                'stock' => 25,
                'image' => 'images/chino_pants.jpg',
            ],

            // --- 3. รองเท้า (Shoes) ---
            [
                'category_id' => $shoesCategory ? $shoesCategory->id : $defaultCat->id,
                'name' => 'Urban Retro Leather Sneakers',
                'description' => 'รองเท้าสนีกเกอร์หนังแท้ทรงเรโทร แมตช์ได้กับทุกชุด พื้นรองเท้านุ่มรับแรงกระแทกได้ดีเยี่ยม ใส่สบายตลอดวัน',
                'price' => 3290.00,
                'stock' => 10,
                'image' => 'images/retro_sneakers.jpg',
            ],
            [
                'category_id' => $shoesCategory ? $shoesCategory->id : $defaultCat->id,
                'name' => 'Vintage High-Top Canvas Sneakers',
                'description' => 'รองเท้าผ้าใบหุ้มข้อสไตล์วินเทจ ส้นยางหนาพิเศษ ทนทาน สไตล์สตรีทแฟชันที่ไม่มีวันตกยุค',
                'price' => 1990.00,
                'stock' => 16,
                'image' => null,
            ],
            [
                'category_id' => $shoesCategory ? $shoesCategory->id : $defaultCat->id,
                'name' => 'Industrial Leather Work Boots',
                'description' => 'รองเท้าบูทหนังแท้ทรงอินดัสเทรียล หัวกะลาเย็บด้ายคู่ แข็งแรงทนทาน มอบลุคเท่มีเอกลักษณ์เฉพาะตัว',
                'price' => 4500.00,
                'stock' => 7,
                'image' => 'images/work_boots.jpg',
            ],

            // --- 4. กระเป๋า (Bags) ---
            [
                'category_id' => $bagsCategory ? $bagsCategory->id : $defaultCat->id,
                'name' => 'Industrial Heavy Canvas Tote Bag',
                'description' => 'กระเป๋าโท้ทผ้าแคนวาสเนื้อหนาพิเศษ ปักโลโก้แบรนด์ ซับในกันน้ำ จุของได้เยอะ เหมาะสำหรับการใช้งานประจำวัน',
                'price' => 890.00,
                'stock' => 30,
                'image' => 'images/canvas_tote.jpg',
            ],
            [
                'category_id' => $bagsCategory ? $bagsCategory->id : $defaultCat->id,
                'name' => 'Vintage Leather Crossbody Bag',
                'description' => 'กระเป๋าสะพายข้างหนังแท้ฟอกวินเทจ สไตล์ Rustic มีช่องเก็บของเป็นสัดส่วน สายสะพายปรับระดับได้',
                'price' => 2290.00,
                'stock' => 12,
                'image' => 'images/crossbody_bag.jpg',
            ],
            [
                'category_id' => $bagsCategory ? $bagsCategory->id : $defaultCat->id,
                'name' => 'Urban Commuter Waterproof Backpack',
                'description' => 'กระเป๋าเป้สะพายหลังกันน้ำ พร้อมช่องใส่โน้ตบุ๊ก 15.6 นิ้ว ซิปกันน้ำและสายสะพายลดแรงกดทับ',
                'price' => 2890.00,
                'stock' => 9,
                'image' => 'images/urban_backpack.jpg',
            ],

            // --- 5. หมวก & แอคเซสซอรี (Hats & Accessories) ---
            [
                'category_id' => $hatsCategory ? $hatsCategory->id : $defaultCat->id,
                'name' => 'Terracotta Street Knit Beanie',
                'description' => 'หมวกไหมพรมทรงสตรีท สีเทอราคอตตา ผ้านุ่มอุ่นสบาย ยืดหยุ่นดี ปักโลโก้แบรนด์แบบทอละเอียด',
                'price' => 490.00,
                'stock' => 35,
                'image' => 'images/knit_beanie.jpg',
            ],
            [
                'category_id' => $hatsCategory ? $hatsCategory->id : $defaultCat->id,
                'name' => 'Vintage Corduroy Baseball Cap',
                'description' => 'หมวกแก๊ปผ้าลูกฟูกสีน้ำตาลเคอรี ปักโลโก้นูนสไตล์วินเทจ มีสายปรับระดับด้านหลังด้วยบัคเคิลโลหะ',
                'price' => 690.00,
                'stock' => 22,
                'image' => 'images/baseball_cap.jpg',
            ],
            [
                'category_id' => $hatsCategory ? $hatsCategory->id : $defaultCat->id,
                'name' => 'Olive Outdoor Waterproof Bucket Hat',
                'description' => 'หมวกบักเก็ตสไตล์เอาท์ดอร์ สีเขียวโอลิฟ ป้องกันรังสี UV และกันหยดน้ำ พร้อมสายคล้องคอกันลมพัด',
                'price' => 790.00,
                'stock' => 19,
                'image' => 'images/bucket_hat.jpg',
            ],

            // --- 6. อื่นๆ (Electronics & Home) ---
            [
                'category_id' => $electronicsCategory ? $electronicsCategory->id : $defaultCat->id,
                'name' => 'Wireless Noise-Canceling Headphones',
                'description' => 'หูฟังไร้สายพร้อมระบบตัดเสียงรบกวน Active Noise Cancellation แบตเตอรี่ใช้งานยาวนาน 30 ชั่วโมง',
                'price' => 2990.00,
                'stock' => 15,
                'image' => null,
            ],
            [
                'category_id' => $electronicsCategory ? $electronicsCategory->id : $defaultCat->id,
                'name' => 'Smart Watch Pro',
                'description' => 'นาฬิกาอัจฉริยะตรวจวัดสุขภาพ วัดอัตราการเต้นของหัวใจและก้าวเดิน หน้าจอ AMOLED สว่างคมชัด',
                'price' => 1890.00,
                'stock' => 3,
                'image' => null,
            ],
            [
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCat->id,
                'name' => 'Automatic Espresso Coffee Maker',
                'description' => 'เครื่องชงกาแฟอัตโนมัติ สกัดเอสเพรสโซและฟองนมเนียนนุ่มได้ในเวลาไม่ถึง 2 นาที',
                'price' => 4500.00,
                'stock' => 8,
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

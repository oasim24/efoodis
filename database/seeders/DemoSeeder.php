<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // --- Categories ---
        $categories = [
            ['name' => 'Electronics', 'image' => 'electronics.jpg', 'parent_id' => null],
            ['name' => 'Mobiles', 'image' => 'mobiles.jpg', 'parent_id' => 1],
            ['name' => 'Laptops', 'image' => 'laptops.jpg', 'parent_id' => 1],
            ['name' => 'Fashion', 'image' => 'fashion.jpg', 'parent_id' => null],
            ['name' => 'Men', 'image' => 'men.jpg', 'parent_id' => 4],
            ['name' => 'Women', 'image' => 'women.jpg', 'parent_id' => 4],
        ];

        DB::table('categories')->insert($categories);

        // --- Brands ---
        $brands = [
            ['name' => 'Apple', 'image' => 'apple.jpg'],
            ['name' => 'Samsung', 'image' => 'samsung.jpg'],
            ['name' => 'HP', 'image' => 'hp.jpg'],
            ['name' => 'Nike', 'image' => 'nike.jpg'],
            ['name' => 'Adidas', 'image' => 'adidas.jpg'],
        ];

        DB::table('brands')->insert($brands);

        // --- Customers ---
        $customers = [
            [
                'name' => 'John Doe',
                'phone' => '0123456789',
                'email' => 'john@example.com',
                'address' => '123 Street',
                'city' => 'New York',
                'zone' => 'Zone A',
                'area' => 'Area 1',
                'image' => 'john.jpg',
            ],
            [
                'name' => 'Jane Smith',
                'phone' => '0987654321',
                'email' => 'jane@example.com',
                'address' => '456 Avenue',
                'city' => 'Los Angeles',
                'zone' => 'Zone B',
                'area' => 'Area 2',
                'image' => 'jane.jpg',
            ],
        ];

        DB::table('customers')->insert($customers);

        // --- Products ---
        $products = [
            [
                'category_id' => 2,
                'brand_id' => 1,
                'name' => 'iPhone 15 Pro',
                'slug' => Str::slug('iPhone 15 Pro'),
                'code' => 'IPH15P',
                'description' => 'Latest iPhone model with advanced features.',
                'old_price' => 1200,
                'new_price' => 1100,
                'stock' => 110,
                'thumbnail_image' => 'iphone15_thumb.jpg',
                'feature_image' => 'iphone15_feature.jpg',
                'status' => true,
            ],
            [
                'category_id' => 3,
                'brand_id' => 3,
                'name' => 'HP Spectre x360',
                'slug' => Str::slug('HP Spectre x360'),
                'code' => 'HPSX360',
                'description' => 'Premium convertible laptop.',
                'old_price' => 1500,
                'new_price' => 1350,
                'stock' => 135,
                'thumbnail_image' => 'hp_spectre_thumb.jpg',
                'feature_image' => 'hp_spectre_feature.jpg',
                'status' => true,
            ],
            [
                'category_id' => 5,
                'brand_id' => 4,
                'name' => 'Nike Air Max',
                'slug' => Str::slug('Nike Air Max'),
                'code' => 'NIKEAM',
                'description' => 'Stylish and comfortable shoes.',
                'old_price' => 150,
                'new_price' => 120,
                'stock' => 12,
                'thumbnail_image' => 'nike_airmax_thumb.jpg',
                'feature_image' => 'nike_airmax_feature.jpg',
                'status' => true,
            ],
        ];

        DB::table('products')->insert($products);

        // --- Orders ---
        $orders = [
            [
                'customer_id' => 1,
                'product_id' => 1,
                'invoice' => 'INV-' . strtoupper(Str::random(6)),
                'quantity' => 1,
                'amount' => 1100,
                'status' => 'pending',
            ],
            [
                'customer_id' => 2,
                'product_id' => 3,
                'invoice' => 'INV-' . strtoupper(Str::random(6)),
                'quantity' => 2,
                'amount' => 240,
                'status' => 'completed',
            ],
        ];

        DB::table('orders')->insert($orders);






         $settings = [
            [
                'name' => 'eFoodis.com',
                'phone' => '01828509632',
                'email' => 'efoodis24@gmail.com' ,
                'address' => 'Dhaka Bangladesh',
                'logo' => 'logo.png',
                'favicon' => 'icon.png',
            ], 
        ];
            DB::table('settings')->insert($settings);

         $osinfos = [
            [
                'type' => 'indhaka',
                'value' => '60',
            ], 
            [
                'type' => 'outdhaka',
                'value' => '120',
            ], 
            [
                'type' => 'facebook',
                'value' => 'www.facebook.com',
            ], 
            [
                'type' => 'youtube',
                'value' => 'www.youtube.com',
            ], 
            [
                'type' => 'linkedin',
                'value' => 'www.linkedin.com',
            ], 
             
        ];
            DB::table('osinfos')->insert($osinfos);


    }
}

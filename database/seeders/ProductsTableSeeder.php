<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products')->delete();
        
        \DB::table('products')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Gelang tali purple',
                'slug' => 'gelang-tali-purple',
                'description' => 'Gelang tali waterproof warna ungu',
                'sku' => 'GLG-TALI-PURPLE',
                'price' => '15000.00',
                'stock' => 5,
                'product_category_id' => 1,
                'image_url' => 'images\\gelang tali purple.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-12 16:08:50',
                'updated_at' => '2025-07-12 16:08:50',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Gelang tali merah',
                'slug' => 'gelang-tali-merah',
                'description' => 'Gelang tali waterproof warna merah',
                'sku' => 'GLG-TALI-MERAH',
                'price' => '15000.00',
                'stock' => 5,
                'product_category_id' => 1,
                'image_url' => 'images\\gelang tali merah.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-12 16:20:50',
                'updated_at' => '2025-07-12 16:21:50',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Gelang tali bunga',
                'slug' => 'gelang-tali-bunga',
                'description' => 'Gelang tali bunga',
                'sku' => 'GLG-TALI-BUNGA',
                'price' => '15000.00',
                'stock' => 5,
                'product_category_id' => 1,
                'image_url' => 'images\\gelang tali bunga.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-12 16:08:50',
                'updated_at' => '2025-07-12 16:15:50',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'cincin',
                'slug' => 'cincin-segitiga',
                'description' => 'cincin segitiga',
                'sku' => 'CNCN-SEGITIGA',
                'price' => '10000.00',
                'stock' => 5,
                'product_category_id' => 3,
                'image_url' => 'images\\cincin segitiga.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-12 16:08:50',
                'updated_at' => '2025-07-12 16:25:50',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'Kalung Daun',
                'slug' => 'kalung-daun',
                'description' => 'Kalung liontin berbentuk daun',
                'sku' => 'KLG-DAUN-001',
                'price' => '50000.00',
                'stock' => 5,
                'product_category_id' => 2,
                'image_url' => 'images\\kalung daun.jpeg',
                'is_active' => 2,
                'created_at' => '2025-07-15 16:08:50',
                'updated_at' => '2025-07-12 16:08:50',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Kalung Kupu',
                'slug' => 'kalung-kupu',
                'description' => 'Kalung Kupu',
                'sku' => 'KLG-Kupu',
                'price' => '18000.00',
                'stock' => 5,
                'product_category_id' => 2,
                'image_url' => 'images\\kalung kupu.jpeg', 
                'is_active' => 1,
                'created_at' => '2025-07-14 16:08:50',
                'updated_at' => '2025-07-12 16:08:50',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'Kalung Morol',
                'slug' => 'Kalung-Morol',
                'description' => 'Kalung Morol',
                'sku' => 'KLG-Morol',
                'price' => '15000.00',
                'stock' => 5,
                'product_category_id' => 2,
                'image_url' => 'images\\kalung morol.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-16 16:08:50',
                'updated_at' => '2025-07-12 16:08:50',
            ),
            7 => 
            array (
                'id' => 9,
                'name' => 'Kalung Salib',
                'slug' => 'kalung-salib',
                'description' => 'Kalung Salib',
                'sku' => 'KLG-Salib',
                'price' => '50000.00',
                'stock' => 5,
                'product_category_id' => 2,
                'image_url' => 'images\\kalung salib.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-17 16:08:50',
                'updated_at' => '2025-07-12 16:08:50',
            ),
            8 => 
            array (
                'id' => 10,
                'name' => 'Cincin Bunga',
                'slug' => 'cincin-bunga',
                'description' => 'Cincin Bunga',
                'sku' => 'Cncn-Bunga',
                'price' => '30000.00',
                'stock' => 5,
                'product_category_id' => 3,
                'image_url' => 'images\\cincin bunga.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-19 16:08:50',
                'updated_at' => '2025-07-12 16:08:50',
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'cincin list hitam',
                'slug' => 'cincin-list-hitam',
                'description' => 'Cincin List Hitam',
                'sku' => 'cncn-list',
                'price' => '15000.00',
                'stock' => 5,
                'product_category_id' => 3,
                'image_url' => 'images\\cincin list hitam.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-20 16:08:50',
                'updated_at' => '2025-07-12 16:08:50',
            ),
            10 => 
            array (
                'id' => 12,
                'name' => 'Anting Kupu',
                'slug' => 'anting-kupu',
                'description' => 'Anting berbentuk Kupu-kupu',
                'sku' => 'ATG-KUPU',
                'price' => '20000.00',
                'stock' => 5,
                'product_category_id' => 4,
                'image_url' => 'images\\anting kupu.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-15 16:08:50',
                'updated_at' => '2025-07-15 16:08:50',
            ),
            11 => 
            array (
                'id' => 13,
                'name' => 'Anting bulan sabit',
                'slug' => 'anting-bulan-sabit',
                'description' => 'Anting bulan sabit',
                'sku' => 'ATG-SABIT',
                'price' => '15000.00',
                'stock' => 5,
                'product_category_id' => 4,
                'image_url' => 'images\\anting sabit.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-12 16:08:50',
                'updated_at' => '2025-07-15 16:08:50',
            ),
            12 => 
            array (
                'id' => 14,
                'name' => 'Anting Tanjiro',
                'slug' => 'anting-tanjiro',
                'description' => 'Anting Tanjiro',
                'sku' => 'ATG-TANJIRO',
                'price' => '25000.00',
                'stock' => 5,
                'product_category_id' => 4,
                'image_url' => 'images\\anting tanjiro.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-12 16:08:50',
                'updated_at' => '2025-07-16 16:08:50',
            ),
            13 => 
            array (
                'id' => 15,
                'name' => 'Anting Daun',
                'slug' => 'anting-daun',
                'description' => 'anting daun',
                'sku' => 'ATG-DAUN',
                'price' => '15000.00',
                'stock' => 5,
                'product_category_id' => 4,
                'image_url' => 'images\\anting daun.jpeg',
                'is_active' => 1,
                'created_at' => '2025-07-12 16:08:50',
                'updated_at' => '2025-07-16 16:08:50',
            ),
        ));
        
        
    }
}
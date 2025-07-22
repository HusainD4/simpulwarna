<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_details')->delete();

        DB::table('order_details')->insert([
            [
                'id'         => 1,
                'order_id'   => 1,
                'product_id' => 1, // pastikan produk ini ada
                'quantity'   => 2,
                'unit_price' => 15000,
                'subtotal'   => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan baris detail lain sesuai order yang kamu buat
        ]);
    }
}

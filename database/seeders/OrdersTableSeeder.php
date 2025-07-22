<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->delete();

        DB::table('orders')->insert([
            [
                'id'           => 1,
                'customer_id'  => 1, // sesuaikan ID customer yang ada
                'order_date'   => '2025-07-20 10:00:00',
                'total_amount' => 150000,
                'status'       => 'pending',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Tambahkan baris order lain sesuai kebutuhan...
        ]);
    }
}

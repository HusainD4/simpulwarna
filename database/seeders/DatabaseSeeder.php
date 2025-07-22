<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Matikan pengecekan foreign key
        Schema::disableForeignKeyConstraints();

        // Panggil semua seeder sesuai urutan dependency
        $this->call([
            CategoriesSeeder::class,
            ThemeSeeder::class,
            ProductsTableSeeder::class,
            OrdersTableSeeder::class,
            OrderDetailsTableSeeder::class,
        ]);

        // Aktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categories;
use Illuminate\Support\Carbon;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::insert([
            [
                'name'        => 'Gelang',
                'slug'        => 'gelang',
                'description' => 'Kategori untuk aksesoris gelang',
                'image'       => 'images/gelang tali bunga.jpeg',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'name'        => 'Kalung',
                'slug'        => 'kalung',
                'description' => 'Kategori Aksesoris Kalung',
                'image'       => 'images/kalung salib.jpeg',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'name'        => 'Cincin',
                'slug'        => 'cincin',
                'description' => 'Kategori Aksesoris Cincin',
                'image'       => 'images/cincin list hitam.jpeg',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'name'        => 'Anting',
                'slug'        => 'anting',
                'description' => 'Kategori Aksesoris Anting',
                'image'       => 'images/anting kupu.jpeg',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ]);
    }
}

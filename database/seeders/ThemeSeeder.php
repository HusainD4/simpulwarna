<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Default Theme',
                'description' => 'This is the default theme.',
                'folder' => 'theme.default',
                'status' => 'active',
            ],
            [
                'name' => 'Hexashop Theme',
                'description' => 'A modern e-commerce theme.',
                'folder' => 'theme.hexashop',
                'status' => 'inactive',
            ],
        ];

        foreach ($themes as $theme) {
            Theme::updateOrCreate(
                ['folder' => $theme['folder']],
                $theme
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\CashCategory;
use Illuminate\Database\Seeder;

class CashCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Iuran Anggota', 'type' => 'income'],
            ['name' => 'Donasi', 'type' => 'income'],
            ['name' => 'Kas Masuk Lainnya', 'type' => 'income'],
            ['name' => 'Operasional', 'type' => 'expense'],
            ['name' => 'Kegiatan', 'type' => 'expense'],
            ['name' => 'Kas Keluar Lainnya', 'type' => 'expense'],
        ];

        foreach ($categories as $category) {
            CashCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}

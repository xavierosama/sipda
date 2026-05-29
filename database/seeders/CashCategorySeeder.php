<?php

namespace Database\Seeders;

use App\Models\CashCategory;
use Illuminate\Database\Seeder;

class CashCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Iuran Anggota', 'type' => 'income', 'status' => 'active'],
            ['name' => 'Donasi', 'type' => 'income', 'status' => 'active'],
            ['name' => 'Kas Masuk Lainnya', 'type' => 'income', 'status' => 'active'],
            ['name' => 'Operasional', 'type' => 'expense', 'status' => 'active'],
            ['name' => 'Kegiatan', 'type' => 'expense', 'status' => 'active'],
            ['name' => 'Kas Keluar Lainnya', 'type' => 'expense', 'status' => 'active'],
        ];

        foreach ($categories as $category) {
            CashCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['name' => 'Ketua', 'status' => 'active'],
            ['name' => 'Wakil Ketua', 'status' => 'active'],
            ['name' => 'Sekretaris', 'status' => 'active'],
            ['name' => 'Wakil Sekretaris', 'status' => 'active'],
            ['name' => 'Bendahara', 'status' => 'active'],
            ['name' => 'Wakil Bendahara', 'status' => 'active'],
            ['name' => 'Ketua Bidang', 'status' => 'active'],
            ['name' => 'Anggota', 'status' => 'active'],
        ];

        foreach ($positions as $position) {
            Position::updateOrCreate(
                ['name' => $position['name']],
                $position
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Ketua', 'code' => 'KETUA', 'status' => 'active'],
            ['name' => 'Sekretaris', 'code' => 'SEK', 'status' => 'active'],
            ['name' => 'Bendahara', 'code' => 'BEN', 'status' => 'active'],
            ['name' => 'Bidang Kaderisasi', 'code' => 'KDR', 'status' => 'active'],
            ['name' => 'Bidang Dakwah', 'code' => 'DKW', 'status' => 'active'],
            ['name' => 'Bidang Sosial', 'code' => 'SOS', 'status' => 'active'],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['code' => $department['code']],
                $department
            );
        }
    }
}

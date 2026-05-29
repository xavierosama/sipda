<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super-admin',
                'display_name' => 'Super Admin',
                'description' => 'Akses penuh ke seluruh modul SIPDA.',
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Pengelola administrasi sistem.',
            ],
            [
                'name' => 'member',
                'display_name' => 'Anggota',
                'description' => 'Pengguna anggota internal.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}

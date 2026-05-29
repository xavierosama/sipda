<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('name', 'super-admin')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'superadmin@sipda.test'],
            [
                'role_id' => $role->id,
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
    }
}

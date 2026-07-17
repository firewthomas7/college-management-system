<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super_admin')->first();

        User::updateOrCreate(
            ['email' => 'admin@wsptc.edu.et'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@wsptc.edu.et',
                'password' => Hash::make('ChangeMe123!'),
                'role_id' => $superAdminRole->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}

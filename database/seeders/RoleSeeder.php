<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Full unrestricted access to the entire system.',
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Manages daily college operations and content.',
            ],
            [
                'name' => 'teacher',
                'display_name' => 'Teacher',
                'description' => 'Manages assigned courses, grades, and attendance.',
            ],
            [
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'Views own courses, grades, attendance, and fees.',
            ],
            [
                'name' => 'accountant',
                'display_name' => 'Accountant',
                'description' => 'Manages fees, payments, and financial records.',
            ],
            [
                'name' => 'librarian',
                'display_name' => 'Librarian',
                'description' => 'Manages library books and borrowing records.',
            ],
            [
                'name' => 'registrar',
                'display_name' => 'Registrar',
                'description' => 'Manages enrollments, sections, and academic records.',
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@hrms.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'admin'
            ]
        );

        // Create Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'admin'
            ]
        );

        // Create HR Manager
        $hrUser = User::firstOrCreate(
            ['email' => 'hr@example.com'],
            [
                'name' => 'HR Manager',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'hr-manager'
            ]
        );

        // Create regular employee
        $employee = User::firstOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'John Employee',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'employee'
            ]
        );

        $this->command->info('✅ Users created successfully!');
        $this->command->info('Super Admin: admin@hrms.com / password123');
        $this->command->info('Admin: admin@example.com / password123');
        $this->command->info('HR Manager: hr@example.com / password123');
        $this->command->info('Employee: employee@example.com / password123');
    }
}
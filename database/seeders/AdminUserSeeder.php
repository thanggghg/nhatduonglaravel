<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role if not exists
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);

        // Create admin user
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@nhatduong.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@nhatduong.com');
        $this->command->info('Password: password');
    }
}

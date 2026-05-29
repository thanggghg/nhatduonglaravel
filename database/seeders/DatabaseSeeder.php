<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@nhatduong.com',
        ]);

        // Call seeders in order
        $this->call([
            SettingSeeder::class,
            BannerSeeder::class,
            PostCategorySeeder::class,
            PostSeeder::class,
            RouteSeeder::class,
        ]);
    }
}

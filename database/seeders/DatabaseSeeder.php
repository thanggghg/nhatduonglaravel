<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            BannerSeeder::class,
            PostCategorySeeder::class,
            PostSeeder::class,
            RouteSeeder::class,
            FaqSeeder::class,
            PageSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostCategory::create([
            'name' => 'Tin Tức',
            'slug' => 'tin-tuc',
            'description' => 'Tin tức và thông báo mới nhất từ Nhà Xe Nhật Dương',
            'status' => true,
        ]);

        PostCategory::create([
            'name' => 'Khuyến Mãi',
            'slug' => 'khuyen-mai',
            'description' => 'Các chương trình khuyến mãi và ưu đãi đặc biệt',
            'status' => true,
        ]);

        PostCategory::create([
            'name' => 'Hướng Dẫn',
            'slug' => 'huong-dan',
            'description' => 'Hướng dẫn đặt vé và sử dụng dịch vụ',
            'status' => true,
        ]);

        PostCategory::create([
            'name' => 'Kinh Nghiệm Du Lịch',
            'slug' => 'kinh-nghiem-du-lich',
            'description' => 'Chia sẻ kinh nghiệm du lịch và khám phá',
            'status' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'title' => 'Nhà Xe Nhật Dương',
            'subtitle' => 'An Toàn - Tin Cậy - Tiện Nghi',
            'button_text' => 'Đặt Vé Ngay',
            'button_url' => '/dat-ve',
            'position' => 'hero',
            'sort_order' => 1,
            'status' => true,
        ]);

        Banner::create([
            'title' => 'Ưu Đãi Đặc Biệt Tháng 5',
            'subtitle' => 'Giảm Giá 20% Toàn Bộ Tuyến Xe',
            'button_text' => 'Xem Chi Tiết',
            'button_url' => '/tin-tuc/uu-dai-dac-biet-thang-5-giam-gia-20-toan-bo-tuyen-xe',
            'position' => 'hero',
            'sort_order' => 2,
            'status' => true,
        ]);

        Banner::create([
            'title' => 'Khai Trương Tuyến Mới',
            'subtitle' => 'Sài Gòn - Đà Lạt Giường Nằm VIP',
            'button_text' => 'Đặt Vé Ngay',
            'button_url' => '/tuyen-xe/sai-gon-da-lat',
            'position' => 'hero',
            'sort_order' => 3,
            'status' => true,
        ]);
    }
}

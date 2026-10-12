<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('routes')->updateOrInsert(
            ['slug' => 'nha-trang-da-nang'],
            [
                'name' => 'Nha Trang - Đà Nẵng',
                'from_location' => 'Nha Trang',
                'to_location' => 'Đà Nẵng',
                'distance' => '530',
                'estimated_time' => '9-10 giờ',
                'price_from' => null,
                'description' => 'Tuyến xe Nha Trang đi Đà Nẵng với xe giường nằm tiện nghi, lịch trình rõ ràng và hỗ trợ đặt vé trực tuyến.',
                'booking_url' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }

    public function down(): void
    {
        DB::table('routes')->where('slug', 'nha-trang-da-nang')->delete();
    }
};

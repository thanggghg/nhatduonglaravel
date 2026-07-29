<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $forwardRoute = DB::table('routes')
            ->where('from_location', 'TP. Hồ Chí Minh')
            ->where('to_location', 'Nha Trang')
            ->first();

        if (!$forwardRoute || DB::table('routes')->where('slug', 'nha-trang-sai-gon')->exists()) {
            return;
        }

        DB::table('routes')->insert([
            'name' => 'Nha Trang - Sài Gòn',
            'slug' => 'nha-trang-sai-gon',
            'from_location' => 'Nha Trang',
            'to_location' => 'TP. Hồ Chí Minh',
            'distance' => $forwardRoute->distance,
            'estimated_time' => $forwardRoute->estimated_time,
            'price_from' => $forwardRoute->price_from,
            'description' => 'Tuyến xe chiều ngược lại từ Nha Trang về Sài Gòn với giường nằm êm ái và thông tin chuyến đi rõ ràng.',
            'booking_url' => $forwardRoute->booking_url,
            'status' => $forwardRoute->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('routes')->where('slug', 'nha-trang-sai-gon')->delete();
    }
};

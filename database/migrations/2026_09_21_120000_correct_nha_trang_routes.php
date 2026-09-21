<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('routes')
            ->whereIn('slug', ['sai-gon-nha-trang', 'nha-trang-tp-ho-chi-minh'])
            ->update([
                'distance' => '430',
                'estimated_time' => '6 giờ 20 phút - 7 giờ 50 phút',
                'price_from' => 330000,
                'updated_at' => now(),
            ]);

        DB::table('routes')
            ->where('slug', 'nha-trang-sai-gon')
            ->update([
                'status' => false,
                'updated_at' => now(),
            ]);

        $forwardRouteId = DB::table('routes')->where('slug', 'sai-gon-nha-trang')->value('id');
        if ($forwardRouteId) {
            DB::table('schedules')->where('route_id', $forwardRouteId)->update(['status' => false]);
        }
    }

    public function down(): void
    {
        DB::table('routes')
            ->where('slug', 'sai-gon-nha-trang')
            ->update([
                'distance' => '450',
                'estimated_time' => '9-10 giờ',
                'price_from' => 220000,
                'updated_at' => now(),
            ]);

        DB::table('routes')
            ->where('slug', 'nha-trang-tp-ho-chi-minh')
            ->update([
                'distance' => '430 km',
                'estimated_time' => '7.5 giờ',
                'price_from' => null,
                'updated_at' => now(),
            ]);

        DB::table('routes')
            ->where('slug', 'nha-trang-sai-gon')
            ->update([
                'status' => true,
                'updated_at' => now(),
            ]);

        $forwardRouteId = DB::table('routes')->where('slug', 'sai-gon-nha-trang')->value('id');
        if ($forwardRouteId) {
            DB::table('schedules')->where('route_id', $forwardRouteId)->update(['status' => true]);
        }
    }
};

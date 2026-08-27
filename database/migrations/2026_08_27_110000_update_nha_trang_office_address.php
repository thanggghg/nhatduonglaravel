<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const OLD_ADDRESS = '23 Tháng 10, Phường Phước Long, TP. Nha Trang';

    private const NEW_ADDRESS = '45-26 Thích Quảng Đức, KĐT Hà Quang 2, Phường Nam Nha Trang, Khánh Hòa';

    public function up(): void
    {
        DB::table('dropoff_points')
            ->where('address', self::OLD_ADDRESS)
            ->update(['address' => self::NEW_ADDRESS, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('dropoff_points')
            ->where('address', self::NEW_ADDRESS)
            ->update(['address' => self::OLD_ADDRESS, 'updated_at' => now()]);
    }
};

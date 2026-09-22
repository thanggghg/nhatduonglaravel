<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const SAIGON_PHONE = '028 3899 3333';

    private const NHA_TRANG_PHONE = '0258 3812 586';

    public function up(): void
    {
        DB::table('pickup_points')
            ->where('phone', self::SAIGON_PHONE)
            ->update(['phone' => null, 'updated_at' => now()]);

        DB::table('dropoff_points')
            ->where('phone', self::NHA_TRANG_PHONE)
            ->update(['phone' => null, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('pickup_points')
            ->where('name', 'VPSG')
            ->where('address', '99 Nguyễn Cư Trinh, Quận 1')
            ->whereNull('phone')
            ->update(['phone' => self::SAIGON_PHONE, 'updated_at' => now()]);

        DB::table('dropoff_points')
            ->where('name', 'Bến xe Nha Trang')
            ->where('address', '45-26 Thích Quảng Đức, KĐT Hà Quang 2, Phường Nam Nha Trang, Khánh Hòa')
            ->whereNull('phone')
            ->update(['phone' => self::NHA_TRANG_PHONE, 'updated_at' => now()]);
    }
};

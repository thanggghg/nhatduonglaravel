<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const OFFICE = 'VP ĐÀ NẴNG: 709 Nguyễn Tất Thành, P. Thanh Khê, TP. Đà Nẵng';

    public function up(): void
    {
        $address = DB::table('settings')->where('key', 'address')->value('value');

        if (is_string($address) && !str_contains($address, self::OFFICE)) {
            DB::table('settings')->where('key', 'address')->update([
                'value' => rtrim($address)."\n".self::OFFICE,
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        $address = DB::table('settings')->where('key', 'address')->value('value');

        if (is_string($address)) {
            DB::table('settings')->where('key', 'address')->update([
                'value' => trim(str_replace("\n".self::OFFICE, '', $address)),
                'updated_at' => now(),
            ]);
        }
    }
};

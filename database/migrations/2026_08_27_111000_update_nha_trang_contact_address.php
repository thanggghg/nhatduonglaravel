<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const OLD_ADDRESS = '44-21 Thích Quảng Đức, KDT Hà Quang 2, P. Nam Nha Trang, Khánh Hoà';

    private const NEW_ADDRESS = '45-26 Thích Quảng Đức, KĐT Hà Quang 2, Phường Nam Nha Trang, Khánh Hòa';

    public function up(): void
    {
        $this->replaceAddress(self::OLD_ADDRESS, self::NEW_ADDRESS);
    }

    public function down(): void
    {
        $this->replaceAddress(self::NEW_ADDRESS, self::OLD_ADDRESS);
    }

    private function replaceAddress(string $from, string $to): void
    {
        DB::table('settings')
            ->where('key', 'address')
            ->where('value', 'like', "%{$from}%")
            ->get(['id', 'value'])
            ->each(fn ($setting) => DB::table('settings')->where('id', $setting->id)->update([
                'value' => str_replace($from, $to, $setting->value),
                'updated_at' => now(),
            ]));

        foreach (['pickup_points', 'dropoff_points'] as $table) {
            DB::table($table)
                ->where('address', $from)
                ->update(['address' => $to, 'updated_at' => now()]);
        }
    }
};

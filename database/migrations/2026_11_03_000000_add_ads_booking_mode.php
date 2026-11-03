<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('ads_mode')->default(false)->after('locale');
        });

        DB::table('settings')->updateOrInsert(
            ['key' => 'ads_booking_mode'],
            [
                'value' => '0',
                'type' => 'boolean',
                'group' => 'booking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'ads_booking_mode')->delete();

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('ads_mode');
        });
    }
};

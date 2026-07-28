<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('public_booking_order_id')->nullable()->unique()->after('trip_code');
            $table->string('public_booking_status', 32)->nullable()->index()->after('public_booking_order_id');
            $table->json('public_booking_ticket_codes')->nullable()->after('public_booking_status');
            $table->json('public_booking_codes')->nullable()->after('public_booking_ticket_codes');
            $table->string('public_booking_idempotency_key', 128)->nullable()->unique()->after('public_booking_codes');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique(['public_booking_order_id']);
            $table->dropUnique(['public_booking_idempotency_key']);
            $table->dropIndex(['public_booking_status']);
            $table->dropColumn([
                'public_booking_order_id',
                'public_booking_status',
                'public_booking_ticket_codes',
                'public_booking_codes',
                'public_booking_idempotency_key',
            ]);
        });
    }
};

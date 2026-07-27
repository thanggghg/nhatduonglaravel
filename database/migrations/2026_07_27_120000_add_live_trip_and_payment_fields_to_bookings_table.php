<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_id')->nullable()->change();
            $table->string('trip_code')->nullable()->index()->after('schedule_id');
            $table->timestamp('departure_at')->nullable()->after('trip_code');
            $table->timestamp('arrival_at')->nullable()->after('departure_at');
            $table->string('vehicle_type')->nullable()->after('arrival_at');
            $table->json('selected_seats')->nullable()->after('seat_preference');
            $table->string('payment_code', 16)->nullable()->unique()->after('status');
            $table->string('payment_status', 32)->default('awaiting_payment')->index()->after('payment_code');
            $table->string('payment_provider', 32)->nullable()->after('payment_status');
            $table->string('payment_transaction_id')->nullable()->unique()->after('payment_provider');
            $table->string('payment_reference')->nullable()->after('payment_transaction_id');
            $table->json('payment_payload')->nullable()->after('payment_reference');
            $table->timestamp('paid_at')->nullable()->after('payment_payload');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique(['payment_code']);
            $table->dropUnique(['payment_transaction_id']);
            $table->dropIndex(['trip_code']);
            $table->dropIndex(['payment_status']);
            $table->dropColumn([
                'trip_code',
                'departure_at',
                'arrival_at',
                'vehicle_type',
                'selected_seats',
                'payment_code',
                'payment_status',
                'payment_provider',
                'payment_transaction_id',
                'payment_reference',
                'payment_payload',
                'paid_at',
            ]);
            $table->unsignedBigInteger('schedule_id')->nullable(false)->change();
        });
    }
};

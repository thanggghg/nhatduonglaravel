<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('schedules', 'vehicle_type')) {
                $table->string('vehicle_type')->nullable()->after('arrival_time');
            }

            if (!Schema::hasColumn('schedules', 'seat_count')) {
                $table->unsignedInteger('seat_count')->nullable()->after('vehicle_type');
            }
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 24)->unique();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->date('travel_date');
            $table->foreignId('return_schedule_id')->nullable()->constrained('schedules')->nullOnDelete();
            $table->date('return_travel_date')->nullable();
            $table->unsignedTinyInteger('passenger_count');
            $table->string('passenger_name');
            $table->string('passenger_email')->nullable();
            $table->string('passenger_phone', 50)->nullable();
            $table->string('pickup_point')->nullable();
            $table->string('dropoff_point')->nullable();
            $table->string('seat_preference', 30)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('outbound_fare');
            $table->unsignedInteger('return_fare')->nullable();
            $table->unsignedInteger('total_amount');
            $table->string('currency', 3)->default('VND');
            $table->string('status', 20)->default('pending')->index();
            $table->string('locale', 5)->default('en');
            $table->timestamps();

            $table->index(['schedule_id', 'travel_date', 'status']);
            $table->index(['return_schedule_id', 'return_travel_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

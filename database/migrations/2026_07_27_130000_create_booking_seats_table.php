<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('trip_code')->index();
            $table->date('travel_date');
            $table->string('seat', 12);
            $table->timestamps();

            $table->unique(['trip_code', 'travel_date', 'seat'], 'booking_seats_trip_date_seat_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};

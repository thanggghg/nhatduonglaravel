<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('from_location');
            $table->string('to_location');
            $table->string('distance', 100)->nullable();
            $table->string('estimated_time', 100)->nullable();
            $table->decimal('price_from', 12, 2)->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('booking_url', 500)->nullable();
            $table->string('status', 50)->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};

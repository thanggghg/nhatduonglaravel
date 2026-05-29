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
        Schema::create('dropoff_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('address', 500)->nullable();
            $table->string('map_url', 500)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('note', 500)->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('status', 50)->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dropoff_points');
    }
};

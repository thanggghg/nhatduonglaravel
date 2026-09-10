<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sepay_transaction_resolutions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 100)->unique();
            $table->string('status', 30)->default('resolved_manually');
            $table->string('resolved_by', 100)->nullable();
            $table->timestamp('resolved_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sepay_transaction_resolutions');
    }
};

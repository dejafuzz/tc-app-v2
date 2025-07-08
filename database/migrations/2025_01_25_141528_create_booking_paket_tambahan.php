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
        Schema::create('booking_paket_tambahan', function (Blueprint $table) {
            $table->string('id_booking_paket_tambahan')->primary()->unique();
            $table->string('booking_id')->nullable();
            $table->string('paket_tambahan_id')->nullable();
            
            $table->foreign('booking_id')->references('id_booking')->on('booking')->cascadeOnDelete();
            $table->foreign('paket_tambahan_id')->references('id_paket_tambahan')->on('paket_tambahan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_paket_tambahan');
    }
};
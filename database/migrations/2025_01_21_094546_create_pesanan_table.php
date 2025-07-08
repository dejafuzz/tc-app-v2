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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('id_pesanan')->primary()->unique();
            $table->string('booking_id');
            $table->unsignedBigInteger('fotografer_id')->nullable();
            $table->text('keterangan')->nullable();
            
            $table->integer('harga_paket_tambahan')->nullable();
            $table->integer('kekurangan')->nullable();
            $table->integer('pelunasan')->nullable();
            $table->integer('discount')->nullable();
            $table->text('file_pelunasan')->nullable();
            $table->integer('total')->nullable();
            $table->string('status_pembayaran')->nullable();
            $table->integer('freelance')->nullable();
            $table->string('faktur')->unique();
            
            $table->foreign('booking_id')->references('id_booking')->on('booking')->cascadeOnDelete();
            $table->foreign('fotografer_id')->references('id_fotografer')->on('fotografer')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
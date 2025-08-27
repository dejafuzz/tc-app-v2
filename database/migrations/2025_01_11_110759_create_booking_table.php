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
        Schema::create('booking', function (Blueprint $table) {
            $table->string('id_booking')->primary();
            $table->string('nama');
            $table->string('email');
            $table->string('no_wa');
            $table->string('event')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam')->nullable();
            $table->string('universitas');
            $table->string('fakultas')->nullable();
            $table->string('lokasi_foto')->nullable();
            $table->string('ig_mua')->nullable();
            $table->string('ig_dress')->nullable();
            $table->string('ig_nailart')->nullable();
            $table->string('ig_hijab')->nullable();
            $table->string('ig_client')->nullable();
            $table->string('post_foto')->nullable();
            $table->string('jumlah_anggota')->nullable();
            $table->string('req_khusus')->nullable();
            $table->string('status_booking');

            $table->string('negara')->nullable();
            $table->string('kota')->nullable();
            $table->date('tanggal_dp')->nullable();
            $table->integer('dp')->nullable();
            $table->text('file_dp')->nullable();
            $table->integer('pelunasan')->nullable();
            $table->text('file_pelunasan')->nullable();
            $table->string('jam_selesai')->nullable();  
            $table->integer('discount')->nullable();

            $table->integer('harga')->nullable();
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('harga_paket_id')->nullable();
            $table->foreign('harga_paket_id')->references('id_harga_paket')->on('harga_paket')->cascadeOnDelete();
            $table->string('paket_tambahan_id')->nullable();
            $table->foreign('paket_tambahan_id')->references('id_paket_tambahan')->on('paket_tambahan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
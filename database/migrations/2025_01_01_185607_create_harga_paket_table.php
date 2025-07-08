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
        Schema::create('harga_paket', function (Blueprint $table) {
            $table->string('id_harga_paket')->primary()->unique();
            $table->integer('harga');
            $table->string('golongan');
            $table->string('paket_id');
            $table->foreign('paket_id')->references('id_paket')->on('paket')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_paket');
    }
};
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
        Schema::create('foto', function (Blueprint $table) {
            $table->string('id_foto')->primary()->unique();
            $table->string('pesanan_id');
            $table->string('status_foto')->nullable();
            $table->text('link')->nullable();
            $table->json('foto_edit')->nullable();
            $table->integer('antrian')->nullable()->unique();

            $table->foreign('pesanan_id')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto');
    }
};
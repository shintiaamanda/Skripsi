<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ajukan_konseling', function (Blueprint $table) {
            $table->bigIncrements('id_konseling');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_jadwal')->nullable();
            $table->dateTime('tanggal_konseling');
            $table->text('keluhan');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('input_data_siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ajukan_konseling');
    }
};

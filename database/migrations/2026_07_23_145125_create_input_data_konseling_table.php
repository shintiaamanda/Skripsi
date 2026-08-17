<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('input_data_konseling', function (Blueprint $table) {
            $table->bigIncrements('id_data_konseling');
            $table->unsignedBigInteger('id_siswa');
            $table->dateTime('tanggal');
            $table->text('masalah');
            $table->text('solusi');
            $table->string('guru_bk');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('input_data_siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('input_data_konseling');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('input_data_monitoring', function (Blueprint $table) {
            $table->bigIncrements('id_monitoring');
            $table->unsignedBigInteger('id_siswa');
            $table->date('tanggal_monitoring');
            $table->text('perkembangan');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('input_data_siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('input_data_monitoring');
    }
};

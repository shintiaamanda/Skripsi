<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('input_data_pelanggaran', function (Blueprint $table) {
            $table->bigIncrements('id_pelanggaran');
            $table->unsignedBigInteger('id_siswa');
            $table->date('tanggal_pelanggaran');
            $table->integer('poin');
            $table->text('tindakan');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('input_data_siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('input_data_pelanggaran');
    }
};

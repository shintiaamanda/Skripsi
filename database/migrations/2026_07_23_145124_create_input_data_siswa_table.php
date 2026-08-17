<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('input_data_siswa', function (Blueprint $table) {
            $table->bigIncrements('id_siswa');
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('kelas');
            $table->text('alamat');
            $table->string('no_hp');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('input_data_siswa');
    }
};

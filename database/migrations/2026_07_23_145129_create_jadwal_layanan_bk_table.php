<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_layanan_bk', function (Blueprint $table) {
            $table->bigIncrements('id_jadwal');
            $table->string('hari');
            $table->date('tanggal_layanan');
            $table->string('jam');
            $table->string('guru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_layanan_bk');
    }
};

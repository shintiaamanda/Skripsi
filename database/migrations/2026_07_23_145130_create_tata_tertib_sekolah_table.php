<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tata_tertib_sekolah', function (Blueprint $table) {
            $table->bigIncrements('id_tertib');
            $table->text('tata_tertib');
            $table->date('tanggal_konseling');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tata_tertib_sekolah');
    }
};

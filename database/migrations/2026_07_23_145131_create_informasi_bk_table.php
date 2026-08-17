<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_bk', function (Blueprint $table) {
            $table->bigIncrements('id_info');
            $table->text('informasi');
            $table->date('tanggal_informasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_bk');
    }
};

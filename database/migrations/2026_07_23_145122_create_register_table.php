<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('register', function (Blueprint $table) {
            $table->bigIncrements('id_register');
            $table->string('nama');
            $table->string('email');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('siswa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('register');
    }
};

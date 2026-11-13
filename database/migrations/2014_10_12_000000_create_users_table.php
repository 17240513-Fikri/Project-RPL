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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->nullable()->index();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_terverifikasi_pada')->nullable();
            $table->string('kata_sandi');
            $table->string('peran')->default('warga')->index();
            $table->rememberToken('token_ingat');
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};

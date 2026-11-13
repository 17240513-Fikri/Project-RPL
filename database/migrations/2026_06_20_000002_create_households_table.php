<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kk', 20)->unique();
            $table->unsignedBigInteger('kepala_warga_id')->nullable()->index();
            $table->text('alamat');
            $table->string('rt', 5)->default('001');
            $table->string('rw', 5)->default('001');
            $table->string('blok')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('status_rumah')->default('milik_sendiri');
            $table->string('status_ekonomi')->default('menengah');
            $table->text('catatan')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
            $table->softDeletes('dihapus_pada');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_keluarga');
    }
};

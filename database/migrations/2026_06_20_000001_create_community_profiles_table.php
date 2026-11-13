<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_wilayah', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->default('Portal RT/RW');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->text('alamat');
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('nama_ketua')->nullable();
            $table->string('nama_wakil_ketua')->nullable();
            $table->string('nama_sekretaris')->nullable();
            $table->string('nama_bendahara')->nullable();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_wilayah');
    }
};

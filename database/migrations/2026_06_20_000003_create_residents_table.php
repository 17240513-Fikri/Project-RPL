<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kartu_keluarga_id')->nullable()->constrained('kartu_keluarga')->nullOnDelete();
            $table->string('nik', 20)->unique();
            $table->string('nama');
            $table->string('jenis_kelamin', 20);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('status_keluarga')->nullable();
            $table->string('kewarganegaraan')->default('WNI');
            $table->string('golongan_darah', 5)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('alamat_ktp')->nullable();
            $table->string('status_warga')->default('aktif')->index();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
            $table->softDeletes('dihapus_pada');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};

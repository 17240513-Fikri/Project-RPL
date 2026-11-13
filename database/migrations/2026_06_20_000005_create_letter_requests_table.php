<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->restrictOnDelete();
            $table->foreignId('warga_id')->constrained('warga')->restrictOnDelete();
            $table->foreignId('diajukan_oleh')->constrained('pengguna')->restrictOnDelete();
            $table->foreignId('diproses_oleh')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->string('nomor_surat')->nullable()->unique();
            $table->text('keperluan');
            $table->json('data_tambahan')->nullable();
            $table->string('status')->default('diajukan')->index();
            $table->text('catatan')->nullable();
            $table->text('alasan_ditolak')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->timestamp('selesai_pada')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};

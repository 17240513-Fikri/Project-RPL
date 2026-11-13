<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_kas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 30)->unique();
            $table->string('jenis')->index();
            $table->string('kategori');
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal_transaksi')->index();
            $table->text('keterangan');
            $table->string('metode_bayar')->nullable();
            $table->string('referensi')->nullable();
            $table->foreignId('dicatat_oleh')->constrained('pengguna')->restrictOnDelete();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_kas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori')->default('Umum')->index();
            $table->longText('isi');
            $table->boolean('terbit')->default(false)->index();
            $table->timestamp('terbit_pada')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('pengguna')->restrictOnDelete();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
            $table->softDeletes('dihapus_pada');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kerusakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // FIX: constrained('infrastruktur') bukan constrained('infrastuktur')
            $table->foreignId('infrastruktur_id')->nullable()->constrained('infrastruktur')->onDelete('set null');
            $table->string('judul_laporan');
            $table->string('lokasi_kerusakan');
            $table->text('deskripsi_kerusakan');
            $table->string('foto')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakan');
    }
};

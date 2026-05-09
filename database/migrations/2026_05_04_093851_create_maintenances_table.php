<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('infrastruktur_id')->constrained('infrastruktur')->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_maintenance');
            $table->text('hasil_pemeriksaan');
            $table->text('catatan')->nullable();
            $table->enum('kondisi_setelah', ['baik', 'rusak_ringan', 'rusak_berat']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};

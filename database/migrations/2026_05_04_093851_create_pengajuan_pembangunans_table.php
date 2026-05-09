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
        Schema::create('pengajuan_pembangunan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nama_proyek');
        $table->string('lokasi');
        $table->string('dusun');
        $table->text('alasan_usulan');
        $table->decimal('estimasi_biaya', 15, 2);
        $table->enum('prioritas', ['rendah','sedang','tinggi'])->default('sedang');
        $table->enum('status', ['diajukan','disetujui','ditolak','selesai'])->default('diajukan');
        $table->text('catatan_admin')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pembangunans');
    }
};

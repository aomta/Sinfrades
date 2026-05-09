<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infrastruktur', function (Blueprint $table) {
            $table->id();
            $table->string('nama_infrastruktur');
            $table->enum('kategori', [
                'jalan', 'jembatan', 'drainase', 'irigasi',
                'lampu_jalan', 'gedung_desa', 'posyandu',
                'sekolah', 'tempat_ibadah', 'sanitasi_umum', 'air_bersih'
            ]);
            $table->string('lokasi');
            $table->string('dusun');
            $table->year('tahun_pembangunan');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infrastruktur');
    }
};

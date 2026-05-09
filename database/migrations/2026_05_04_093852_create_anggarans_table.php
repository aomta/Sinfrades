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
        Schema::create('anggaran', function (Blueprint $table) {
        $table->id();
        $table->string('sumber_dana');
        $table->decimal('nominal', 15, 2);
        $table->date('tanggal');
        $table->enum('jenis', ['pemasukan','pengeluaran']);
        $table->string('jenis_pengeluaran')->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggarans');
    }
};

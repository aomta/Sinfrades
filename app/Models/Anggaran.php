<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = 'anggaran'; 

    protected $fillable = [
        'sumber_dana',
        'nominal',
        'tanggal',
        'jenis',
        'jenis_pengeluaran',
        'keterangan'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Infrastruktur extends Model
{
    protected $table = 'infrastruktur';

    protected $fillable = [
        'nama_infrastruktur',
        'kategori',
        'lokasi',
        'dusun',
        'tahun_pembangunan',
        'kondisi',
        'deskripsi',
        'foto',
        'lat',
        'lng',
    ];

    public function laporans(): HasMany
    {
        return $this->hasMany(LaporanKerusakan::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }


}

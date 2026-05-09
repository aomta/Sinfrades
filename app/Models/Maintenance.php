<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenance';

    protected $fillable = [
        'infrastruktur_id',
        'petugas_id',
        'tanggal_maintenance',
        'hasil_pemeriksaan',
        'catatan',
        'kondisi_setelah'
    ];

    public function infrastruktur()
{
    return $this->belongsTo(Infrastruktur::class);
}

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}

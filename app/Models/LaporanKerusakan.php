<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model {
    protected $table = 'laporan_kerusakan';
    protected $fillable = [
        'user_id','infrastruktur_id','judul_laporan',
        'lokasi_kerusakan','deskripsi_kerusakan','foto',
        'status','catatan_admin'
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function infrastruktur() { return $this->belongsTo(Infrastruktur::class); }
}

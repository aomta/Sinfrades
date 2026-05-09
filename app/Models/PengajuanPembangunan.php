<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PengajuanPembangunan extends Model {

    protected $table = 'pengajuan_pembangunan';

    protected $fillable = [
        'user_id','nama_proyek','lokasi','dusun',
        'alasan_usulan','estimasi_biaya','prioritas','status','catatan_admin'
    ];

    public function user() { 
        return $this->belongsTo(User::class); 
    }
}
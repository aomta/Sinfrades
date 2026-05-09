<?php
namespace App\Http\Controllers;
use App\Models\{Infrastruktur, LaporanKerusakan, PengajuanPembangunan, User};

class DashboardController extends Controller {
    public function index() {
        $totalInfrastruktur = Infrastruktur::count();
        $fasilitasBaik = Infrastruktur::where('kondisi','baik')->count();
        $rusakRingan = Infrastruktur::where('kondisi','rusak_ringan')->count();
        $rusakBerat = Infrastruktur::where('kondisi','rusak_berat')->count();
        $laporanMasuk = LaporanKerusakan::where('status','menunggu')->count();
        $proyekAktif = PengajuanPembangunan::where('status','disetujui')->count();
        $grafikKondisi = [
            'baik' => $fasilitasBaik,
            'rusak_ringan' => $rusakRingan,
            'rusak_berat' => $rusakBerat,
        ];
        return view('dashboard', compact(
            'totalInfrastruktur','fasilitasBaik','rusakRingan',
            'rusakBerat','laporanMasuk','proyekAktif','grafikKondisi'
        ));
    }
}

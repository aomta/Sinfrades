<?php
namespace App\Http\Controllers;
use App\Models\Infrastruktur;

class MapController extends Controller {
    public function index() {
        return view('peta.index');
    }
    public function data() {
        $data = Infrastruktur::whereNotNull('lat')->whereNotNull('lng')->get([
            'id','nama_infrastruktur','kategori','lokasi','kondisi','lat','lng'
        ]);
        return response()->json($data);
    }
}

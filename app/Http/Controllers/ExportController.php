<?php

namespace App\Http\Controllers;

use App\Models\Infrastruktur;
use App\Models\LaporanKerusakan;
use App\Exports\InfrastrukturExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function pdf()
    {
        $data = Infrastruktur::orderBy('kategori')->get();
        $pdf  = Pdf::loadView('export.pdf', compact('data'))
                   ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-infrastruktur-' . date('Y-m-d') . '.pdf');
    }

    // FIX: Route /export/excel sudah ada di routes/web.php, method ini memastikan controller-nya ada
    public function excel()
    {
        return Excel::download(
            new InfrastrukturExport,
            'laporan-infrastruktur-' . date('Y-m-d') . '.xlsx'
        );
    }
}

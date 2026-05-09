<?php
namespace App\Exports;
use App\Models\Infrastruktur;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings};

class InfrastrukturExport implements FromCollection, WithHeadings {
    public function collection() {
        return Infrastruktur::select(
            'nama_infrastruktur','kategori','lokasi','dusun',
            'tahun_pembangunan','kondisi','deskripsi'
        )->get();
    }
    public function headings(): array {
        return ['Nama','Kategori','Lokasi','Dusun','Tahun','Kondisi','Deskripsi'];
    }
}

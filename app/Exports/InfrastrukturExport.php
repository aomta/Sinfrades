<?php

namespace App\Exports;

use App\Models\Infrastruktur;
use Maatwebsite\Excel\Concerns\FromCollection;

class InfrastrukturExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Infrastruktur::all();
    }
}

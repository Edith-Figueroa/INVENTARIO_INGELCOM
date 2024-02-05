<?php

namespace App\Exports;

use App\Models\Salida;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportarSalidas implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Salida::all();
    }
}

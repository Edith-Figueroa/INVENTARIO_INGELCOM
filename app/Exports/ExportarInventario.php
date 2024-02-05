<?php

namespace App\Exports;

use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportarInventario implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventario::all();
    }
}

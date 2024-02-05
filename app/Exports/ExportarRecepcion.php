<?php

namespace App\Exports;

use App\Models\Entrada;
use App\Models\Producto; //MODELO PRODUCTO
use App\Models\Categoria; //MODELO CATEGORIA
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportarRecepcion implements FromView
{
    public function view(): view
    {
        return view('excel.ExportarRecepcion', [
            'entradas' => Entrada::all(),
            'productos' => Producto::all(),
            'categorias' => Categoria::all()
        ]);
        
    }
}

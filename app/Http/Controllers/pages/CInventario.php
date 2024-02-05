<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario; //MODELO INVENTARIO
use App\Models\Producto; //MODELO PRODUCTO
use App\Models\Categoria; //MODELO CATEGORIA
use App\Models\Entrada; //MODELO CATEGORIA

//CLASE DE EXPORTACIÓN 
use App\Exports\ExportarInventario;
use Maatwebsite\Excel\Facades\Excel;

class CInventario extends Controller
{
       public function index()
    {
        $productos = Producto::all(); //MOSTRARÁ UNICAMENTE LOS PRODUCTOS QUE SE ENCUENTREN ACTIVOS
        $categorias = Categoria::all(); //MOSTRARÁ UNICAMENTE LAS CATEGORIAS QUE SE ENCUENTREN ACTIVAS
        $inventario = Inventario::where('Cantidad', '>', 0)->get(); // Filtra los productos en inventario con cantidad mayor a 0

        return view('content.pages.pages-inventario', ['inventario' => $inventario ,'productos' => $productos, 'categorias' => $categorias]);
    }
    
  public function export()
  {
      return Excel::download(new ExportarInventario, 'Inventario.xlsx');
  }
  
}


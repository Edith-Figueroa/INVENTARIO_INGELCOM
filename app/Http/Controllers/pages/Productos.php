<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto; //MODELO PRODUCTO
use App\Models\Categoria; //MODELO CATEGORIA

//CLASE DE EXPORTACIÓN 
use App\Exports\ExportarProductos;
use Maatwebsite\Excel\Facades\Excel;

class Productos extends Controller
{
  public function index()
  {
    $productos = Producto::all();
    return view('content.pages.pages-productos', ['productos' => $productos]);
  }

  public function create(){
    $categorias = Categoria::where('Estado', 'Activo')->get(); //MOSTRARÁ UNICAMENTE LAS CATEGORIAS QUE SE ENCUENTREN ACTIVAS
    return view('content.pages.pages-productos-crear',  ['categorias' => $categorias ]);
  }

  public function store(Request $request){
    // Obtén los datos de los productos del formulario
    $nombreProductos = $request->input('NombreP');
    $categorias = $request->input('IdCategoria');
    $descripciones = $request->input('DescripcionP');
    $preciosUnitarios = $request->input('PrecioUnitario');
    $costosUnitarios = $request->input('CostoUnitario');
    $costosInventario = $request->input('CostoInventario');
    $preciosInventario = $request->input('PrecioInventario');

    // Itera a través de los datos y guarda cada producto
    foreach ($nombreProductos as $key => $nombreProducto) {
        $producto = new Producto();
        $producto->IdCategoria = $categorias[$key];
        $producto->NombreP = $nombreProducto;
        $producto->DescripcionP = $descripciones[$key];
        $producto->PrecioUnitario = $preciosUnitarios[$key];
        $producto->CostoUnitario = $costosUnitarios[$key];
        $producto->CostoInventario = $costosInventario[$key];
        $producto->PrecioInventario = $preciosInventario[$key];
        $producto->save();
    }

    return redirect()->route('pages-productos');
}

  public function show($IdProducto){
    $producto = Producto::find($IdProducto);
    return view('content.pages.pages-productos-editar', ['producto' => $producto]);
  }

  public function update(Request $request){
    $producto = Producto::find($request->IdProducto);
    $producto->NombreP = $request->NombreP;
    $producto->DescripcionP = $request->DescripcionP;
    $producto->PrecioUnitario = $request->PrecioUnitario;
    $producto->CostoUnitario = $request->CostoUnitario;
    $producto->CostoInventario = $request->CostoInventario;
    $producto->PrecioInventario = $request->PrecioInventario;
    $producto->save();
    return redirect()->route('pages-productos');
  }

  public function destroy(Request $request){
    $producto = Producto::find($request->IdProducto);
    $producto->delete();
    return redirect()->route('pages-productos');
  }

  public function switch($IdProducto){
    $producto = Producto::find($IdProducto);

    // Verifica el estado actual del producto y cambia al estado opuesto
    if ($producto->Estado === 'Activo') {
        $producto->Estado = 'Inactivo';
    } else {
        $producto->Estado = 'Activo';
    }

    $producto->save();
    return redirect()->route('pages-productos');
  }
  
  public function export()
  {
      return Excel::download(new ExportarProductos, 'Productos.xlsx');
  }
  
}
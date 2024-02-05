<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria; //MODELO CATEGORIA

//CLASE DE EXPORTACIÓN 
use App\Exports\ExportarCategorias;
use Maatwebsite\Excel\Facades\Excel;

class Categorias extends Controller
{
  public function index()
  {
    $categorias = Categoria::all();
    return view('content.pages.pages-categorias', ['categorias' => $categorias]);
  }

  public function create(){
    return view('content.pages.pages-categorias-crear');
  }

  public function store(Request $request){
    $categoria = new Categoria();
    $categoria->NombreC = $request->NombreC;
    $categoria->DescripcionC = $request->DescripcionC;
    $categoria->save();
    return redirect()->route('pages-categorias');
  }

  public function show($IdCategoria){
    $categoria = Categoria::find($IdCategoria);
    return view('content.pages.pages-categorias-editar', ['categoria' => $categoria]);
  }

  public function update(Request $request){
    $categoria = Categoria::find($request->IdCategoria);
    $categoria->NombreC = $request->NombreC;
    $categoria->DescripcionC = $request->DescripcionC;
    $categoria->save();
    return redirect()->route('pages-categorias');
  }

  public function destroy(Request $request){
    $categoria = Categoria::find($request->IdCategoria);
    $categoria->delete();
    return redirect()->route('pages-categorias');
  }

  public function switch($IdCategoria){
    $categoria = Categoria::find($IdCategoria);
    
    // Verifica el estado actual de la categoria y cambia al estado opuesto
    if ($categoria->Estado === 'Activo') {
        $categoria->Estado = 'Inactivo';
    } else {
        $categoria->Estado = 'Activo';
    }

    $categoria->save();
    return redirect()->route('pages-categorias');
  }
  
  public function export()
  {
      return Excel::download(new ExportarCategorias, 'Categorias.xlsx');
  }
  
}
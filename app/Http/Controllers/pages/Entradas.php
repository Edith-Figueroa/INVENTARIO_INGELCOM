<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Inventario; //MODELO INVENTARIO
use App\Models\Producto; //MODELO PRODUCTO
use App\Models\Categoria; //MODELO CATEGORIA
use App\Models\Entrada; //MODELO CATEGORIA
use App\Models\Recepciones; //MODELO RECEPCION
use App\Models\User;

//CLASE DE EXPORTACIÓN 
use App\Exports\ExportarEntradas;
use App\Exports\ExportarRecepcion;
use Maatwebsite\Excel\Facades\Excel;

//PDF
use Barryvdh\DomPDF\facade\Pdf;

class Entradas extends Controller
{
    public function index()
    {
        $entradas = Entrada::all();
        $productos = Producto::all();
        $categorias = Categoria::all();
        $recepciones = Recepciones::all();

        // Realiza la agrupación por IdRegistro y Detalle de recepción
        $entradasGrouped = $entradas->groupBy(function ($entrada) {
            return $entrada->IdRegistro . '-' . optional($entrada->recepcion)->Detalle;
        });

        return view('content.pages.pages-inventario-entradas', [
            'entradas' => $entradasGrouped,
            'productos' => $productos,
            'categorias' => $categorias,
            'recepciones' => $recepciones,
        ]);
    }

    //FUNCIÓN PARA LA VISTA CREAR
    public function create()
    {
        $Supervisor = User::where('idRole', 5)->get();
        $productos = Producto::where('Estado', 'Activo')->get(); //MOSTRARÁ UNICAMENTE LOS PRODUCTOS QUE SE ENCUENTREN ACTIVOS
        $categorias = Categoria::where('Estado', 'Activo')->get(); //MOSTRARÁ UNICAMENTE LAS CATEGORIAS QUE SE ENCUENTREN ACTIVAS
        return view('content.pages.pages-inventario-entradas-crear', [
            'productos' => $productos,
            'categorias' => $categorias,
            'Super' => $Supervisor
        ]);
    }

    public function store(Request $request)
    {
        $productos = $request->input('IdProducto');
        $cantidades = $request->input('Cantidad');
        $descripciones = $request->input('Descripcion');
        $detalleEntrega = $request->input('detalle');

        $recepcion = new Recepciones();
        $recepcion->Detalle = implode(', ', $detalleEntrega);
        $recepcion->Receptor = $request->input('Supervisor');
        $recepcion->Supervisor = $request->input('Receptor');
        $recepcion->save();
        $IdRegistro = $recepcion->id;

        // Procesar los productos en el array
        foreach ($productos as $key => $productoId) {
            $producto = Producto::find($productoId);

            if ($producto) {
                // Crear una nueva instancia de entradas
                $entrada = new Entrada();
                $entrada->IdRegistro = $IdRegistro;
                $entrada->IdProducto = $productoId;
                $entrada->Notas = $descripciones[$key] ?? $producto->DescripcionP;
                $entrada->Cantidad = $cantidades[$key];
                $entrada->save();

                // Actualizar o crear el registro en 'inventario'
                $inventario = Inventario::where('IdProducto', $productoId)->first();
                if ($inventario) {
                    $inventario->Cantidad += $cantidades[$key];
                    $inventario->Notas = $entrada->Notas;
                } else {
                    $inventario = new Inventario();
                    $inventario->IdProducto = $productoId;
                    $inventario->Notas = $entrada->Notas;
                    $inventario->Cantidad = $cantidades[$key];
                }
                $inventario->save();
            }
        }

        return redirect()->route('pages-inventario-entradas')->with('success', 'Entradas y productos en inventario agregados correctamente.');
    }

    public function export()
    {
        $entradas = Entrada::all();
        $productos = Producto::all();
        $categorias = Categoria::all();

        return Excel::download(new ExportarEntradas($entradas, $productos, $categorias), 'Entradas.xlsx');
    }


    public function DestroyEntrada($id)
    {
        $Entrada = Entrada::where('id', $id)->first();
        $Entrada->delete();

        return back()->with('success', 'El producto se eliminó correctamente');
    }

    public function exportrecepcion()
    {
        $entradas = Entrada::all();
        $productos = Producto::all();
        $categorias = Categoria::all();

        return Excel::download(new ExportarRecepcion($entradas, $productos, $categorias), 'RecepcionEntrada.xlsx');
    }

    public function pdf()
    {

        $productos = Producto::all();
        $categorias = Categoria::all();
        $entrada = Entrada::all();

        $pdf = Pdf::loadView('pdf.entradas', [
            'entrada' => $entrada,
            'productos' => $productos,
            'categorias' => $categorias,
        ]);

        return $pdf->download('Entradas.pdf');
    }

    public function pdfrecepcion($IdRegistro)
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        $entradas = Entrada::where('IdRegistro', $IdRegistro)->get();
        $recepciones = Recepciones::where('id', $IdRegistro)->get();
        // Lee el contenido del archivo CSS
        $css = file_get_contents(public_path('/assets/vendor/css/Exports/pdf.css'));

        $pdf = Pdf::loadView('pdf.recepcion', [
            'entradas' => $entradas,
            'productos' => $productos,
            'categorias' => $categorias,
            'css' => $css,
            'recepciones' => $recepciones,
        ]);


        return $pdf->stream();
        // return $pdf->download('Recepcion.pdf');
    }

    public function verentradas($IdRegistro, $edicion)
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        $recepciones = Recepciones::where('id', $IdRegistro)->get();
        $entradas = Entrada::where('IdRegistro', $IdRegistro)->get();
        session(['idEntrega' => $IdRegistro]);
        $role = Auth::user()->idRole;
        $edit = $edicion;

        if ($entradas) {
            return view('content.pages.pages-inventario-verentradas', [
                'entradas' => $entradas,
                'productos' => $productos,
                'categorias' => $categorias,
                'recepciones' => $recepciones,
                'role' => $role,
                'edicion' => $edit
            ]);
        } else {
            return view('error-entrada-no-encontrada');
        }
    }


    public function GuardadoGeneral(Request $request, $idRegistro)
    {
        $Productos = $request->input('idProduct');
        $cantidades = $request->input('Cantidad');
        $botonesEliminar = $request->input('Eliminar');
        $i = 0;

        foreach ($Productos as $key => $productoId) {
            $producto = Producto::find($productoId);
            $inventario = Inventario::where('IdProducto', $productoId)->first();

            if ($botonesEliminar[$i] == 1) {
                if ($inventario) {

                    $Entradas = Entrada::where('IdProducto', $productoId)->where('IdRegistro', $idRegistro)->first();

                    if ($Entradas) {
                        $inventario->Cantidad -= $Entradas->Cantidad;

                        $Entradas->delete();
                        $inventario->save();
                    }
                }
            } else {
                if ($inventario) {
                    $Entradas = Entrada::where('IdProducto', $productoId)->where('IdRegistro', $idRegistro)->first();

                    if ($Entradas) {
                        $inventario->Cantidad -= $Entradas->Cantidad;
                        $inventario->Cantidad += $cantidades[$key];

                        $Entradas->Cantidad = $cantidades[$key];
                        $Entradas->save();
                        $inventario->save();
                    }
                }
            }
            $i++;
        }
        return redirect()->route('pages-inventario-verentradas', [$idRegistro, 1])->with('success', 'Salidas y productos en inventario agregados correctamente.');
    }

    public function EntradaEditProduct(Request $request)
    {
        $id = $request->input('id');
        $productos = $request->input('IdProducto');
        $cantidades = $request->input('Cantidad');
        $descripciones = $request->input('Descripcion');
        foreach ($productos as $key => $productoId) {
            $producto = Producto::find($productoId);
            if ($producto) {
                $entrada = new Entrada();
                $entrada->IdProducto = $productoId;
                $entrada->IdRegistro = $id;
                $entrada->Notas = $descripciones[$key] ?? $producto->DescripcionP;
                $entrada->Cantidad = $cantidades[$key];
                $entrada->save();

                // Actualizar o crear el registro en 'inventario'
                $inventario = Inventario::where('IdProducto', $productoId)->first();
                if ($inventario) {
                    $inventario->Cantidad += $cantidades[$key];
                    $inventario->Notas = $entrada->Notas;
                } else {
                    $inventario = new Inventario();
                    $inventario->IdProducto = $productoId;
                    $inventario->Notas = $entrada->Notas;
                    $inventario->Cantidad = $cantidades[$key];
                }
                $inventario->save();
            }
        }

        return redirect()->route('pages-inventario-verentradas', [$id, 1])->with('success', 'Entradas y productos en inventario agregados correctamente.');
    }


    public function verentradasedit(Request $request)
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        $recepciones = Recepciones::all();


        return view('content.pages.pages-inventario-entradas-editar', [
            'productos' => $productos,
            'categorias' => $categorias,
            'recepciones' => $recepciones,
        ]);
    }
}

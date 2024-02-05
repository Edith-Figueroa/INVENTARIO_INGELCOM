<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Salida;
use App\Models\Requisiciones; // Agregamos el modelo Requisiciones

use App\Exports\ExportarSalidas;
use Maatwebsite\Excel\Facades\Excel;

//PDF
use Barryvdh\DomPDF\facade\Pdf;

class Salidas extends Controller
{
    /**
     * Muestra la página de salidas con información de productos, categorías y requisiciones.
     */
    public function index()
    {
        // Obtener productos, categorías, salidas y requisiciones
        $productos = Producto::all();
        $categorias = Categoria::all();
        $salidas = Salida::all();
        $requisiciones = Requisiciones::all(); // Obtener todas las requisiciones

        // Realiza la agrupación por IdRegistro y Detalle de recepción
        $salidasGrouped = $salidas->groupBy(function ($salida) {
            return $salida->IdRegistro . '-' . optional($salida->recepcion)->Detalle;
        });
    

        // Pasar los datos a la vista
        return view('content.pages.pages-inventario-salidas', [
            'salidas' => $salidasGrouped,
            'productos' => $productos,
            'categorias' => $categorias,
            'requisiciones' => $requisiciones, // Pasamos las requisiciones a la vista
        ]);
    }

    /**
     * Muestra el formulario para crear una salida.
     */

    public function create()
    {
        // Obtener productos y categorías activos
        $productos = Producto::where('Estado', 'Activo')->get();
        $categorias = Categoria::where('Estado', 'Activo')->get();
        $salida = Salida::all();

        // Filtrar los productos con cantidad mayor a 0 en el inventario
        $productos = $productos->filter(function ($producto) {
            $inventario = Inventario::where('IdProducto', $producto->IdProducto)->first();
            return $inventario && $inventario->Cantidad > 0;
        });

        return view('content.pages.pages-inventario-salidas-crear', [
            'productos' => $productos,
            'categorias' => $categorias,
            'salida' => $salida
        ]);
    }

    /**
     * Almacena una nueva salida en la base de datos.
     */
  
 public function store(Request $request)
{
    $productos = $request->input('IdProducto');
    $cantidades = $request->input('Cantidad');
    $descripciones = $request->input('Descripcion');
    $detalleEntrega = $request->input('detalle');

    // Obtener el IdRegistro del registro de Requisiciones que acabas de crear
    $requisicion = new Requisiciones();
    $requisicion->Detalle = implode(', ', $detalleEntrega); // Convierte el array en una cadena
    $requisicion->Receptor = $request->input('receptor');
    $requisicion->Supervisor = $request->input('supervisor');
    $requisicion->save();
    $IdRegistro = $requisicion->id;

    // Realiza la validación de la cantidad en inventario y la deducción del inventario
    foreach ($productos as $key => $productoId) {
        $producto = Producto::find($productoId);
        $inventario = Inventario::where('IdProducto', $productoId)->first();

        if ($inventario) {
            if ($inventario->Cantidad < $cantidades[$key]) {
                // Si la cantidad solicitada supera la cantidad en inventario, muestra un mensaje de error y redirige de nuevo al formulario.
                Alert::error('Error', 'La cantidad solicitada para el producto ' . $producto->NombreP . ' supera la cantidad en inventario.');
                return redirect()->route('pages-inventario-createsalidas');
                   
            
                }

            // Deduce la cantidad solicitada del inventario
            $inventario->Cantidad -= $cantidades[$key];
            $inventario->Notas = $descripciones[$key] ?? $producto->DescripcionP;
            $inventario->save();
        }

        // Crear una nueva instancia de Salida
        $salida = new Salida();
        $salida->IdRegistro = $IdRegistro;
        $salida->IdProducto = $productoId;
        $salida->Notas = $descripciones[$key] ?? $producto->DescripcionP;
        $salida->Cantidad = $cantidades[$key];
        $salida->save();
    }

    return redirect()->route('pages-inventario-salidas')->with('success', 'Salidas y productos en inventario agregados correctamente.');
}






    /**
     * Exporta las salidas a un archivo Excel.
     */
    public function export()
    {
        return Excel::download(new ExportarSalidas, 'Salidas.xlsx');
    }


    public function pdfrequisicion($IdRegistro){
        $productos = Producto::all();
        $categorias = Categoria::all(); 
        $salidas = Salida::where('IdRegistro', $IdRegistro)->get(); 
        $requisiciones = requisiciones::where('id', $IdRegistro)->get();
         // Lee el contenido del archivo CSS
        $css = file_get_contents(public_path('/assets/vendor/css/Exports/pdf.css'));
    
        $pdf = Pdf::loadView('pdf.requisicion', [
            'salidas' => $salidas,
            'productos' => $productos,
            'categorias' => $categorias,
            'css' => $css,
            'requisiciones' => $requisiciones,
        ]);
    
        
        return $pdf->stream();
        // return $pdf->download('requisicion.pdf');
    }
    
    public function versalidas($IdRegistro)
{
    $productos = Producto::all();
    $categorias = Categoria::all();
    $requisiciones = Requisiciones::where('id', $IdRegistro)->get();
    $salidas = Salida::where('IdRegistro', $IdRegistro)->get(); 


    if ($salidas) {
        return view('content.pages.pages-inventario-versalidas', [
            'salidas' => $salidas,
            'productos' => $productos,
            'requisiciones' => $requisiciones,
            'categorias' => $categorias,
        ]);
    } else {
        // Manejo de error: salidas no encontrada
        return view('error-salida-no-encontrada');
    }
    }
}

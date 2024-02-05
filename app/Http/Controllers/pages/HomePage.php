<?php
namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Support\Facades\DB;

class HomePage extends Controller
{
    public function index(Request $request)
    {
        // Contar la cantidad de usuarios
        $n_users =  User::count();

        // Contar únicamente las categorías activas
        $n_categorias = Categoria::where('Estado', 'Activo')->count();

        // Contar únicamente los productos activos
        $n_productos = Producto::where('Estado', 'Activo')->count();

        $categorias = Categoria::where('Estado', 'Activo')->get();

        // Obtener las categorías que están relacionadas con productos en el inventario
        $categorias = Categoria::select('categorias.IdCategoria', 'categorias.NombreC')
            ->join('productos', 'categorias.IdCategoria', '=', 'productos.IdCategoria')
            ->join('inventario', 'productos.IdProducto', '=', 'inventario.IdProducto')
            ->where('categorias.Estado', 'Activo')
            ->distinct()
            ->get();

        // Verifica si se ha seleccionado una categoría en la solicitud
        $selectedCategoryId = $request->input('categoria');

        if ($selectedCategoryId) {
            // Filtra el inventario por la categoría seleccionada
            $inventario = Inventario::select('productos.NombreP', 'inventario.cantidad', 'categorias.NombreC')
                ->join('productos', 'inventario.IdProducto', '=', 'productos.IdProducto')
                ->join('categorias', 'productos.IdCategoria', '=', 'categorias.IdCategoria')
                ->where('productos.IdCategoria', $selectedCategoryId)
                ->get();
        } else {
            // Si no se ha seleccionado una categoría, muestra todo el inventario
            $inventario = Inventario::select('productos.NombreP', 'inventario.cantidad', 'categorias.NombreC')
                ->join('productos', 'inventario.IdProducto', '=', 'productos.IdProducto')
                ->join('categorias', 'productos.IdCategoria', '=', 'categorias.IdCategoria')
                ->get();
        }


        return view('content.pages.pages-home', compact('n_users', 'n_categorias', 'n_productos', 'categorias', 'inventario', 'selectedCategoryId'));
    }
}

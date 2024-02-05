<?php
namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Support\Facades\DB;

class Page2 extends Controller
{
    public function index()
    {

        return view('content.pages.pages-page2');
    }
}

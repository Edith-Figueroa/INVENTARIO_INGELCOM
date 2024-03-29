<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Mail\NuevoEmailEditar;
use App\Mail\NuevoEmailEditarReceptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Requisiciones;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Mail\NuevoEmail;
use App\Models\Firmas;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Salida;

class Correo extends Controller
{
    public function index($idRegistro)
    {
        // $productos = Producto::all();
        // $categorias = Categoria::all();
        // $requisiciones = Requisiciones::where('id', $IdRegistro)->get();        
        // $salidas = Salida::where('IdRegistro', $IdRegistro)->get();                
        
        return view('email.pages-correo-plantilla-editar', ['idRegistro' => $idRegistro]);
    }

    public function index2()
    {
        $rutaImagen = public_path('assets\img\illustrations\Logo.jpg');
        return view('email.pages-correo-plantilla', [
            'Imagen' => $rutaImagen,
        ]);
    }

    public function enviarCorreoRequisicion($idRegistro)
    {
            
        $requisiciones = requisiciones::where('id', $idRegistro)->first();

        $NameEntrega = User::where('email', $requisiciones->Email_Entrega)->first();
        $NameReceptor = User::where('email', $requisiciones->Email_Receptor)->first();
        $NameSUP = User::where('email', $requisiciones->Email_Sup)->first();
        $NameRRHH = User::where('email', $requisiciones->Email_RRHH)->first();
        $NameAdminis = User::where('email', $requisiciones->Email_Adminis)->first();


        $correosAdmin = [
            $NameSUP->email,
            $NameAdminis->email,
            $NameRRHH->email,
        ];
        $correos = [
            $NameEntrega->email,
            $NameReceptor->email,
        ];

        $mail = new NuevoEmailEditar();
        $mail->idRegistro = $idRegistro;

        $mail2 = new NuevoEmailEditarReceptor();
        $mail2->idRegistro = $idRegistro;

        Mail::to($correosAdmin)->send($mail);
        Mail::to($correos)->send($mail2);

        return redirect()->route('pages-inventario-versalidas', [$idRegistro, 1])->with('success', 'Salidas y productos en inventario agregados correctamente.');
    }
}




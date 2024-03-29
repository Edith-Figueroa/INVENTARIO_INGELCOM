<?php

namespace App\Http\Controllers\pages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Requisiciones;
use App\Models\Producto;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Salida;
use App\Http\Controllers\Controller;

class RequisicionesController extends Controller
{
    public function index()
    {
        $requisicions = Requisiciones::all();
        return view('content.pages.pages-requisicionesAll', ['requisicions' => $requisicions]);
    }
    public function indexUser($idRegistro, $Operacion)
    {
        // Obtener productos, categorías, salidas y requisiciones
        $productos = Producto::all();
        $categorias = Categoria::all();
        $salidas = Salida::all();        

        // Realiza la agrupación por IdRegistro y Detalle de recepción
        $salidasGrouped = $salidas->groupBy(function ($salida) {
            return $salida->IdRegistro . '-' . optional($salida->recepcion)->Detalle;
        });

        $role = Auth::user()->idRole;
        $tipoUsuario = Auth::user()->email;

    
        if($Operacion == 1){
            if ($role == 1) {
                $requisicions = Requisiciones::orderBy('id', 'desc')->get();
            } else if ($role == 2) {
                $requisicions = Requisiciones::where('Email_Entrega', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            } else if ($role == 3) {
                $requisicions = Requisiciones::where('Email_RRHH', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            } else if ($role == 4) {
                $requisicions = Requisiciones::where('Email_Adminis', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            } else if ($role == 5) {
                $requisicions = Requisiciones::where('Email_Sup', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            } else {
                $requisicions = Requisiciones::where('Email_Receptor', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            }
        }else{
            if ($role == 1) {
                $requisicions = Requisiciones::where('id', $idRegistro);
            } else if ($role == 2) {
                $requisicions = Requisiciones::where('Email_Entrega', $tipoUsuario)->where('id', $idRegistro)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            } else if ($role == 3) {
                $requisicions = Requisiciones::where('Email_RRHH', $tipoUsuario)->where('id', $idRegistro)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            } else if ($role == 4) {
                $requisicions = Requisiciones::where('Email_Adminis', $tipoUsuario)->where('id', $idRegistro)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            } else if ($role == 5) {
                $requisicions = Requisiciones::where('Email_Sup', $tipoUsuario)->where('id', $idRegistro)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            } else {
                $requisicions = Requisiciones::where('Email_Receptor', $tipoUsuario)->where('id', $idRegistro)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
            }
        }        

        return view('content.pages.pages-requisicionesAllUser', [
            'requisicions' => $requisicions,
            'salidas' => $salidasGrouped,
            'productos' => $productos,
            'categorias' => $categorias,
            'role' => $role,
        ]);
    }

    public function CambiarEstadoAlgot($requisicions, $userBD, $valor)
    {
        if ($valor == 1) {
            $requisicions->$userBD = "si";
        } else if ($valor == 0) {
            $requisicions->$userBD = "no";
        }
    }

    public function actualizarEstado($id, $valor)
    {
        $requisicions = Requisiciones::find($id);
        $Usuario = Auth::user()->email;

        $EncontrarUser = User::where('email', $Usuario)->first();
        $IdFirma = $EncontrarUser->idFirma;

        $role = Auth::user()->idRole;

        if ($role == 5) {
            $this->cambiarEstadoAlgot($requisicions, "Supervisor", $valor);
            $requisicions->Firma_Sup = $IdFirma;
        } else if ($role == 4) {
            $this->cambiarEstadoAlgot($requisicions, "Administracion", $valor);
            $requisicions->Firma_Adminis = $IdFirma;
        } else {
            $this->cambiarEstadoAlgot($requisicions, "RRHH", $valor);
            $requisicions->Firma_RRHH = $IdFirma;
        }

        $requisicions->Estado = $valor;
        $requisicions->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
}

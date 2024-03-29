<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Mail\NuevoEmailEditarReceptor;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Firmas;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Salida;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Mail\NuevoEmail;
use App\Mail\NuevoEmailEditar;
use App\Mail\NuevoEmailAdministradores;
use Illuminate\Support\Facades\Mail;
use App\Models\Requisiciones;
use Illuminate\Support\Facades\Auth;

use App\Exports\ExportarSalidas;
use Maatwebsite\Excel\Facades\Excel;

//PDF
use Barryvdh\DomPDF\facade\Pdf;

class Salidas extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        $salidas = Salida::all();
        $role = Auth::user()->idRole;
        $tipoUsuario = Auth::user()->email;

        if ($role == 1) {
            $requisiciones = Requisiciones::orderBy('id', 'desc')->get();
        } else if ($role == 2) {
            $requisiciones = Requisiciones::where('Email_Entrega', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
        } else if ($role == 3) {
            $requisiciones = Requisiciones::where('Email_RRHH', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
        } else if ($role == 4) {
            $requisiciones = Requisiciones::where('Email_Adminis', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
        } else if ($role == 5) {
            $requisiciones = Requisiciones::where('Email_Sup', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
        } else {
            $requisiciones = Requisiciones::where('Email_Receptor', $tipoUsuario)->orderBy('Fecha', 'desc')->orderBy('id', 'desc')->get();
        }

        // Realiza la agrupación por IdRegistro y Detalle de recepción
        $salidasGrouped = $salidas->groupBy(function ($salida) {
            return $salida->IdRegistro . '-' . optional($salida->recepcion)->Detalle;
        });

        // Pasar los datos a la vista
        return view('content.pages.pages-inventario-salidas', [
            'salidas' => $salidasGrouped,
            'productos' => $productos,
            'categorias' => $categorias,
            'SalidaJoin' => $requisiciones,
            'role' => $role,            
        ]);
    }
    public function create()
    {
        $JefeInv = User::where('idRole', 2)->get();
        $RRHH = User::where('idRole', 3)->get();
        $Administracion = User::where('idRole', 4)->get();
        $Supervisor = User::where('idRole', 5)->get();
        $Usuario = User::where('idRole', 6)->get();

        $productos = Producto::where('Estado', 'Activo')->get();
        $categorias = Categoria::where('Estado', 'Activo')->get();
        $salida = Salida::all();

        $productos = $productos->filter(function ($producto) {
            $inventario = Inventario::where('IdProducto', $producto->IdProducto)->first();
            return $inventario && $inventario->Cantidad > 0;
        });

        return view('content.pages.pages-inventario-salidas-crear', [
            'productos' => $productos,
            'categorias' => $categorias,
            'salida' => $salida,
            'JefeInv' => $JefeInv,
            'RRHH' => $RRHH,
            'Administracion' => $Administracion,
            'Supervisor' => $Supervisor,
            'usuarios' => $Usuario,
        ]);
    }
    public function DestroySalida($id)
    {
        $Salida = Salida::where('id', $id)->first();
        $Salida->delete();

        return back()->with('success', 'El producto se eliminó correctamente');
    }

    public function store(Request $request)
    {

        $fechaActual = Carbon::now();

        $productos = $request->input('IdProducto');
        $cantidades = $request->input('Cantidad');
        $descripciones = $request->input('Descripcion');
        $detalleEntrega = $request->input('detalle');

        $requisicion = new Requisiciones();
        $requisicion->Detalle = implode(', ', $detalleEntrega); // Convierte el array en una cadena

        $EncontrarFirmaEntrega = User::where('email', $request->input('Email_Entrega'))->first();
        $EncontrarFirmaReceptor = User::where('email', $request->input('Email_Receptor'))->first();
        $IdFirmaEntrega = $EncontrarFirmaEntrega->idFirma;
        $IdFirmaReceptor = $EncontrarFirmaReceptor->idFirma;

        $requisicion->Email_Entrega = $request->input('Email_Entrega');
        $requisicion->Firma_Entrega = $IdFirmaEntrega;
        $requisicion->Email_Receptor = $request->input('Email_Receptor');
        $requisicion->Firma_Receptor = $IdFirmaReceptor;
        $requisicion->Email_Sup = $request->input('Email_Sup');
        $requisicion->Email_Adminis = $request->input('Email_Adminis');
        $requisicion->Email_RRHH = $request->input('Email_RRHH');
        $requisicion->Fecha = $fechaActual;
        $requisicion->Administracion = "no";
        $requisicion->Supervisor = "no";
        $requisicion->RRHH = "no";
        $requisicion->Estado = 0;
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
                $inventario->Cantidad -= $cantidades[$key];
                $inventario->Notas = $descripciones[$key] ?? $producto->DescripcionP;
                $inventario->save();
            }

            $salida = new Salida();
            $salida->IdRegistro = $IdRegistro;
            $salida->IdProducto = $productoId;
            $salida->Notas = $descripciones[$key] ?? $producto->DescripcionP;
            $salida->Cantidad = $cantidades[$key];
            $salida->save();
        }

        $Email_Sup = User::join('requisiciones as b', 'b.Email_Sup', '=', 'email')
            ->select('email')
            ->where('b.id', '=', $IdRegistro)
            ->first();

        $Email_Entrega = User::join('requisiciones as b', 'b.Email_Entrega', '=', 'email')
            ->select('email')
            ->where('b.id', '=', $IdRegistro)
            ->first();
        $Email_Receptor = User::join('requisiciones as b', 'b.Email_Receptor', '=', 'email')
            ->select('email')
            ->where('b.id', '=', $IdRegistro)
            ->first();
        $Email_Adminis = User::join('requisiciones as b', 'b.Email_Adminis', '=', 'email')
            ->select('email')
            ->where('b.id', '=', $IdRegistro)
            ->first();
        $Email_RRHH = User::join('requisiciones as b', 'b.Email_RRHH', '=', 'email')
            ->select('email')
            ->where('b.id', '=', $IdRegistro)
            ->first();

        $correosInteresados = [
            $Email_Entrega->email,
            $Email_Receptor->email,
        ];

        $correosAdministradores = [
            $Email_Sup->email,
            $Email_Adminis->email,
            $Email_RRHH->email
        ];

        Mail::to($correosInteresados)->send(new NuevoEmail());

        Mail::to($correosAdministradores)->send(new NuevoEmailAdministradores());

        return redirect()->route('pages-inventario-salidas')->with('success', 'Salidas y productos en inventario agregados correctamente.');
    }

    public function export()
    {
        return Excel::download(new ExportarSalidas, 'Salidas.xlsx');
    }

    public function pdfrequisicion($IdRegistro)
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        $salidas = Salida::where('IdRegistro', $IdRegistro)->get();
        $requisiciones = requisiciones::where('id', $IdRegistro)->first();

        ///Firmas 
        $firmaEntrega = $requisiciones->Firma_Entrega ? Firmas::where('id', $requisiciones->Firma_Entrega)->first() : null;
        $firmaReceptor = $requisiciones->Firma_Receptor ? Firmas::where('id', $requisiciones->Firma_Receptor)->first() : null;
        $firmaSUP = $requisiciones->Firma_Sup ? Firmas::where('id', $requisiciones->Firma_Sup)->first() : null;
        $firmaRRHH = $requisiciones->Firma_RRHH ? Firmas::where('id', $requisiciones->Firma_RRHH)->first() : null;
        $firmaAdminis = $requisiciones->Firma_Adminis ? Firmas::where('id', $requisiciones->Firma_Adminis)->first() : null;

        //Nombres
        $NameEntrega = User::where('email', $requisiciones->Email_Entrega)->first();
        $NameReceptor = User::where('email', $requisiciones->Email_Receptor)->first();
        $NameSUP = User::where('email', $requisiciones->Email_Sup)->first();
        $NameRRHH = User::where('email', $requisiciones->Email_RRHH)->first();
        $NameAdminis = User::where('email', $requisiciones->Email_Adminis)->first();


        $pdf = Pdf::loadView('pdf.Requisicion', [
            'salidas' => $salidas,
            'productos' => $productos,
            'categorias' => $categorias,
            'requisiciones' => $requisiciones,
            'Entrega' => isset ($firmaEntrega->firma) ? $firmaEntrega->firma : null,
            'Receptor' => isset ($firmaReceptor->firma) ? $firmaReceptor->firma : null,
            'Supervisor' => isset ($firmaSUP->firma) ? $firmaSUP->firma : null,
            'RRHH' => isset ($firmaRRHH->firma) ? $firmaRRHH->firma : null,
            'Administracion' => isset ($firmaAdminis->firma) ? $firmaAdminis->firma : null,
            'NameEntrega' => $NameEntrega->name ?? null,
            'NameReceptor' => $NameReceptor->name ?? null,
            'NameSupervisor' => $NameSUP->name ?? null,
            'NameRRHH' => $NameRRHH->name ?? null,
            'NameAdministracion' => $NameAdminis->name ?? null,
        ]);
        return $pdf->stream();
    }

    public function versalidas($IdRegistro, $edicion)
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        $requisiciones = Requisiciones::where('id', $IdRegistro)->get();
        $Comprobacion = Requisiciones::where('id', $IdRegistro)->first();
        $salidas = Salida::where('IdRegistro', $IdRegistro)->get();
        $role = Auth::user()->idRole;

        $edit = $edicion;
        $Mostrar = false;

        if ($Comprobacion->Supervisor == 'si' && $Comprobacion->Administracion == 'si') {
            $Mostrar = true;
        } else {
            $Mostrar = false;
        }

        if ($salidas) {
            return view('content.pages.pages-inventario-versalidas', [
                'salidas' => $salidas,
                'productos' => $productos,
                'requisiciones' => $requisiciones,
                'categorias' => $categorias,
                'Mostrar' => $Mostrar,
                'role' => $role,
                'edicion' => $edit
            ]);
        } else {
            return view('error-salida-no-encontrada');
        }
    }

    public function versalidasedit($IdRegistro)
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        $requisiciones = Requisiciones::where('id', $IdRegistro)->get();
        $salidas = Salida::where('IdRegistro', $IdRegistro)->get();
        $role = Auth::user()->idRole;
        session(['id' => $IdRegistro]);

        if ($salidas) {
            return view('content.pages.pages-inventario-salidas-editar', [
                'salidas' => $salidas,
                'productos' => $productos,
                'requisiciones' => $requisiciones,
                'categorias' => $categorias,
                'role' => $role,
            ]);
        } else {
            return view('error-salida-no-encontrada');
        }
    }
    public function buscarUsuario($email)
    {
        $usuario = User::where('email', $email)->first();
        if ($usuario) {
            return response()->json(['usuario' => $usuario]);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $salida = new Salida();
        $salida->IdRegistro = $idRegistro;
        $salida->IdProducto = $productoId;
        $salida->Notas = $descripciones;
        $salida->Cantidad = $cantidades[$key];
        $salida->save();

        Requisiciones::where('id', $idRegistro)->update([
            'Supervisor' => 'no',
            'Administracion' => 'no',
            'RRHH' => 'no',
        ]);
    }

    public function GuardadoGeneral(Request $request, $idRegistro)
    {
        $requisicion = Requisiciones::where('id', $idRegistro)->first();        
        $Productos = $request->input('idProduct');
        $cantidades = $request->input('Cantidad');
        $botonesEliminar = $request->input('Eliminar');
        $i = 0;

        foreach ($Productos as $key => $productoId) {
            $producto = Producto::find($productoId);
            $inventario = Inventario::where('IdProducto', $productoId)->first();

            if ($botonesEliminar[$i] == 1) {
                if ($inventario) {

                    $Salidas = Salida::where('IdProducto', $productoId)->where('IdRegistro', $idRegistro)->first();

                    if ($Salidas) {
                        $inventario->Cantidad += $Salidas->Cantidad;

                        $Salidas->delete();
                        $inventario->save();
                    }
                }
            } else {
                if ($inventario) {
                    $Salidas = Salida::where('IdProducto', $productoId)->where('IdRegistro', $idRegistro)->first();

                    if ($Salidas) {
                        $inventario->Cantidad += $Salidas->Cantidad;
                        $inventario->Cantidad -= $cantidades[$key];

                        $Salidas->Cantidad = $cantidades[$key];
                        $Salidas->save();
                        $inventario->save();
                    }
                }
            }
            $requisicion->Administracion = "no";
            $requisicion->Supervisor = "no";
            $requisicion->RRHH = "no";
            $requisicion->Estado = 0;
            $requisicion->save();
            $i++;
        }
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

    public function SalidaEditProduct(Request $request)
    {
        $id = $request->input('id');
        $fechaActual = Carbon::now();

        $productos = $request->input('IdProducto');
        $cantidades = $request->input('Cantidad');
        $descripciones = $request->input('Notas');
        $idRegistro = $request->input('id');

        $requisicion = Requisiciones::where('id', $fechaActual)->first();

        foreach ($productos as $key => $productoId) {
            $producto = Producto::find($productoId);

            $inventario = Inventario::where('IdProducto', $productoId)->first();

            if ($inventario) {
                if ($inventario->Cantidad < $cantidades[$key]) {
                    Alert('Error', 'La cantidad solicitada para el producto ' . $producto->NombreP . ' supera la cantidad en inventario.');
                    return redirect()->route('pages-inventario-editar');
                }
                $inventario->Cantidad -= $cantidades[$key];
                $inventario->Notas = $descripciones;
                $inventario->save();
            }

            $salida = new Salida();
            $salida->IdRegistro = $idRegistro;
            $salida->IdProducto = $productoId;
            $salida->Notas = $descripciones;
            $salida->Cantidad = $cantidades[$key];
            $salida->save();
        }
    
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

        return redirect()->route('pages-inventario-versalidas', [$id, 1])->with('success', 'Salidas y productos en inventario agregados correctamente.');
    }
}
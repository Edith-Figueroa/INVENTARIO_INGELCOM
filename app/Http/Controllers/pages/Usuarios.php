<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Roles;
use App\Models\Firmas;
//CLASE DE EXPORTACIÓN 
use App\Exports\ExportarUsuarios;
use Maatwebsite\Excel\Facades\Excel;

class Usuarios extends Controller
{
  public function index()
  {
    $users = User::join('roles', 'users.idRole', '=', 'roles.id')
      ->join('firmas as b', 'users.idFirma', '=', 'b.id')
      ->select('users.*', 'roles.name as role', 'b.firma')
      ->get();


    return view('content.pages.pages-usuarios', [
      'users' => $users
    ]);
  }


  public function pagination()
  {
    $users = User::paginate(20);
    return view('content.pages.pages-usuarios', compact('users'));
  }

  public function create()
  {
    $roles = Roles::all();
    return view('content.pages.pages-usuarios-crear', compact('roles'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|confirmed',
      'idRole' => 'required',
    ]);
    
    $imagen = $request->file('imagen');

    DB::beginTransaction();

    try {
      $firma = new Firmas();

      if ($imagen) {
        // Si se ha subido un archivo
        $firma->firma = file_get_contents($imagen->getRealPath());
      } else {
        // Si la firma proviene del canvas
        $signatureData = $request->input('firma');
        $signature = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData));
        $firma->firma = $signature;
      }

      $firma->save();

      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = Hash::make($request->password);
      $user->idRole = $request->idRole;
      $user->idFirma = $firma->id;
      $user->save();

      DB::commit();

      return redirect()->route('pages-usuarios')->with('success', 'Usuario creado exitosamente.');
    } catch (\Exception $e) {

      DB::rollback();

      return redirect()->back()->with('error', 'Hubo un error al guardar el usuario.');
    }
  }


  public function show($user_id)
  {
    $user = User::find($user_id);
    return view('content.pages.pages-usuarios-editar', ['user' => $user]);
  }
  public function update(Request $request)
  {
    $EmailUser = User::find($request->user_id)->email;

    $IdFirma = User::where('email', $EmailUser)->first()->idFirma;



    // Verificar si se ha cargado una nueva imagen
    if ($request->hasFile('imagen')) {

      // Eliminar la Firma anterior solo si se ha cargado una nueva imagen
      // Firmas::Where('id', $IdFirma)->delete();

      // Obtener la imagen y guardarla en la base de datos
      $imagen = file_get_contents($request->file('imagen')->getRealPath());
      $firma = new Firmas();
      $firma->firma = $imagen;
      $firma->save();

      // Actualizar los datos del usuario
      $user = User::find($request->user_id);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->idFirma = $firma->id;
      $user->password = Hash::make($request->password);
      $user->save();
    } else {
      // Si no se ha cargado una nueva imagen, nada más se actualizan los datos del usuario
      $user = User::find($request->user_id);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = Hash::make($request->password);
      $user->save();
    }
    return redirect()->route('pages-usuarios');
  }


  public function destroy($user_id)
  {
    $user = User::find($user_id);
    $user->delete();
    return redirect()->route('pages-usuarios');
  }


  public function switch ($id)
  {
    $user = User::find($id);

    // Verifica el estado actual del usuario y cambia al estado opuesto
    if ($user->Estado === 'Activo') {
      $user->Estado = 'Inactivo';
    } else {
      $user->Estado = 'Activo';
    }

    $user->save();
    return redirect()->route('pages-usuarios');
  }

  public function search(Request $request)
  {
    $texto = $request->query('texto');
    $startDate = $request->query('startDateFilter');
    $endDate = $request->query('endDateFilter');
    $dateType = $request->query('dateType'); //eleccionar fecha de creación o actualización

    // Consulta inicial para buscar por nombre de usuario
    $query = User::query()->where('name', 'like', '%' . $texto . '%');

    // Si se especifica un rango de fechas, agregamos una condición a la consulta
    if ($startDate && $endDate) {
      $dateField = ($dateType === 'created_at') ? 'created_at' : 'updated_at';
      $query->whereBetween($dateField, [$startDate, $endDate]);
    }

    // Ejecutamos la consulta
    $users = $query->get();

    return view('content.pages.pages-usuarios', compact('users'));
  }

  public function export()
  {
    return Excel::download(new ExportarUsuarios, 'Usuarios.xlsx');
  }

}
<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // MODELO USUARIOS
use App\Models\Roles; // MODELO USUARIOS

//CLASE DE EXPORTACIÓN 
use App\Exports\ExportarUsuarios;
use Maatwebsite\Excel\Facades\Excel;

class Usuarios extends Controller
{
  public function index()
  {
    $users = User::all();
    return view('content.pages.pages-usuarios',['users' => $users]);
  }

  
  public function pagination(){
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
        'password' => 'required|string|confirmed', // Asegúrate de tener el campo password_confirmation en tu formulario
        'IdCategoria' => 'required',
        'firma_source' => ['nullable', 'string'], // Validar la fuente de la firma
        'firma' => ['nullable', 'string'], // Agregar validación para la firma si es necesario
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);

if ($request->filled('firma_canvas')) {
  // SI SE PROPORCIONÓ UNA FIRMA EN EL CANVAS
  $user->firma = $request->firma_canvas;
  $user->firma_source = 'canvas';
} 
elseif ($request->hasFile('firma_file')) {
  $firmaFile = $request->file('firma_file');
  $firmaPath = $firmaFile->store('firma', 'public'); // ALMACENAR LA FIRMA EN storage/public/firma
  $user->firma = $firmaPath;
  $user->firma_source = 'imagen';
}

    $user->save();

    // Asignar el rol al usuario
    $user->assignRole($request->IdCategoria);

    return redirect()->route('pages-usuarios');
}


  public function show($user_id){
    $user = User::find($user_id);
    $roles = Roles::all();
    return view('content.pages.pages-usuarios-editar',['user' => $user, 'roles' => $roles]);
  }

  public function update(Request $request){
    

    $user = User::find($request->user_id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);

    
    // Actualizar firma si se proporciona
    if ($request->filled('firma_canvas')) {
      // SI SE PROPORCIONÓ UNA FIRMA EN EL CANVAS
      $user->firma = $request->firma_canvas;
      $user->firma_source = 'canvas';
  } elseif ($request->hasFile('firma_file')) {
      $firmaFile = $request->file('firma_file');
      $firmaPath = $firmaFile->store('firma', 'public'); // ALMACENAR LA FIRMA EN storage/public/firma
      $user->firma = $firmaPath;
      $user->firma_source = 'imagen';
  }

  // Actualizar el rol del usuario
  $user->syncRoles([$request->IdCategoria]);

    $user->save();
    return redirect()->route('pages-usuarios');
  }

  public function destroy($user_id){
    $user = User::find($user_id);
    $user->delete();
    return redirect()->route('pages-usuarios');
  }

  
  public function switch($id){
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

  public function verusuarios($user_id)
  {
    $user = User::find($user_id);
    $roles = Roles::all();
    return view('content.pages.pages-usuarios-ver',['user' => $user, 'roles' => $roles]);
  }
  
}

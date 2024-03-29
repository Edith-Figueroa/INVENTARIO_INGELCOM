<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LoginBasic extends Controller
{
    public function index()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);   // Verifica si se ha enviado el formulario de inicio de sesión
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                // Comprueba si el usuario está inactivo
                if (Auth::user()->estado === 'Inactivo') {
                    Auth::logout(); // Cierra la sesión
                    return redirect()->route('login')->with('status', 'Tu cuenta está inactiva.');
                }
                $user = Auth::user();

                session(['ID_ROLE' => $user->idRole]);
                
                return redirect('/dashboard');
            } else {
                return redirect()->route('login')->with('status', 'Credenciales incorrectas.');
            }
        } else {
            // Código original para mostrar la vista de inicio de sesión
            $pageConfigs = ['myLayout' => 'blank'];
            return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
        }
    }
}

<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$mechanismsOfAuthentication)
    {
        // Comprueba si se han especificado mecanismos de autenticación; si no, utiliza un mecanismo nulo
        $mechanismsOfAuthentication = empty($mechanismsOfAuthentication) ? [null] : $mechanismsOfAuthentication;

        // Itera a través de los mecanismos de autenticación especificados
        foreach ($mechanismsOfAuthentication as $mechanismOfAuthentication) {
            // Verifica si el usuario está autenticado en el mecanismo de autenticación actual
            if (Auth::guard($mechanismOfAuthentication)->check()) {
                // Obtiene el usuario autenticado
                $user = Auth::guard($mechanismOfAuthentication)->user();

                // Comprueba si el usuario está inactivo
                if ($user->Estado == 'Inactivo') {
                    // Si el usuario está inactivo, redirige a la misma página con un mensaje de error
                    return redirect(RouteServiceProvider::LOGIN);
                } else {
                    // Si el usuario no está inactivo, redirige a la vista de inicio (Home)
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        // Si el usuario no está autenticado en ninguno de los mecanismos de autenticación, permite continuar la solicitud
        return $next($request);
    }
}

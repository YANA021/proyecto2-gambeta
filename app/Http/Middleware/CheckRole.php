<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * manejar una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // asumimos que la relación es 'rol' basada en el plan y el modelo 'usuario'
        $userRole = auth()->user()->rol->nombre;

        // normalizamos a minúsculas para comparación
        $roles = array_map('strtolower', $roles);
        if (!in_array(strtolower($userRole), $roles)) {
            $dashboardRoute = strtolower($userRole) === 'administrador'
                ? 'admin.dashboard'
                : 'empleado.dashboard';
            return redirect()->route($dashboardRoute);
        }

        return $next($request);
    }
}

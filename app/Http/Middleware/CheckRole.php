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
        $userRole = strtolower(auth()->user()->rol->nombre ?? '');

        // normalizamos a minúsculas para comparación
        $roles = array_map('strtolower', $roles);
        if (!in_array($userRole, $roles)) {
            // redirigir según rol o abortar si no hay match
            if ($userRole === 'administrador') {
                return redirect()->route('admin.dashboard');
            }
            if ($userRole === 'empleado') {
                return redirect()->route('empleado.dashboard');
            }
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}

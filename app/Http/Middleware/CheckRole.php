<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Assuming the relationship is 'rol' based on the plan and 'Usuario' model
        $userRole = auth()->user()->rol->nombre;

        // Normalize to lowercase for comparison
        $roles = array_map('strtolower', $roles);
        if (!in_array(strtolower($userRole), $roles)) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}

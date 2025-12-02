<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Roles;
use App\Models\Cliente;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:255|unique:usuarios',
            'contrasena' => 'required|string|min:8|confirmed',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'nombre_equipo' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // buscar o crear rol 'cliente'
            $role = Roles::firstOrCreate(['nombre' => 'cliente']);

            // crear usuario
            $usuario = Usuario::create([
                'nombre_usuario' => $request->nombre_usuario,
                'contrasena' => Hash::make($request->contrasena),
                'rol_id' => $role->id,
            ]);

            // manejar equipoo
            $grupoId = null;
            if ($request->filled('nombre_equipo')) {
                $grupo = Grupo::firstOrCreate(['nombre' => $request->nombre_equipo]);
                $grupoId = $grupo->id;
            }

            // crear cliente vinculado a usuario
            Cliente::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'grupo_id' => $grupoId,
                'usuario_id' => $usuario->id,
            ]);

            DB::commit();

            Auth::login($usuario);

            return redirect()->route('cliente.dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al registrar el usuario. Por favor intente nuevamente.']);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        ]);

        // Find or create 'cliente' role (lowercase as per DB convention)
        $role = Roles::firstOrCreate(['nombre' => 'cliente']);

        $usuario = Usuario::create([
            'nombre_usuario' => $request->nombre_usuario,
            'contrasena' => Hash::make($request->contrasena),
            'rol_id' => $role->id,
        ]);

        Auth::loginUsingId($usuario->id);

        return redirect()->route('cliente.dashboard');
    }
}

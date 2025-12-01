<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nombre_usuario' => 'required',
            'contrasena' => 'required'
        ]);

        $usuario = Usuario::where('nombre_usuario', $credentials['nombre_usuario'])->first();

        if ($usuario && Hash::check($credentials['contrasena'], $usuario->contrasena)) {
            Auth::login($usuario);
            $request->session()->regenerate();

            // redirección basada en roles
            $role = strtolower($usuario->rol->nombre);
            if ($role === 'administrador') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'empleado') {
                return redirect()->route('empleado.dashboard');
            }
            
            return redirect()->route('cliente.dashboard');
        }

        return back()->withErrors([
            'nombre_usuario' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('nombre_usuario');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuariosController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with(['rol', 'empleado'])
            ->orderBy('nombre_usuario')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create', [
            'roles' => Roles::pluck('nombre', 'id'),
            'empleados' => User::pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateUsuario($request);

        Usuario::create($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load(['rol', 'empleado']);

        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', [
            'usuario' => $usuario,
            'roles' => Roles::pluck('nombre', 'id'),
            'empleados' => User::pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Usuario $usuario)
    {
        $data = $this->validateUsuario($request, $usuario);

        if (!$data['contrasena']) {
            unset($data['contrasena']);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    private function validateUsuario(Request $request, ?Usuario $usuario = null): array
    {
        $rules = [
            'nombre_usuario' => [
                'required',
                'string',
                'max:255',
                Rule::unique('usuarios', 'nombre_usuario')->ignore($usuario?->id),
            ],
            'contrasena' => [
                $usuario ? 'nullable' : 'required',
                'string',
                'min:8',
            ],
            'empleado_id' => [
                'nullable',
                'exists:users,id',
            ],
            'rol_id' => [
                'nullable',
                'exists:roles,id',
            ],
        ];

        return $request->validate($rules);
    }
}

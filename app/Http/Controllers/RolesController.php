<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::withCount('usuarios')->orderBy('nombre')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create', [
            'permittedRoles' => Roles::PERMITTED_ROLES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateRole($request);

        Roles::create($data);

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function show(Roles $role)
    {
        $role->load('usuarios');

        return view('roles.show', compact('role'));
    }

    public function edit(Roles $role)
    {
        return view('roles.edit', [
            'role' => $role,
            'permittedRoles' => Roles::PERMITTED_ROLES,
        ]);
    }

    public function update(Request $request, Roles $role)
    {
        $data = $this->validateRole($request, $role);

        $role->update($data);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Roles $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }

    private function validateRole(Request $request, ?Roles $role = null): array
    {
        return $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::in(Roles::PERMITTED_ROLES),
                Rule::unique('roles', 'nombre')->ignore($role?->id),
            ],
        ]);
    }
}

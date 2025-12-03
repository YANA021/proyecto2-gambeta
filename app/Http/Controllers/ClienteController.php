<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Grupo;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('grupo')->orderBy('id', 'asc')->paginate(10);

        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        $grupos = Grupo::pluck('nombre', 'id');
        return view('admin.clientes.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Cliente::create($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('grupo');
        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $grupos = Grupo::pluck('nombre', 'id');
        return view('admin.clientes.edit', compact('cliente', 'grupos'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $this->validateData($request);
        $cliente->update($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:30', 'regex:/^[0-9+()\\s-]{7,}$/'],
            'grupo_id' => ['nullable', 'exists:grupos,id'],
        ]);
    }
}

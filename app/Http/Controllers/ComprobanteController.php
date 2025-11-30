<?php

namespace App\Http\Controllers;

use App\Models\Comprobante;
use App\Models\Pago;
use Illuminate\Http\Request;

class ComprobanteController extends Controller
{
    public function index()
    {
        $comprobantes = Comprobante::with('pago')->latest()->paginate(10);
        return view('admin.comprobantes.index', compact('comprobantes'));
    }

    public function create()
    {
        $pagos = Pago::with('cliente')->get();
        return view('admin.comprobantes.create', compact('pagos'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Comprobante::create($data);

        return redirect()->route('comprobantes.index')->with('success', 'Comprobante creado correctamente.');
    }

    public function show(Comprobante $comprobante)
    {
        $comprobante->load('pago.cliente');
        return view('admin.comprobantes.show', compact('comprobante'));
    }

    public function edit(Comprobante $comprobante)
    {
        $pagos = Pago::with('cliente')->get();
        return view('admin.comprobantes.edit', compact('comprobante', 'pagos'));
    }

    public function update(Request $request, Comprobante $comprobante)
    {
        $data = $this->validateData($request);
        $comprobante->update($data);

        return redirect()->route('comprobantes.index')->with('success', 'Comprobante actualizado correctamente.');
    }

    public function destroy(Comprobante $comprobante)
    {
        $comprobante->delete();

        return redirect()->route('comprobantes.index')->with('success', 'Comprobante eliminado correctamente.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'pago_id' => ['required', 'exists:pagos,id'],
            'url_comprobante' => ['required', 'string', 'max:255', 'url'],
        ]);
    }
}

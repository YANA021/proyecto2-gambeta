<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Reserva;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['reserva', 'cliente'])->latest()->paginate(10);
        return view('admin.pagos.index', compact('pagos'));
    }

    public function create()
    {
        $reservas = Reserva::with('cliente')->get()->pluck('id', 'id');
        $clientes = Cliente::pluck('nombre', 'id');

        return view('admin.pagos.create', compact('reservas', 'clientes'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Pago::create($data);

        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    public function show(Pago $pago)
    {
        $pago->load(['reserva', 'cliente']);
        return view('admin.pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $reservas = Reserva::with('cliente')->get()->pluck('id', 'id');
        $clientes = Cliente::pluck('nombre', 'id');

        return view('admin.pagos.edit', compact('pago', 'reservas', 'clientes'));
    }

    public function update(Request $request, Pago $pago)
    {
        $data = $this->validateData($request, $pago->id);
        $pago->update($data);

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        if (auth()->user()?->hasRole('empleado')) {
            abort(403, 'Los empleados no pueden eliminar pagos.');
        }

        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'reserva_id' => ['required', 'exists:reservas,id'],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'fecha_pago' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0'],
            'metodo' => ['required', 'string', 'max:255'],
            'estado_pago' => ['required', 'in:pendiente,completado'],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\EstadoReserva;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['reserva', 'cliente'])->orderBy('id', 'asc')->paginate(10);
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
        $payload = $this->prepararPago($data);

        Pago::create($payload['pago']);
        $this->actualizarEstadoReserva($payload['reserva'], $payload['pagadoTotal']);

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
        $payload = $this->prepararPago($data, $pago->id);

        $pago->update($payload['pago']);
        $this->actualizarEstadoReserva($payload['reserva'], $payload['pagadoTotal']);

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
            // el cliente se asigna según la reserva
            'fecha_pago' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0'],
            'metodo' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Prepara payload de pago validando saldo y estados.
     */
    private function prepararPago(array $data, ?int $ignorePagoId = null): array
    {
        $reserva = Reserva::findOrFail($data['reserva_id']);

        // asegurar que el cliente coincida con la reserva
        $data['cliente_id'] = $reserva->cliente_id;

        $pagadoPrevio = Pago::where('reserva_id', $reserva->id)
            ->when($ignorePagoId, fn($q) => $q->where('id', '!=', $ignorePagoId))
            ->sum('monto');

        $monto = $data['monto'];
        if ($monto <= 0) {
            back()->withErrors(['monto' => 'El monto debe ser mayor a 0'])->throwResponse();
        }

        $saldo = $reserva->precio_total - $pagadoPrevio;
        if ($monto > $saldo) {
            back()->withErrors(['monto' => 'El monto supera el saldo pendiente ($'.number_format($saldo, 2).')'])->throwResponse();
        }

        $pagadoTotal = $pagadoPrevio + $monto;
        $estadoPago = $pagadoTotal >= $reserva->precio_total ? 'completado' : 'pendiente';

        $data['estado_pago'] = $estadoPago;

        return [
            'pago' => $data,
            'reserva' => $reserva,
            'pagadoTotal' => $pagadoTotal,
        ];
    }

    private function actualizarEstadoReserva(Reserva $reserva, float $pagadoTotal): void
    {
        $pendienteId = EstadoReserva::where('nombre', 'Pendiente')->value('id');
        $confirmadaId = EstadoReserva::where('nombre', 'Confirmada')->value('id')
            ?? EstadoReserva::where('nombre', 'Finalizada')->value('id');

        if ($pagadoTotal >= $reserva->precio_total && $confirmadaId) {
            $reserva->update(['estado_id' => $confirmadaId]);
        } elseif ($pendienteId) {
            $reserva->update(['estado_id' => $pendienteId]);
        }
    }
}

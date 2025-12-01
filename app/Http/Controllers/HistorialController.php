<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Cliente;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    public function porCancha($id)
    {
        $cancha = Cancha::findOrFail($id);
        $reservas = Reserva::with(['cliente', 'estado'])
            ->where('cancha_id', $id)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate(20);

        return view('admin.historial.por-cancha', compact('cancha', 'reservas'));
    }

    public function clientesFrecuentes()
    {
        $clientes = Cliente::select('clientes.*', DB::raw('COUNT(reservas.id) as total_reservas'), DB::raw('COALESCE(SUM(pagos.monto), 0) as total_gastado'))
            ->leftJoin('reservas', 'clientes.id', '=', 'reservas.cliente_id')
            ->leftJoin('pagos', 'clientes.id', '=', 'pagos.cliente_id')
            ->groupBy('clientes.id')
            ->orderByDesc('total_reservas')
            ->limit(10)
            ->get();

        return view('admin.historial.clientes-frecuentes', compact('clientes'));
    }
}

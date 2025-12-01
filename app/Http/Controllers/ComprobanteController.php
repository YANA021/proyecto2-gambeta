<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ComprobanteController extends Controller
{
    public function index()
    {
        // redirigir a pagos o mostrar lista de comprobantes
        return redirect()->route('pagos.index');
    }

    public function show($id)
    {
        $pago = Pago::with(['cliente', 'reserva.cancha'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.comprobantes.pdf', compact('pago'));

        return $pdf->stream('comprobante-' . $pago->id . '.pdf');
    }
}

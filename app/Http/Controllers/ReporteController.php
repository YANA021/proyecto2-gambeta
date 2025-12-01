<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Reserva;
use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        $data = $this->getReportData();
        return view('admin.reportes.index', $data);
    }

    public function export(Request $request)
    {
        $type = $request->query('type', 'general');
        $data = $this->getReportData();
        $data['type'] = $type;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reportes.pdf', $data);
        return $pdf->stream("reporte-{$type}-" . now()->format('Y-m-d') . '.pdf');
    }

    private function getReportData()
    {
        // 1. kpis generales
        $ingresosHoy = Pago::whereDate('fecha_pago', Carbon::today())->sum('monto');
        $ingresosMes = Pago::whereMonth('fecha_pago', Carbon::now()->month)
                           ->whereYear('fecha_pago', Carbon::now()->year)
                           ->sum('monto');
        $reservasMes = Reserva::whereMonth('fecha', Carbon::now()->month)
                              ->whereYear('fecha', Carbon::now()->year)
                              ->count();

        // 2. ingresos mensuales (últimos 6 meses)
        $ingresosPorMes = Pago::select(
                DB::raw('sum(monto) as total'),
                DB::raw("DATE_FORMAT(fecha_pago, '%Y-%m') as mes")
            )
            ->where('fecha_pago', '>=', Carbon::now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $chartLabels = $ingresosPorMes->pluck('mes')->map(function($mes) {
            return Carbon::createFromFormat('Y-m', $mes)->format('M Y');
        });
        $chartData = $ingresosPorMes->pluck('total');

        // 3. canchas más usadas
        $canchasPopulares = Reserva::select('cancha_id', DB::raw('count(*) as total'))
            ->groupBy('cancha_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('cancha')
            ->get();

        $canchaLabels = $canchasPopulares->map(fn($r) => $r->cancha->nombre ?? 'Desconocida');
        $canchaData = $canchasPopulares->pluck('total');

        return compact(
            'ingresosHoy', 
            'ingresosMes', 
            'reservasMes',
            'chartLabels',
            'chartData',
            'canchaLabels',
            'canchaData',
            'ingresosPorMes', // añadido para vista de tabla en pdf
            'canchasPopulares' // añadido para vista de tabla en pdf
        );
    }
}

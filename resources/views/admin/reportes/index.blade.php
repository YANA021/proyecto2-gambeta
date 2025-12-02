<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-7xl px-6 py-10">
        <header class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Business Intelligence</p>
                <h1 class="text-3xl font-bold">Reportes y Estadísticas</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('reportes.export', ['type' => 'general']) }}" target="_blank" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    📄 Exportar General
                </a>
                <a href="{{ route('reportes.export', ['type' => 'ingresos']) }}" target="_blank" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    💰 Ingresos
                </a>
                <a href="{{ route('reportes.export', ['type' => 'canchas']) }}" target="_blank" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    🏟️ Canchas
                </a>
            </div>
        </header>

        <!-- KPIs -->
        <div class="mb-8 grid gap-6 md:grid-cols-3">
            <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Ingresos Hoy</p>
                <p class="text-2xl font-bold text-emerald-600">${{ number_format($ingresosHoy, 2) }}</p>
            </div>
            <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Ingresos Este Mes</p>
                <p class="text-2xl font-bold text-slate-800">${{ number_format($ingresosMes, 2) }}</p>
            </div>
            <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Reservas Este Mes</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $reservasMes }}</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Ingresos Chart -->
            <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-bold text-slate-800">Ingresos Mensuales</h3>
                <canvas id="incomeChart"></canvas>
            </div>

            <!-- Canchas Chart -->
            <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-bold text-slate-800">Canchas Más Populares</h3>
                <div class="mx-auto w-3/4">
                    <canvas id="usageChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Income Chart
        const ctxIncome = document.getElementById('incomeChart').getContext('2d');
        new Chart(ctxIncome, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Ingresos ($)',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: '#10b981',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Usage Chart
        const ctxUsage = document.getElementById('usageChart').getContext('2d');
        new Chart(ctxUsage, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($canchaLabels) !!},
                datasets: [{
                    data: {!! json_encode($canchaData) !!},
                    backgroundColor: [
                        '#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#f97316'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
</body>
</html>

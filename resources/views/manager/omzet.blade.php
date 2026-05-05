<x-admin-layout>
    @section('title_breadcrumb', 'Rekap Pendapatan')
    <div class="space-y-10 animate-reveal">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Rekap <span class="text-primary">Pendapatan</span></h1>
                <p class="text-slate-500 font-medium">Laporan omzet cabang berdasarkan periode waktu.</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="premium-card p-8 bg-white border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Omzet Hari Ini</p>
                <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</h3>
            </div>
            <div class="premium-card p-8 bg-white border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Omzet Minggu Ini</p>
                <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($omzetMingguIni, 0, ',', '.') }}</h3>
            </div>
            <div class="premium-card p-8 bg-slate-900 shadow-xl shadow-slate-200">
                <p class="text-[10px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Omzet Bulan Ini</p>
                <h3 class="text-2xl font-black text-white">Rp {{ number_format($omzetBulanIni, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="premium-card p-10 bg-white border border-slate-100 shadow-sm">
            <h3 class="text-xl font-black text-slate-900 mb-8">Grafik Pendapatan 7 Hari Terakhir</h3>
            <div class="h-80 w-full">
                <canvas id="omzetChart"></canvas>
            </div>
        </div>

        <!-- Table Container -->
        <div class="premium-card overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-lg font-black text-slate-900">Rincian Harian</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Transaksi</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Omzet</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($chartData as $row)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900">{{ Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-500">{{ $row->total_transaksi }} transaksi</td>
                            <td class="px-8 py-6 text-sm font-black text-primary">Rp {{ number_format($row->total_omzet, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            const ctx = document.getElementById('omzetChart').getContext('2d');
            
            if (chartData.length === 0) {
                ctx.font = "14px Arial";
                ctx.fillStyle = "#94a3b8";
                ctx.textAlign = "center";
                ctx.fillText("Belum ada data pendapatan 7 hari terakhir", ctx.canvas.width/2, ctx.canvas.height/2);
                return;
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.map(d => d.tanggal),
                    datasets: [{
                        label: 'Omzet',
                        data: chartData.map(d => d.total_omzet),
                        backgroundColor: '#185FA5',
                        borderRadius: 8,
                        barThickness: 25
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } },
                        y: { grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } }
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>

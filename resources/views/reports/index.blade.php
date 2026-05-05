<x-admin-layout>
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Business Reports</h1>
                <p class="text-slate-500 font-medium mt-1">Ringkasan performa operasional dan finansial.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="window.print()" class="bg-white text-slate-600 font-bold py-3 px-6 rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2-2v4a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Print PDF
                </button>
                <a href="{{ route('reports.export') }}" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    Export Excel
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="premium-card p-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Total Omzet</p>
                <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
                <div class="mt-2 flex items-center gap-1 text-emerald-500 font-bold text-xs">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                    <span>12% Increase</span>
                </div>
            </div>
            <div class="premium-card p-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Total Paket</p>
                <h3 class="text-2xl font-black text-slate-900">{{ $totalPackets }}</h3>
                <div class="mt-2 flex items-center gap-1 text-emerald-500 font-bold text-xs">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                    <span>5% Increase</span>
                </div>
            </div>
            <div class="premium-card p-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Rata-rata / Transaksi</p>
                <h3 class="text-2xl font-black text-slate-900">Rp {{ number_format($avgTransaction, 0, ',', '.') }}</h3>
            </div>
            <div class="premium-card p-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">COD Pending</p>
                <h3 class="text-2xl font-black text-rose-500">Rp {{ number_format($codPending, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Revenue Chart -->
            <div class="lg:col-span-2 premium-card p-8">
                <h3 class="text-lg font-black text-slate-900 mb-6">Tren Omzet (7 Hari Terakhir)</h3>
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Payment Breakdown -->
            <div class="lg:col-span-1 premium-card p-8">
                <h3 class="text-lg font-black text-slate-900 mb-6">Metode Pembayaran</h3>
                <div class="space-y-6">
                    @foreach($breakdown as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $item->payment_method === 'cash' ? 'bg-emerald-50 text-emerald-600' : ($item->payment_method === 'transfer' ? 'bg-blue-50 text-primary' : 'bg-amber-50 text-amber-600') }}">
                                @if($item->payment_method === 'cash')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                @elseif($item->payment_method === 'transfer')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3L22 4m-2 1h.01M17 21a2 2 0 11-4 0 2 2 0 014 0zM7 21a2 2 0 11-4 0 2 2 0 014 0zM14 7h.01M9 16H5v4h4v-4z" /></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900 uppercase tracking-wider">{{ $item->payment_method }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $item->count }} Transaksi</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-slate-900">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const data = @json($chartData);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(i => i.date),
                datasets: [{
                    label: 'Omzet',
                    data: data.map(i => i.total),
                    backgroundColor: '#6366f1',
                    borderRadius: 8,
                    barThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f1f5f9' },
                        ticks: { font: { weight: 'bold' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold' } }
                    }
                }
            }
        });
    </script>
</x-admin-layout>

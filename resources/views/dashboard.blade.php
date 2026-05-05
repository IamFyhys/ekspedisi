<x-admin-layout>
    @section('title_breadcrumb', 'Dashboard Sistem')
    <div class="space-y-12 animate-reveal">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Selamat datang, <span class="text-primary">{{ Auth::user()->name }}</span></h1>
                <p class="text-slate-500 font-medium text-lg">{{ Auth::user()->role === 'admin' ? 'Administrator Pusat' : (Auth::user()->branch->name ?? 'Cabang') }} — {{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('tracking') }}" class="px-6 py-3 bg-white text-primary border border-slate-200 font-bold rounded-2xl hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Cek Resi
                </a>
                <a href="{{ route('shipments.create') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Kirim Paket Baru
                </a>
            </div>
        </div>

        <!-- Stat Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="premium-card p-8">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Total Shipments</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-900">{{ number_format($stats['total'], 0, ',', '.') }}</h3>
                    <div class="w-12 h-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                </div>
            </div>
            <div class="premium-card p-8">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Delivered</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-900">{{ number_format($stats['delivered'], 0, ',', '.') }}</h3>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                </div>
            </div>
            <div class="premium-card p-8">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Pending</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-900">{{ number_format($stats['pending'], 0, ',', '.') }}</h3>
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>
            <div class="premium-card p-8 bg-primary">
                <p class="text-[10px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Total Revenue</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-2xl font-black text-white">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</h3>
                    <div class="w-12 h-12 bg-white/10 text-white rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle Section -->
        <div class="premium-card overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-900">Recent Activities</h3>
                <a href="{{ route('shipments.index') }}" class="px-4 py-2 bg-slate-50 text-[10px] font-black text-primary uppercase tracking-widest rounded-xl hover:bg-primary hover:text-white transition-all">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reference</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentShipments as $shipment)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900 tracking-tight">{{ $shipment->tracking_number }}</td>
                            <td class="px-8 py-6 text-sm font-medium text-slate-600">{{ $shipment->sender_name }}</td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                                    {{ $shipment->status === 'delivered' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ str_replace('_', ' ', $shipment->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right font-black text-slate-900">
                                Rp {{ number_format($shipment->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(auth()->user()->role === 'manager' || auth()->user()->role === 'admin')
        <!-- CHARTS SECTION -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="premium-card p-10">
                <h3 class="text-xl font-black text-slate-900 mb-8">Revenue Trends (7 Days)</h3>
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            <div class="premium-card p-10">
                <h3 class="text-xl font-black text-slate-900 mb-8">Shipment Volume (7 Days)</h3>
                <div class="h-64">
                    <canvas id="shipmentChart"></canvas>
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const trends = @json($trends);
                const labels = trends.map(t => t.date);
                const revenueData = trends.map(t => t.revenue);
                const countData = trends.map(t => t.count);

                // Revenue Chart
                new Chart(document.getElementById('revenueChart'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Revenue',
                            data: revenueData,
                            borderColor: '#185FA5',
                            backgroundColor: 'rgba(24, 95, 165, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { 
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } }, 
                            x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } } 
                        }
                    }
                });

                // Shipment Chart
                new Chart(document.getElementById('shipmentChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Shipments',
                            data: countData,
                            backgroundColor: '#10b981',
                            borderRadius: 10,
                            barThickness: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { 
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } }, 
                            x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } } 
                        }
                    }
                });
            });
        </script>
        @endpush
        @endif
    </div>
</x-admin-layout>

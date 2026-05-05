<x-admin-layout>
    @section('title_breadcrumb', 'Ringkasan Cabang')
    <div class="space-y-12 animate-reveal">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Selamat datang, <span class="text-primary">{{ Auth::user()->name }}</span></h1>
                <p class="text-slate-500 font-medium text-lg">{{ Auth::user()->branch->name ?? 'Cabang' }} — {{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        </div>

        @if($agingAlerts->count() > 0)
        <div class="p-6 bg-rose-50 border border-rose-100 rounded-3xl flex items-center justify-between animate-pulse">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-black text-rose-900 uppercase tracking-widest">Inventory Aging Alert!</h4>
                    <p class="text-rose-600 text-xs font-bold">{{ $agingAlerts->count() }} paket tertahan di gudang lebih dari 3 hari.</p>
                </div>
            </div>
            <a href="{{ route('manager.gudang') }}" class="px-5 py-2 bg-rose-500 text-white text-[10px] font-black rounded-xl uppercase tracking-widest">Lihat Detail</a>
        </div>
        @endif

        <!-- Stat Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="premium-card p-8">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Paket Masuk</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-900">{{ $statCards['paket_masuk'] }}</h3>
                    <div class="w-12 h-12 bg-blue-50 text-primary rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" /></svg>
                    </div>
                </div>
            </div>
            <div class="premium-card p-8">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Paket Terkirim</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-900">{{ $statCards['paket_terkirim'] }}</h3>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                </div>
            </div>
            <div class="premium-card p-8">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Paket Gudang</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-900">{{ $statCards['paket_gudang'] }}</h3>
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                </div>
            </div>
            <div class="premium-card p-8 bg-primary">
                <p class="text-[10px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Omzet Hari Ini</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-2xl font-black text-white">Rp {{ number_format($statCards['omzet_hari_ini'], 0, ',', '.') }}</h3>
                    <div class="w-12 h-12 bg-white/10 text-white rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pickup Requests Section -->
        <div class="premium-card overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-900">Permintaan Pickup Pending</h3>
                <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full uppercase tracking-widest">
                    {{ $pendingPickups->count() }} Menunggu
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengirim</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jadwal</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($pendingPickups as $pickup)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <div class="font-black text-slate-900">{{ $pickup->sender_name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $pickup->sender_phone }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm font-medium text-slate-600">{{ $pickup->pickup_date->format('d M Y') }}</div>
                                <div class="text-[11px] font-bold text-primary">{{ $pickup->pickup_time }}</div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('manager.pickup.assign') }}" method="POST" class="flex items-center justify-end gap-2">
                                    @csrf
                                    <input type="hidden" name="pickup_id" value="{{ $pickup->id }}">
                                    <select name="courier_id" class="px-4 py-2 bg-slate-50 border-none text-[11px] font-black text-slate-900 rounded-xl outline-none focus:ring-2 focus:ring-primary/20" required>
                                        <option value="">Pilih Kurir</option>
                                        @foreach($pickupCouriers as $courier)
                                        <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-4 py-2 bg-primary text-[10px] font-black text-white uppercase tracking-widest rounded-xl hover:bg-slate-900 transition-all">Assign</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center text-slate-400 text-sm font-medium">Tidak ada permintaan pickup pending.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Middle Section -->
        <div class="premium-card overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-900">Transaksi Terkini (5 data terbaru)</h3>
                <a href="{{ route('manager.transaksi') }}" class="px-4 py-2 bg-slate-50 text-[10px] font-black text-primary uppercase tracking-widest rounded-xl hover:bg-primary hover:text-white transition-all">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">No Resi</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tujuan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentTransactions as $tx)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900 tracking-tight">{{ $tx->tracking_number }}</td>
                            <td class="px-8 py-6 text-sm font-medium text-slate-600">{{ $tx->receiver_address }}</td>
                            <td class="px-8 py-6 text-right">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                                    {{ $tx->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ $tx->payment_status === 'paid' ? 'Paid ✓' : 'Pending' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Audit Ringkasan -->
            <div class="premium-card overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <h3 class="text-xl font-black text-slate-900">Cash Drawer Hari Ini</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kasir</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($todayShifts as $shift)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 font-black text-xs">
                                            {{ substr($shift->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 leading-none">{{ $shift->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                                        {{ $shift->approved_at ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                        {{ $shift->approved_at ? 'Approve' : 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Staff Status -->
            <div class="premium-card p-10">
                <h3 class="text-xl font-black text-slate-900 mb-8">Staff Online</h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($staffOnline as $staff)
                    <a href="{{ route('manager.staff.show', $staff->id) }}" class="p-6 bg-slate-50/50 rounded-3xl border border-slate-50 flex flex-col items-center text-center group hover:bg-white hover:border-primary/20 hover:shadow-xl hover:shadow-slate-200/50 transition-all">
                        <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-slate-400 font-black text-lg mb-4 group-hover:scale-110 transition-transform">
                            {{ substr($staff->name, 0, 1) }}
                        </div>
                        <p class="text-sm font-black text-slate-900 leading-tight mb-1">{{ $staff->name }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-4">{{ $staff->role }}</p>
                        <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                            {{ $staff->status_label === 'Offline' ? 'bg-slate-200 text-slate-500' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ $staff->status_label }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Bar Chart Section -->
        <div class="premium-card p-10">
            <h3 class="text-xl font-black text-slate-900 mb-8">Bar Chart Omzet 7 Hari Terakhir</h3>
            <div class="h-80 w-full">
                <canvas id="omzetChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const chartData = @json($chartData);
        const ctx = document.getElementById('omzetChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(d => d.tanggal),
                datasets: [{
                    label: 'Omzet',
                    data: chartData.map(d => d.total_omzet),
                    backgroundColor: '#185FA5',
                    borderRadius: 10,
                    borderSkipped: false,
                    barThickness: 20
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
    </script>
    @endpush
</x-admin-layout>

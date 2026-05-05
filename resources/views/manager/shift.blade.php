<x-admin-layout>
    <div class="space-y-12 animate-reveal">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Shift <span class="text-primary">History</span></h1>
                <p class="text-slate-500 font-medium text-lg">Pantau riwayat jam kerja dan produktivitas staff Anda.</p>
            </div>
            <div class="flex p-1.5 bg-white rounded-2xl shadow-sm border border-slate-100">
                <button class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest bg-primary text-white shadow-lg shadow-primary/20 transition-all">Hari Ini</button>
                <button class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all">Minggu Ini</button>
            </div>
        </div>

        <!-- History Table -->
        <div class="premium-card overflow-hidden">
            <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-white/50 backdrop-blur-sm">
                <h3 class="text-xl font-black text-slate-900">Riwayat Shift Karyawan</h3>
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Live Updates</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama Staff</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Mulai</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Selesai</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Transaksi</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Omzet</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($shifts as $shift)
                        <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 font-black group-hover:scale-110 transition-transform">
                                        {{ substr($shift->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 leading-none mb-1">{{ $shift->user->name }}</p>
                                        <p class="text-[10px] font-bold text-primary uppercase tracking-widest">{{ $shift->user->role }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-sm font-bold text-slate-700">
                                {{ $shift->start_time->format('d/m H:i') }}
                            </td>
                            <td class="px-10 py-8 text-sm font-bold text-slate-400">
                                {{ $shift->end_time ? $shift->end_time->format('d/m H:i') : '-' }}
                            </td>
                            <td class="px-10 py-8 text-sm font-black text-slate-900">
                                0 <span class="text-[10px] font-bold text-slate-400 ml-1">TRX</span>
                            </td>
                            <td class="px-10 py-8 text-sm font-black text-primary">
                                Rp {{ number_format($shift->total_revenue ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $shift->status == 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $shift->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center">
                                <p class="text-slate-300 font-bold italic">Belum ada data shift untuk periode ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>

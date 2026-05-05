<x-admin-layout>
    @section('title_breadcrumb', 'Transit Dashboard')
    <div class="space-y-10 animate-reveal">
        <!-- Welcome Section -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-black text-slate-900 mb-2 tracking-tight">Selamat datang, <span class="text-primary">{{ Auth::user()->name }}</span></h1>
                <p class="text-slate-500 font-medium">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <svg class="absolute -right-10 -bottom-10 w-64 h-64 text-slate-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /></svg>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="premium-card p-8 bg-white">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Paket Dibawa Hari Ini</p>
                <h3 class="text-4xl font-black text-slate-900">{{ $paketDibawa }} <span class="text-lg text-slate-400 ml-1">paket</span></h3>
            </div>
            <div class="premium-card p-8 bg-white">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Sudah Diserahterimakan</p>
                <h3 class="text-4xl font-black text-emerald-600">{{ $sudahDiserahterimakan }} <span class="text-lg text-slate-400 ml-1">paket</span></h3>
            </div>
            <div class="premium-card p-8 bg-primary text-white shadow-xl shadow-primary/20">
                <p class="text-[10px] font-black text-white/60 uppercase tracking-[0.2em] mb-4">Sisa Muatan Kendaraan</p>
                <h3 class="text-4xl font-black">{{ 50 - $paketDibawa }} <span class="text-lg text-white/60 ml-1">slot</span></h3>
            </div>
        </div>

        <!-- Active Trip Status -->
        <div class="premium-card p-10 bg-white border border-slate-100 shadow-sm">
            <h3 class="text-xl font-black text-slate-900 mb-8">Status Perjalanan Aktif</h3>
            @if($activeTrip)
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <span class="px-4 py-1.5 rounded-full bg-primary text-white text-[10px] font-black uppercase tracking-widest">{{ $activeTrip->originBranch->name }}</span>
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        <span class="px-4 py-1.5 rounded-full bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest">{{ $activeTrip->destinationBranch->name }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-500 italic">Berangkat: {{ $activeTrip->departed_at->format('H:i') }} — Estimasi: {{ $activeTrip->departed_at->addHours(8)->format('H:i') }}</p>
                    </div>
                </div>
                <div class="text-center md:text-right space-y-2">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</p>
                    <span class="px-6 py-3 rounded-2xl bg-amber-100 text-amber-700 text-xs font-black uppercase tracking-widest animate-pulse">DALAM PERJALANAN</span>
                </div>
            </div>
            @else
            <div class="bg-slate-50 p-12 rounded-3xl border border-dashed border-slate-200 text-center">
                <p class="text-slate-400 font-bold italic">Tidak ada perjalanan aktif saat ini.</p>
                <a href="{{ route('courier.transit.manifest-out') }}" class="mt-4 inline-block px-8 py-3 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-primary/20">Mulai Perjalanan</a>
            </div>
            @endif
        </div>

        <!-- Recent Packages -->
        <div class="premium-card overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-lg font-black text-slate-900">5 Paket Terbaru dalam Muatan</h3>
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
                        @foreach($recentPackages as $pkg)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900">{{ $pkg->tracking_number }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-500">{{ $pkg->receiver_address }}</td>
                            <td class="px-8 py-6 text-right">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $pkg->status === 'in_transit' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ str_replace('_', ' ', $pkg->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>

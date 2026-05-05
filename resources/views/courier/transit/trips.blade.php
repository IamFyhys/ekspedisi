<x-admin-layout>
    @section('title_breadcrumb', 'Trip Logs')
    <div class="space-y-10 animate-reveal">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Riwayat <span class="text-primary">Perjalanan</span></h1>
            <p class="text-slate-500 font-medium">Catatan lengkap perjalanan antar hub yang telah dilakukan.</p>
        </div>

        <div class="premium-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rute</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Paket</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($trips as $trip)
                        <tr class="hover:bg-slate-50/30 transition-colors cursor-pointer">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-black text-slate-900">{{ $trip->originBranch->name }}</span>
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                    <span class="text-sm font-black text-slate-900">{{ $trip->destinationBranch->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-500">Berangkat: {{ $trip->departed_at->format('d/m/Y H:i') }}</p>
                                    @if($trip->arrived_at)
                                    <p class="text-xs font-bold text-slate-400">Tiba: {{ $trip->arrived_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-black text-slate-900">{{ $trip->total_received }}/{{ $trip->total_packages }}</span>
                                    @if($trip->total_received < $trip->total_packages && $trip->status === 'completed')
                                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                                    {{ $trip->status === 'completed' ? ($trip->total_received < $trip->total_packages ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600') : 'bg-amber-50 text-amber-600' }}">
                                    {{ $trip->status === 'completed' ? ($trip->total_received < $trip->total_packages ? '⚠️ Selisih' : 'Selesai ✓') : 'On The Way' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold italic">Belum ada riwayat perjalanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-6 border-t border-slate-50">
                {{ $trips->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

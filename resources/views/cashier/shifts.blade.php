<x-admin-layout>
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white">Shift History</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Rekam jejak jam kerja kasir dan performa per shift.</p>
        </div>

        <div class="premium-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Nama Kasir</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Tanggal</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Jam Kerja</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Transaksi</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Pemasukan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($shifts as $shift)
                        <tr class="group hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6 font-black text-slate-900">{{ $shift->user->name }}</td>
                            <td class="px-8 py-6 text-sm font-medium text-slate-500">{{ $shift->start_time->format('d M Y') }}</td>
                            <td class="px-8 py-6">
                                <div class="text-xs font-black text-slate-900">
                                    {{ $shift->start_time->format('H:i') }} - {{ $shift->end_time ? $shift->end_time->format('H:i') : 'Sekarang' }}
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center font-black text-primary">{{ $shift->total_transactions }}</td>
                            <td class="px-8 py-6 text-right font-black text-slate-900">
                                Rp {{ number_format($shift->total_revenue, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $shift->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $shift->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($shifts->hasPages())
            <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/20">
                {{ $shifts->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>

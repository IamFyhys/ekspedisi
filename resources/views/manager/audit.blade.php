<x-admin-layout>
    @section('title_breadcrumb', 'Audit Cash Drawer')
    <div class="space-y-10 animate-reveal">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Audit <span class="text-primary">Cash Drawer</span></h1>
                <p class="text-slate-500 font-medium">Lakukan verifikasi pendapatan fisik kasir per shift.</p>
            </div>
        </div>

        <!-- Filter Section (Simplified) -->
        <div class="premium-card p-8 bg-white border border-slate-100 shadow-sm">
            <form action="{{ route('manager.audit') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full px-5 py-3.5 rounded-xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all text-sm font-bold">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Kasir</label>
                    <input type="text" name="kasir" value="{{ request('kasir') }}" placeholder="Cari kasir..." class="w-full px-5 py-3.5 rounded-xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all text-sm font-bold">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-4 bg-primary text-white font-black rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all uppercase tracking-widest text-[10px]">Filter</button>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="premium-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kasir</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Shift</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sistem</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Fisik</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Selisih</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($shifts as $shift)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <p class="text-sm font-black text-slate-900 leading-none">{{ $shift->user->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ $shift->start_time->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-500">
                                {{ $shift->start_time->format('H:i') }} - {{ $shift->end_time ? $shift->end_time->format('H:i') : 'Aktif' }}
                            </td>
                            <td class="px-8 py-6 text-sm font-black text-slate-900">Rp {{ number_format($shift->total_revenue, 0, ',', '.') }}</td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-700">Rp {{ number_format($shift->physical_cash ?? 0, 0, ',', '.') }}</td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-black {{ ($shift->difference ?? 0) < 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                    Rp {{ number_format($shift->difference ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                             <td class="px-8 py-6 text-right">
                                 @if(!$shift->end_time)
                                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-full">Berlangsung</span>
                                 @elseif(!$shift->approved_at)
                                 <form action="{{ route('manager.audit.approve', $shift->id) }}" method="POST">
                                     @csrf
                                     <button type="submit" class="px-6 py-2.5 bg-primary text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">Setujui</button>
                                 </form>
                                 @else
                                 <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">Disetujui ✓</span>
                                 @endif
                             </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-slate-400 font-bold italic">Belum ada data audit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>

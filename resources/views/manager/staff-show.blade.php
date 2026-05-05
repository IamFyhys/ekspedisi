<x-admin-layout>
    @section('title_breadcrumb', 'Detail Staff')
    <div class="space-y-10 animate-reveal">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-[2.5rem] bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-300 font-black text-4xl shadow-sm">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">{{ $user->name }}</h1>
                    <div class="flex items-center gap-4">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-primary text-white">{{ str_replace('_', ' ', $user->role) }}</span>
                        <span class="text-slate-400 font-bold text-sm">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('manager.staff') }}" class="px-8 py-4 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all uppercase tracking-widest text-[10px]">Kembali</a>
                <button class="px-8 py-4 bg-rose-50 text-rose-600 font-black rounded-2xl hover:bg-rose-100 transition-all uppercase tracking-widest text-[10px]">Nonaktifkan</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left Column: Profile Info -->
            <div class="space-y-10">
                <div class="premium-card p-10 bg-white">
                    <h3 class="text-xl font-black text-slate-900 mb-8">Informasi Kontak</h3>
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Address</p>
                            <p class="text-sm font-bold text-slate-900">{{ $user->email }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Phone Number</p>
                            <p class="text-sm font-bold text-slate-900">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alamat</p>
                            <p class="text-sm font-medium text-slate-600 leading-relaxed">{{ $user->address ?? 'Alamat belum diatur.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="premium-card p-10 bg-indigo-600 text-white shadow-xl shadow-indigo-100">
                    <h3 class="text-sm font-black uppercase tracking-widest mb-6 opacity-60">Statistik Peforma</h3>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center pb-4 border-b border-white/10">
                            <span class="text-sm font-medium opacity-80">Total Shift</span>
                            <span class="text-lg font-black">{{ $shifts->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-white/10">
                            <span class="text-sm font-medium opacity-80">Rating Rata-rata</span>
                            <span class="text-lg font-black">4.8 / 5.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Shift History -->
            <div class="lg:col-span-2">
                <div class="premium-card overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="text-xl font-black text-slate-900">Riwayat Shift Terakhir</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Durasi</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Omzet</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($shifts as $shift)
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-10 py-6">
                                        <p class="text-sm font-black text-slate-900 leading-none mb-1">{{ $shift->start_time->format('d M Y') }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $shift->start_time->format('H:i') }} - {{ $shift->end_time ? $shift->end_time->format('H:i') : 'Aktif' }}</p>
                                    </td>
                                    <td class="px-10 py-6 text-sm font-bold text-slate-500">
                                        @if($shift->end_time)
                                            {{ $shift->start_time->diff($shift->end_time)->format('%h jam %i menit') }}
                                        @else
                                            Ongoing
                                        @endif
                                    </td>
                                    <td class="px-10 py-6 text-sm font-black text-slate-900">Rp {{ number_format($shift->total_revenue, 0, ',', '.') }}</td>
                                    <td class="px-10 py-6 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            @php
                                                $statusClass = 'bg-slate-100 text-slate-500';
                                                $statusText = 'Offline';

                                                if (!$shift->end_time) {
                                                    $statusClass = 'bg-blue-50 text-blue-600';
                                                    $statusText = 'Aktif (Ongoing)';
                                                } elseif (!$shift->approved_at) {
                                                    $statusClass = 'bg-amber-50 text-amber-600';
                                                    $statusText = 'Pending Audit';
                                                } else {
                                                    $statusClass = 'bg-emerald-50 text-emerald-600';
                                                    $statusText = 'Verified';
                                                }
                                            @endphp

                                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>

                                            @if($shift->end_time && !$shift->approved_at)
                                                <form action="{{ route('manager.audit.approve', $shift->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-1.5 bg-primary text-white text-[9px] font-black uppercase tracking-widest rounded-full hover:bg-slate-900 transition-all shadow-lg shadow-primary/20">
                                                        Verify
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-20 text-center text-slate-400 font-bold italic">Belum ada riwayat shift.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

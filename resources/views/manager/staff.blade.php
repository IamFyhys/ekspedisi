<x-admin-layout>
    @section('title_breadcrumb', 'Manajemen Staff')

    <div class="space-y-8 animate-reveal">
        <!-- Header & Stats -->
        <div class="flex flex-col gap-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-1">Direktori Staff</h1>
                    <p class="text-sm font-medium text-slate-500">Monitor personil dan status operasional di <span class="text-primary">{{ Auth::user()->branch->name }}</span></p>
                </div>
                
                <div class="flex p-1 bg-slate-100 rounded-xl w-fit">
                    <a href="{{ route('manager.staff') }}" class="px-5 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ !request('role') ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Semua</a>
                    <a href="{{ route('manager.staff', ['role' => 'cashier']) }}" class="px-5 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ request('role') == 'cashier' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Kasir</a>
                    <a href="{{ route('manager.staff', ['role' => 'courier']) }}" class="px-5 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ request('role') == 'courier' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Kurir</a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 bg-blue-50 text-primary rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-900 leading-none">{{ $stats['total'] }}</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Total Staff</div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-900 leading-none">{{ $stats['cashier'] }}</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kasir Aktif</div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-slate-900 leading-none">{{ $stats['courier'] }}</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kurir Lapangan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($staffs as $staff)
            <div class="bg-white rounded-3xl border border-slate-100 p-6 hover:shadow-xl hover:shadow-slate-200/50 transition-all group relative overflow-hidden">
                <!-- Status Glow -->
                <div class="absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16 bg-gradient-to-br {{ $staff->is_online ? 'from-emerald-400/20 to-transparent' : 'from-slate-400/10 to-transparent' }} rounded-full blur-2xl"></div>

                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-lg font-black shadow-lg shadow-slate-900/20">
                            {{ strtoupper(substr($staff->name, 0, 1)) }}{{ strtoupper(substr(strrchr($staff->name, " ") ?: '', 1, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 leading-tight group-hover:text-primary transition-colors">{{ $staff->name }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $staff->role) }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="text-[10px] font-bold text-slate-400">{{ $staff->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end gap-2">
                        @if($staff->is_online)
                            <span class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[9px] font-black uppercase tracking-widest animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                {{ $staff->status_label }}
                            </span>
                        @else
                            <span class="flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[9px] font-black uppercase tracking-widest">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Offline
                            </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3 text-sm text-slate-600">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <span class="font-bold">{{ $staff->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="font-medium text-[11px]">Terakhir aktif: {{ $staff->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-50">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $staff->phone) }}" target="_blank" class="flex items-center justify-center gap-2 py-3 bg-emerald-50 text-emerald-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    <a href="{{ route('manager.staff.show', $staff->id) }}" class="flex items-center justify-center py-3 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary transition-all">
                        Performa
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-slate-900 font-black">Tidak ada staff</h3>
                <p class="text-slate-500 text-sm">Tidak ada personil yang ditemukan untuk kriteria ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-admin-layout>

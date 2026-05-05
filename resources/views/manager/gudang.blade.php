<x-admin-layout>
    @section('title_breadcrumb', 'Monitoring Gudang')
    <div class="space-y-10 animate-reveal" x-data="{ openAssign: false, selectedPkg: null }">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Monitoring <span class="text-primary">Gudang</span></h1>
                <p class="text-slate-500 font-medium">Monitoring paket yang berada di gudang atau menunggu kurir.</p>
            </div>
        </div>

        <!-- Table Container -->
        <div class="premium-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">No Resi</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tujuan</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lama Tertahan</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($packages as $pkg)
                        <tr class="hover:bg-slate-50/30 transition-colors {{ $pkg->lama_tertahan > 2 ? 'bg-rose-50' : '' }}">
                            <td class="px-8 py-6 text-sm font-black text-slate-900 tracking-tight">{{ $pkg->tracking_number }}</td>
                            <td class="px-8 py-6 text-sm font-medium text-slate-600 truncate max-w-[200px]">{{ $pkg->receiver_address }}</td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold {{ $pkg->lama_tertahan > 2 ? 'text-rose-600' : 'text-slate-700' }}">
                                    {{ $pkg->lama_tertahan }} hari
                                    @if($pkg->lama_tertahan > 2)
                                        <span class="ml-2">⚠️</span>
                                    @endif
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                                    {{ $pkg->status === 'tertahan' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ str_replace('_', ' ', $pkg->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button @click="selectedPkg = {{ $pkg->id }}; openAssign = true" class="px-6 py-2.5 bg-primary text-white text-[9px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-primary/20 hover:scale-105 transition-all">Tugaskan Kurir</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Gudang kosong. Semua paket telah diproses.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Assign Modal -->
        <div x-show="openAssign" class="fixed inset-0 z-50 flex items-center justify-center p-8 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div class="bg-white rounded-[2.5rem] w-full max-w-lg p-12 shadow-2xl space-y-8 animate-reveal" @click.away="openAssign = false">
                <h3 class="text-2xl font-black text-slate-900">Tugaskan Kurir</h3>
                <form action="{{ route('manager.assign-courier') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="shipment_id" :value="selectedPkg">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Kurir Tersedia</label>
                        <select name="courier_id" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all font-bold text-sm">
                            @foreach($couriers as $courier)
                            <option value="{{ $courier->id }}">{{ $courier->name }} ({{ str_replace('_', ' ', $courier->role) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <button type="button" @click="openAssign = false" class="py-4 bg-slate-100 text-slate-600 font-black rounded-2xl uppercase tracking-widest text-[10px]">Batal</button>
                        <button type="submit" class="py-4 bg-primary text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px]">Tugaskan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

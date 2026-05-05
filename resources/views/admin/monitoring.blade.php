<x-admin-layout>
    @section('title_breadcrumb', 'Global Monitoring')
    
    <div class="space-y-8 animate-reveal" x-data="adminMonitoring()">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Global <span class="text-primary">Monitoring</span></h1>
                <p class="text-slate-500 font-medium text-sm">Pantau dan kelola stok gudang di seluruh cabang ekspedisi.</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="premium-card bg-white p-6 border border-slate-100 shadow-sm">
            <form action="{{ route('admin.monitoring') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih Cabang</label>
                    <select name="branch_id" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-4 focus:ring-primary/10 transition-all cursor-pointer">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status Paket</label>
                    <select name="status" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-4 focus:ring-primary/10 transition-all cursor-pointer">
                        <option value="">Semua Status Gudang</option>
                        <option value="ready_to_ship" {{ request('status') == 'ready_to_ship' ? 'selected' : '' }}>Ready to Ship</option>
                        <option value="arrived_at_hub" {{ request('status') == 'arrived_at_hub' ? 'selected' : '' }}>Arrived at Hub</option>
                        <option value="returned_to_warehouse" {{ request('status') == 'returned_to_warehouse' ? 'selected' : '' }}>Returned</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Filter Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="premium-card overflow-hidden bg-white border border-slate-100 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Resi & Lokasi Saat Ini</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rute</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lama di Gudang</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($packages as $pkg)
                        <tr class="group hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900 tracking-tight">{{ $pkg->tracking_number }}</span>
                                    <span class="inline-flex items-center gap-1.5 mt-1">
                                        <div class="w-1.5 h-1.5 rounded-full bg-primary"></div>
                                        <span class="text-[11px] font-bold text-primary uppercase tracking-wider">{{ $pkg->branch->name ?? 'Unknown' }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase">{{ $pkg->originLocation->name ?? '-' }}</span>
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                    <span class="text-[11px] font-bold text-slate-900 uppercase">{{ $pkg->destinationLocation->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-slate-700">{{ (int) $pkg->created_at->diffInDays(now()) }} Hari</span>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusColors = [
                                        'ready_to_ship' => 'bg-indigo-50 text-indigo-600',
                                        'arrived_at_hub' => 'bg-emerald-50 text-emerald-600',
                                        'returned_to_warehouse' => 'bg-amber-50 text-amber-600',
                                        'tertahan' => 'bg-rose-50 text-rose-600',
                                    ];
                                    $colorClass = $statusColors[$pkg->status] ?? 'bg-slate-50 text-slate-500';
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $colorClass }}">
                                    {{ str_replace('_', ' ', $pkg->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button @click="openAssignModal({{ $pkg->id }}, '{{ $pkg->tracking_number }}', {{ $pkg->branch_id }}, '{{ $pkg->branch->name }}')" 
                                    class="px-5 py-2.5 bg-primary hover:bg-primary/90 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-primary/10">
                                    Tugaskan Kurir
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Tidak ada paket yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($packages->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
                {{ $packages->links() }}
            </div>
            @endif
        </div>

        <!-- Assign Courier Modal -->
        <div x-show="showAssignModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div class="premium-card shadow-2xl w-full max-w-sm overflow-hidden" @click.away="showAssignModal = false">
                <form action="{{ route('admin.assign-courier') }}" method="POST" class="p-8">
                    @csrf
                    <input type="hidden" name="shipment_id" :value="modalData.shipment_id">
                    
                    <div class="mb-6">
                        <h3 class="text-xl font-black text-slate-900">Tugaskan Kurir</h3>
                        <p class="text-xs text-slate-500 mt-1">Mengatur pengiriman untuk resi <span class="text-primary font-bold" x-text="modalData.resi"></span></p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="p-4 bg-blue-50 rounded-xl">
                            <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-1">Cabang Saat Ini</p>
                            <p class="text-sm font-bold text-slate-700" x-text="modalData.branch_name"></p>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 block mb-2">Pilih Kurir di Cabang Ini</label>
                            <select name="courier_id" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" required>
                                <option value="">Pilih Kurir...</option>
                                <template x-for="courier in getCouriers(modalData.branch_id)" :key="courier.id">
                                    <option :value="courier.id" x-text="courier.name + ' (' + courier.role + ')'"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" @click="showAssignModal = false" class="py-3 font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 rounded-xl shadow-lg shadow-primary/20 transition-all">Tugaskan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function adminMonitoring() {
            return {
                showAssignModal: false,
                modalData: {
                    shipment_id: '',
                    resi: '',
                    branch_id: '',
                    branch_name: ''
                },
                couriers: @json($couriersByBranch),
                openAssignModal(id, resi, branchId, branchName) {
                    this.modalData = {
                        shipment_id: id,
                        resi: resi,
                        branch_id: branchId,
                        branch_name: branchName
                    };
                    this.showAssignModal = true;
                },
                getCouriers(branchId) {
                    return this.couriers[branchId] || [];
                }
            }
        }
    </script>
</x-admin-layout>

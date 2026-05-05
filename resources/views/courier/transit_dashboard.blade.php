<x-admin-layout>
    <div class="space-y-10" x-data="{ 
        tab: 'active',
        modalOpen: false,
        selectedShipment: null,
        shipments: @js($shipments),
        completed: @js($completedShipments),

        openTransit(id) {
            this.selectedShipment = this.shipments.find(s => s.id === id);
            this.modalOpen = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div data-aos="fade-right">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Transit <span class="text-indigo-600">Hub Management</span></h1>
                <p class="text-slate-500 font-medium mt-1">Operational center for inter-branch logistics.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-100 rounded-2xl text-xs font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                    Scan Manifes
                </button>
                <div class="h-10 w-[1px] bg-slate-200 mx-2"></div>
                <div class="flex flex-col text-right">
                    <span class="text-[10px] font-black text-slate-400 uppercase">Current Branch</span>
                    <span class="text-sm font-black text-indigo-600">{{ Auth::user()->branch->name ?? 'Hub Jakarta' }}</span>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6" data-aos="fade-up">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V4" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Tasks</p>
                        <h4 class="text-2xl font-black text-slate-900">{{ $stats['active_count'] }} <span class="text-xs text-slate-400 font-bold ml-1">Items</span></h4>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Weight</p>
                        <h4 class="text-2xl font-black text-slate-900">{{ number_format($stats['total_weight'], 1) }} <span class="text-xs text-slate-400 font-bold ml-1">KG</span></h4>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Est. Trip Time</p>
                        <h4 class="text-2xl font-black text-slate-900">4.5 <span class="text-xs text-slate-400 font-bold ml-1">Hours</span></h4>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Priority Items</p>
                        <h4 class="text-2xl font-black text-slate-900">3 <span class="text-xs text-slate-400 font-bold ml-1">Express</span></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content (Tabs) -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="px-8 pt-8 flex justify-between items-end border-b border-slate-50">
                <div class="flex gap-8">
                    <button @click="tab = 'active'" class="pb-6 text-sm font-black uppercase tracking-widest transition-all relative" :class="tab === 'active' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600'">
                        Active Transits
                        <div x-show="tab === 'active'" class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div>
                    </button>
                    <button @click="tab = 'history'" class="pb-6 text-sm font-black uppercase tracking-widest transition-all relative" :class="tab === 'history' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600'">
                        History ({{ $stats['completed_count'] }})
                        <div x-show="tab === 'history'" class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div>
                    </button>
                </div>
            </div>

            <!-- Active Table -->
            <div x-show="tab === 'active'" class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-6">Shipment ID</th>
                            <th class="px-8 py-6">Route (Destination Hub)</th>
                            <th class="px-8 py-6 text-center">Payload</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($shipments as $shipment)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-900">{{ $shipment->tracking_number }}</span>
                                    <span class="text-[10px] font-bold text-slate-400">Created: {{ $shipment->created_at->format('d M H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="shrink-0 w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-indigo-600 uppercase tracking-tight">{{ $shipment->destinationBranch->name ?? 'N/A' }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 italic">Via Truck #{{ rand(10, 99) }}-TRK</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs font-black text-slate-700">{{ number_format($shipment->total_weight / 1000, 1) }} KG</span>
                                    <span class="text-[10px] font-bold text-slate-400">1 Item</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $shipment->status === 'processed' ? 'bg-amber-500' : 'bg-indigo-500 animate-pulse' }}"></span>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">
                                        {{ str_replace('_', ' ', $shipment->status) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <button @click="openTransit({{ $shipment->id }})" class="px-6 py-2.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                    Update Status
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center opacity-30">
                                    <svg class="w-16 h-16 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    <p class="font-black text-slate-500 uppercase tracking-widest">No Active Transits</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- History Table -->
            <div x-show="tab === 'history'" class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-6">Tracking Number</th>
                            <th class="px-8 py-6">Arrived At</th>
                            <th class="px-8 py-6">Weight</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6">Final Hub</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($completedShipments as $shipment)
                        <tr class="opacity-70 grayscale-[0.5] hover:grayscale-0 transition-all">
                            <td class="px-8 py-6 font-black text-slate-900">{{ $shipment->tracking_number }}</td>
                            <td class="px-8 py-6 text-xs font-bold text-slate-500">{{ $shipment->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="px-8 py-6 text-xs font-black text-slate-700">{{ number_format($shipment->total_weight / 1000, 1) }} KG</td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase">Arrived</span>
                            </td>
                            <td class="px-8 py-6 text-xs font-black text-indigo-600 uppercase">{{ $shipment->destinationBranch->name ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Transit Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-md" x-cloak x-transition>
            <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100" @click.away="modalOpen = false">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-indigo-600">
                    <div class="flex flex-col">
                        <h3 class="text-white font-black uppercase tracking-widest text-xs">Update Transit Flow</h3>
                        <p class="text-indigo-200 text-[10px] font-bold" x-text="'Tracking: ' + selectedShipment?.tracking_number"></p>
                    </div>
                    <button @click="modalOpen = false" class="p-2 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>
                <form :action="`/courier/shipments/${selectedShipment?.id}/transit-update`" method="POST" class="p-8 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 italic">Pilih Tahapan Saat Ini:</label>
                        <select name="status" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none text-xs font-black text-slate-700 focus:ring-4 focus:ring-indigo-600/10 transition-all shadow-inner">
                            <template x-if="selectedShipment?.status === 'processed'">
                                <option value="in_transit">🚚 BERANGKAT (Keluar dari Hub Asal)</option>
                            </template>
                            <template x-if="selectedShipment?.status === 'in_transit'">
                                <option value="arrived_at_destination">🏢 TIBA (Masuk Hub Tujuan)</option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Manifes / Catatan</label>
                        <textarea name="notes" rows="2" placeholder="Contoh: Truck-01 via Tol Cipali..." class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-none text-xs font-medium text-slate-700 focus:ring-4 focus:ring-indigo-600/10 transition-all shadow-inner"></textarea>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-2xl flex items-start gap-3">
                        <svg class="w-5 h-5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-[10px] font-bold text-indigo-600 leading-relaxed">Pastikan paket sudah sesuai dengan manifes sebelum melakukan update status perjalanan.</p>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-100 hover:scale-[1.02] transition-all text-xs uppercase tracking-widest">Konfirmasi Update</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

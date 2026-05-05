<x-admin-layout>
    @section('title_breadcrumb', 'Courier Task Dashboard')

    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 50%, 90% { transform: translateX(-6px); }
            30%, 70% { transform: translateX(6px); }
        }
        @keyframes countPop {
            0% { transform: scale(1); }
            40% { transform: scale(1.4); }
            100% { transform: scale(1); }
        }
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateY(0); }
            to   { opacity: 0; transform: translateY(-20px); }
        }
        .failed-card-shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
        .failed-count-pop  { animation: countPop 0.4s ease-out both; }
        .toast-in  { animation: toastSlideIn 0.35s ease forwards; }
        .toast-out { animation: toastSlideOut 0.35s ease forwards; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        [x-cloak] { display: none !important; }
        .premium-card { border-radius: 24px; transition: all 0.3s ease; }
        
        /* Modal Scroll Fix */
        .modal-container { 
            max-height: 90vh; 
            overflow-y: auto; 
            scrollbar-width: thin;
        }
        .modal-container::-webkit-scrollbar { width: 6px; }
        .modal-container::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
    @endpush

    <div x-data="deliveryDashboard()">
        <!-- Toast Container -->
        <div id="toast-container" style="position:fixed;top:80px;left:50%;transform:translateX(-50%);z-index:9999;display:flex;flex-direction:column;align-items:center;gap:10px;min-width:320px;"></div>



        <div class="space-y-8 animate-reveal">

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="premium-card p-7 bg-white border border-slate-100 shadow-sm">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Tugas</p>
                <h3 class="text-3xl font-black text-slate-900"><span x-text="totalCount">{{ $stats['total'] }}</span> <span class="text-xs text-slate-400 font-bold">tugas</span></h3>
            </div>
            <div class="premium-card p-7 bg-white border border-emerald-100 shadow-sm">
                <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest mb-2">✓ Selesai</p>
                <h3 class="text-3xl font-black text-emerald-600" x-text="successCount">{{ $stats['success'] }}</h3>
            </div>
            <!-- Card Gagal -->
            <div id="failed-card" class="premium-card p-7 bg-white border-2 transition-all duration-300 shadow-sm" :class="failedCount > 0 ? 'border-rose-300 shadow-rose-100 shadow-lg' : 'border-rose-100'">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[9px] font-black text-rose-400 uppercase tracking-widest">✗ Gagal (Delivery)</p>
                    <span x-show="failedCount > 0" x-text="failedCount" class="inline-flex items-center justify-center w-5 h-5 text-[9px] font-black bg-rose-500 text-white rounded-full"></span>
                </div>
                <h3 id="failed-count-el" class="text-3xl font-black text-rose-600" x-text="failedCount">{{ $stats['failed'] }}</h3>
            </div>
            <!-- Card Sisa -->
            <div class="premium-card p-7 shadow-xl shadow-blue-900/20" style="background-color: #185FA5 !important; color: white !important;">
                <p class="text-[9px] font-black uppercase tracking-widest mb-2" style="color: rgba(255,255,255,0.7) !important;">Sisa Tugas</p>
                <h3 class="text-3xl font-black"><span x-text="remainingCount">{{ $stats['remaining'] }}</span></h3>
            </div>
        </div>

        <!-- Section Ringkasan Paket Gagal -->
        <div x-show="failedList.length > 0" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="premium-card bg-white border-2 border-rose-200 overflow-hidden">
            <div class="px-8 py-5 bg-rose-50 border-b border-rose-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-rose-700">Paket Gagal Dikirim</h3>
                        <p class="text-[10px] font-bold text-rose-400">Perlu tindak lanjut — <span x-text="failedList.length"></span> paket</p>
                    </div>
                </div>
            </div>
            <div class="divide-y divide-slate-50">
                <template x-for="(item, i) in failedList" :key="i">
                    <div class="flex items-start gap-5 px-8 py-6">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-black text-slate-900" x-text="item.name"></p>
                            <p class="text-xs font-medium text-slate-400 mt-0.5 truncate" x-text="item.address"></p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-2 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-lg uppercase tracking-widest" x-text="item.reason"></span>
                                <span class="text-[9px] text-slate-400 font-bold" x-text="item.time"></span>
                            </div>
                        </div>
                        <button @click="cobaLagi(item.id, item.name)" class="px-5 py-3 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary/90 transition-all">
                            Coba Lagi
                        </button>
                    </div>
                </template>
            </div>
        </div>


        
        <!-- Unified Task Section -->
        <div class="mb-12">
            <div class="premium-card bg-white border border-slate-100 overflow-hidden shadow-sm">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Daftar Tugas Hari Ini</h3>
                        <p class="text-xs font-bold text-slate-400 mt-1">Daftar gabungan paket untuk diantar (Delivery) dan dijemput (Pickup).</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="min-w-[700px] sm:min-w-0">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-4 sm:px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                                    <th class="px-4 sm:px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kontak & Alamat</th>
                                    <th class="px-4 sm:px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail</th>
                                    <th class="px-4 sm:px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <!-- 1. Delivery Rows -->
                                @foreach($deliveries as $dl)
                                <tr class="hover:bg-slate-50/30 transition-colors" data-shipment-id="{{ $dl->id }}">
                                    <td class="px-4 sm:px-8 py-7">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg uppercase tracking-widest">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                            ANTAR
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-8 py-7">
                                        <div class="space-y-1">
                                            <p class="text-sm font-black text-slate-900">{{ $dl->receiver_name }}</p>
                                            <p class="text-xs font-bold text-slate-500 leading-relaxed max-w-[200px] sm:max-w-xs">{{ $dl->receiver_address }}</p>
                                            <div class="flex items-center gap-3 pt-1">
                                                <a href="tel:{{ $dl->receiver_phone }}" class="text-[10px] font-bold text-slate-400 hover:text-primary">📞 {{ $dl->receiver_phone }}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-8 py-7">
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-black text-primary uppercase tracking-widest">{{ $dl->tracking_number }}</p>
                                            @if($dl->payment_method === 'cod')
                                            <span class="text-[9px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded">COD: Rp {{ number_format($dl->total_price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-8 py-7 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button @click="openMap(@js($dl->receiver_name), @js($dl->receiver_address), @js($dl->dest_lat), @js($dl->dest_lng))"
                                                class="p-2 sm:p-3 bg-slate-100 text-slate-600 rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </button>
                                            <button @click="selectedId = {{ $dl->id }}; showConfirm = true"
                                                class="px-3 sm:px-5 py-3 bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                                                ✓ Selesai
                                            </button>
                                            <button @click="openFailedModal({{ $dl->id }}, @js($dl->receiver_name), @js($dl->receiver_address))"
                                                class="px-3 sm:px-5 py-3 bg-rose-500 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-rose-600 transition-all shadow-lg shadow-rose-500/20">
                                                Gagal
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
    
                                <!-- 2. Pickup Rows -->
                                @foreach($pickups as $p)
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-4 sm:px-8 py-7">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg uppercase tracking-widest">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                            JEMPUT
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-8 py-7">
                                        <div class="space-y-1">
                                            <p class="text-sm font-black text-slate-900">{{ $p->sender_name }}</p>
                                            <p class="text-xs font-bold text-slate-500 leading-relaxed max-w-[200px] sm:max-w-xs">{{ $p->sender_address }}</p>
                                            <div class="flex items-center gap-3 pt-1">
                                                <a href="tel:{{ $p->sender_phone }}" class="text-[10px] font-bold text-slate-400 hover:text-primary">📞 {{ $p->sender_phone }}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-8 py-7">
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">#{{ $p->pickup_code }}</p>
                                            <p class="text-[9px] font-bold text-slate-400">{{ $p->goods_type }} (est. {{ $p->estimated_weight }}kg)</p>
                                            <p class="text-[9px] font-black text-slate-600">🕒 {{ $p->pickup_time }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-8 py-7 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button @click="openMap(@js($p->sender_name), @js($p->sender_address), @js($p->sender_lat), @js($p->sender_lng))"
                                                class="p-2 sm:p-3 bg-slate-100 text-slate-600 rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </button>
                                            @if($p->status === 'pending')
                                            <button @click="acceptPickup({{ $p->id }})"
                                                class="px-3 sm:px-5 py-3 bg-primary text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                                                Terima Tugas
                                            </button>
                                            @elseif($p->status === 'assigned_pickup' || $p->status === 'on_the_way')
                                            <button @click="openPickupModal({{ $p->id }}, @js($p->sender_name))"
                                                class="px-3 sm:px-5 py-3 bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                                                Ambil Paket
                                            </button>
                                            @elseif($p->status === 'picked_up')
                                            <button @click="confirmPickupArrival({{ $p->id }})"
                                                class="px-3 sm:px-5 py-3 bg-primary text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                                                Sampai Gudang
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
    
                                @if($deliveries->isEmpty() && $pickups->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-10 py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <p class="font-black text-slate-500">Tidak ada tugas hari ini.</p>
                                            <p class="text-sm text-slate-400 font-medium">Semua pengantaran dan penjemputan selesai 🎉</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div> {{-- End of animate-reveal --}}

        <!-- MODAL OVERLAYS (Moved to end and set to highest z-index) -->
        <div class="relative z-[99999]">
            <!-- Route Map Modal -->
            <div x-show="showMap" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 sm:p-6 bg-slate-900/80 backdrop-blur-md overflow-y-auto" x-cloak>
                <div x-show="showMap"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="bg-white rounded-2xl w-full max-w-4xl shadow-2xl flex flex-col overflow-hidden border border-slate-100 my-auto" 
                     @click.away="showMap = false">
                    
                    <!-- Header -->
                    <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-white sticky top-0 z-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-primary/5 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900" x-text="mapRecipientName"></h3>
                                <p class="text-xs font-bold text-slate-400 mt-0.5" x-text="mapAddress"></p>
                            </div>
                        </div>
                        <button @click="showMap = false" class="w-10 h-10 rounded-full hover:bg-slate-50 flex items-center justify-center transition-colors text-slate-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <!-- Map Container -->
                    <div class="relative h-[400px] sm:h-[500px] bg-slate-50">
                        <div id="deliveryMap" class="absolute inset-0 z-0"></div>
                        
                        <!-- Route Info Floating Card -->
                        <div class="absolute bottom-6 left-6 right-6 z-10 flex flex-col sm:flex-row gap-3">
                            <div class="flex-1 flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-white/90 backdrop-blur-md shadow-lg shadow-slate-200/50">
                                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jarak</p>
                                    <p class="text-lg font-bold text-slate-900 mt-0.5" x-text="routeData.distance"></p>
                                </div>
                            </div>
                            <div class="flex-1 flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-white/90 backdrop-blur-md shadow-lg shadow-slate-200/50">
                                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Estimasi</p>
                                    <p class="text-lg font-bold text-slate-900 mt-0.5" x-text="routeData.duration"></p>
                                </div>
                            </div>
                            <div class="flex-1 flex items-center gap-2">
                                 <a :href="'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(mapAddress)" target="_blank"
                                    class="w-full py-4 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Confirm Pickup Modal -->
            <div x-show="showPickupConfirm" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-md overflow-y-auto" x-cloak>
                <div x-show="showPickupConfirm"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="bg-white rounded-[2.5rem] w-full max-w-lg p-10 shadow-2xl space-y-6 my-auto modal-container" @click.away="showPickupConfirm = false">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900" x-text="'Jemput Paket: ' + pickupData.senderName"></h3>
                        <p class="text-sm text-slate-400 font-medium mt-1">Lengkapi data penjemputan paket.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Berat Aktual (Kg) *</label>
                            <input type="number" x-model="pickupData.actualWeight" step="0.1" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none font-black text-lg text-primary focus:ring-2 focus:ring-primary transition-all" placeholder="0.0">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Foto Bukti Pickup *</label>
                            <label class="flex items-center justify-center gap-3 w-full px-6 py-5 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 cursor-pointer hover:border-primary hover:bg-blue-50/20 transition-all">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span class="text-sm font-bold text-slate-500" x-text="pickupData.photoName || 'Ambil foto paket...'"></span>
                                <input type="file" accept="image/*" @change="handlePickupFile($event)" class="hidden">
                            </label>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Catatan (Opsional)</label>
                            <textarea x-model="pickupData.note" rows="2" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none font-medium text-sm focus:ring-2 focus:ring-primary transition-all" placeholder="Contoh: Paket pecah belah, butuh bubble wrap..."></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <button type="button" @click="showPickupConfirm = false" :disabled="isSubmitting" class="py-4 bg-slate-100 text-slate-600 font-black rounded-2xl uppercase tracking-widest text-[10px] hover:bg-slate-200 transition-all">Batal</button>
                        <button type="button" @click="submitPickup" :disabled="!pickupData.actualWeight || !pickupData.photo || isSubmitting" class="py-4 bg-emerald-500 disabled:opacity-50 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] hover:bg-emerald-600 transition-all flex items-center justify-center gap-2">
                            <template x-if="isSubmitting">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </template>
                            <span x-text="isSubmitting ? 'Memproses...' : 'Konfirmasi Pickup'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Confirm Success Modal -->
            <div x-show="showConfirm" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-md overflow-y-auto" x-cloak>
                <div x-show="showConfirm"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="bg-white rounded-[2.5rem] w-full max-w-lg p-10 shadow-2xl space-y-6 my-auto modal-container" @click.away="showConfirm = false">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900">Konfirmasi Terima Paket</h3>
                        <p class="text-sm text-slate-400 font-medium mt-1">Lengkapi data penerimaan paket.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Diterima Oleh *</label>
                            <input type="text" x-model="successData.receivedBy" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none font-medium text-sm focus:ring-2 focus:ring-emerald-400 transition-all" placeholder="Nama Penerima">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Hubungan *</label>
                            <select x-model="successData.relation" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none font-medium text-sm focus:ring-2 focus:ring-emerald-400 transition-all">
                                <option value="">Pilih Hubungan</option>
                                <option value="Diri Sendiri">Diri Sendiri</option>
                                <option value="Keluarga">Keluarga</option>
                                <option value="Tetangga">Tetangga</option>
                                <option value="Staff/Karyawan">Staff/Karyawan</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Catatan</label>
                        <textarea x-model="successData.note" rows="2" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none font-medium text-sm focus:ring-2 focus:ring-emerald-400 transition-all" placeholder="Catatan tambahan..."></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Foto Bukti Diterima *</label>
                        <label class="flex items-center justify-center gap-3 w-full px-6 py-5 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/20 transition-all">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span class="text-sm font-bold text-slate-500" x-text="successData.photoName || 'Pilih foto...'"></span>
                            <input type="file" accept="image/*" @change="handleFile($event)" class="hidden">
                        </label>
                        <div x-show="successData.photoPreview" class="mt-2">
                            <img :src="successData.photoPreview" class="h-32 rounded-xl object-cover w-full">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanda Tangan Digital *</label>
                            <button type="button" @click="clearSignature" class="text-[9px] font-bold text-rose-500 uppercase">Hapus</button>
                        </div>
                        <div class="bg-slate-50 border-2 border-slate-100 rounded-2xl overflow-hidden">
                            <canvas id="signature-pad" class="w-full h-32"></canvas>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <button type="button" @click="showConfirm = false" :disabled="isSubmitting" class="py-4 bg-slate-100 text-slate-600 font-black rounded-2xl uppercase tracking-widest text-[10px] hover:bg-slate-200 transition-all">Batal</button>
                        <button type="button" @click="submitSuccess" :disabled="!successData.photo || !successData.receivedBy || isSubmitting" class="py-4 bg-emerald-500 disabled:opacity-50 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] hover:bg-emerald-600 transition-all flex items-center justify-center gap-2">
                            <template x-if="isSubmitting">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </template>
                            <span x-text="isSubmitting ? 'Memproses...' : 'Konfirmasi Terima'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Failed Modal -->
            <div x-show="showFailed" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-md overflow-y-auto" x-cloak>
                <div x-show="showFailed"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="bg-white rounded-[2.5rem] w-full max-w-lg p-10 shadow-2xl space-y-6 my-auto modal-container" @click.away="showFailed = false">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900">Laporan Gagal Kirim</h3>
                        <p class="text-sm text-slate-400 font-medium mt-1">Pilih alasan dan upload foto bukti lokasi.</p>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alasan Gagal *</label>
                        <div class="grid grid-cols-1 gap-2">
                            @foreach(['Rumah Kosong' => 'Rumah Kosong', 'Alamat Tidak Ditemukan' => 'Alamat Tidak Ditemukan', 'Penerima Menolak' => 'Penerima Menolak', 'HP Tidak Aktif' => 'HP Tidak Aktif'] as $val => $label)
                            <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all" :class="failedData.reason === '{{ $val }}' ? 'ring-2 ring-rose-400 bg-rose-50' : ''">
                                <input type="radio" x-model="failedData.reason" value="{{ $val }}" class="w-4 h-4 text-rose-500">
                                <span class="text-sm font-bold text-slate-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Catatan Tambahan</label>
                        <textarea x-model="failedData.note" rows="2" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none font-medium text-sm focus:ring-2 focus:ring-rose-400 transition-all" placeholder="Detail lainnya..."></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Foto Bukti Lokasi *</label>
                        <label class="flex items-center justify-center gap-3 w-full px-6 py-5 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 cursor-pointer hover:border-rose-400 hover:bg-rose-50/20 transition-all">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span class="text-sm font-bold text-slate-500" x-text="failedData.photoName || 'Pilih foto...'"></span>
                            <input type="file" accept="image/*" @change="handleFailedFile($event)" class="hidden">
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <button type="button" @click="showFailed = false" :disabled="isSubmitting" class="py-4 bg-slate-100 text-slate-600 font-black rounded-2xl uppercase tracking-widest text-[10px] hover:bg-slate-200 transition-all">Batal</button>
                        <button type="button" @click="submitFailed" :disabled="!failedData.reason || !failedData.photo || isSubmitting" class="py-4 bg-rose-500 disabled:opacity-50 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] hover:bg-rose-600 transition-all flex items-center justify-center gap-2">
                            <template x-if="isSubmitting">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </template>
                            <span x-text="isSubmitting ? 'Memproses...' : 'Laporkan Gagal'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        </div>
        {{-- Modal Coba Lagi --}}
        <div id="modalCobaLagi" class="fixed inset-0 z-[99999] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6" style="display: none;">
            <div class="bg-white rounded-3xl w-full max-w-sm p-8 shadow-2xl space-y-6">
                <input type="hidden" id="cobaLagiId">
                <div>
                    <h3 class="text-xl font-black text-slate-900">Tindak Lanjut Paket</h3>
                    <p class="text-xs font-bold text-slate-400 mt-1" id="cobaLagiName"></p>
                </div>
                <div class="space-y-3">
                    <button onclick="submitCobaLagi('retry', event)" class="w-full py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 uppercase tracking-widest text-[10px] hover:bg-primary/90 transition-all flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Kirim Ulang
                    </button>
                    <button onclick="submitCobaLagi('return', event)" class="w-full py-4 bg-slate-800 text-white font-black rounded-2xl shadow-xl shadow-slate-800/20 uppercase tracking-widest text-[10px] hover:bg-slate-900 transition-all flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"/></svg>
                        Retur ke Gudang
                    </button>
                    <button onclick="closeCobaLagi()" class="w-full py-4 bg-slate-100 text-slate-500 font-black rounded-2xl uppercase tracking-widest text-[10px] hover:bg-slate-200 transition-all">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div> {{-- End of x-data --}}

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        function deliveryDashboard() {
            return {
                showMap: false,
                showConfirm: false,
                showFailed: false,
                showPickupConfirm: false,
                selectedId: null,
                selectedRecipientName: '',
                selectedAddress: '',
                mapRecipientName: '',
                mapAddress: '',
                routeData: { distance: '-', duration: '-' },
                routeLayer: null,
                startMarker: null,
                endMarker: null,
                map: null,
                isSubmitting: false,

                // Stats & Data
                totalCount: {{ $stats['total'] }},
                successCount: {{ $stats['success'] }},
                failedCount: {{ $stats['failed'] }},
                remainingCount: {{ $stats['remaining'] }},
                failedList: @json($failedDeliveries),
                
                // Form Data
                successData: { photo: null, photoName: '', photoPreview: '', receivedBy: '', relation: '', note: '' },
                failedData: { reason: '', photo: null, photoName: '', note: '' },
                pickupData: { id: null, senderName: '', actualWeight: '', photo: null, photoName: '', note: '' },
                signaturePad: null,

                init() {
                    this.$watch('showConfirm', value => {
                        if (value) {
                            this.$nextTick(() => {
                                const canvas = document.getElementById('signature-pad');
                                if (canvas && typeof SignaturePad !== 'undefined') {
                                    this.signaturePad = new SignaturePad(canvas, {
                                        backgroundColor: 'rgb(248, 250, 252)',
                                        penColor: 'rgb(30, 41, 59)'
                                    });
                                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                                    canvas.width = canvas.offsetWidth * ratio;
                                    canvas.height = canvas.offsetHeight * ratio;
                                    canvas.getContext("2d").scale(ratio, ratio);
                                    this.signaturePad.clear();
                                }
                            });
                        }
                    });
                },

                clearSignature() { if (this.signaturePad) this.signaturePad.clear(); },

                openMap(name, address, lat = null, lng = null) {
                    this.mapRecipientName = name;
                    this.mapAddress = address;
                    this.showMap = true;
                    this.routeData = { distance: '...', duration: '...' };

                    this.$nextTick(() => {
                        if (typeof L === 'undefined') {
                            console.error('Leaflet is not loaded');
                            return;
                        }
                        if (!this.map) {
                            this.map = L.map('deliveryMap', { zoomControl: false }).setView([-6.2088, 106.8456], 13);
                            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(this.map);
                        }

                        const startLat = -6.175110; // Hub/Gudang
                        const startLng = 106.827153;

                        const processRoute = (endLat, endLng) => {
                            fetch(`https://router.project-osrm.org/route/v1/driving/${startLng},${startLat};${endLng},${endLat}?geometries=geojson&overview=full`)
                                .then(res => res.json())
                                .then(data => {
                                    if(data.code === 'Ok') {
                                        const route = data.routes[0];
                                        this.routeData.distance = (route.distance / 1000).toFixed(1) + ' km';
                                        this.routeData.duration = Math.ceil(route.duration / 60) + ' m';
                                        
                                        if (this.routeLayer) this.map.removeLayer(this.routeLayer);
                                        this.routeLayer = L.geoJSON(route.geometry, { style: { color: '#3B82F6', weight: 5 } }).addTo(this.map);
                                        
                                        if (this.startMarker) this.map.removeLayer(this.startMarker);
                                        if (this.endMarker) this.map.removeLayer(this.endMarker);

                                        this.startMarker = L.circleMarker([startLat, startLng], { color: '#10B981', fillOpacity: 1, radius: 8 }).addTo(this.map);
                                        this.endMarker = L.circleMarker([endLat, endLng], { color: '#EF4444', fillOpacity: 1, radius: 8 }).addTo(this.map);
                                        
                                        this.map.fitBounds(this.routeLayer.getBounds(), { padding: [50, 50] });
                                    }
                                });
                            setTimeout(() => this.map.invalidateSize(), 300);
                        };

                        if (lat && lng) {
                            processRoute(parseFloat(lat), parseFloat(lng));
                        } else {
                            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json&limit=1`)
                                .then(r => r.json())
                                .then(data => {
                                    if (data.length > 0) processRoute(parseFloat(data[0].lat), parseFloat(data[0].lon));
                                });
                        }
                    });
                },

                handleFile(e) { 
                    const file = e.target.files[0];
                    if (file) {
                        this.successData.photo = file;
                        this.successData.photoName = file.name;
                        this.successData.photoPreview = URL.createObjectURL(file);
                    }
                },
                handleFailedFile(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.failedData.photo = file;
                        this.failedData.photoName = file.name;
                    }
                },
                handlePickupFile(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.pickupData.photo = file;
                        this.pickupData.photoName = file.name;
                    }
                },

                openPickupModal(id, name) {
                    this.pickupData = { id: id, senderName: name, actualWeight: '', photo: null, photoName: '', note: '' };
                    this.showPickupConfirm = true;
                },

                openFailedModal(id, name, address) {
                    this.selectedId = id;
                    this.selectedRecipientName = name;
                    this.selectedAddress = address;
                    this.showFailed = true;
                },

                acceptPickup(id) {
                    Swal.fire({
                        title: 'Terima Tugas?',
                        text: "Anda akan mengambil tugas penjemputan ini.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Terima'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route("courier.delivery.accept-pickup") }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ pickup_id: id })
                            }).then(r => r.json()).then(data => {
                                if(data.success) {
                                    Swal.fire('Berhasil', data.message, 'success').then(() => location.reload());
                                } else {
                                    Swal.fire('Gagal', data.message, 'error');
                                }
                            });
                        }
                    });
                },

                submitPickup() {
                    if (this.isSubmitting) return;
                    this.isSubmitting = true;
                    let fd = new FormData();
                    fd.append('pickup_id', this.pickupData.id);
                    fd.append('actual_weight', this.pickupData.actualWeight);
                    fd.append('pickup_photo', this.pickupData.photo);
                    fd.append('note', this.pickupData.note);

                    fetch('{{ route("courier.delivery.confirm-pickup") }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: fd
                    }).then(r => r.json()).then(data => {
                        if(data.success) location.reload();
                        else Swal.fire('Error', data.message, 'error');
                    }).finally(() => this.isSubmitting = false);
                },

                confirmPickupArrival(id) {
                    Swal.fire({
                        title: 'Sampai di Gudang?',
                        text: "Konfirmasi bahwa paket jemputan sudah tiba di cabang.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Sampai'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route("courier.delivery.arrived-pickup") }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ pickup_id: id })
                            }).then(r => r.json()).then(data => {
                                if(data.success) location.reload();
                            });
                        }
                    });
                },

                submitSuccess() {
                    if (this.isSubmitting) return;
                    this.isSubmitting = true;
                    let fd = new FormData();
                    fd.append('shipment_id', this.selectedId);
                    fd.append('received_by', this.successData.receivedBy);
                    fd.append('relation', this.successData.relation);
                    fd.append('photo', this.successData.photo);
                    fd.append('note', this.successData.note);
                    if (this.signaturePad && !this.signaturePad.isEmpty()) fd.append('signature', this.signaturePad.toDataURL());

                    fetch('{{ route("courier.delivery.confirm") }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: fd
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: data.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        } else {
                            Swal.fire('Gagal', data.message || 'Terjadi kesalahan sistem.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                    })
                    .finally(() => {
                        this.isSubmitting = false;
                    });
                },

                showToast(recipientName, reason) {
                    const container = document.getElementById('toast-container');
                    const toast = document.createElement('div');
                    toast.className = 'toast-in';
                    toast.style.cssText = `
                        background: #fff;
                        border: 1.5px solid #fecaca;
                        border-left: 5px solid #ef4444;
                        border-radius: 14px;
                        padding: 14px 16px;
                        display: flex;
                        align-items: flex-start;
                        gap: 12px;
                        box-shadow: 0 8px 24px rgba(239,68,68,0.15);
                        max-width: 360px;
                        width: 100%;
                    `;
                    toast.innerHTML = `
                        <div style="width:36px;height:36px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5">
                                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                            </svg>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:12px;font-weight:800;color:#1e293b;margin-bottom:3px;">Paket Gagal Dikirim</div>
                            <div style="font-size:12px;color:#ef4444;font-weight:700;">${recipientName}</div>
                            <div style="font-size:11px;color:#94a3b8;margin-top:2px;">${reason}</div>
                        </div>
                        <button onclick="this.closest('div[style]').classList.replace('toast-in','toast-out');setTimeout(()=>this.closest('div[style]').remove(),400);"
                            style="background:none;border:none;color:#94a3b8;cursor:pointer;padding:2px;line-height:1;flex-shrink:0;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        </button>
                    `;
                    container.prepend(toast);
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.classList.replace('toast-in', 'toast-out');
                            setTimeout(() => toast.remove(), 400);
                        }
                    }, 5000);
                },

                // ── Animate Failed Card ───────────────────────────────────────
                animateFailedCard() {
                    const card = document.getElementById('failed-card');
                    const el   = document.getElementById('failed-count-el');
                    if (card) {
                        card.classList.remove('failed-card-shake');
                        void card.offsetWidth; // reflow
                        card.classList.add('failed-card-shake');
                        card.addEventListener('animationend', () => card.classList.remove('failed-card-shake'), { once: true });
                    }
                    if (el) {
                        el.classList.remove('failed-count-pop');
                        void el.offsetWidth;
                        el.classList.add('failed-count-pop');
                        el.addEventListener('animationend', () => el.classList.remove('failed-count-pop'), { once: true });
                    }
                },

                // retryDelivery removed as we now use cobaLagi

                submitFailed() {
                    if (!this.failedData.reason || !this.failedData.photo) {
                        Swal.fire('Data Belum Lengkap', 'Pilih alasan dan upload foto bukti.', 'warning');
                        return;
                    }
                    if (this.isSubmitting) return;
                    this.isSubmitting = true;

                    let fd = new FormData();
                    fd.append('shipment_id', this.selectedId);
                    fd.append('reason', this.failedData.reason);
                    fd.append('note', this.failedData.note);
                    fd.append('photo', this.failedData.photo);

                    // Capture current context before async
                    const recipientName = this.selectedRecipientName;
                    const recipientAddr = this.selectedAddress;
                    const reason        = this.failedData.reason;

                    fetch('{{ route("courier.delivery.failed") }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: fd
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            this.failedCount++;
                            if (this.remainingCount > 0) this.remainingCount--;

                            this.$nextTick(() => this.animateFailedCard());

                            const now = new Date();
                            this.failedList.unshift({
                                id: this.selectedId,
                                name: recipientName,
                                address: recipientAddr,
                                reason: reason,
                                time: now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB'
                            });

                            this.showToast(recipientName, reason);
                            this.showFailed = false;
                            this.failedData = { reason: '', note: '', photo: null, photoName: '' };

                            const row = document.querySelector(`[data-shipment-id="${this.selectedId}"]`);
                            if (row) row.remove();
                            
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Laporan gagal kirim telah disimpan.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire('Gagal', data.message || 'Terjadi kesalahan sistem.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                    })
                    .finally(() => {
                        this.isSubmitting = false;
                    });
                },
            }
        }

        // --- Coba Lagi Modal JS ---
        function cobaLagi(shipmentId, namaPenerima) {
            document.getElementById('cobaLagiNama').textContent    = namaPenerima;
            document.getElementById('cobaLagiId').value            = shipmentId;
            document.getElementById('modalCobaLagi').style.display = 'flex';
        }

        function closeCobaLagi() {
            document.getElementById('modalCobaLagi').style.display = 'none';
        }

        function submitCobaLagi(action, event) {
            const shipmentId = document.getElementById('cobaLagiId').value;
            const btn        = event.currentTarget;

            // Loading state
            btn.style.opacity  = '0.6';
            btn.style.cursor   = 'wait';
            btn.disabled       = true;

            fetch('{{ route("courier.delivery.retry") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    shipment_id: shipmentId,
                    action: action
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeCobaLagi();

                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Tindak lanjut paket telah disimpan',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Gagal', 'Terjadi kesalahan, coba lagi', 'error');
                    btn.style.opacity = '1';
                    btn.style.cursor  = 'pointer';
                    btn.disabled      = false;
                }
            })
            .catch(() => {
                Swal.fire('Gagal', 'Gagal terhubung ke server', 'error');
                btn.style.opacity = '1';
                btn.style.cursor  = 'pointer';
                btn.disabled      = false;
            });
        }

        document.getElementById('modalCobaLagi').addEventListener('click', function(e) {
            if (e.target === this) closeCobaLagi();
        });
    </script>
    @endpush
</x-admin-layout>

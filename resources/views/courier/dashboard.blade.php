<x-admin-layout>


    <div class="space-y-10" x-data="courierDashboard(@js($shipments))">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div data-aos="fade-right">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Courier <span class="text-indigo-600">Dashboard</span></h1>
                <p class="text-slate-500 font-medium mt-1">Manage your deliveries and update real-time status.</p>
            </div>
            <div class="flex items-center gap-4 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
                <div class="px-4 py-2 bg-indigo-50 rounded-xl">
                    <span class="text-sm font-black text-indigo-600 uppercase tracking-widest">{{ $shipments->total() }} Tasks</span>
                </div>
                <div class="px-4 py-2">
                    <span class="text-sm font-bold text-slate-400">{{ now()->format('l, d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Task List -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden" data-aos="fade-up">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-900">Active Deliveries</h3>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Real-time Tasks</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-6">Tracking Number</th>
                            <th class="px-8 py-6">Receiver</th>
                            <th class="px-8 py-6">Address</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($shipments as $shipment)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                    </div>
                                    <span class="font-black text-slate-900">{{ $shipment->tracking_number }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900">{{ $shipment->receiver_name }}</span>
                                    <span class="text-xs font-medium text-slate-500">{{ $shipment->receiver_phone }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="max-w-xs">
                                    <p class="text-sm font-medium text-slate-600 truncate">{{ $shipment->receiver_address }}</p>
                                    <p class="text-[10px] font-black text-indigo-500 uppercase mt-0.5">{{ $shipment->destinationLocation->name ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                                    {{ $shipment->status === 'delivered' ? 'bg-emerald-50 text-emerald-600' : 'bg-indigo-50 text-indigo-600' }}">
                                    {{ str_replace('_', ' ', $shipment->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <!-- Map Action -->
                                    <button @click="initMap({{ $shipment->id }}, '{{ $shipment->receiver_address }}, {{ $shipment->destinationLocation->name ?? '' }}')" 
                                            class="p-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 transition shadow-lg shadow-blue-100 hover:scale-110 active:scale-95"
                                            title="View Map">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </button>
                                    <!-- Confirm Action -->
                                    <button @click="openConfirmModal(@js($shipment))" 
                                            class="p-3 bg-emerald-600 text-white rounded-2xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 hover:scale-110 active:scale-95"
                                            title="Confirm Delivery">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center gap-4 opacity-50">
                                    <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    <p class="text-slate-500 font-bold">No active tasks found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($shipments->hasPages())
            <div class="p-8 border-t border-slate-50">
                {{ $shipments->links() }}
            </div>
            @endif
        </div>

        <!-- 🗺️ Map Modal -->
        <div x-show="mapOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-10 bg-slate-900/60 backdrop-blur-md"
             x-cloak>
            <div class="bg-white w-full max-w-5xl h-[85vh] rounded-[3rem] shadow-2xl overflow-hidden flex flex-col relative border border-white/20" @click.away="closeMap()">
                <!-- Modal Header -->
                <div class="p-6 md:p-8 border-b border-slate-50 flex justify-between items-center bg-white shrink-0">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 leading-tight">Navigasi ke Penerima</h3>
                            <p class="text-sm font-medium text-slate-400 mt-0.5" x-text="targetAddress"></p>
                        </div>
                    </div>
                    <button @click="closeMap()" class="p-3 bg-slate-50 rounded-2xl text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <!-- Map Area -->
                <div id="map" class="flex-1 bg-slate-100 z-10 relative">
                    <div x-show="mapLoading" class="absolute inset-0 z-50 bg-white/80 backdrop-blur-sm flex flex-col items-center justify-center">
                        <div class="w-12 h-12 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                        <p class="mt-4 text-sm font-black text-slate-600 uppercase tracking-widest" x-text="loadingText">Mencari lokasi...</p>
                    </div>
                </div>

                <!-- Map Footer/Info -->
                <div class="p-6 md:p-8 bg-white border-t border-slate-50 shrink-0">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="flex items-center gap-4">
                            <div class="px-4 py-2 bg-slate-50 rounded-xl">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Jarak</p>
                                <p class="text-lg font-black text-slate-900" x-text="routeInfo.distance">--</p>
                            </div>
                            <div class="px-4 py-2 bg-slate-50 rounded-xl">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Estimasi</p>
                                <p class="text-lg font-black text-slate-900" x-text="routeInfo.time">--</p>
                            </div>
                        </div>
                        <div class="text-center md:text-left">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Via</p>
                            <p class="text-sm font-bold text-slate-700 truncate" x-text="routeInfo.summary">--</p>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <a :href="`https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(targetAddress)}`" target="_blank"
                               class="px-6 py-3 bg-indigo-50 text-indigo-600 font-black rounded-2xl hover:bg-indigo-100 transition shadow-sm flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                Google Maps
                            </a>
                            <button @click="closeMap()" class="px-8 py-3 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ Confirmation Modal -->
        <div x-show="confirmOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-8"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
             x-cloak>
            <div class="bg-white w-full max-w-xl max-h-[90vh] rounded-[3rem] shadow-2xl overflow-y-auto relative border border-white/20" @click.away="confirmOpen = false">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-white sticky top-0 z-20">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900">Konfirmasi Pengiriman</h3>
                            <p class="text-sm font-bold text-emerald-600 mt-0.5" x-text="selectedShipment?.tracking_number"></p>
                        </div>
                    </div>
                    <button @click="confirmOpen = false" class="p-3 bg-slate-50 rounded-2xl text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form :action="`/courier/shipments/${selectedShipment?.id}/confirm-delivery`" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf
                    <!-- Received By -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Penerima</label>
                            <input type="text" :value="selectedShipment?.receiver_name" readonly class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none text-sm font-bold text-slate-400 cursor-not-allowed">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Diterima Oleh *</label>
                            <input type="text" name="received_by" x-model="receivedBy" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-indigo-600 focus:bg-white focus:ring-0 transition-all text-sm font-black text-slate-900" placeholder="Nama pengambil...">
                        </div>
                    </div>

                    <!-- Relation -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Hubungan dengan Penerima</label>
                        <select name="receiver_relation" required class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-indigo-600 focus:bg-white focus:ring-0 transition-all text-sm font-bold text-slate-900 appearance-none">
                            <option value="diri_sendiri">Diri Sendiri</option>
                            <option value="keluarga">Keluarga</option>
                            <option value="tetangga">Tetangga</option>
                            <option value="satpam">Satpam / Receptionist</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Note -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Catatan (Opsional)</label>
                        <textarea name="delivery_note" rows="2" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-indigo-600 focus:bg-white focus:ring-0 transition-all text-sm font-medium text-slate-900" placeholder="Tambahkan catatan jika perlu..."></textarea>
                    </div>

                    <!-- Photo Proof -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Foto Bukti Pengiriman *</label>
                        <div class="relative group">
                            <input type="file" name="proof_photo" @change="handlePhotoChange($event)" accept="image/*" class="hidden" id="proof_photo">
                            <label for="proof_photo" class="block w-full cursor-pointer">
                                <div class="w-full h-48 rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50 group-hover:bg-slate-100 group-hover:border-indigo-300 transition-all flex flex-col items-center justify-center overflow-hidden">
                                    <template x-if="!photoPreview">
                                        <div class="text-center p-6">
                                            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-slate-400 mx-auto mb-3 group-hover:scale-110 group-hover:text-indigo-600 transition-all">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </div>
                                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Klik untuk ambil foto</p>
                                        </div>
                                    </template>
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="w-full h-full object-cover">
                                    </template>
                                </div>
                            </label>
                            <button x-show="photoPreview" @click.prevent="photoPreview = null; document.getElementById('proof_photo').value = ''" 
                                    class="absolute top-4 right-4 p-2 bg-rose-500 text-white rounded-xl shadow-lg hover:bg-rose-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Digital Signature -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanda Tangan Digital (Opsional)</label>
                        <div class="relative bg-slate-50 rounded-3xl border-2 border-slate-100 overflow-hidden">
                            <canvas id="signature-pad" class="w-full h-40 cursor-crosshair"></canvas>
                            <input type="hidden" name="signature" x-model="signatureData">
                            <div class="absolute bottom-4 right-4 flex gap-2">
                                <button type="button" @click="clearSignature()" class="px-4 py-2 bg-white text-rose-500 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-sm border border-rose-100 hover:bg-rose-50 transition-colors">Bersihkan</button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 grid grid-cols-2 gap-4">
                        <button type="button" @click="confirmOpen = false" class="px-8 py-4 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-colors">Batal</button>
                        <button type="submit" @click="prepareSignature()" class="px-8 py-4 bg-emerald-600 text-white font-black rounded-2xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">Konfirmasi Terima</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('courierDashboard', (initialShipments) => ({
                shipments: initialShipments,
                mapOpen: false,
                confirmOpen: false,
                selectedShipment: null,
                
                // Map States
                map: null,
                routingControl: null,
                targetAddress: '',
                mapLoading: false,
                loadingText: '',
                routeInfo: { distance: '--', time: '--', summary: '--' },

                // Confirmation States
                receivedBy: '',
                photoPreview: null,
                signaturePad: null,
                signatureData: '',

                initMap(id, address) {
                    this.selectedShipment = this.shipments.data.find(s => s.id === id);
                    this.targetAddress = address;
                    this.mapOpen = true;
                    this.mapLoading = true;
                    this.loadingText = 'Mencari lokasi Anda...';

                    setTimeout(() => {
                        if (!this.map) {
                            this.map = L.map('map').setView([-7.2575, 112.7521], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap'
                            }).addTo(this.map);
                        }
                        
                        this.map.invalidateSize();
                        this.getRoute(address);
                    }, 500);
                },

                getRoute(address) {
                    if (!navigator.geolocation) {
                        alert('Browser tidak mendukung Geolocation');
                        this.mapLoading = false;
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            const userLat = pos.coords.latitude;
                            const userLng = pos.coords.longitude;
                            
                            this.loadingText = 'Mencari rute ke tujuan...';

                            // Geocode address using Nominatim
                            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (data.length > 0) {
                                        const destLat = data[0].lat;
                                        const destLng = data[0].lon;

                                        if (this.routingControl) {
                                            this.map.removeControl(this.routingControl);
                                        }

                                        this.routingControl = L.Routing.control({
                                            waypoints: [
                                                L.latLng(userLat, userLng),
                                                L.latLng(destLat, destLng)
                                            ],
                                            router: L.Routing.osrmv1({
                                                serviceUrl: 'https://router.project-osrm.org/route/v1'
                                            }),
                                            lineOptions: {
                                                styles: [{ color: '#4f46e5', weight: 6, opacity: 0.8 }]
                                            },
                                            createMarker: function(i, wp, n) {
                                                const icon = L.divIcon({
                                                    className: 'custom-div-icon',
                                                    html: `<div class="w-8 h-8 ${i === 0 ? 'bg-indigo-600' : 'bg-rose-500'} rounded-full border-4 border-white shadow-lg flex items-center justify-center text-white text-[10px] font-black">${i === 0 ? 'A' : 'B'}</div>`,
                                                    iconSize: [32, 32],
                                                    iconAnchor: [16, 32]
                                                });
                                                return L.marker(wp.latLng, { icon: icon });
                                            },
                                            addWaypoints: false,
                                            draggableWaypoints: false,
                                            fitSelectedRoutes: true,
                                            show: false // Hide the instruction panel
                                        }).addTo(this.map);

                                        this.routingControl.on('routesfound', (e) => {
                                            const routes = e.routes;
                                            const summary = routes[0].summary;
                                            this.routeInfo = {
                                                distance: (summary.totalDistance / 1000).toFixed(1) + ' km',
                                                time: Math.round(summary.totalTime / 60) + ' menit',
                                                summary: routes[0].name || 'Jalan Utama'
                                            };
                                            this.mapLoading = false;
                                        });
                                    } else {
                                        alert('Alamat tidak ditemukan di peta');
                                        this.mapLoading = false;
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    this.mapLoading = false;
                                });
                        },
                        (err) => {
                            alert('Gagal mengambil lokasi. Mohon aktifkan GPS.');
                            this.mapLoading = false;
                        }
                    );
                },

                closeMap() {
                    this.mapOpen = false;
                    if (this.routingControl) {
                        this.map.removeControl(this.routingControl);
                        this.routingControl = null;
                    }
                    this.routeInfo = { distance: '--', time: '--', summary: '--' };
                },

                openConfirmModal(shipment) {
                    this.selectedShipment = shipment;
                    this.receivedBy = shipment.receiver_name;
                    this.confirmOpen = true;
                    
                    this.$nextTick(() => {
                        const canvas = document.getElementById('signature-pad');
                        if (canvas) {
                            // Resize canvas logic
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            canvas.getContext("2d").scale(ratio, ratio);

                            if (!this.signaturePad) {
                                this.signaturePad = new SignaturePad(canvas, {
                                    backgroundColor: 'rgba(255, 255, 255, 0)',
                                    penColor: '#1e293b'
                                });
                            } else {
                                this.signaturePad.clear();
                            }
                        }
                    });
                },

                handlePhotoChange(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.photoPreview = URL.createObjectURL(file);
                    }
                },

                clearSignature() {
                    if (this.signaturePad) this.signaturePad.clear();
                },

                prepareSignature() {
                    if (this.signaturePad && !this.signaturePad.isEmpty()) {
                        this.signatureData = this.signaturePad.toDataURL();
                    }
                }
            }))
        })
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .leaflet-routing-container { display: none !important; }
        .custom-div-icon { background: transparent; border: none; }
        #signature-pad { touch-action: none; }
    </style>
</x-admin-layout>

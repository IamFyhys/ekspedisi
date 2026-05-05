<x-admin-layout>
    @section('title_breadcrumb', 'Manifest In')
    <div class="space-y-10 animate-reveal" x-data="manifestIn()">
        <!-- Header Section -->
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Manifest <span class="text-primary">In</span></h1>
            <p class="text-slate-500 font-medium">Scan paket yang Anda bawa saat tiba di gudang tujuan.</p>
        </div>

        @if(!$activeTrip)
        <div class="premium-card p-20 bg-white text-center">
            <div class="max-w-md mx-auto space-y-6">
                <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mx-auto text-slate-300">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900">Tidak ada perjalanan aktif</h3>
                <p class="text-slate-500 font-medium">Anda belum memulai perjalanan (Manifest Out). Silakan mulai perjalanan terlebih dahulu.</p>
                <a href="{{ route('courier.transit.manifest-out') }}" class="inline-block px-10 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 uppercase tracking-widest text-xs">Mulai Sekarang</a>
            </div>
        </div>
        @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Summary Card -->
            <div class="lg:col-span-1 space-y-8">
                <div class="premium-card p-10 bg-white border border-slate-100">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8">Informasi Perjalanan</h4>
                    <div class="space-y-8">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-primary font-black text-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tujuan</p>
                                <p class="text-lg font-black text-slate-900">{{ $activeTrip->destinationBranch->name }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-6 bg-slate-50 rounded-3xl text-center">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Expected</p>
                                <p class="text-2xl font-black text-slate-900">{{ $activeTrip->total_packages }}</p>
                            </div>
                            <div class="p-6 bg-emerald-50 rounded-3xl text-center">
                                <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest mb-1">Scanned</p>
                                <p class="text-2xl font-black text-emerald-600" x-text="scannedItems.length"></p>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-slate-50">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Scan Paket Masuk</label>
                            <div class="flex gap-2">
                                <input type="text" x-model="tempResi" @keyup.enter="scanItem" placeholder="No. Resi..." class="flex-1 px-6 py-4 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all font-black uppercase text-sm">
                                <button @click="startScanner" class="p-4 bg-slate-900 text-white rounded-2xl shadow-lg hover:bg-slate-800 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </button>
                            </div>
                        </div>
                        
                        <button @click="showConfirm = true" :disabled="scannedItems.length === 0" class="w-full py-5 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:bg-primary/90 transition-all uppercase tracking-widest text-[10px]">Selesai & Konfirmasi</button>
                    </div>
                </div>
            </div>

            <!-- Detailed List -->
            <div class="lg:col-span-2">
                <div class="premium-card overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-xl font-black text-slate-900">Daftar Manifest</h3>
                        <div class="flex gap-4">
                            <button @click="filter = 'all'" :class="filter === 'all' ? 'text-primary' : 'text-slate-400'" class="text-[10px] font-black uppercase tracking-widest">Semua</button>
                            <button @click="filter = 'scanned'" :class="filter === 'scanned' ? 'text-primary' : 'text-slate-400'" class="text-[10px] font-black uppercase tracking-widest">Sudah Scan</button>
                            <button @click="filter = 'pending'" :class="filter === 'pending' ? 'text-primary' : 'text-slate-400'" class="text-[10px] font-black uppercase tracking-widest">Belum Scan</button>
                        </div>
                    </div>
                    <div class="max-h-[600px] overflow-y-auto custom-scrollbar">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-slate-50">
                                <template x-for="item in filteredItems">
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="px-10 py-6">
                                            <p class="text-sm font-black text-slate-900" x-text="item.resi"></p>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <span x-show="item.scanned" class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest">Diterima ✓</span>
                                            <span x-show="!item.scanned" class="px-4 py-1.5 rounded-full bg-slate-50 text-slate-400 text-[9px] font-black uppercase tracking-widest italic">Belum Scan</span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div x-show="showConfirm" class="fixed inset-0 z-50 flex items-center justify-center p-8 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div class="bg-white rounded-[2.5rem] w-full max-w-xl p-12 shadow-2xl space-y-8 animate-reveal" @click.away="showConfirm = false">
                <div class="text-center space-y-4">
                    <div class="w-20 h-20 bg-amber-50 rounded-3xl flex items-center justify-center mx-auto text-amber-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900">Konfirmasi Manifest In</h3>
                    <p class="text-slate-500 font-medium" x-show="missingCount > 0">Terdapat <span class="text-rose-500 font-black" x-text="missingCount"></span> paket yang belum di-scan. Mohon isi catatan alasan selisih.</p>
                    <p class="text-slate-500 font-medium" x-show="missingCount === 0">Semua paket telah sesuai. Klik konfirmasi untuk menyelesaikan.</p>
                </div>

                <div class="space-y-4" x-show="missingCount > 0">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alasan Paket Kurang *</label>
                    <textarea x-model="missingNote" rows="4" class="w-full px-6 py-4 rounded-3xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all font-medium" placeholder="Contoh: Paket rusak di jalan, ketinggalan di hub asal, dll..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4">
                    <button @click="showConfirm = false" class="py-4 bg-slate-100 text-slate-600 font-black rounded-2xl uppercase tracking-widest text-[10px]">Batal</button>
                    <button @click="confirmArrival" class="py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] hover:bg-slate-800 transition-all">Konfirmasi</button>
                </div>
            </div>
        </div>

        <!-- Scanner Modal -->
        <div x-show="showScanner" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-md" x-cloak>
            <div class="bg-white rounded-[2.5rem] w-full max-w-lg overflow-hidden shadow-2xl flex flex-col">
                <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-xl font-black text-slate-900">Scanner Kamera</h3>
                    <button @click="stopScanner" class="w-10 h-10 rounded-full hover:bg-slate-50 flex items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="p-4 bg-slate-50">
                    <div id="reader-in" class="overflow-hidden rounded-2xl border-4 border-white shadow-inner" style="background: #000;"></div>
                </div>
                <div class="p-8 text-center">
                    <p class="text-xs font-bold text-slate-400">Arahkan kamera ke Barcode paket yang baru sampai.</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function manifestIn() {
            return {
                tempResi: '',
                scannedItems: [],
                filter: 'all',
                showConfirm: false,
                missingNote: '',
                showScanner: false,
                html5QrCode: null,

                startScanner() {
                    this.showScanner = true;
                    this.$nextTick(() => {
                        this.html5QrCode = new Html5Qrcode("reader-in");
                        this.html5QrCode.start(
                            { facingMode: "environment" }, 
                            { fps: 10, qrbox: { width: 250, height: 150 } }, 
                            (decodedText) => {
                                this.tempResi = decodedText;
                                this.scanItem();
                                if (navigator.vibrate) navigator.vibrate(100);
                            }
                        ).catch(err => {
                            console.error(err);
                            this.showScanner = false;
                        });
                    });
                },

                stopScanner() {
                    if (this.html5QrCode) {
                        this.html5QrCode.stop().finally(() => { this.showScanner = false; });
                    } else {
                        this.showScanner = false;
                    }
                },
                // In a real app, you'd load the expected items from the server or local storage
                // For demo, we'll assume we know what they are (this could be passed via compact)
                expectedItems: [
                    @if($activeTrip)
                        @foreach($activeTrip->shipments as $s)
                        { resi: '{{ $s->tracking_number }}', scanned: false },
                        @endforeach
                    @endif
                ],

                init() {
                    console.log('Manifest In initialized with', this.expectedItems.length, 'items');
                },

                scanItem() {
                    let resi = this.tempResi.trim().toUpperCase();
                    if (!resi) return;

                    let item = this.expectedItems.find(i => i.resi === resi);
                    if (item) {
                        if (item.scanned) {
                            Swal.fire({ icon: 'warning', title: 'Sudah di-scan', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                        } else {
                            item.scanned = true;
                            this.scannedItems.push(resi);
                            const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3');
                            audio.play();
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'Tidak Ditemukan', text: 'Resi ini tidak ada dalam manifest perjalanan ini!', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                    }
                    this.tempResi = '';
                },

                get missingCount() {
                    return this.expectedItems.filter(i => !i.scanned).length;
                },

                get filteredItems() {
                    if (this.filter === 'scanned') return this.expectedItems.filter(i => i.scanned);
                    if (this.filter === 'pending') return this.expectedItems.filter(i => !i.scanned);
                    return this.expectedItems;
                },

                confirmArrival() {
                    if (this.missingCount > 0 && !this.missingNote) {
                        Swal.fire('Error', 'Mohon isi catatan alasan selisih!', 'error');
                        return;
                    }

                    fetch('{{ route("courier.transit.manifest-in.confirm") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            scanned_items: this.scannedItems,
                            missing_items: this.expectedItems.filter(i => !i.scanned).map(i => i.resi),
                            note: this.missingNote
                        })
                    }).then(res => res.json()).then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                window.location.href = '{{ route("courier.transit.dashboard") }}';
                            });
                        } else {
                            Swal.fire('Gagal', data.message, 'error');
                        }
                    });
                }
            }
        }
    </script>
    @endpush
</x-admin-layout>

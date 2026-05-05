<x-admin-layout>
    @section('title_breadcrumb', 'Manifest Out')
    <div class="space-y-10 animate-reveal" x-data="manifestOut()">
        <!-- Header Section -->
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Manifest <span class="text-primary">Out</span></h1>
            <p class="text-slate-500 font-medium">Scan paket yang akan dibawa keluar dari {{ Auth::user()->branch->name }}.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left: Control & Scan -->
            <div class="lg:col-span-1 space-y-8">
                <div class="premium-card p-10 bg-white border border-slate-100">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Cabang Tujuan</label>
                            <select x-model="destinationId" class="w-full px-5 py-3.5 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all text-sm font-bold appearance-none">
                                <option value="">Pilih Cabang Tujuan</option>
                                @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Scan Barcode / Input Resi</label>
                            <div class="relative">
                                <input type="text" x-model="scannedResi" @keyup.enter="addItem" placeholder="EXP-xxx..." class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all text-sm font-black uppercase placeholder:normal-case">
                                <button @click="addItem" class="absolute right-2 top-2 p-2 bg-primary text-white rounded-xl shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                        </div>

                        <button class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 transition-all flex items-center justify-center gap-3 shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span class="uppercase tracking-widest text-[10px]">Buka Kamera Scanner</span>
                        </button>
                    </div>
                </div>

                <div class="premium-card p-10 bg-primary text-white shadow-xl shadow-primary/20" x-show="items.length > 0">
                    <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-2">Ringkasan Manifest</p>
                    <div class="flex justify-between items-end">
                        <h4 class="text-3xl font-black" x-text="items.length + ' Paket'"></h4>
                        <button @click="submitManifest" :disabled="!destinationId || items.length === 0" class="px-8 py-3 bg-white text-primary rounded-xl font-black uppercase tracking-widest text-[10px] hover:scale-105 transition-all disabled:opacity-50 disabled:hover:scale-100">Berangkat</button>
                    </div>
                </div>
            </div>

            <!-- Right: List of scanned items -->
            <div class="lg:col-span-2">
                <div class="premium-card overflow-hidden">
                    <div class="p-10 border-b border-slate-50">
                        <h3 class="text-xl font-black text-slate-900">Paket dalam Manifest</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">No Resi</th>
                                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="px-10 py-6">
                                            <p class="text-sm font-black text-slate-900" x-text="item"></p>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <button @click="removeItem(index)" class="p-3 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-100 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="items.length === 0">
                                    <td colspan="2" class="px-10 py-20 text-center text-slate-400 font-bold italic">Belum ada paket yang di-scan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available in Warehouse -->
        <div class="premium-card bg-white border border-slate-100 mt-10">
            <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-slate-900">Paket Siap Kirim di Gudang</h3>
                    <p class="text-xs text-slate-500 font-medium mt-1">Daftar paket yang bisa kamu masukkan ke manifest.</p>
                </div>
                <span class="px-4 py-1.5 bg-slate-100 rounded-full text-[10px] font-black text-slate-600 uppercase tracking-widest">
                    {{ count($availableShipments) }} Tersedia
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Resi & Pengirim</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Rute</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Penerima</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Tujuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($availableShipments as $ship)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-10 py-6">
                                <p class="text-sm font-black text-primary">{{ $ship->tracking_number }}</p>
                                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">Dari: {{ $ship->sender_name }}</p>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex items-center justify-center gap-3">
                                    <span class="text-[10px] font-bold text-slate-900">{{ $ship->originLocation->name ?? '-' }}</span>
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                    <span class="text-[10px] font-bold text-slate-900">{{ $ship->destinationLocation->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <p class="text-sm font-black text-slate-700">{{ $ship->receiver_name }}</p>
                                <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $ship->receiver_address }}</p>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <span class="px-3 py-1 bg-blue-50 text-primary rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    {{ $ship->destinationLocation->name ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-16 text-center text-slate-400 font-bold italic">Tidak ada paket baru di gudang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
                    <div id="reader" class="overflow-hidden rounded-2xl border-4 border-white shadow-inner" style="background: #000;"></div>
                </div>
                <div class="p-8 text-center">
                    <p class="text-xs font-bold text-slate-400">Arahkan kamera ke Barcode / QR Code pada paket.</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function manifestOut() {
            return {
                destinationId: '',
                scannedResi: '',
                items: [],
                showScanner: false,
                html5QrCode: null,

                startScanner() {
                    this.showScanner = true;
                    this.$nextTick(() => {
                        this.html5QrCode = new Html5Qrcode("reader");
                        const config = { fps: 10, qrbox: { width: 250, height: 150 } };
                        
                        this.html5QrCode.start(
                            { facingMode: "environment" }, 
                            config, 
                            (decodedText) => {
                                this.scannedResi = decodedText;
                                this.addItem();
                                // Feedback suara & getar jika didukung
                                if (navigator.vibrate) navigator.vibrate(100);
                            },
                            (errorMessage) => {
                                // Ignore constant scan errors
                            }
                        ).catch((err) => {
                            console.error("Unable to start scanning.", err);
                            Swal.fire('Error', 'Gagal membuka kamera. Pastikan izin kamera diberikan.', 'error');
                            this.showScanner = false;
                        });
                    });
                },

                stopScanner() {
                    if (this.html5QrCode) {
                        this.html5QrCode.stop().then(() => {
                            this.showScanner = false;
                        }).catch(err => {
                            this.showScanner = false;
                        });
                    } else {
                        this.showScanner = false;
                    }
                },

                async addItem() {
                    if (!this.scannedResi.trim()) return;
                    
                    const resi = this.scannedResi.toUpperCase();
                    if (this.items.includes(resi)) {
                        Swal.fire({ icon: 'warning', title: 'Sudah di-scan', text: 'Resi ini sudah ada dalam daftar.', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                        this.scannedResi = '';
                        return;
                    }

                    try {
                        const response = await fetch('{{ route("courier.transit.manifest-out.scan") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ resi: resi })
                        });
                        const data = await response.json();

                        if (data.success) {
                            this.items.unshift(resi);
                            this.scannedResi = '';
                            // Success Feedback
                            const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3');
                            audio.play();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                        }
                    } catch (error) {
                        console.error(error);
                    }
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                submitManifest() {
                    if (!this.destinationId) {
                        Swal.fire('Error', 'Pilih cabang tujuan!', 'error');
                        return;
                    }
                    
                    Swal.fire({
                        title: 'Konfirmasi Keberangkatan',
                        text: `Anda akan memberangkatkan ${this.items.length} paket?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Berangkat!',
                        confirmButtonColor: '#185FA5'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route("courier.transit.manifest-out.depart") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    dest_branch: this.destinationId,
                                    tracking_numbers: this.items
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
                    });
                }
            }
        }
    </script>
    @endpush
</x-admin-layout>

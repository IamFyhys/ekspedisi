<x-admin-layout>
    <div class="max-w-5xl mx-auto" x-data="shipmentForm()">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Buat Pengiriman Baru</h1>
            <p class="text-slate-500 font-medium mt-1">Input data paket dan selesaikan pembayaran dalam satu langkah.</p>
        </div>

        <form @submit.prevent="submitForm" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Packet Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipper & Receiver Section -->
                <div class="premium-card p-8">
                    <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Informasi Pengiriman
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Shipper -->
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengirim</h4>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Pengirim</label>
                                <input type="text" x-model="formData.sender_name" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">No. Telepon</label>
                                <div class="flex gap-2">
                                    <input type="text" x-model="formData.sender_phone" class="flex-1 bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                                    <button type="button" @click="searchCustomer()" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-all" title="Cari Data Pengirim">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kota Asal</label>
                                <select x-model="formData.origin_location_id" @change="onOriginCityChange()" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                                    <option value="">Pilih Kota</option>
                                    @foreach($locations as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kecamatan Asal</label>
                                <select x-model="formData.origin_subdistrict_id" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <template x-for="sub in originSubdistricts" :key="sub.id">
                                        <option :value="sub.id" x-text="sub.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <!-- Receiver -->
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Penerima</h4>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Penerima</label>
                                <input type="text" x-model="formData.receiver_name" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">No. Telepon</label>
                                <input type="text" x-model="formData.receiver_phone" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kota Tujuan</label>
                                <select x-model="formData.destination_location_id" @change="onDestCityChange($event)" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                                    <option value="">Pilih Kota</option>
                                    @foreach($locations as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kecamatan Tujuan</label>
                                <select x-model="formData.destination_subdistrict_id" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <template x-for="sub in destinationSubdistricts" :key="sub.id">
                                        <option :value="sub.id" x-text="sub.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Lengkap Penerima</label>
                        <textarea x-model="formData.receiver_address" rows="3" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required></textarea>
                    </div>
                </div>

                <!-- Package Section -->
                <div class="premium-card p-8">
                    <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        Detail Paket
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Barang</label>
                            <input type="text" x-model="formData.item_name" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Berat Asli</label>
                            <div class="relative">
                                <input type="number" x-model="formData.weight" step="0.1" @input="calculateRate()" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all" required>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] font-bold">KG</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Panjang</label>
                            <div class="relative">
                                <input type="number" x-model="formData.length" @input="calculateRate()" placeholder="Opsional" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] font-bold">CM</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Lebar</label>
                            <div class="relative">
                                <input type="number" x-model="formData.width" @input="calculateRate()" placeholder="Opsional" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] font-bold">CM</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tinggi</label>
                            <div class="relative">
                                <input type="number" x-model="formData.height" @input="calculateRate()" placeholder="Opsional" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900 transition-all">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] font-bold">CM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary & Payment -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-slate-900 rounded-[2rem] text-white p-8 shadow-2xl shadow-primary/20 sticky top-24">
                    <h3 class="text-lg font-black mb-6">Ringkasan Biaya</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Berat</span>
                            <span class="font-bold" x-text="(formData.weight || 0) + ' kg'"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Tujuan</span>
                            <span class="font-bold" x-text="destinationName || '-'"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Chargeable Weight</span>
                            <span class="font-bold text-primary" x-text="chargeableWeight ? (chargeableWeight + ' kg') : '-'"></span>
                        </div>
                        <div class="flex justify-between text-sm" x-show="volumetricWeight">
                            <span class="text-slate-400">Berat Volumetrik</span>
                            <span class="font-bold text-amber-400" x-text="volumetricWeight + ' kg'"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Ongkir</span>
                            <span class="font-bold" x-text="formatRupiah(totalPrice)"></span>
                        </div>
                        <div x-show="rateError" class="text-[10px] text-amber-400 font-bold text-center bg-amber-500/10 rounded-lg px-3 py-2" x-text="rateError"></div>
                        <div class="pt-4 border-t border-white/10 flex justify-between items-center">
                            <span class="text-blue-400 font-bold">Total</span>
                            <span class="text-2xl font-black" x-text="formatRupiah(totalPrice)"></span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Metode Pembayaran</h4>
                        <div class="grid grid-cols-1 gap-3">
                            <label class="relative flex items-center p-4 rounded-xl border border-white/10 cursor-pointer hover:bg-white/5 transition-colors" :class="formData.payment_method === 'cash' ? 'bg-primary/20 border-primary' : ''">
                                <input type="radio" x-model="formData.payment_method" value="cash" class="sr-only" required>
                                <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                <span class="font-bold text-sm">Cash</span>
                            </label>
                            <label class="relative flex items-center p-4 rounded-xl border border-white/10 cursor-pointer hover:bg-white/5 transition-colors" :class="formData.payment_method === 'transfer' ? 'bg-primary/20 border-primary' : ''">
                                <input type="radio" x-model="formData.payment_method" value="transfer" class="sr-only">
                                <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                <span class="font-bold text-sm">Transfer / QRIS</span>
                            </label>
                            <label class="relative flex items-center p-4 rounded-xl border border-white/10 cursor-pointer hover:bg-white/5 transition-colors" :class="formData.payment_method === 'cod' ? 'bg-primary/20 border-primary' : ''">
                                <input type="radio" x-model="formData.payment_method" value="cod" class="sr-only">
                                <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3L22 4m-2 1h.01M17 21a2 2 0 11-4 0 2 2 0 014 0zM7 21a2 2 0 11-4 0 2 2 0 014 0zM14 7h.01M9 16H5v4h4v-4z" /></svg>
                                <div>
                                    <span class="font-bold text-sm block">COD</span>
                                    <span class="text-[9px] text-slate-400">Bayar di Tujuan</span>
                                </div>
                            </label>
                            <label class="relative flex items-center p-4 rounded-xl border border-white/10 cursor-pointer hover:bg-white/5 transition-colors" :class="formData.payment_method === 'midtrans' ? 'bg-primary/20 border-primary' : ''">
                                <input type="radio" x-model="formData.payment_method" value="midtrans" class="sr-only">
                                <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                <div>
                                    <span class="font-bold text-sm block">Midtrans</span>
                                    <span class="text-[9px] text-slate-400">QRIS / GoPay / Transfer</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" :disabled="loading || !formData.payment_method" class="w-full bg-primary hover:bg-primary/90 disabled:bg-slate-800 disabled:text-slate-600 text-white font-black py-4 rounded-2xl mt-8 shadow-xl shadow-primary/20 transition-all flex items-center justify-center gap-2">
                        <template x-if="!loading">
                            <span>Simpan & Bayar</span>
                        </template>
                        <template x-if="loading">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </template>
                    </button>
                </div>
            </div>
        </form>

        <!-- Success Modal -->
        <div x-show="showSuccessModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div class="premium-card shadow-2xl w-full max-w-md overflow-hidden transform transition-all" @click.away="showSuccessModal = false">
                <div class="p-8 text-center">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-2">Transaksi Berhasil!</h2>
                    <p class="text-slate-500 text-sm mb-8">Paket telah didaftarkan dan siap dikirim.</p>
                    
                    <div class="bg-slate-50 rounded-2xl p-6 mb-8 text-left space-y-4">
                        <div class="flex justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor Resi</span>
                            <span class="font-black text-primary" x-text="successData.tracking_number"></span>
                        </div>
                        <div class="flex justify-between border-t border-slate-200 pt-4">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</span>
                            <span class="font-black text-slate-900" x-text="formatRupiah(successData.total_price)"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <a :href="'/shipments/' + successData.id + '/print'" target="_blank" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2-2v4a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            Cetak Resi
                        </a>
                        <button @click="window.location.href='/shipments'" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 rounded-xl shadow-lg shadow-primary/20 transition-all">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
    function shipmentForm() {
        return {
            formData: {
                sender_name: '', sender_phone: '',
                origin_location_id: '', origin_subdistrict_id: '',
                receiver_name: '', receiver_phone: '', receiver_address: '',
                destination_location_id: '', destination_subdistrict_id: '',
                item_name: '', weight: '', length: '', width: '', height: '', payment_method: ''
            },
            originSubdistricts: [],
            destinationSubdistricts: [],
            totalPrice: 0,
            chargeableWeight: null,
            volumetricWeight: null,
            destinationName: '',
            rateError: '',
            loading: false,
            showSuccessModal: false,
            successData: {},

            searchCustomer() {
                if (!this.formData.sender_phone) return;
                fetch(`{{ url('/cashier/search-customer') }}?phone=${this.formData.sender_phone}`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.found) {
                            this.formData.sender_name = data.sender_name;
                            this.formData.sender_address = data.sender_address;
                            Swal.fire({
                                toast: true, position: 'top-end', icon: 'success',
                                title: 'Data pelanggan ditemukan!', showConfirmButton: false, timer: 1500
                            });
                        } else {
                            Swal.fire({
                                toast: true, position: 'top-end', icon: 'info',
                                title: 'Pelanggan baru.', showConfirmButton: false, timer: 1500
                            });
                        }
                    });
            },

            onOriginCityChange() {
                this.formData.origin_subdistrict_id = '';
                this.originSubdistricts = [];
                this.totalPrice = 0;
                if (!this.formData.origin_location_id) return;
                fetch(`{{ url('/subdistricts') }}?location_id=${this.formData.origin_location_id}`)
                    .then(r => r.json())
                    .then(data => { this.originSubdistricts = Array.isArray(data) ? data : []; })
                    .catch(() => {});
            },

            onDestCityChange(e) {
                this.formData.destination_subdistrict_id = '';
                this.destinationSubdistricts = [];
                this.totalPrice = 0;
                this.rateError = '';
                if (!this.formData.destination_location_id) { this.destinationName = ''; return; }
                if (e && e.target) {
                    const sel = e.target;
                    this.destinationName = sel.options[sel.selectedIndex]?.text || '';
                }
                fetch(`{{ url('/subdistricts') }}?location_id=${this.formData.destination_location_id}`)
                    .then(r => r.json())
                    .then(data => {
                        this.destinationSubdistricts = Array.isArray(data) ? data : [];
                        this.calculateRate();
                    })
                    .catch(() => {});
            },

            calculateRate() {
                if (!this.formData.origin_location_id || !this.formData.destination_location_id || !this.formData.weight) {
                    this.totalPrice = 0;
                    return;
                }
                this.rateError = '';
                fetch('{{ url('/shipments/calculate-rate') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({
                        origin_location_id: this.formData.origin_location_id,
                        destination_location_id: this.formData.destination_location_id,
                        weight: this.formData.weight,
                        length: this.formData.length,
                        width: this.formData.width,
                        height: this.formData.height
                    })
                })
                .then(r => r.json())
                .then(data => {
                    this.totalPrice = data.total_price || 0;
                    this.chargeableWeight = data.chargeable_weight || null;
                    this.volumetricWeight = data.volumetric_weight || null;
                    if (!this.totalPrice) this.rateError = 'Rute belum tersedia, hubungi admin.';
                })
                .catch(() => { this.rateError = 'Gagal menghitung ongkir.'; });
            },

            submitForm() {
                if (!this.formData.payment_method) {
                    Swal.fire('Pilih Metode', 'Silakan pilih metode pembayaran.', 'warning');
                    return;
                }
                this.loading = true;
                fetch('{{ route('shipments.store') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(this.formData)
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        if (this.formData.payment_method === 'midtrans') {
                            this.processMidtrans(data.shipment.id, data.shipment);
                        } else {
                            this.loading = false;
                            this.successData = data.shipment;
                            this.showSuccessModal = true;
                        }
                    } else {
                        this.loading = false;
                        Swal.fire('Error', data.message || 'Terjadi kesalahan.', 'error');
                    }
                })
                .catch(() => {
                    this.loading = false;
                    Swal.fire('Error', 'Gagal memproses transaksi.', 'error');
                });
            },

            processMidtrans(shipmentId, shipmentData) {
                fetch('{{ route('cashier.payment.midtrans.create') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ shipment_id: shipmentId })
                })
                .then(r => r.json())
                .then(data => {
                    this.loading = false;
                    if (data.success && data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: () => { this.successData = shipmentData; this.showSuccessModal = true; },
                            onPending: () => { this.successData = shipmentData; this.showSuccessModal = true; },
                            onError: () => { Swal.fire('Pembayaran Gagal', 'Silakan coba lagi.', 'error'); },
                            onClose: () => {
                                Swal.fire('Dibatalkan', 'Popup ditutup sebelum pembayaran selesai.', 'warning')
                                    .then(() => window.location.href = '/shipments');
                            }
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Gagal generate snap token.', 'error');
                    }
                })
                .catch(() => {
                    this.loading = false;
                    Swal.fire('Error', 'Gagal terhubung ke Midtrans.', 'error');
                });
            },

            formatRupiah(val) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val || 0);
            }
        }
    }
    </script>
    @endpush
</x-admin-layout>


<x-admin-layout>
    <div class="space-y-8" x-data="drawerPage()">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Cash Drawer</h1>
                <p class="text-slate-500 font-medium mt-1">Pantau akurasi uang fisik dan ringkasan pendapatan harian.</p>
            </div>
            @if(!$drawer || $drawer->status === 'closed')
                <button @click="showOpenModal = true" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Buka Drawer
                </button>
            @else
                <button @click="showCloseModal = true" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-rose-600/20 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Tutup Drawer
                </button>
            @endif
        </div>

        @if($drawer)
        <!-- Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="premium-card p-6 bg-white border border-slate-100">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Pemasukan</p>
                <h3 class="text-2xl font-black text-slate-900">{{ 'Rp ' . number_format($summary['total_income'], 0, ',', '.') }}</h3>
            </div>
            <div class="premium-card p-6 bg-white border border-emerald-100">
                <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest mb-2">💵 Cash</p>
                <h3 class="text-2xl font-black text-emerald-600">{{ 'Rp ' . number_format($summary['cash_income'], 0, ',', '.') }}</h3>
            </div>
            <div class="premium-card p-6 bg-white border border-blue-100">
                <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-2">📱 Midtrans</p>
                <h3 class="text-2xl font-black text-primary">{{ 'Rp ' . number_format($summary['midtrans_income'], 0, ',', '.') }}</h3>
            </div>
            <div class="premium-card p-6 bg-white border border-indigo-100">
                <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-2">💳 Transfer/QRIS</p>
                <h3 class="text-2xl font-black text-indigo-600">{{ 'Rp ' . number_format($summary['transfer_income'], 0, ',', '.') }}</h3>
            </div>
            <div class="premium-card p-6 bg-white border border-amber-100">
                <p class="text-[9px] font-black text-amber-400 uppercase tracking-widest mb-2">🚚 COD</p>
                <h3 class="text-2xl font-black text-amber-600">{{ 'Rp ' . number_format($summary['cod_income'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Tabs -->
        <div class="premium-card overflow-hidden bg-white border border-slate-100">
            <div class="border-b border-slate-50 flex gap-0">
                <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'border-b-2 border-primary text-primary bg-blue-50/30' : 'text-slate-500 hover:text-slate-700'" class="px-8 py-5 text-[10px] font-black uppercase tracking-widest transition-all">
                    Semua ({{ $summary['transaction_count'] }})
                </button>
                <button @click="activeTab = 'cod'" :class="activeTab === 'cod' ? 'border-b-2 border-amber-500 text-amber-600 bg-amber-50/30' : 'text-slate-500 hover:text-slate-700'" class="px-8 py-5 text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2">
                    Pending COD
                    @if(count($codShipments) > 0)
                    <span class="bg-amber-500 text-white text-[8px] font-black px-2 py-0.5 rounded-full">{{ count($codShipments) }}</span>
                    @endif
                </button>
            </div>

            <!-- All Transactions Tab -->
            <div x-show="activeTab === 'all'" class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor Resi</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Metode</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jam</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kasir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transactions as $tx)
                        <tr class="group hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-5">
                                <span class="font-black text-primary">{{ $tx->shipment->tracking_number ?? '-' }}</span>
                            </td>
                            <td class="px-8 py-5 font-black text-slate-900">
                                Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5">
                                @php
                                    $methodClass = match($tx->payment_method) {
                                        'cash' => 'bg-emerald-50 text-emerald-600',
                                        'midtrans' => 'bg-blue-50 text-primary',
                                        'transfer' => 'bg-indigo-50 text-indigo-600',
                                        'cod' => 'bg-amber-50 text-amber-600',
                                        default => 'bg-slate-50 text-slate-500',
                                    };
                                    $methodLabel = match($tx->payment_method) {
                                        'cash' => '💵 Cash',
                                        'midtrans' => '📱 Midtrans',
                                        'transfer' => '💳 Transfer/QRIS',
                                        'cod' => '🚚 COD',
                                        default => ucfirst($tx->payment_method),
                                    };
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $methodClass }}">
                                    {{ $methodLabel }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-sm font-medium text-slate-500">{{ $tx->created_at->format('H:i') }}</td>
                            <td class="px-8 py-5 text-sm font-black text-slate-700">{{ $tx->shipment->cashier->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center text-slate-400 font-bold italic">Belum ada transaksi hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pending COD Tab -->
            <div x-show="activeTab === 'cod'" class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-amber-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-amber-400 uppercase tracking-widest">No Resi</th>
                            <th class="px-8 py-5 text-[10px] font-black text-amber-400 uppercase tracking-widest">Penerima</th>
                            <th class="px-8 py-5 text-[10px] font-black text-amber-400 uppercase tracking-widest">Ongkir COD</th>
                            <th class="px-8 py-5 text-[10px] font-black text-amber-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-amber-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-50">
                        @forelse($codShipments as $cod)
                        <tr class="hover:bg-amber-50/20 transition-colors">
                            <td class="px-8 py-5 font-black text-primary text-sm">{{ $cod->tracking_number }}</td>
                            <td class="px-8 py-5">
                                <p class="font-bold text-slate-900 text-sm">{{ $cod->receiver_name }}</p>
                                <p class="text-xs text-slate-400 truncate max-w-[180px]">{{ $cod->receiver_address }}</p>
                            </td>
                            <td class="px-8 py-5 font-black text-slate-900">Rp {{ number_format($cod->total_price, 0, ',', '.') }}</td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-black bg-amber-50 text-amber-600 uppercase tracking-widest">Pending COD</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <button @click="openCODModal({{ $cod->id }}, '{{ $cod->tracking_number }}', '{{ $cod->receiver_name }}', {{ $cod->total_price }}, '{{ $cod->sender_name }}')"
                                    class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-[9px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-amber-500/20">
                                    Terima Setoran
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center text-slate-400 font-bold italic">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Tidak ada COD yang perlu diproses.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @else
        <div class="bg-blue-50/50 rounded-[2rem] p-12 text-center border-2 border-dashed border-blue-100">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary/10">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
            </div>
            <h3 class="text-xl font-black text-slate-900 mb-2">Drawer Belum Dibuka</h3>
            <p class="text-slate-500 font-medium text-sm max-w-xs mx-auto mb-8">Buka drawer kasir untuk memulai pencatatan transaksi hari ini.</p>
            <button @click="showOpenModal = true" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-primary/20 transition-all">
                Buka Drawer Sekarang
            </button>
        </div>
        @endif

        <!-- Open Drawer Modal -->
        <div x-show="showOpenModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div class="premium-card shadow-2xl w-full max-w-sm overflow-hidden" @click.away="showOpenModal = false">
                <form action="{{ route('cashier.drawer.open') }}" method="POST" class="p-8">
                    @csrf
                    <h3 class="text-xl font-black text-slate-900 mb-6">Buka Drawer Baru</h3>
                    <div class="space-y-4 mb-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Saldo Awal (Modal)</label>
                            <input type="number" name="starting_balance" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-black focus:ring-2 focus:ring-primary text-slate-900" required value="0">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" @click="showOpenModal = false" class="px-5 py-3 font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-xl text-sm transition-colors">Batal</button>
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 rounded-xl shadow-lg shadow-primary/20 text-sm transition-all">Buka Sekarang</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Close Drawer Modal -->
        <div x-show="showCloseModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div class="premium-card shadow-2xl w-full max-w-md overflow-hidden" @click.away="showCloseModal = false">
                <form action="{{ route('cashier.drawer.close') }}" method="POST" class="p-8">
                    @csrf
                    <h3 class="text-xl font-black text-slate-900 mb-2">Tutup Drawer</h3>
                    <p class="text-slate-500 text-sm font-medium mb-6">Hitung uang fisik di laci dan bandingkan dengan catatan sistem.</p>
                    
                    <div class="bg-slate-50 rounded-2xl p-6 mb-8 space-y-3">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-500 uppercase tracking-widest text-[10px] font-black">Saldo Sistem</span>
                            <span class="text-slate-900 font-black">Rp {{ number_format($drawer->current_balance ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Uang Fisik (Hasil Hitung)</label>
                            <input type="number" name="physical_cash" x-model="physicalCash" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-lg font-black focus:ring-2 focus:ring-primary text-slate-900" required>
                        </div>
                        
                        <template x-if="physicalCash > 0">
                            <div class="p-4 rounded-xl text-sm font-bold" :class="physicalCash == {{ $drawer->current_balance ?? 0 }} ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'">
                                <span x-show="physicalCash == {{ $drawer->current_balance ?? 0 }}">Sesuai ✓</span>
                                <span x-show="physicalCash != {{ $drawer->current_balance ?? 0 }}">Selisih ✗ (<span x-text="formatRupiah(physicalCash - {{ $drawer->current_balance ?? 0 }})"></span>)</span>
                            </div>
                        </template>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" @click="showCloseModal = false" class="px-5 py-3 font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-xl text-sm transition-colors">Batal</button>
                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-rose-600/20 text-sm transition-all">Tutup & Rekonsiliasi</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Terima Setoran COD Modal -->
        <div x-show="showCODModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div class="premium-card shadow-2xl w-full max-w-lg overflow-hidden" @click.away="showCODModal = false">
                <div class="p-8 space-y-6">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">Terima Setoran COD</h3>
                        <p class="text-[10px] font-black text-primary mt-1 uppercase tracking-widest" x-text="codModal.tracking_number"></p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-5 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-bold">Pengirim</span>
                            <span class="font-black text-slate-900" x-text="codModal.sender_name"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-bold">Penerima</span>
                            <span class="font-black text-slate-900" x-text="codModal.receiver_name"></span>
                        </div>
                        <div class="flex justify-between text-sm border-t border-slate-200 pt-3">
                            <span class="text-slate-400 font-bold">Total COD</span>
                            <span class="font-black text-primary text-lg" x-text="formatRupiah(codModal.amount)"></span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Diterima dari Kurir *</label>
                            <select x-model="codModal.courier_id" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900" required>
                                <option value="">Pilih Kurir</option>
                                @foreach($couriers as $courier)
                                <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Metode Setor *</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition-all" :class="codModal.method === 'tunai' ? 'ring-2 ring-primary' : ''">
                                    <input type="radio" x-model="codModal.method" value="tunai" class="w-4 h-4 text-primary">
                                    <span class="text-sm font-bold text-slate-700">Tunai ke Kasir</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition-all" :class="codModal.method === 'transfer' ? 'ring-2 ring-primary' : ''">
                                    <input type="radio" x-model="codModal.method" value="transfer" class="w-4 h-4 text-primary">
                                    <span class="text-sm font-bold text-slate-700">Transfer Rekening</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">Catatan (Opsional)</label>
                            <textarea x-model="codModal.note" rows="2" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary text-slate-900" placeholder="Catatan tambahan..."></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" @click="showCODModal = false" class="py-4 bg-slate-100 text-slate-600 font-black rounded-2xl uppercase tracking-widest text-[10px]">Batal</button>
                        <button type="button" @click="submitCOD()" :disabled="!codModal.courier_id || !codModal.method" class="py-4 bg-amber-500 hover:bg-amber-600 disabled:opacity-50 text-white font-black rounded-2xl shadow-xl shadow-amber-500/20 uppercase tracking-widest text-[10px] transition-all">Konfirmasi Terima</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function drawerPage() {
        return {
            showOpenModal: false,
            showCloseModal: false,
            showCODModal: false,
            activeTab: 'all',
            physicalCash: '',
            codModal: {
                shipment_id: null,
                tracking_number: '',
                sender_name: '',
                receiver_name: '',
                amount: 0,
                courier_id: '',
                method: '',
                note: '',
            },

            openCODModal(shipmentId, trackingNumber, receiverName, amount, senderName) {
                this.codModal = {
                    shipment_id: shipmentId,
                    tracking_number: trackingNumber,
                    receiver_name: receiverName,
                    sender_name: senderName,
                    amount: amount,
                    courier_id: '',
                    method: '',
                    note: '',
                };
                this.showCODModal = true;
            },

            submitCOD() {
                if (!this.codModal.courier_id || !this.codModal.method) return;

                fetch('{{ route('cashier.receive-cod') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        shipment_id: this.codModal.shipment_id,
                        courier_id: this.codModal.courier_id,
                        method: this.codModal.method,
                        amount: this.codModal.amount,
                        note: this.codModal.note,
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.showCODModal = false;
                        window.location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + (data.message || ''));
                    }
                })
                .catch(() => alert('Gagal memproses permintaan.'));
            },

            formatRupiah(val) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
            }
        }
    }
    </script>
</x-admin-layout>

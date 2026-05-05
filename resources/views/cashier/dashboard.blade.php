@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <!-- Premium Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">KASIR <span class="text-primary">DASHBOARD</span></h1>
            <p class="text-slate-500 font-medium mt-1">Selamat datang kembali, <span class="text-primary font-bold">{{ $nama_kasir }}</span> • {{ $cabang }}</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="px-6 py-3 bg-white border border-slate-100 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-xs font-bold text-slate-600 uppercase tracking-widest">{{ now()->translatedFormat('d M Y') }}</span>
            </div>
            <a href="{{ route('shipments.create') }}" class="px-8 py-4 bg-primary hover:bg-primary/90 text-white rounded-2xl font-bold text-sm transition-all shadow-xl shadow-primary/20 flex items-center gap-3 group">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Pengiriman Baru
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="premium-card p-8 group hover:border-primary/50">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Hari Ini</span>
            </div>
            <h3 class="text-4xl font-black text-slate-900 mb-1">{{ number_format($total_paket_hari_ini) }}</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest">Total Paket Masuk</p>
        </div>

        <div class="premium-card p-8 group hover:border-emerald-500/50">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Revenue</span>
            </div>
            <h3 class="text-4xl font-black text-slate-900 mb-1">Rp {{ number_format($total_omzet_hari_ini, 0, ',', '.') }}</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest">Omzet Hari Ini</p>
        </div>

        <div class="premium-card p-8 group hover:border-amber-500/50">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Drawer Status</span>
            </div>
            <h3 class="text-4xl font-black {{ $cash_drawer && $cash_drawer->status === 'open' ? 'text-emerald-600' : 'text-slate-900' }} mb-1">{{ $cash_drawer ? strtoupper($cash_drawer->status) : 'CLOSED' }}</h3>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest">
                Saldo: <span class="text-slate-900">Rp {{ number_format($cash_drawer->current_balance ?? 0, 0, ',', '.') }}</span>
            </p>
        </div>
    </div>

    <!-- Recent Activity & Tools -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Shipments -->
        <div class="lg:col-span-2 premium-card overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest">Pengiriman Terakhir</h3>
                <a href="{{ route('cashier.transactions') }}" class="text-primary text-xs font-black hover:underline tracking-widest uppercase">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-white">
                            <th class="px-8 py-5">No. Resi</th>
                            <th class="px-8 py-5">Penerima</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recent_shipments as $shipment)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-slate-900 block">{{ $shipment->tracking_number }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $shipment->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-slate-600">{{ $shipment->receiver_name }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border
                                    {{ $shipment->status === 'delivered' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-blue-50 text-blue-600 border-blue-100' }}">
                                    {{ str_replace('_', ' ', $shipment->status) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-sm font-black text-slate-900">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        </div>

        <!-- Pickup Masuk -->
        <div class="lg:col-span-2 premium-card overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-amber-50/30">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Pickup Masuk (Siap Proses)
                </h3>
                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-black rounded-full uppercase tracking-widest">
                    {{ $pickups->count() }} Paket
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-white">
                            <th class="px-8 py-5">Pengirim</th>
                            <th class="px-8 py-5">Detail Pickup</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($pickups as $p)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-slate-900 block">{{ $p->sender_name }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->sender_phone }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-medium text-slate-600 block">{{ $p->goods_type }} ({{ $p->actual_weight }} Kg)</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-bold text-primary uppercase tracking-widest">Oleh: {{ $p->courier->name ?? 'Kurir' }}</span>
                                    @if($p->status === 'picked_up')
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[8px] font-black uppercase rounded border border-amber-100">OTW Gudang</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-black uppercase rounded border border-emerald-100">Tiba</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                @if($p->status === 'arrived_at_branch')
                                    <button onclick="openProcessModal({{ $p->id }}, '{{ $p->sender_name }}', {{ $p->actual_weight }})" class="px-5 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary transition-all shadow-lg shadow-slate-900/10">Proses Resi</button>
                                @else
                                    <button disabled class="px-5 py-2 bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl cursor-not-allowed">Menunggu</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center text-slate-400 text-sm font-medium">Belum ada paket pickup yang tiba.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tools and Help -->
        <div class="space-y-8">
            <div class="premium-card p-8">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-widest mb-8">Alat Kasir</h3>
                <div class="grid grid-cols-2 gap-5">
                    <a href="{{ route('cashier.drawer') }}" class="p-6 bg-slate-50 rounded-3xl flex flex-col items-center gap-4 hover:bg-primary hover:text-white transition-all group shadow-sm">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-slate-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-center">Cash Drawer</span>
                    </a>
                    <a href="{{ route('reports.index') }}" class="p-6 bg-slate-50 rounded-3xl flex flex-col items-center gap-4 hover:bg-primary hover:text-white transition-all group shadow-sm">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-slate-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-center">Reports</span>
                    </a>
                </div>
            </div>

            <div class="bg-primary p-8 rounded-[2.5rem] relative overflow-hidden group shadow-2xl shadow-primary/20">
                <div class="relative z-10">
                    <h4 class="text-xl font-black text-white mb-2">Butuh Bantuan?</h4>
                    <p class="text-white/70 text-sm mb-6 leading-relaxed">Hubungi Manager cabang jika terjadi kendala pada sistem kasir.</p>
                    <button class="w-full py-4 bg-white text-primary rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all shadow-lg active:scale-95">
                        Hubungi Manager
                    </button>
                </div>
                <!-- Abstract Shape -->
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<!-- Process Pickup Modal -->
<div id="processModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[100] hidden items-center justify-center p-6">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden animate-reveal">
        <div class="p-10 border-b border-slate-50">
            <h3 id="modalTitle" class="text-2xl font-black text-slate-900">Proses Resi Pickup</h3>
            <p class="text-slate-500 text-sm mt-2">Ubah data pickup menjadi resi pengiriman resmi.</p>
        </div>
        <form id="processForm" onsubmit="submitProcess(event)" class="p-10 space-y-6">
            @csrf
            <input type="hidden" name="pickup_id" id="modalPickupId">
            
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Berat Aktual (Kg)</label>
                    <input type="number" step="0.1" name="official_weight" id="officialWeight" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all" required>
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Ongkir (Rp)</label>
                    <input type="number" name="total_price" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all" required>
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Metode Pembayaran</label>
                <select name="payment_method" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all" required>
                    <option value="cash">Tunai (Cash)</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="cod">COD (Bayar di Tujuan)</option>
                    <option value="midtrans">Digital Payment</option>
                </select>
            </div>

            <div class="flex items-center gap-4 pt-6">
                <button type="button" onclick="closeProcessModal()" class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" class="flex-[2] py-4 bg-primary text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-900 transition-all shadow-xl shadow-primary/20">Cetak Resi & Selesai</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openProcessModal(id, name, weight) {
        document.getElementById('modalPickupId').value = id;
        document.getElementById('modalTitle').innerText = 'Proses Pickup: ' + name;
        document.getElementById('officialWeight').value = weight;
        document.getElementById('processModal').classList.remove('hidden');
        document.getElementById('processModal').classList.add('flex');
    }

    function closeProcessModal() {
        document.getElementById('processModal').classList.add('hidden');
        document.getElementById('processModal').classList.remove('flex');
    }

    async function submitProcess(e) {
        e.preventDefault();
        const formData = new FormData(document.getElementById('processForm'));
        
        try {
            const response = await fetch("{{ route('cashier.pickup.process') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });
            const res = await response.json();
            if (res.success) {
                alert(res.message + ' Nomor Resi: ' + res.tracking_number);
                location.reload();
            } else {
                alert('Gagal memproses.');
            }
        } catch (err) {
            alert('Terjadi kesalahan sistem.');
        }
    }
</script>
@endsection

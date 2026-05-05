@extends('layouts.admin')

@section('title_breadcrumb', 'Pickup Requests')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pickup Requests</h1>
            <p class="text-slate-500 font-medium">Manajemen seluruh permintaan penjemputan paket pelanggan.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
        <form id="filterForm" method="GET" action="{{ route('cashier.pickups') }}" class="flex w-full lg:w-auto gap-3">
            <div class="relative flex-grow lg:flex-initial">
                <select name="status" onchange="this.form.submit()" class="w-full lg:w-48 appearance-none rounded-xl border-slate-200 text-sm font-bold text-slate-600 focus:ring-4 focus:ring-primary/10 focus:border-primary bg-white pl-6 pr-12 py-3 shadow-sm transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="assigned_pickup" {{ request('status') === 'assigned_pickup' ? 'selected' : '' }}>Kurir Ditugaskan</option>
                    <option value="on_the_way" {{ request('status') === 'on_the_way' ? 'selected' : '' }}>Menuju Lokasi</option>
                    <option value="picked_up" {{ request('status') === 'picked_up' ? 'selected' : '' }}>Paket Diambil (OTW)</option>
                    <option value="arrived_at_branch" {{ request('status') === 'arrived_at_branch' ? 'selected' : '' }}>Tiba di Cabang</option>
                    <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Selesai (Resi)</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal Jemput</option>
                </select>
                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
            
            <div class="relative flex-grow lg:w-[350px]">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pengirim, resi..." 
                       class="w-full pl-14 pr-6 py-3 rounded-xl border-slate-200 bg-white text-sm font-bold text-slate-700 placeholder:text-slate-400 placeholder:font-medium focus:ring-4 focus:ring-primary/10 focus:border-primary shadow-sm transition-all">
                <button type="submit" class="hidden"></button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail Pelanggan</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Paket</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Request</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status / Kurir</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @forelse($pickups as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="text-sm font-black text-slate-900 block">{{ $p->sender_name }}</span>
                            <span class="text-xs font-bold text-slate-500">{{ $p->sender_phone }}</span>
                            <span class="text-[10px] font-medium text-slate-400 block mt-1 line-clamp-1 w-48" title="{{ $p->sender_address }}">{{ $p->sender_address }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-bold text-slate-700 block">{{ $p->goods_type }}</span>
                            <span class="text-xs font-bold text-slate-400 block">Est. {{ $p->estimated_weight }} Kg ({{ $p->vehicle_type }})</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-bold text-slate-700 block">{{ $p->created_at->format('d M Y') }}</span>
                            <span class="text-xs font-bold text-slate-400 block">{{ $p->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-slate-100 text-slate-600 border-slate-200',
                                    'assigned_pickup' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'on_the_way' => 'bg-sky-50 text-sky-600 border-sky-100',
                                    'picked_up' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'arrived_at_branch' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'processed' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                    'failed' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ];
                                $color = $statusColors[$p->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $color }}">
                                {{ str_replace('_', ' ', $p->status) }}
                            </span>
                            @if($p->courier)
                                <span class="text-[10px] font-bold text-primary uppercase tracking-widest block mt-2">Kurir: {{ $p->courier->name }}</span>
                            @else
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mt-2">Belum ada kurir</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            @if($p->status === 'arrived_at_branch')
                                <button onclick="openProcessModal({{ $p->id }}, '{{ $p->sender_name }}', {{ $p->actual_weight ?? $p->estimated_weight }})" class="px-6 py-2.5 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary transition-all shadow-lg shadow-slate-900/10">Proses Resi</button>
                            @elseif($p->status === 'processed')
                                <span class="text-xs font-black text-emerald-500">SELESAI</span>
                            @else
                                <button disabled class="px-6 py-2.5 bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl cursor-not-allowed">Menunggu</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                </div>
                                <p class="text-slate-400 font-bold">Tidak ada data pickup yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pickups->hasPages())
        <div class="p-6 border-t border-slate-50 bg-slate-50/30">
            {{ $pickups->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Process Pickup Modal -->
<div id="processModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[100] hidden items-center justify-center p-6 transition-all opacity-0">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden scale-95 transition-all" id="modalContent">
        <div class="p-10 border-b border-slate-50 flex items-center justify-between">
            <div>
                <h3 id="modalTitle" class="text-2xl font-black text-slate-900">Proses Resi Pickup</h3>
                <p class="text-slate-500 text-sm mt-2">Ubah data pickup menjadi resi pengiriman resmi.</p>
            </div>
            <button type="button" onclick="closeProcessModal()" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="processForm" onsubmit="submitProcess(event)" class="p-10 space-y-6">
            @csrf
            <input type="hidden" name="pickup_id" id="modalPickupId">
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kota Asal</label>
                        <select name="origin_location_id" id="originLocation" onchange="autoCalculateRate()" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all" required>
                            <option value="">Pilih Kota Asal</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kota Tujuan</label>
                        <select name="destination_location_id" id="destinationLocation" onchange="autoCalculateRate()" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all" required>
                            <option value="">Pilih Kota Tujuan</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Berat (Kg)</label>
                        <input type="number" step="0.1" name="official_weight" id="officialWeight" oninput="autoCalculateRate()" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Panjang</label>
                        <input type="number" name="length" id="length" oninput="autoCalculateRate()" placeholder="cm" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Lebar</label>
                        <input type="number" name="width" id="width" oninput="autoCalculateRate()" placeholder="cm" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tinggi</label>
                        <input type="number" name="height" id="height" oninput="autoCalculateRate()" placeholder="cm" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all">
                    </div>
                </div>

                <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl shadow-primary/10">
                    <div class="flex justify-between items-center text-sm mb-2" id="volumetricDisplay" style="display: none;">
                        <span class="text-slate-400">Berat Volumetrik</span>
                        <span class="font-bold text-amber-400" id="volumetricValue">0 Kg</span>
                    </div>
                    <div class="flex justify-between items-center text-sm mb-4">
                        <span class="text-slate-400">Chargeable Weight</span>
                        <span class="font-bold text-primary" id="chargeableValue">0 Kg</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-white/10 pt-4">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Ongkir</span>
                        <span class="text-2xl font-black text-white" id="totalPriceDisplay">Rp 0</span>
                    </div>
                    <p id="rateError" class="text-xs text-rose-400 font-bold mt-2 text-center" style="display: none;"></p>
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Metode Pembayaran</label>
                <select name="payment_method" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all cursor-pointer" required>
                    <option value="cash">Tunai (Cash)</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="cod">COD (Bayar di Tujuan)</option>
                    <option value="midtrans">Digital Payment</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-primary text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-slate-900 transition-all shadow-xl shadow-primary/20">Cetak Resi & Selesai</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const modal = document.getElementById('processModal');
    const modalContent = document.getElementById('modalContent');

    let calculateTimeout;

    function autoCalculateRate() {
        clearTimeout(calculateTimeout);
        calculateTimeout = setTimeout(() => {
            const originId = document.getElementById('originLocation').value;
            const destId = document.getElementById('destinationLocation').value;
            const weight = document.getElementById('officialWeight').value;
            const length = document.getElementById('length').value;
            const width = document.getElementById('width').value;
            const height = document.getElementById('height').value;

            if (!originId || !destId || !weight) {
                document.getElementById('totalPriceDisplay').innerText = 'Rp 0';
                document.getElementById('chargeableValue').innerText = '0 Kg';
                document.getElementById('volumetricDisplay').style.display = 'none';
                return;
            }

            fetch('{{ url('/shipments/calculate-rate') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    origin_location_id: originId,
                    destination_location_id: destId,
                    weight: weight,
                    length: length,
                    width: width,
                    height: height
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.total_price) {
                    document.getElementById('totalPriceDisplay').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.total_price);
                    document.getElementById('chargeableValue').innerText = data.chargeable_weight + ' Kg';
                    
                    if (data.volumetric_weight) {
                        document.getElementById('volumetricValue').innerText = data.volumetric_weight + ' Kg';
                        document.getElementById('volumetricDisplay').style.display = 'flex';
                    } else {
                        document.getElementById('volumetricDisplay').style.display = 'none';
                    }
                    
                    document.getElementById('rateError').style.display = 'none';
                } else {
                    document.getElementById('totalPriceDisplay').innerText = 'Rp 0';
                    document.getElementById('rateError').innerText = 'Rute pengiriman tidak tersedia.';
                    document.getElementById('rateError').style.display = 'block';
                }
            });
        }, 500);
    }

    function openProcessModal(id, name, weight) {
        document.getElementById('modalPickupId').value = id;
        document.getElementById('modalTitle').innerText = 'Proses: ' + name;
        document.getElementById('officialWeight').value = weight;
        
        // Reset fields
        document.getElementById('length').value = '';
        document.getElementById('width').value = '';
        document.getElementById('height').value = '';
        document.getElementById('originLocation').value = '';
        document.getElementById('destinationLocation').value = '';
        autoCalculateRate();
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger animation
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeProcessModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    async function submitProcess(e) {
        e.preventDefault();
        
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

        const formData = new FormData(document.getElementById('processForm'));
        
        try {
            const response = await fetch("{{ route('cashier.pickup.process') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });
            const res = await response.json();
            
            if (res.success) {
                closeProcessModal();
                Swal.fire({
                    title: 'Berhasil!',
                    html: `${res.message}<br><br>Nomor Resi:<br><b class="text-xl text-primary">${res.tracking_number}</b>`,
                    icon: 'success',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Gagal', res.message || 'Terjadi kesalahan.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        } catch (err) {
            Swal.fire('Error', 'Gagal memproses data. Silakan coba lagi.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }
</script>
@endpush
@endsection

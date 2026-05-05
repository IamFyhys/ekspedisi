@extends('layouts.admin')

@section('title_breadcrumb', 'Manajemen Pickup')

@section('content')
<style>
.pickup-card {
  background: #fff;
  border: 1px solid #e8edf2;
  border-radius: 16px;
  padding: 20px 24px;
  display: flex;
  gap: 20px;
  align-items: stretch;
  border-left: 4px solid #16a34a; /* aksen kiri tetap */
  transition: box-shadow 0.2s ease, transform 0.2s ease;
  margin-bottom: 12px;
}

.pickup-card:hover {
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
  transform: translateY(-2px);
}

.pickup-card-left {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0;
}

.pickup-card-right {
  width: 160px;
  flex-shrink: 0;
  border-left: 1px solid #f1f5f9;
  padding-left: 20px;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: space-between;
}

.pickup-code {
  font-size: 13px;
  font-weight: 700;
  color: #1e2d4a;
  font-family: 'Courier New', monospace;
  letter-spacing: 0.03em;
}

.pickup-meta {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-top: 6px;
}

.pickup-meta-item {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 12px;
  color: #64748b;
}

.pickup-meta-item svg {
  width: 12px;
  height: 12px;
  stroke: #94a3b8;
  flex-shrink: 0;
}

.pickup-divider {
  border: none;
  border-top: 1px solid #f1f5f9;
  margin: 14px 0;
}

.pickup-sender {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

.pickup-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #6366f1;
  color: #fff;
  font-size: 13px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.pickup-sender-name {
  font-size: 14px;
  font-weight: 600;
  color: #1e2d4a;
  line-height: 1.2;
}

.pickup-sender-phone {
  font-size: 12px;
  color: #64748b;
  margin-top: 1px;
}

.pickup-address {
  display: flex;
  align-items: flex-start;
  gap: 6px;
  font-size: 13px;
  color: #64748b;
  margin-bottom: 8px;
  line-height: 1.5;
}

.pickup-address svg {
  width: 13px;
  height: 13px;
  stroke: #94a3b8;
  flex-shrink: 0;
  margin-top: 2px;
}

.pickup-weight {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #64748b;
}

.pickup-weight svg {
  width: 13px;
  height: 13px;
  stroke: #94a3b8;
}

/* Badge status */
.pickup-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  font-weight: 700;
  padding: 5px 12px;
  border-radius: 20px;
  letter-spacing: 0.03em;
}

.pickup-badge.selesai {
  background: #dcfce7;
  color: #15803d;
}

.pickup-badge.pending {
  background: #fef9c3;
  color: #854d0e;
}

.pickup-badge.proses {
  background: #e0f2fe;
  color: #0369a1;
}

.pickup-badge.batal {
  background: #fee2e2;
  color: #b91c1c;
}

.pickup-badge svg {
  width: 11px;
  height: 11px;
}

/* Info kurir di kolom kanan */
.pickup-kurir-label {
  font-size: 10px;
  font-weight: 700;
  color: #94a3b8;
  letter-spacing: 0.08em;
  text-align: right;
  margin-bottom: 3px;
}

.pickup-kurir-name {
  font-size: 13px;
  font-weight: 600;
  color: #1e2d4a;
  text-align: right;
}
</style>

<div class="space-y-6 animate-reveal">
    <!-- Header & Summary Stats -->
    <div>
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-1">Manajemen Pickup</h1>
                <p class="text-sm font-medium text-slate-500">Pantau dan kelola seluruh permintaan penjemputan dari pelanggan.</p>
            </div>
            <a href="{{ route('pickup.index') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/30 hover:bg-slate-900 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                Lihat Form Publik
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $stats = [
                    [
                        'label' => 'Total Pickup',
                        'value' => $pickups->total(),
                        'color' => 'text-primary',
                        'bg'    => 'bg-blue-50',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3M9 11h14v10H9zM12 21v-2M20 21v-2"/>',
                    ],
                    [
                        'label' => 'Menunggu Assign',
                        'value' => collect($pickups->items())->where('status', 'pending')->count(),
                        'color' => 'text-amber-600',
                        'bg'    => 'bg-amber-50',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    ],
                    [
                        'label' => 'Dalam Proses',
                        'value' => collect($pickups->items())->whereIn('status', ['assigned_pickup', 'on_the_way', 'picked_up'])->count(),
                        'color' => 'text-purple-600',
                        'bg'    => 'bg-purple-50',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                    ],
                    [
                        'label' => 'Selesai Hari Ini',
                        'value' => collect($pickups->items())->where('status', 'processed')->count(),
                        'color' => 'text-emerald-600',
                        'bg'    => 'bg-emerald-50',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
                    ],
                ];
            @endphp

            @foreach($stats as $card)
            <div class="bg-white rounded-2xl p-5 border border-slate-100 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 {{ $card['bg'] }} {{ $card['color'] }} rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $card['icon'] !!}
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $card['label'] }}</div>
                    <div class="text-2xl font-black {{ $card['color'] }}">{{ $card['value'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-[14px] p-4 lg:p-5 border border-slate-100 shadow-sm mb-6">
        <form method="GET" action="{{ route('manager.pickups') }}" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
            
            <!-- Search -->
            <div style="flex: 1; min-width: 250px;">
                <label style="font-size: 11px; font-weight: 800; color: #94a3b8; display: block; margin-bottom: 8px;">CARI KODE / PENGIRIM</label>
                <div style="position: relative;">
                    <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kode atau nama pengirim..." style="width: 100%; height: 44px; padding-left: 44px; padding-right: 16px; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#185FA5'; this.style.background='#ffffff'" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'">
                </div>
            </div>

            <!-- Filter Status -->
            <div style="min-width: 220px; flex-shrink: 0;">
                <label style="font-size: 11px; font-weight: 800; color: #94a3b8; display: block; margin-bottom: 8px;">STATUS</label>
                <select name="status" style="width: 100%; height: 44px; padding: 0 16px; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; color: #334155; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#185FA5'; this.style.background='#ffffff'" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'">
                    <option value="">Semua Status</option>
                    @foreach([
                        'pending'           => 'Menunggu Assign',
                        'assigned_pickup'   => 'Sudah Di-assign',
                        'on_the_way'        => 'Dalam Perjalanan',
                        'picked_up'         => 'Paket Diambil',
                        'arrived_at_branch' => 'Tiba di Cabang',
                        'processed'         => 'Selesai Diproses',
                        'cancelled'         => 'Dibatalkan',
                    ] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div style="display: flex; gap: 8px; flex-shrink: 0;">
                <button type="submit" style="height: 44px; padding: 0 24px; background: #185FA5; color: #ffffff; border: none; border-radius: 12px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Terapkan
                </button>
                @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('manager.pickups') }}" style="height: 44px; padding: 0 20px; background: #f1f5f9; color: #64748b; border: none; border-radius: 12px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Cards List -->
    <div class="flex flex-col gap-4">
        @forelse($pickups as $pickup)
        @php
            $badgeClass = match($pickup->status) {
                'pending' => 'pending',
                'assigned_pickup', 'on_the_way', 'picked_up', 'arrived_at_branch' => 'proses',
                'processed' => 'selesai',
                'cancelled' => 'batal',
                default => 'pending',
            };
            
            $statusLabel = match($pickup->status) {
                'pending' => 'Menunggu Assign',
                'assigned_pickup' => 'Sudah Di-assign',
                'on_the_way' => 'Dalam Perjalanan',
                'picked_up' => 'Paket Diambil',
                'arrived_at_branch' => 'Tiba di Cabang',
                'processed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default => 'Unknown',
            };

            $statusIcon = match($pickup->status) {
                'processed' => '<path d="M20 6L9 17l-5-5"/>',
                'pending' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
                'cancelled' => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
                default => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
            };

            $borderColor = match($pickup->status) {
                'processed' => '#16a34a',
                'pending' => '#eab308',
                'cancelled' => '#dc2626',
                default => '#0ea5e9',
            };
        @endphp

        <div class="pickup-card" style="border-left-color: {{ $borderColor }};">

          {{-- Kolom kiri --}}
          <div class="pickup-card-left">

            {{-- Header: kode + badge status --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
              <span class="pickup-code">{{ $pickup->pickup_code }}</span>
              <span class="pickup-badge {{ $badgeClass }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  {!! $statusIcon !!}
                </svg>
                {{ $statusLabel }}
              </span>
            </div>

            {{-- Meta: tanggal & jam --}}
            <div class="pickup-meta">
              <div class="pickup-meta-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="4" width="18" height="18" rx="2"/>
                  <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                {{ \Carbon\Carbon::parse($pickup->pickup_date)->translatedFormat('d M Y') }}
              </div>
              <div class="pickup-meta-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"/>
                  <path d="M12 6v6l4 2"/>
                </svg>
                {{ $pickup->pickup_time }}
              </div>
            </div>

            <hr class="pickup-divider">

            {{-- Pengirim --}}
            <div class="pickup-sender">
              <div class="pickup-avatar">{{ strtoupper(substr($pickup->sender_name, 0, 1)) }}</div>
              <div>
                <div class="pickup-sender-name">{{ $pickup->sender_name }}</div>
                <div class="pickup-sender-phone">{{ $pickup->sender_phone }}</div>
              </div>
            </div>

            {{-- Alamat --}}
            <div class="pickup-address">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                <circle cx="12" cy="9" r="2.5"/>
              </svg>
              <div>{{ $pickup->sender_address }}</div>
            </div>

            {{-- Berat --}}
            <div class="pickup-weight">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16v-2"/>
                <path d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12"/>
              </svg>
              {{ abs($pickup->estimated_weight) }} Kg
            </div>

          </div>

          {{-- Kolom kanan: status & kurir --}}
          <div class="pickup-card-right">
            <div style="width: 100%;">
              @if($pickup->status === 'pending')
              <button onclick="openAssign('{{ $pickup->id }}', '{{ $pickup->pickup_code }}')" style="width: 100%; height: 36px; background: #185FA5; color: white; border: none; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                  <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                  Assign
              </button>
              @elseif($pickup->status === 'arrived_at_branch')
              <div style="width: 100%; text-align: center; font-size: 10px; font-weight: 700; color: #d97706; text-transform: uppercase; background: #fef3c7; padding: 10px 0; border-radius: 8px; border: 1px solid #fde68a;">
                  ⏳ Msk Kasir
              </div>
              @endif
            </div>
            
            <div style="text-align:right;">
              @if($pickup->courier)
              <div class="pickup-kurir-label">KURIR BERTUGAS</div>
              <div class="pickup-kurir-name">{{ $pickup->courier->name }}</div>
              @endif
            </div>
          </div>

        </div>
        @empty
        <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm">
            <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h4 class="text-xl font-black text-slate-900 mb-2">Belum Ada Pickup</h4>
            <p class="text-sm font-medium text-slate-500">Saat ini tidak ada data request pickup yang sesuai dengan filter.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($pickups->hasPages())
    <div class="mt-6">
        {{ $pickups->links() }}
    </div>
    @endif
</div>

<!-- Modal Assign Kurir -->
<div id="modalAssign" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[9999] hidden items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div id="modalAssignContent" class="bg-white rounded-[24px] w-full max-w-[440px] overflow-hidden shadow-2xl scale-95 transition-transform duration-300">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="text-lg font-black text-slate-900">Assign Kurir Pickup</h3>
                <p id="assignKode" class="text-xs font-bold text-primary mt-1 uppercase tracking-widest"></p>
            </div>
            <button onclick="closeAssign()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 hover:bg-rose-50 flex items-center justify-center transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('manager.pickup.assign') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="pickup_id" id="assignPickupId">

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Kurir *</label>
                <div class="relative">
                    <select name="courier_id" id="assignCourierId" class="w-full h-[48px] px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-black text-slate-900 focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white transition-all appearance-none cursor-pointer outline-none" required>
                        <option value="">-- Pilih Kurir Jemputan --</option>
                        @foreach($pickupCouriers as $courier)
                        <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-2 flex gap-3">
                <button type="button" onclick="closeAssign()" class="flex-1 py-3.5 bg-slate-100 text-slate-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                    Batal
                </button>
                <button type="submit" id="btnSubmitAssign" class="flex-[2] py-3.5 bg-primary text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Assign Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const modalAssign = document.getElementById('modalAssign');
    const modalContent = document.getElementById('modalAssignContent');

    function openAssign(id, kode) {
        document.getElementById('assignPickupId').value = id;
        document.getElementById('assignKode').textContent = kode;
        document.getElementById('assignCourierId').value = '';
        
        modalAssign.classList.remove('hidden');
        modalAssign.classList.add('flex');
        
        // Trigger animation
        setTimeout(() => {
            modalAssign.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeAssign() {
        modalAssign.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modalAssign.classList.add('hidden');
            modalAssign.classList.remove('flex');
        }, 300);
    }
</script>
@endpush
@endsection

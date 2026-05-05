@extends('layouts.premium')

@section('title', 'Lacak Pickup — Skynet Logistics')

@section('styles')
<style>
    .track-page { padding: 140px 0 80px; background: #f8fafc; min-height: 100vh; }
    .track-container { max-width: 600px; margin: 0 auto; }
    
    .search-card { background: #fff; padding: 32px; border-radius: 24px; border: 1px solid #e2e8f0; margin-bottom: 32px; }
    .search-group { display: flex; gap: 12px; }
    .search-input { 
        flex: 1; height: 52px; background: #f1f5f9; border: 2px solid transparent;
        border-radius: 14px; padding: 0 16px; font-size: 15px; font-weight: 600; outline: none;
    }
    .search-input:focus { border-color: #185FA5; background: #fff; }
    .btn-search { 
        padding: 0 24px; background: #185FA5; color: #fff; border: none;
        border-radius: 14px; font-weight: 700; cursor: pointer;
    }

    .status-card { background: #fff; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden; }
    .card-header { padding: 24px 32px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
    .card-body { padding: 32px; }
    
    .timeline { position: relative; padding-left: 32px; }
    .timeline::before { content: ''; position: absolute; left: 6px; top: 8px; bottom: 8px; width: 2px; background: #e2e8f0; }
    
    .timeline-item { position: relative; margin-bottom: 32px; }
    .timeline-dot { 
        position: absolute; left: -32px; top: 4px; width: 14px; height: 14px;
        background: #fff; border: 3px solid #cbd5e1; border-radius: 50%; z-index: 1;
    }
    .timeline-item.active .timeline-dot { border-color: #185FA5; background: #185FA5; box-shadow: 0 0 0 4px rgba(24,95,165,0.1); }
    .timeline-item.completed .timeline-dot { border-color: #16a34a; background: #16a34a; }

    .timeline-content h4 { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
    .timeline-content p { font-size: 13px; color: #64748b; }
    .timeline-time { font-size: 11px; font-weight: 600; color: #94a3b8; margin-top: 4px; }

    .badge { padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: 700; }
    .badge-pending { background: #fff7ed; color: #c2410c; }
    .badge-active { background: #f0f7ff; color: #185FA5; }
    .badge-success { background: #f0fdf4; color: #16a34a; }
</style>
@endsection

@section('content')
<div class="track-page">
    <div class="container track-container">
        <!-- Search -->
        <div class="search-card">
            <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 16px;">Lacak Permintaan Pickup</h3>
            <form action="{{ route('pickup.track') }}" method="GET" class="search-group">
                <input type="text" name="code" class="search-input" placeholder="Masukkan Kode Pickup (PKP-XXXX)" value="{{ request('code') }}" required>
                <button type="submit" class="btn-search">Cari</button>
            </form>
        </div>

        @if(isset($notFound))
        <div style="text-align: center; padding: 40px; background: #fff; border-radius: 24px; border: 1px solid #fee2e2;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" style="margin-bottom: 16px;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <h4 style="font-weight: 800; color: #1e293b; margin-bottom: 8px;">Kode Tidak Ditemukan</h4>
            <p style="color: #64748b;">Maaf, kode <strong>{{ $searchedCode }}</strong> tidak ada dalam catatan kami.</p>
        </div>
        @endif

        @if(isset($pickup) && $pickup)
        <div class="status-card">
            <div class="card-header">
                <div>
                    <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Kode Pickup</div>
                    <div style="font-size: 18px; font-weight: 900; color: #1e293b;">{{ $pickup->pickup_code }}</div>
                </div>
                @php
                    $statusBadge = match($pickup->status) {
                        'pending'           => ['Request Diterima', 'badge-pending'],
                        'assigned_pickup'   => ['Kurir Ditugaskan', 'badge-active'],
                        'on_the_way'        => ['Dalam Perjalanan', 'badge-active'],
                        'picked_up'         => ['Paket Diambil', 'badge-success'],
                        'arrived_at_branch' => ['Tiba di Cabang', 'badge-success'],
                        'processed'         => ['Selesai Diproses', 'badge-success'],
                        'cancelled'         => ['Dibatalkan', 'badge-pending'],
                        default             => ['Diproses', 'badge-pending'],
                    };
                @endphp
                <span class="badge {{ $statusBadge[1] }}">{{ $statusBadge[0] }}</span>
            </div>
            
            <div class="card-body">
                <div class="timeline">
                    <!-- Status Processed -->
                    <div class="timeline-item {{ $pickup->status === 'processed' ? 'active' : ($pickup->processed_by ? 'completed' : '') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h4>Paket Diproses Menjadi Resi</h4>
                            <p>Paket telah diverifikasi oleh kasir dan siap dikirim.</p>
                            @if($pickup->status === 'processed')
                                <div class="timeline-time">{{ $pickup->updated_at->format('d M Y, H:i') }} WIB</div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Arrived at Branch -->
                    <div class="timeline-item {{ $pickup->status === 'arrived_at_branch' ? 'active' : ($pickup->arrived_at ? 'completed' : '') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h4>Tiba di Cabang</h4>
                            <p>Kurir telah menyerahkan paket ke kantor cabang {{ $pickup->branch->city }}.</p>
                            @if($pickup->arrived_at)
                                <div class="timeline-time">{{ $pickup->arrived_at->format('d M Y, H:i') }} WIB</div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Picked Up -->
                    <div class="timeline-item {{ $pickup->status === 'picked_up' ? 'active' : ($pickup->picked_up_at ? 'completed' : '') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h4>Paket Diambil Kurir</h4>
                            <p>Kurir telah melakukan penjemputan di lokasi pengirim.</p>
                            @if($pickup->picked_up_at)
                                <div class="timeline-time">{{ $pickup->picked_up_at->format('d M Y, H:i') }} WIB</div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Assigned -->
                    <div class="timeline-item {{ $pickup->status === 'assigned_pickup' || $pickup->status === 'on_the_way' ? 'active' : ($pickup->courier_id ? 'completed' : '') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h4>Kurir Ditugaskan</h4>
                            <p>Kurir {{ $pickup->courier->name ?? 'Pickup' }} sedang bersiap menuju lokasi Anda.</p>
                        </div>
                    </div>

                    <!-- Status Pending -->
                    <div class="timeline-item {{ $pickup->status === 'pending' ? 'active' : 'completed' }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <h4>Permintaan Diterima</h4>
                            <p>Sistem telah mencatat permintaan pickup Anda.</p>
                            <div class="timeline-time">{{ $pickup->created_at->format('d M Y, H:i') }} WIB</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

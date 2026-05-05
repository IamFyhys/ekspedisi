@extends('layouts.premium')

@section('title', 'Courier Pickup Dashboard')

@section('styles')
<style>
    .dashboard-page { padding: 120px 0 80px; background: #f1f5f9; min-height: 100vh; }
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; }
    .stat-card { background: #fff; padding: 24px; border-radius: 20px; border: 1px solid #e2e8f0; }
    .stat-label { font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 8px; }
    .stat-value { font-size: 28px; font-weight: 900; color: #1e293b; }

    .pickup-list { background: #fff; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden; }
    .list-header { padding: 24px 32px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
    .pickup-item { padding: 24px 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; transition: background 0.2s; }
    .pickup-item:hover { background: #f8fafc; }
    
    .item-info h4 { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
    .item-info p { font-size: 14px; color: #64748b; margin-bottom: 4px; }
    .item-meta { display: flex; gap: 16px; font-size: 12px; font-weight: 600; color: #94a3b8; }
    
    .btn-action { padding: 10px 20px; border-radius: 12px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; }
    .btn-pickup { background: #185FA5; color: #fff; }
    .btn-arrived { background: #16a34a; color: #fff; }
    
    /* Modal */
    .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-content { background: #fff; width: 100%; max-width: 500px; border-radius: 24px; padding: 32px; }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
    .form-input { width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid #e2e8f0; outline: none; }
    .form-input:focus { border-color: #185FA5; }
</style>
@endsection

@section('content')
<div class="dashboard-page">
    <div class="container">
        <div style="margin-bottom: 32px;">
            <h1 style="font-size: 28px; font-weight: 900; color: #1e293b;">Halo, {{ auth()->user()->name }} 👋</h1>
            <p style="color: #64748b;">Berikut adalah jadwal penjemputan Anda hari ini.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Tugas</div>
                <div class="stat-value">{{ $stats['today'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Belum Diambil</div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Selesai</div>
                <div class="stat-value" style="color: #16a34a;">{{ $stats['completed'] }}</div>
            </div>
        </div>

        <div class="pickup-list">
            <div class="list-header">
                <h3 style="font-size: 18px; font-weight: 800;">Daftar Penjemputan</h3>
            </div>
            @forelse($pickups as $p)
            <div class="pickup-item">
                <div class="item-info">
                    <h4>{{ $p->sender_name }}</h4>
                    <p>{{ $p->sender_address }}</p>
                    <div class="item-meta">
                        <span>🕒 {{ $p->pickup_time }}</span>
                        <span>📦 {{ $p->goods_type }} (est. {{ $p->estimated_weight }}kg)</span>
                    </div>
                </div>
                <div>
                    @if($p->status === 'assigned_pickup')
                    <button class="btn-action btn-pickup" onclick="openPickupModal({{ $p->id }}, '{{ $p->sender_name }}')">Ambil Paket</button>
                    @elseif($p->status === 'picked_up')
                    <button class="btn-action btn-arrived" onclick="confirmArrival({{ $p->id }})">Sampai di Cabang</button>
                    @endif
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->sender_phone) }}?text=Halo%20{{ urlencode($p->sender_name) }},%20saya%20kurir%20Skynet%20Logistics%20ingin%20menjemput%20paket%20Anda.%20Apakah%20posisi%20sesuai%20alamat?" target="_blank" class="btn-action" style="background: #25D366; color: #fff; text-decoration: none;">
                        <svg style="width:16px;height:16px;display:inline;vertical-align:middle;margin-right:4px" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"></path></svg>
                        Hubungi
                    </a>
                </div>
            </div>
            @empty
            <div style="padding: 48px; text-align: center; color: #94a3b8;">
                Tidak ada jadwal penjemputan saat ini.
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Pickup -->
<div id="pickupModal" class="modal">
    <div class="modal-content">
        <h3 id="modalTitle" style="margin-bottom: 24px; font-size: 20px; font-weight: 800;">Ambil Paket</h3>
        <form id="pickupForm" onsubmit="submitPickup(event)">
            <input type="hidden" name="pickup_id" id="modalPickupId">
            <div class="form-group">
                <label class="form-label">Berat Aktual (Kg)</label>
                <input type="number" name="actual_weight" id="actualWeight" class="form-input" step="0.1" required>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Paket / Bukti Pickup</label>
                <input type="file" name="pickup_photo" id="pickupPhoto" class="form-input" accept="image/*" required>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan (Opsional)</label>
                <textarea name="note" id="pickupNote" class="form-input" rows="2"></textarea>
            </div>
            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="button" class="btn-action" style="flex: 1; background: #f1f5f9; color: #64748b;" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-action" style="flex: 2; background: #185FA5; color: #fff;">Konfirmasi Pickup</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openPickupModal(id, name) {
        document.getElementById('modalPickupId').value = id;
        document.getElementById('modalTitle').innerText = 'Ambil Paket: ' + name;
        document.getElementById('pickupModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('pickupModal').style.display = 'none';
    }

    async function submitPickup(e) {
        e.preventDefault();
        const formData = new FormData(document.getElementById('pickupForm'));
        
        try {
            const response = await fetch("{{ route('courier.pickup.confirm') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });
            const res = await response.json();
            if (res.success) {
                location.reload();
            }
        } catch (err) {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    async function confirmArrival(id) {
        if (!confirm('Konfirmasi bahwa paket sudah sampai di cabang?')) return;
        
        try {
            const response = await fetch("{{ route('courier.pickup.arrived') }}", {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ pickup_id: id })
            });
            const res = await response.json();
            if (res.success) {
                location.reload();
            }
        } catch (err) {
            alert('Terjadi kesalahan.');
        }
    }
</script>
@endsection

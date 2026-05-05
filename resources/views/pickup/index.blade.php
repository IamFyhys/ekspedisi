@extends('layouts.premium')

@section('title', 'Request Pickup — Skynet Logistics')

@section('styles')
<style>
    .pickup-page { padding: 140px 0 80px; background: #f8fafc; min-height: 100vh; }
    .form-container { max-width: 800px; margin: 0 auto; background: #fff; border-radius: 32px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    
    .form-header { 
        background: linear-gradient(135deg, #1e2d4a 0%, #185FA5 100%);
        padding: 48px 40px;
        color: #fff;
    }
    .form-header h1 { font-size: 32px; font-weight: 900; margin-bottom: 12px; }
    .form-header p { color: rgba(255,255,255,0.7); font-size: 16px; }

    .form-body { padding: 48px 40px; }
    .form-section { margin-bottom: 48px; }
    .section-title { 
        font-size: 13px; font-weight: 800; color: #94a3b8; 
        text-transform: uppercase; letter-spacing: 0.1em;
        margin-bottom: 24px; display: flex; align-items: center; gap: 12px;
    }
    .section-title::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }

    .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .full-width { grid-column: 1 / -1; }

    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
    .form-input {
        width: 100%; height: 52px; background: #f8fafc; border: 2px solid #e2e8f0;
        border-radius: 14px; padding: 0 20px; font-size: 15px; font-weight: 500;
        color: #1e293b; outline: none; transition: all 0.2s;
    }
    .form-input:focus { border-color: #185FA5; background: #fff; box-shadow: 0 0 0 4px rgba(24, 95, 165, 0.1); }
    
    textarea.form-input { height: auto; padding: 16px 20px; }

    .time-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .time-option {
        padding: 16px; border: 2px solid #e2e8f0; border-radius: 14px;
        background: #f8fafc; cursor: pointer; text-align: center;
        transition: all 0.2s;
    }
    .time-option.active { border-color: #185FA5; background: #f0f7ff; color: #185FA5; font-weight: 700; }
    
    .btn-submit {
        width: 100%; height: 60px; background: #185FA5; color: #fff;
        border: none; border-radius: 16px; font-size: 18px; font-weight: 800;
        cursor: pointer; transition: all 0.3s; display: flex; align-items: center;
        justify-content: center; gap: 12px; margin-top: 24px;
    }
    .btn-submit:hover { background: #1449a0; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(24,95,165,0.4); }

    @media (max-width: 768px) {
        .grid-form { grid-template-columns: 1fr; }
        .form-header, .form-body { padding: 32px 24px; }
    }
</style>
@endsection

@section('content')
<div class="pickup-page">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h1>Request Pickup</h1>
                <p>Isi formulir di bawah ini dan kurir kami akan segera menjemput paket Anda sesuai jadwal.</p>
            </div>

            <form action="{{ route('pickup.store') }}" method="POST" class="form-body">
                @csrf

                @if ($errors->any())
                    <div style="background: #fef2f2; border: 1px solid #fee2e2; padding: 16px; border-radius: 12px; margin-bottom: 24px;">
                        <ul style="margin: 0; padding-left: 20px; color: #b91c1c; font-size: 14px; font-weight: 500;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Info Pengirim -->
                <div class="form-section">
                    <div class="section-title">Informasi Pengirim</div>
                    <div class="grid-form">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="sender_name" class="form-input" placeholder="Contoh: Ahmad Fauzi" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="tel" name="sender_phone" class="form-input" placeholder="08xxxxxxxx" required>
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Alamat Penjemputan</label>
                            <textarea name="sender_address" class="form-input" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kota / Kabupaten</label>
                            <input type="text" name="sender_city" class="form-input" placeholder="Contoh: Surabaya" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Cabang Terdekat</label>
                            <select name="branch_id" class="form-input" style="padding: 0 16px;" required>
                                <option value="">Pilih Cabang</option>
                                @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }} ({{ $branch->city }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Info Paket -->
                <div class="form-section">
                    <div class="section-title">Detail Paket</div>
                    <div class="grid-form">
                        <div class="form-group">
                            <label class="form-label">Jenis Barang</label>
                            <select name="goods_type" class="form-input" style="padding: 0 16px;" required>
                                <option value="Dokumen">Dokumen</option>
                                <option value="Pakaian">Pakaian</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Estimasi Berat (Kg)</label>
                            <input type="number" name="estimated_weight" class="form-input" step="0.1" value="1.0" required>
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Deskripsi Tambahan</label>
                            <textarea name="goods_description" class="form-input" rows="2" placeholder="Informasi tambahan tentang isi paket..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Info Penerima -->
                <div class="form-section">
                    <div class="section-title">Informasi Penerima</div>
                    <div class="grid-form">
                        <div class="form-group">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="receiver_name" class="form-input" placeholder="Nama lengkap penerima" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor WhatsApp Penerima</label>
                            <input type="tel" name="receiver_phone" class="form-input" placeholder="08xxxxxxxx" required>
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Alamat Tujuan</label>
                            <textarea name="receiver_address" class="form-input" rows="3" placeholder="Alamat lengkap penerima..." required></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Kota Tujuan</label>
                            <input type="text" name="receiver_city" class="form-input" placeholder="Contoh: Jakarta" required>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Pickup -->
                <div class="form-section">
                    <div class="section-title">Jadwal Penjemputan</div>
                    <div class="grid-form">
                        <div class="form-group">
                            <label class="form-label">Tanggal Pickup</label>
                            <input type="date" name="pickup_date" class="form-input" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Waktu Pickup</label>
                            <div class="time-grid" id="timeGrid">
                                <div class="time-option" onclick="selectTime(this, '08:00-10:00')">08:00 - 10:00</div>
                                <div class="time-option" onclick="selectTime(this, '10:00-12:00')">10:00 - 12:00</div>
                                <div class="time-option" onclick="selectTime(this, '13:00-15:00')">13:00 - 15:00</div>
                                <div class="time-option" onclick="selectTime(this, '15:00-17:00')">15:00 - 17:00</div>
                            </div>
                            <input type="hidden" name="pickup_time" id="pickupTime" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"></path><path d="M7 18a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path><path d="M17 18a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path><path d="M13 18h4"></path><path d="M7 18h4"></path></svg>
                    Kirim Permintaan Pickup
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function selectTime(el, time) {
        document.querySelectorAll('.time-option').forEach(opt => opt.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('pickupTime').value = time;
    }
    // Highlight required: show validation hint if no time selected
    document.querySelector('.btn-submit').addEventListener('click', function(e) {
        if (!document.getElementById('pickupTime').value) {
            e.preventDefault();
            document.getElementById('timeGrid').style.borderColor = '#ef4444';
            document.getElementById('timeGrid').style.outline = '2px solid #fca5a5';
            document.getElementById('timeGrid').style.borderRadius = '16px';
            document.getElementById('timeGrid').style.padding = '8px';
            alert('Silakan pilih waktu pickup terlebih dahulu.');
        }
    });
</script>
@endpush


@extends('layouts.premium')

@section('title', 'Permintaan Pickup Berhasil — Skynet Logistics')

@section('styles')
<style>
    .success-page {
        padding: 140px 0 80px;
        background: #f8fafc;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
    .success-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 24px;
        animation: fadeUp 0.6s ease both;
    }
    @keyframes fadeUp {
        from { opacity:0; transform: translateY(24px); }
        to   { opacity:1; transform: translateY(0); }
    }

    /* Success card */
    .success-card {
        background: #fff;
        border-radius: 32px;
        padding: 52px 44px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 20px 60px rgba(0,0,0,0.07);
        text-align: center;
    }

    /* Icon */
    .success-icon {
        width: 88px; height: 88px;
        border-radius: 50%;
        background: linear-gradient(135deg,#f0fdf4,#dcfce7);
        border: 3px solid #bbf7d0;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 28px;
        animation: popIn 0.5s 0.3s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes popIn {
        from { opacity:0; transform: scale(0.6); }
        to   { opacity:1; transform: scale(1); }
    }

    /* Kode box */
    .code-box {
        background: linear-gradient(135deg,#f1f5f9,#e9f0f8);
        border: 2px dashed #cbd5e1;
        border-radius: 20px;
        padding: 24px 28px;
        margin: 28px 0;
        position: relative;
    }
    .code-label {
        font-size: 11px; font-weight: 700;
        color: #94a3b8; letter-spacing: 0.1em;
        text-transform: uppercase; margin-bottom: 10px;
    }
    .code-value {
        font-size: 30px; font-weight: 900;
        color: #1e293b; letter-spacing: 3px;
    }
    .copy-btn {
        position: absolute; top: 12px; right: 12px;
        background: #6366f1; color: #fff;
        border: none; border-radius: 8px;
        padding: 6px 12px; font-size: 11px;
        font-weight: 700; cursor: pointer;
        display: flex; align-items: center; gap: 4px;
        transition: all 0.2s;
    }
    .copy-btn:hover { background: #4f46e5; }

    /* Steps */
    .steps { margin: 28px 0; text-align: left; }
    .step-item {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .step-item:last-child { border-bottom: none; }
    .step-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: #eef2ff; color: #6366f1;
        font-size: 12px; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 2px;
    }
    .step-text { font-size: 13px; color: #475569; line-height: 1.5; }
    .step-text strong { color: #1e293b; display: block; font-size: 14px; margin-bottom: 2px; }

    /* Buttons */
    .action-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 28px;
    }
    .action-btn {
        height: 52px; border-radius: 16px;
        font-size: 14px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        text-decoration: none; cursor: pointer; border: none;
        transition: all 0.2s;
    }
    .btn-track   { background: #185FA5; color: #fff; box-shadow: 0 4px 14px rgba(24,95,165,0.3); }
    .btn-track:hover { background: #1449a0; transform: translateY(-2px); }
    .btn-home    { background: #f1f5f9; color: #1e2d4a; }
    .btn-home:hover  { background: #e2e8f0; }

    .note-text { font-size: 12px; color: #94a3b8; margin-top: 20px; }
</style>
@endsection

@section('content')
<div class="success-page">
    <div class="success-wrapper">
        <div class="success-card">
            <div class="success-icon">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>

            <h1 style="font-size: 26px; font-weight: 900; color: #1e293b; margin-bottom: 10px;">Request Pickup Berhasil! 🎉</h1>
            <p style="color: #64748b; font-size: 15px; line-height: 1.6;">Permintaan Anda telah diterima. Kurir kami akan menghubungi Anda sebelum penjemputan.</p>

            <div class="code-box">
                <div class="code-label">Kode Pickup Anda</div>
                <div class="code-value" id="pickup-code">{{ session('pickup_code') }}</div>
                <button class="copy-btn" onclick="copyCode()">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    Salin
                </button>
            </div>

            <div class="steps">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <div class="step-text">
                        <strong>Konfirmasi Jadwal</strong>
                        Tim kami akan menghubungi Anda via WhatsApp untuk konfirmasi jadwal penjemputan.
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div class="step-text">
                        <strong>Kurir Berangkat</strong>
                        Kurir akan menuju lokasi Anda sesuai jadwal yang telah disepakati.
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div class="step-text">
                        <strong>Paket Dijemput & Diproses</strong>
                        Paket langsung dibawa ke cabang untuk disortir dan dikirim ke tujuan.
                    </div>
                </div>
            </div>

            <div class="action-grid">
                <a href="{{ route('pickup.track', session('pickup_code')) }}" class="action-btn btn-track">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Lacak Status
                </a>
                <a href="{{ url('/') }}" class="action-btn btn-home">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Kembali ke Beranda
                </a>
            </div>

            <p class="note-text">💾 Simpan kode <strong>{{ session('pickup_code') }}</strong> untuk memantau status penjemputan.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // SweetAlert2 success popup
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Request Berhasil Diterima!',
                html: `Kode pickup Anda: <strong style="font-size:18px;color:#6366f1;">{{ session('pickup_code') }}</strong><br><small style="color:#94a3b8;">Simpan kode ini untuk melacak status pickup</small>`,
                confirmButtonText: 'Oke, Mengerti',
                confirmButtonColor: '#6366f1',
                timer: 6000,
                timerProgressBar: true,
                showClass: { popup: 'animate__animated animate__fadeInDown' },
            });
        }
    });

    // Copy kode
    function copyCode() {
        const code = document.getElementById('pickup-code').innerText;
        navigator.clipboard.writeText(code).then(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Kode disalin!', showConfirmButton: false, timer: 2000 });
            }
        });
    }
</script>
@endpush

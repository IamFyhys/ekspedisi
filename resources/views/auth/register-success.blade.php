@extends('layouts.premium')

@section('title', 'Lamaran Berhasil Dikirim — Skynet Logistics')

@section('styles')
<style>
    .success-page { 
        min-height: calc(100vh - 80px); 
        width: 100%;
        display: flex; 
        flex-direction: column;
        align-items: center; 
        justify-content: center; 
        background: #f1f5f9;
        padding: 40px 20px;
        margin-top: 80px;
    }
    
    .success-card { 
        max-width: 500px; 
        width: 100%; 
        background: #ffffff; 
        padding: 48px 40px; 
        border-radius: 24px; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); 
        border: 1px solid #e8edf2; 
        text-align: center;
    }

    .status-icon {
        width: 80px;
        height: 80px;
        background: #dcfce7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    .success-card h1 { 
        font-size: 26px; 
        font-weight: 800; 
        color: #1e2d4a; 
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .success-card p { 
        color: #64748b; 
        font-size: 15px; 
        line-height: 1.6; 
        margin-bottom: 32px;
    }

    .next-steps {
        background: #f8fafc;
        border-radius: 16px;
        padding: 24px;
        text-align: left;
        margin-bottom: 24px;
    }

    .next-steps-label {
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        letter-spacing: 1.5px;
        margin-bottom: 20px;
        display: block;
    }

    .step-item {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
    }

    .step-item:last-child { margin-bottom: 0; }

    .step-icon {
        width: 38px;
        height: 38px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        flex-shrink: 0;
        background: #ffffff;
    }

    .step-content h4 {
        font-size: 14px;
        font-weight: 700;
        color: #1e2d4a;
        margin-bottom: 2px;
    }

    .step-content p {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 0;
        line-height: 1.4;
    }

    .email-info {
        background: #f0f7ff;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 32px;
        text-align: left;
    }

    .email-label {
        font-size: 10px;
        font-weight: 800;
        color: #6366f1;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 2px;
    }

    .email-value {
        font-size: 14px;
        font-weight: 700;
        color: #1e2d4a;
    }

    .btn-home {
        width: 100%;
        height: 50px;
        background: #6366f1;
        color: #ffffff;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.3s;
        margin-bottom: 20px;
    }

    .btn-home:hover {
        background: #4f46e5;
        transform: translateY(-2px);
    }

    .login-link {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
    }

    .login-link a {
        color: #6366f1;
        text-decoration: none;
    }

    .reveal { opacity: 0; transform: translateY(20px); transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1); margin: 0 auto; }
    .reveal.is-visible { opacity: 1; transform: translateY(0); }
</style>
@endsection

@section('content')
<div class="success-page">
    <div class="success-card reveal">
        <div class="status-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h1>Lamaran Berhasil Dikirim</h1>
        <p>Data Anda sudah kami terima dan akan segera diproses oleh Manager {{ session('branch_name') }} dalam 1–3 hari kerja.</p>
        
        <div class="next-steps">
            <span class="next-steps-label">LANGKAH SELANJUTNYA</span>
            
            <div class="step-item">
                <div class="step-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>
                <div class="step-content">
                    <h4>Review oleh Manager</h4>
                    <p>Manager cabang akan memeriksa kelengkapan data lamaran Anda</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <div class="step-content">
                    <h4>Persetujuan Admin Pusat</h4>
                    <p>Admin pusat akan mengaktifkan akun Anda setelah disetujui</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div class="step-content">
                    <h4>Notifikasi via Email</h4>
                    <p>Anda akan menerima email konfirmasi saat akun sudah aktif</p>
                </div>
            </div>
        </div>

        <div class="email-info">
            <div style="color: #6366f1;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </div>
            <div>
                <span class="email-label">PANTAU STATUS VIA EMAIL</span>
                <span class="email-value">{{ session('registered_email') }}</span>
            </div>
        </div>

        <a href="{{ url('/') }}" class="btn-home">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Kembali ke Beranda
        </a>

        <p class="login-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelector('.reveal').classList.add('is-visible');
        }, 100);
    });
</script>
@endpush


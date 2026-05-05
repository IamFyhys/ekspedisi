@extends('layouts.premium')

@section('title', 'Expedition — Solusi Logistik Terpercaya')

@section('styles')
<style>
    /* =============================================
       WELCOME PAGE — DARK MODE AWARE STYLES
       Uses CSS variables from premium.blade.php
    ============================================= */

    /* Global Animations */
    .animate-target { opacity: 0; transform: translateY(24px); transition: opacity 0.6s cubic-bezier(0.16,1,0.3,1), transform 0.6s cubic-bezier(0.16,1,0.3,1); }
    .animate-target.animate-in { opacity: 1; transform: translateY(0); }

    @keyframes float { 0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)} }
    @keyframes pulse-glow { 0%,100%{box-shadow:0 0 0 0 rgba(99,102,241,.3)}50%{box-shadow:0 0 0 8px rgba(99,102,241,0)} }

    /* ---- HERO ---- */
    .hero-section {
        background: var(--bg);
        padding: 120px 24px 80px;
        position: relative; overflow: hidden;
        transition: background 0.4s;
    }
    .hero-grid { max-width:1100px; margin:0 auto; display:grid; grid-template-columns:1.2fr 0.8fr; gap:60px; align-items:center; }
    .hero-badge { display:inline-flex; align-items:center; gap:8px; padding:8px 16px; background:#eef2ff; border-radius:50px; font-size:13px; font-weight:700; color:#6366f1; margin-bottom:24px; animation:pulse-glow 2s infinite; }
    .hero-title { font-size:52px; font-weight:800; color:var(--text); line-height:1.1; letter-spacing:-1px; margin-bottom:24px; }
    .hero-title span { color:#6366f1; }
    .hero-subtext { font-size:18px; color:var(--muted); margin-bottom:40px; line-height:1.6; }
    .hero-btns { display:flex; align-items:center; gap:20px; margin-bottom:48px; }
    .btn-hero-primary { background:#6366f1; color:#fff; padding:16px 32px; border-radius:14px; font-weight:700; text-decoration:none; transition:all .2s; box-shadow:0 4px 12px rgba(99,102,241,.2); }
    .btn-hero-primary:hover { transform:scale(1.03); box-shadow:0 6px 20px rgba(99,102,241,.3); }
    .btn-hero-ghost { color:var(--text); font-weight:700; text-decoration:none; position:relative; }
    .btn-hero-ghost::after { content:''; position:absolute; bottom:-4px; left:0; width:0; height:2px; background:var(--text); transition:width .3s; }
    .btn-hero-ghost:hover::after { width:100%; }

    .hero-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
    .hero-stat-item { border-left:1px solid var(--border); padding-left:16px; }
    .hero-stat-item:first-child { border-left:none; padding-left:0; }
    .hero-stat-val { font-size:28px; font-weight:800; color:#6366f1; display:block; margin-bottom:4px; }
    .hero-stat-lab { font-size:12px; color:var(--muted); font-weight:600; text-transform:uppercase; letter-spacing:.5px; }

    .hero-visual { position:relative; }
    .hero-img-container { border-radius:20px; overflow:hidden; box-shadow:var(--shadow-lg); animation:float 4s infinite ease-in-out; }
    .hero-img-container img { width:100%; height:auto; display:block; }
    .hero-card-1 { position:absolute; bottom:-20px; left:-20px; background:var(--surface); padding:16px 20px; border-radius:16px; box-shadow:0 10px 25px rgba(0,0,0,.1); z-index:2; }
    .hero-card-1 div:first-child { color:#6366f1; }
    .hero-card-2 { position:absolute; top:20px; right:-20px; background:#6366f1; color:#fff; padding:12px 20px; border-radius:14px; box-shadow:0 8px 20px rgba(99,102,241,.3); z-index:2; display:flex; align-items:center; gap:10px; font-weight:700; transform:translateX(20px); opacity:0; transition:all .6s .8s ease; }
    .animate-in .hero-card-2 { transform:translateX(0); opacity:1; }

    /* ---- TRACKING WIDGET ---- */
    .tracking-section { padding:100px 0; background:var(--bg3); transition:background .4s; }
    .widget-container { max-width:860px; margin:0 auto; background:var(--surface); border-radius:20px; overflow:hidden; box-shadow:var(--shadow-md); border:1px solid var(--border); transition:background .4s, border-color .4s; }
    .widget-tabs { display:grid; grid-template-columns:repeat(4,1fr); background:var(--bg3); border-bottom:1px solid var(--border); }
    .widget-tab { padding:16px 8px; border:none; background:transparent; color:var(--muted); font-weight:700; font-size:12px; cursor:pointer; display:flex; flex-direction:column; align-items:center; gap:6px; transition:all .2s; border-bottom:3px solid transparent; }
    .widget-tab.active { background:var(--surface); color:#6366f1; border-bottom-color:#6366f1; }
    .input-control { height:52px; background:var(--bg3); border:2px solid transparent; border-radius:12px; padding:0 16px; font-size:15px; font-weight:500; color:var(--text); outline:none; transition:all .2s; width:100%; }
    .input-control:focus { background:var(--surface); border-color:#6366f1; box-shadow:0 0 0 4px rgba(99,102,241,.1); }
    .btn-submit { height:52px; padding:0 32px; background:#6366f1; color:#fff; border:none; border-radius:12px; font-weight:700; cursor:pointer; transition:all .2s; white-space:nowrap; }
    .btn-submit:hover { transform:scale(1.02); background:#4f46e5; }

    /* ---- FEATURES ---- */
    #layanan { background:var(--surface); transition:background .4s; }
    .features-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; max-width:900px; margin:0 auto; }
    .feature-card { background:var(--bg3); padding:28px 24px; border-radius:18px; border:1px solid var(--border); transition:all .25s ease; }
    .feature-card:hover { transform:translateY(-4px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
    .feat-icon-box { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-bottom:20px; }
    .feat-title { font-size:17px; font-weight:700; color:var(--text); margin-bottom:12px; }
    .feat-desc { font-size:14px; color:var(--muted); line-height:1.6; }

    /* ---- HOW IT WORKS ---- */
    .how-it-works { padding:100px 0; background:var(--bg); overflow:hidden; transition:background .4s; }
    .step-wrapper { position:relative; display:flex; flex-direction:column; align-items:center; opacity:0; transform:translateY(30px); transition:opacity .6s cubic-bezier(.16,1,.3,1),transform .6s cubic-bezier(.16,1,.3,1); width:100%; max-width:200px; margin:0 auto; }
    .step-wrapper.visible { opacity:1; transform:translateY(0); }
    .step-icon-box { width:72px; height:72px; background:var(--bg3); border:1px solid var(--border); border-radius:20px; display:flex; align-items:center; justify-content:center; position:relative; transition:background .2s,transform .2s; cursor:default; z-index:2; }
    .step-icon-box:hover { background:#6366f1; transform:scale(1.08); }
    .step-icon-box:hover svg { stroke:#fff; }
    .step-badge { position:absolute; top:-8px; right:-8px; width:22px; height:22px; background:#6366f1; color:#fff; font-size:11px; font-weight:700; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid var(--surface); z-index:3; }
    .step-connector { position:absolute; top:36px; left:calc(50% + 36px); width:calc(100% - 72px); height:2px; background:transparent; border-top:2px dashed var(--border); z-index:1; }
    .step-connector-fill { position:absolute; top:-2px; left:0; height:2px; background:#6366f1; width:0%; transition:width .8s cubic-bezier(.16,1,.3,1); }
    .step-connector-fill.animate { width:100%; }

    /* ---- PORTAL / LAYANAN SECTION ---- */
    .portal-section { background:var(--surface); padding:100px 24px; transition:background .4s; }

    /* 3-column grid with equal height cards */
    .svc-grid {
        display: grid;
        grid-template-columns: 1fr 1.08fr 1fr;
        gap: 20px;
        max-width: 1060px;
        margin: 0 auto;
        align-items: stretch;
    }
    .svc-card {
        border-radius: 24px;
        padding: 36px 30px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        transition: transform .25s ease, box-shadow .25s ease;
        display: flex;
        flex-direction: column;
    }
    .svc-card:hover { transform: translateY(-6px); box-shadow: 0 20px 48px rgba(0,0,0,.12); }
    .svc-card .svc-btn-area { margin-top: auto; }

    /* Light cards use surface + border */
    .svc-card-light {
        background: var(--surface);
        border: 1.5px solid var(--border);
    }
    /* featured dark card */
    .svc-card-featured {
        background: linear-gradient(145deg, #1a2744 0%, #1d4ed8 100%);
        position: relative; overflow: hidden;
    }
    .svc-card-featured:hover { transform: translateY(-8px); box-shadow: 0 24px 64px rgba(29,78,216,.4); }
    .svc-glow { position:absolute;top:-50px;right:-50px;width:180px;height:180px;background:radial-gradient(circle,rgba(255,255,255,.1),transparent);border-radius:50%;pointer-events:none; }

    /* ---- FOOTER ---- */
    footer { background:#1e2d4a; color:#fff; padding:60px 24px 40px; }
    .footer-link { display:flex; align-items:center; gap:6px; color:rgba(255,255,255,.7); text-decoration:none; font-size:14px; transition:color .15s,transform .15s; margin-bottom:10px; }
    .footer-link:hover { color:#fff; transform:translateX(4px); }
    .footer-arrow { opacity:0; transform:translateX(-4px); transition:opacity .15s,transform .15s; width:12px; height:12px; }
    .footer-link:hover .footer-arrow { opacity:1; transform:translateX(0); }
    .social-btn { width:36px; height:36px; background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12); border-radius:8px; display:flex; align-items:center; justify-content:center; transition:background .2s; cursor:pointer; color:white; text-decoration:none; }
    .social-btn:hover { background:rgba(255,255,255,.16); }

    /* ---- WA FLOAT ---- */
    .wa-float { position:fixed; bottom:30px; left:30px; width:60px; height:60px; background-color:#25d366; color:#FFF; border-radius:50%; box-shadow:0 4px 10px rgba(0,0,0,.15); z-index:100; display:flex; align-items:center; justify-content:center; transition:all .3s ease; }
    .wa-float:hover { transform:translateY(-5px) scale(1.05); box-shadow:0 10px 20px rgba(37,211,102,.4); }
    .wa-float svg { width:34px; height:34px; }

    /* ---- DARK MODE EXTRA OVERRIDES ---- */
    [data-theme="dark"] .hero-badge { background:#1e2435; }
    [data-theme="dark"] .step-badge { border-color:#0B0F1A; }
    [data-theme="dark"] .svc-card-light { border-color:rgba(255,255,255,.08); }
    [data-theme="dark"] .widget-tab.active { background:var(--surface); }

    /* Light card border-top accent colors need override for dark */
    [data-theme="dark"] .svc-card-light.accent-purple { border-top-color:#818cf8; }
    [data-theme="dark"] .svc-card-light.accent-green  { border-top-color:#4ade80; }

    /* NAVBAR & FOOTER */
    [data-theme="dark"] nav.scrolled {
        background: rgba(30, 41, 59, 0.85); /* surface color with opacity */
        border-bottom: 1px solid var(--border);
    }
    [data-theme="dark"] footer {
        background: #0f172a; /* base */
        border-top: 1px solid var(--border);
    }

    /* HERO SECTION */
    [data-theme="dark"] .hero-section {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }
    [data-theme="dark"] .hero-title {
        color: #f8fafc;
    }
    [data-theme="dark"] .hero-subtext {
        color: #94a3b8;
    }

    /* PANEL LACAK KIRIMAN (Di atas Hero) */
    [data-theme="dark"] .tracking-panel,
    [data-theme="dark"] .widget-container,
    [data-theme="dark"] .widget-panel {
        background: var(--bg-surface);
        border: 1px solid var(--border);
    }
    [data-theme="dark"] .widget-container {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }
    [data-theme="dark"] .tracking-input,
    [data-theme="dark"] .input-control {
        background: #0f172a; /* lebih gelap dari surface agar input menonjol */
        border: 1px solid var(--border);
        color: #f8fafc;
    }
    [data-theme="dark"] .tracking-input:focus,
    [data-theme="dark"] .input-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2);
    }

    /* SECTION FITUR & LAYANAN (Cards) */
    [data-theme="dark"] .feature-card,
    [data-theme="dark"] .svc-card-light,
    [data-theme="dark"] .step-card {
        background: var(--bg-surface);
        border: 1px solid var(--border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
    }
    [data-theme="dark"] .feature-card:hover,
    [data-theme="dark"] .svc-card-light:hover,
    [data-theme="dark"] .step-card:hover {
        background: var(--bg-elevated); /* Card lebih terang saat di-hover */
        border-color: rgba(129, 140, 248, 0.3); /* subtle accent border */
        transform: translateY(-5px);
    }
    [data-theme="dark"] .feat-icon-box,
    [data-theme="dark"] .service-icon {
        background: rgba(129, 140, 248, 0.15); /* light purple bg for icons */
        color: var(--accent);
    }

    /* PORTAL SECTION */
    [data-theme="dark"] .portal-section {
        background: #0f172a;
    }
    [data-theme="dark"] .portal-card {
        background: var(--bg-surface);
        border: 1px solid var(--border);
    }
    [data-theme="dark"] .portal-card:hover {
        background: var(--bg-elevated);
    }

    /* ---- RESPONSIVE ---- */
    @media (max-width: 900px) {
        .svc-grid { grid-template-columns: 1fr; }
        .svc-card-featured { margin-top: 0; }
    }
    @media (max-width: 768px) {
        .hero-grid, .features-grid, .footer-content { grid-template-columns:1fr; }
        .hero-title { font-size:36px; }
        .hero-visual { margin-top:40px; }
        .steps-grid { grid-template-columns:1fr; gap:40px; }
        .step-connector { display:none; }
        .widget-tabs { grid-template-columns: repeat(2,1fr); }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero-section">
    <div class="hero-grid animate-target">
        <div class="hero-text">
            <div class="hero-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                Logistik Modern & Terpercaya
            </div>
            <h1 class="hero-title">Solusi Pengiriman <span>Cepat & Aman</span> Untuk Bisnis Anda.</h1>
            <p class="hero-subtext">Menjangkau seluruh pelosok Indonesia dengan sistem pelacakan real-time, tarif transparan, dan layanan kurir profesional.</p>
            
            <div class="hero-btns">
                <a href="#tracking" class="btn-hero-primary">Lacak Sekarang</a>
                <a href="{{ route('pickup.index') }}" class="btn-hero-ghost">Request Pickup &rarr;</a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat-item">
                    <span class="hero-stat-val" data-target="99.9">0%</span>
                    <span class="hero-stat-lab">Pengiriman Sukses</span>
                </div>
                <div class="hero-stat-item">
                    <span class="hero-stat-val" data-target="50">0</span>
                    <span class="hero-stat-lab">Kota Terjangkau</span>
                </div>
                <div class="hero-stat-item">
                    <span class="hero-stat-val" data-target="10000">0</span>
                    <span class="hero-stat-lab">Paket per Hari</span>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-img-container">
                <img src="{{ asset('images/hero-bg.jpg') }}" alt="Warehouse">
            </div>
            <div class="hero-card-1">
                <div style="font-size: 24px; font-weight: 800; color: #6366f1; margin-bottom: 4px;">99.9%</div>
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Customer Satisfaction</div>
            </div>
            <div class="hero-card-2">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path></svg>
                10K+ Paket Hari Ini
            </div>
        </div>
    </div>
</section>

<!-- Tracking Section -->
<section id="tracking" class="tracking-section">
    <div class="container animate-target">
        @php
            $showTarif = session()->has('hasil') || session()->has('error');
        @endphp
        <div class="widget-container">
            <div class="widget-tabs">
                <button class="widget-tab {{ !$showTarif ? 'active' : '' }}" onclick="switchTab(this, 'lacak')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
                    Lacak Resi
                </button>
                <button class="widget-tab {{ $showTarif ? 'active' : '' }}" onclick="switchTab(this, 'tarif')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    Cek Tarif
                </button>
                <button class="widget-tab" onclick="switchTab(this, 'pickup')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"></path><circle cx="7" cy="17" r="2"></circle><circle cx="17" cy="17" r="2"></circle><path d="M13 17h-6"></path><path d="M13 11h8l-2 6"></path></svg>
                    Request Pickup
                </button>
                <button class="widget-tab" onclick="switchTab(this, 'lacak-pickup')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Lacak Pickup
                </button>
            </div>

            {{-- hidden panel for cabang (tetap bisa diakses walau tab dihapus) --}}
            
            <div id="panel-lacak" class="widget-panel {{ !$showTarif ? 'active' : '' }}" style="padding: 32px; {{ $showTarif ? 'display: none;' : '' }}">
                <form action="{{ route('tracking') }}" method="GET" style="display: flex; gap: 12px; flex-direction: column;">
                    <div style="display: flex; gap: 12px;">
                        <input type="text" name="resi" class="input-control" placeholder="Masukkan nomor resi..." required>
                        <button type="submit" class="btn-submit">Cek Resi</button>
                    </div>
                    <span style="font-size: 12px; color: #94a3b8;">Format: EXP-20260429-XXXX atau nomor resi lainnya</span>
                </form>
            </div>
            
            <div id="panel-tarif" class="widget-panel {{ $showTarif ? 'active' : '' }}" style="padding: 32px; {{ !$showTarif ? 'display: none;' : '' }}">
                <form id="form-cek-tarif" action="{{ route('cek-tarif.hitung') }}" method="POST" style="display: flex; gap: 16px;">
                    @csrf
                    <input type="text" name="asal" class="input-control" placeholder="Kota Asal" required value="{{ session('asal', '') }}">
                    <input type="text" name="tujuan" class="input-control" placeholder="Kota Tujuan" required value="{{ session('tujuan', '') }}">
                    <input type="number" name="berat" class="input-control" style="max-width: 100px;" placeholder="Kg" required min="1" value="{{ session('berat', '') }}">
                    <button type="submit" id="btn-hitung-tarif" class="btn-submit">Hitung</button>
                </form>

                <div id="tarif-results-container">

                @if(session('error'))
                    <div style="margin-top: 16px; padding: 12px 16px; background: #fee2e2; color: #ef4444; border-radius: 12px; font-size: 14px; font-weight: 500;">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('hasil'))
                    <div style="margin-top: 24px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                        @foreach(session('hasil') as $layanan)
                            <div style="border: 1px solid var(--border); border-radius: 16px; padding: 20px; background: var(--bg3);">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; background: #eef2ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6366f1;">
                                            {!! $layanan['icon'] !!}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; font-size: 14px; color: var(--text);">{{ $layanan['nama'] }}</div>
                                            <div style="font-size: 12px; color: var(--muted);">{{ $layanan['desc'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: 20px; font-weight: 800; color: #6366f1; margin-bottom: 4px;">Rp {{ number_format($layanan['harga'], 0, ',', '.') }}</div>
                                <div style="font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 4px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    Estimasi: {{ $layanan['estimasi'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                </div>
            </div>
            
            <div id="panel-cabang" class="widget-panel" style="padding: 32px; display: none;">
                <form action="{{ route('cabang') }}" method="GET" style="display: flex; gap: 12px;">
                    <input type="text" name="kota" class="input-control" placeholder="Cari kota atau cabang..." required>
                    <button type="submit" class="btn-submit">Cari</button>
                </form>
            </div>

            <div id="panel-pickup" class="widget-panel" style="padding: 32px; display: none;">
                <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 220px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <div style="width: 40px; height: 40px; background: #eef2ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"></path><circle cx="7" cy="17" r="2"></circle><circle cx="17" cy="17" r="2"></circle><path d="M13 17h-6"></path><path d="M13 11h8l-2 6"></path></svg>
                            </div>
                            <div>
                                <p style="font-size: 15px; font-weight: 700; color: #1e2d4a;">Jemput Paket di Lokasi Anda</p>
                                <p style="font-size: 13px; color: #64748b;">Kurir kami akan datang sesuai jadwal yang Anda pilih.</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('pickup.index') }}" class="btn-submit" style="text-decoration: none; white-space: nowrap; min-width: 180px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        Mulai Request
                    </a>
                </div>
            </div>

            <div id="panel-lacak-pickup" class="widget-panel" style="padding: 32px; display: none;">
                <form action="{{ route('pickup.track') }}" method="GET" style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; gap: 12px;">
                        <input type="text" name="code" class="input-control" placeholder="Masukkan kode pickup (PKP-XXXXXXXX-XXXX)" required>
                        <button type="submit" class="btn-submit">Cek Status</button>
                    </div>
                    <span style="font-size: 12px; color: #94a3b8;">Kode pickup dikirim via WhatsApp setelah request berhasil</span>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="layanan" style="padding: 100px 0; background: #fff;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;" class="animate-target">
            <h2 style="font-size: 32px; font-weight: 700; color: #1e2d4a; margin-bottom: 16px;">Mengapa Skynet Logistics?</h2>
            <p style="font-size: 15px; color: #64748b; max-width: 600px; margin: 0 auto;">Sistem logistik modern yang dirancang untuk kecepatan, keamanan, dan kemudahan pengiriman Anda.</p>
        </div>

        <div class="features-grid">
            <!-- Card 1 -->
            <div class="feature-card animate-target">
                <div class="feat-icon-box" style="background: #eef2ff;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2"><path d="M10 17h4V5H2v12h3m1 0h4m5 0h4m1 0h3v-6l-3-3h-7m7 9v-2m-7 2v-2"></path><circle cx="7" cy="17" r="2"></circle><circle cx="17" cy="17" r="2"></circle></svg>
                </div>
                <h3 class="feat-title">Pengiriman Real-Time</h3>
                <p class="feat-desc">Lacak posisi paket Anda secara real-time dari gudang hingga tangan penerima dengan akurasi tinggi.</p>
            </div>
            <!-- Card 2 -->
            <div class="feature-card animate-target" style="transition-delay: 0.1s;">
                <div class="feat-icon-box" style="background: #f0fdf4;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <h3 class="feat-title">Keamanan Terjamin</h3>
                <p class="feat-desc">Setiap paket diasuransikan dan dipantau ketat oleh sistem manajemen kami selama dalam perjalanan.</p>
            </div>
            <!-- Card 3 -->
            <div class="feature-card animate-target" style="transition-delay: 0.2s;">
                <div class="feat-icon-box" style="background: #fff7ed;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <h3 class="feat-title">Estimasi Akurat</h3>
                <p class="feat-desc">Sistem kami memberikan estimasi waktu tiba yang akurat berdasarkan rute optimal dan kondisi lapangan.</p>
            </div>
            <!-- Card 4 -->
            <div class="feature-card animate-target" style="transition-delay: 0.3s;">
                <div class="feat-icon-box" style="background: #fdf4ff;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <h3 class="feat-title">Jaringan Luas</h3>
                <p class="feat-desc">Menjangkau lebih dari 50 kota di seluruh Indonesia dengan armada yang terstandarisasi dan andal.</p>
            </div>
            <!-- Card 5 -->
            <div class="feature-card animate-target" style="transition-delay: 0.4s;">
                <div class="feat-icon-box" style="background: #eff6ff;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                </div>
                <h3 class="feat-title">Staff Terlatih</h3>
                <p class="feat-desc">Kurir dan kasir kami terseleksi ketat dengan standar profesional tinggi di industri logistik.</p>
            </div>
            <!-- Card 6 -->
            <div class="feature-card animate-target" style="transition-delay: 0.5s;">
                <div class="feat-icon-box" style="background: #f0fdf4;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                </div>
                <h3 class="feat-title">Laporan Transparan</h3>
                <p class="feat-desc">Manager dan admin mendapatkan laporan operasional lengkap dan transparan setiap harinya.</p>
            </div>
        </div>
    </div>
</section>

<!-- Workflow Section -->
<section class="how-it-works">
    <div class="container">
        <div style="text-align: center; margin-bottom: 64px;" class="animate-target">
            <h2 style="font-size: 36px; font-weight: 700; color: #1e2d4a; margin-bottom: 8px;">Bagaimana Cara Kerjanya?</h2>
            <p style="font-size: 15px; color: #64748b;">Proses pengiriman yang sederhana, cepat, dan dapat dipantau dari mana saja.</p>
        </div>

        <div class="steps-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); position: relative;">
            <div class="step-wrapper">
                <div class="step-icon-box">
                    <div class="step-badge">1</div>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                </div>
                <h4 style="font-size: 15px; font-weight: 600; color: #1e2d4a; margin-top: 16px; margin-bottom: 6px;">Serahkan Paket</h4>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; max-width: 160px; margin: auto; text-align: center;">Bawa paket ke cabang terdekat atau jadwalkan pickup.</p>
                <div class="step-connector"><div class="step-connector-fill"></div></div>
            </div>
            
            <div class="step-wrapper">
                <div class="step-icon-box">
                    <div class="step-badge">2</div>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="1.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                </div>
                <h4 style="font-size: 15px; font-weight: 600; color: #1e2d4a; margin-top: 16px; margin-bottom: 6px;">Proses & Sortir</h4>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; max-width: 160px; margin: auto; text-align: center;">Paket disortir dengan cepat dan disiapkan untuk rute optimal.</p>
                <div class="step-connector"><div class="step-connector-fill"></div></div>
            </div>
            
            <div class="step-wrapper">
                <div class="step-icon-box">
                    <div class="step-badge">3</div>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="1.5"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"></path><path d="M7 18a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path><path d="M17 18a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path><path d="M13 18h4"></path></svg>
                </div>
                <h4 style="font-size: 15px; font-weight: 600; color: #1e2d4a; margin-top: 16px; margin-bottom: 6px;">Dalam Perjalanan</h4>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; max-width: 160px; margin: auto; text-align: center;">Kurir mengantarkan paket Anda dengan aman.</p>
                <div class="step-connector"><div class="step-connector-fill"></div></div>
            </div>
            
            <div class="step-wrapper">
                <div class="step-icon-box">
                    <div class="step-badge">4</div>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <h4 style="font-size: 15px; font-weight: 600; color: #1e2d4a; margin-top: 16px; margin-bottom: 6px;">Diterima</h4>
                <p style="font-size: 13px; color: #64748b; line-height: 1.6; max-width: 160px; margin: auto; text-align: center;">Paket sampai di tujuan dan diterima dengan konfirmasi.</p>
            </div>
        </div>
    </div>
</section>

<!-- Portal / Layanan Section -->
<section class="portal-section" id="layanan-portal">
    <div style="text-align:center; margin-bottom:56px;" class="animate-target">
        <div style="display:inline-flex; align-items:center; gap:8px; padding:6px 16px; background:#eef2ff; border-radius:50px; font-size:12px; font-weight:700; color:#6366f1; letter-spacing:.05em; text-transform:uppercase; margin-bottom:16px;">
            ✦ Pilih Layanan Anda
        </div>
        <h2 style="font-size:36px; font-weight:800; color:var(--text); margin-bottom:14px; letter-spacing:-.5px;">Semua Layanan, Satu Platform</h2>
        <p style="font-size:16px; color:var(--muted); max-width:500px; margin:0 auto; line-height:1.6;">Lacak kiriman, jemput paket, atau kelola operasional — semuanya ada di Skynet Logistics.</p>
    </div>

    <div class="svc-grid">

        {{-- Card 1: Lacak Paket --}}
        <div class="svc-card svc-card-light accent-purple animate-target" style="border-top:5px solid #6366f1; transition-delay:0s;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#eef2ff,#e0e7ff);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:24px;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </div>
            <span style="display:inline-block;padding:3px 10px;background:#eef2ff;border-radius:20px;font-size:10px;font-weight:700;color:#6366f1;letter-spacing:.06em;text-transform:uppercase;margin-bottom:14px;">GRATIS</span>
            <h3 style="font-size:22px;font-weight:800;color:var(--text);margin-bottom:12px;">Lacak Paket</h3>
            <p style="font-size:14px;color:var(--muted);line-height:1.75;margin-bottom:28px;">Pantau posisi kiriman secara real-time dengan nomor resi dari mana saja dan kapan saja.</p>
            <div class="svc-btn-area">
                <a href="#tracking" style="display:flex;align-items:center;justify-content:center;gap:8px;background:#6366f1;color:#fff;height:50px;border-radius:14px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s;box-shadow:0 4px 14px rgba(99,102,241,.25);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Cek Resi Sekarang
                </a>
            </div>
        </div>

        {{-- Card 2: Request Pickup (featured) --}}
        <div class="svc-card svc-card-featured animate-target" style="transition-delay:.1s;">
            <div class="svc-glow"></div>
            <div style="width:56px;height:56px;background:rgba(255,255,255,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:24px;border:1px solid rgba(255,255,255,.2);">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/><path d="M13 17h-6"/><path d="M13 11h8l-2 6"/></svg>
            </div>
            <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 12px;background:rgba(255,255,255,.18);border-radius:20px;font-size:10px;font-weight:700;color:#fff;letter-spacing:.06em;text-transform:uppercase;margin-bottom:14px;border:1px solid rgba(255,255,255,.2);">🔥 PALING POPULER</span>
            <h3 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:12px;">Request Pickup</h3>
            <p style="font-size:14px;color:rgba(255,255,255,.75);line-height:1.75;margin-bottom:28px;">Kurir kami datang ke lokasi Anda sesuai jadwal. Tanpa antri, tanpa repot keluar rumah.</p>
            <div class="svc-btn-area" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                <a href="{{ route('pickup.index') }}" style="display:flex;align-items:center;justify-content:center;gap:7px;background:#fff;color:#1a2744;height:50px;border-radius:14px;font-size:13px;font-weight:800;text-decoration:none;transition:all .2s;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                    Buat Request
                </a>
                <a href="{{ route('pickup.track') }}" style="display:flex;align-items:center;justify-content:center;gap:7px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#fff;height:50px;border-radius:14px;font-size:13px;font-weight:700;text-decoration:none;transition:all .2s;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Lacak Pickup
                </a>
            </div>
        </div>

        {{-- Card 3: Portal Staff --}}
        <div class="svc-card svc-card-light accent-green animate-target" style="border-top:5px solid #16a34a; transition-delay:.2s;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:24px;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span style="display:inline-block;padding:3px 10px;background:#f0fdf4;border-radius:20px;font-size:10px;font-weight:700;color:#16a34a;letter-spacing:.06em;text-transform:uppercase;margin-bottom:14px;">STAFF & KURIR</span>
            <h3 style="font-size:22px;font-weight:800;color:var(--text);margin-bottom:12px;">Portal Operasional</h3>
            <p style="font-size:14px;color:var(--muted);line-height:1.75;margin-bottom:28px;">Dashboard untuk staff kasir, kurir, manager, dan admin guna kelola pengiriman harian.</p>
            <div class="svc-btn-area" style="display:grid;grid-template-columns:1fr 1.3fr;gap:10px;">
                <a href="{{ route('login') }}" style="display:flex;align-items:center;justify-content:center;background:var(--bg3);color:var(--text);height:50px;border-radius:14px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s;border:1px solid var(--border);">
                    Masuk
                </a>
                <a href="{{ route('register') }}" style="display:flex;align-items:center;justify-content:center;gap:7px;background:#16a34a;color:#fff;height:50px;border-radius:14px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s;box-shadow:0 4px 14px rgba(22,163,74,.25);">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Daftar Staff
                </a>
            </div>
        </div>

    </div>
</section>

<!-- Footer -->
<footer>
    <div class="footer-content" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 60px; max-width: 1100px; margin: 0 auto;">
        <div class="footer-col animate-target">
            <a href="#" style="font-size: 24px; font-weight: 800; color: #fff; text-decoration: none; display: block; margin-bottom: 20px;">SKYNET</a>
            <p style="color: rgba(255,255,255,0.6); line-height: 1.6; margin-bottom: 24px; font-size: 14px;">Solusi logistik modern untuk mendukung pertumbuhan ekonomi digital Indonesia.</p>
            <div style="font-size: 13px; color: rgba(255,255,255,0.4);">&copy; 2026 Skynet Logistics. All rights reserved.</div>
        </div>
        <div class="footer-col animate-target" style="transition-delay: 0.1s;">
            <h4 style="font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.4); margin-bottom: 16px; letter-spacing: 0.1em;">NAVIGASI</h4>
            <div>
                <a href="#hero" class="footer-link">
                    <svg class="footer-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Beranda
                </a>
                <a href="#tracking" class="footer-link">
                    <svg class="footer-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Lacak Paket
                </a>
                <a href="{{ route('pickup.index') }}" class="footer-link">
                    <svg class="footer-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Request Pickup
                </a>
                <a href="{{ route('dashboard') }}" class="footer-link">
                    <svg class="footer-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Portal Staff
                </a>
            </div>
        </div>
        <div class="footer-col animate-target" style="transition-delay: 0.2s;">
            <h4 style="font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.4); margin-bottom: 16px; letter-spacing: 0.1em;">KONTAK</h4>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 14px; color: rgba(255,255,255,0.7);">ekspedisi@expedisi.com</span>
                <span style="font-size: 14px; color: rgba(255,255,255,0.7);">+62 895-3869-56728</span>
            </div>
        </div>
    </div>
    <div class="footer-bottom" style="max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 24px; margin-top: 48px;">
        <div style="font-size: 14px; color: rgba(255,255,255,0.6);">Dibuat dengan dedikasi untuk logistik Indonesia.</div>
        <div style="display: flex; gap: 12px;">
            <a href="#" class="social-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
            </a>
            <a href="#" class="social-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>
        </div>
    </div>
</footer>

<!-- WhatsApp Floating -->
<a href="https://wa.me/62895386956728" target="_blank" class="wa-float">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"></path></svg>
</a>
@endsection

@push('scripts')
<script>
    // Tab switching
    function switchTab(btn, tabId) {
        document.querySelectorAll('.widget-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.widget-panel').forEach(p => {
            p.classList.remove('active');
            p.style.display = 'none';
        });
        const panel = document.getElementById('panel-' + tabId);
        if (panel) {
            panel.classList.add('active');
            panel.style.display = 'block';
        }
    }

    // Intersection Observer for Animations
    const landingObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                // Trigger count-up if element has stat value
                const statVals = entry.target.querySelectorAll('.hero-stat-val');
                statVals.forEach(statVal => {
                    if (statVal && !statVal.dataset.started) {
                        animateValue(statVal);
                    }
                });
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-target').forEach(el => landingObserver.observe(el));

    // Interaction Observers for new sections
    // 1. Steps Animation
    const stepsSection = document.querySelector('.how-it-works');
    const stepObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const steps = entry.target.querySelectorAll('.step-wrapper');
                steps.forEach((step, i) => {
                    setTimeout(() => { step.classList.add('visible'); }, i * 150);
                });
                setTimeout(() => {
                    entry.target.querySelectorAll('.step-connector-fill').forEach((line, i) => {
                        setTimeout(() => { line.classList.add('animate'); }, i * 200);
                    });
                }, 600);
                stepObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });
    if (stepsSection) stepObserver.observe(stepsSection);

    // 2. Portal Cards Animation
    const portalSection = document.querySelector('.portal-section');
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const cards = entry.target.querySelectorAll('.portal-card');
                cards.forEach((card, i) => {
                    setTimeout(() => { card.classList.add('visible'); }, i * 150);
                });
                cardObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });
    if (portalSection) cardObserver.observe(portalSection);

    // Count-up animation
    function animateValue(obj) {
        const target = parseFloat(obj.dataset.target);
        const duration = 2000;
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            let current = progress * target;
            
            if (target % 1 !== 0) {
                obj.innerHTML = current.toFixed(1) + '%';
            } else {
                obj.innerHTML = Math.floor(current).toLocaleString() + (target > 1000 ? '+' : '');
            }
            
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        obj.dataset.started = true;
        window.requestAnimationFrame(step);
    }

    // AJAX for Cek Tarif to prevent page reload
    const formCekTarif = document.getElementById('form-cek-tarif');
    if (formCekTarif) {
        formCekTarif.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('btn-hitung-tarif');
            const originalText = btn.textContent;
            btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite; display:inline-block; vertical-align:middle;"><path d="M21 12a9 9 0 11-6.219-8.56"/></svg> Memproses...';
            btn.disabled = true;

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('tarif-results-container');
                container.innerHTML = ''; // clear previous results

                if (data.status === 'error') {
                    container.innerHTML = `
                        <div style="margin-top: 16px; padding: 12px 16px; background: #fee2e2; color: #ef4444; border-radius: 12px; font-size: 14px; font-weight: 500;">
                            ${data.message}
                        </div>
                    `;
                } else if (data.status === 'success') {
                    let html = '<div style="margin-top: 24px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">';
                    data.layanan.forEach(l => {
                        const formattedPrice = new Intl.NumberFormat('id-ID').format(l.harga);
                        html += `
                            <div style="border: 1px solid var(--border); border-radius: 16px; padding: 20px; background: var(--bg3); cursor: pointer; transition: all .2s;" onmouseover="this.style.borderColor='#6366f1'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='none';" onclick="window.location.href='{{ route('pickup.index') }}'">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; background: #eef2ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6366f1;">
                                            ${l.icon}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; font-size: 14px; color: var(--text);">${l.nama}</div>
                                            <div style="font-size: 12px; color: var(--muted);">${l.desc}</div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: 20px; font-weight: 800; color: #6366f1; margin-bottom: 4px;">Rp ${formattedPrice}</div>
                                <div style="font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 4px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    Estimasi: ${l.estimasi}
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    html += '<div style="margin-top: 16px; font-size: 13px; color: var(--muted); text-align: center;">Klik salah satu paket di atas untuk mulai membuat Request Pickup.</div>';
                    container.innerHTML = html;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem saat menghitung tarif.');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    }
</script>
@endpush

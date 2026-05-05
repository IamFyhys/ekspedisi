<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Expedition — Autentikasi')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg: #F4F6FB;
            --bg2: #FFFFFF;
            --bg3: #EEF1F8;
            --surface: #FFFFFF;
            --border: rgba(0,0,0,0.07);
            --text: #0F172A;
            --muted: #64748B;
            --hint: #94A3B8;
            --accent: #4F46E5;
            --accent-hover: #4338CA;
            --green: #10B981;
            --green-hover: #059669;
            --red: #EF4444;
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.14);
            --radius-md: 12px;
            --radius-lg: 20px;
        }

        [data-theme="dark"] {
            --bg: #0B0F1A;
            --bg2: #111827;
            --bg3: #1E2435;
            --surface: #1E2435;
            --border: rgba(255,255,255,0.07);
            --text: #F1F5F9;
            --muted: #94A3B8;
            --hint: #64748B;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg); color: var(--text); overflow: hidden; }

        .auth-split { display: flex; min-height: 100vh; }
        .auth-panel { flex: 0.4; background: linear-gradient(135deg, var(--accent), #6366F1); color: white; padding: 60px; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden; }
        .auth-panel::after { content: ''; position: absolute; width: 100%; height: 100%; top: 0; left: 0; background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 30px 30px; }
        .auth-content { position: relative; z-index: 1; }
        .auth-content h2 { font-size: 36px; font-weight: 800; margin-bottom: 20px; }
        .auth-content p { font-size: 18px; opacity: 0.8; line-height: 1.6; }

        .auth-form-side { flex: 0.6; background: var(--bg); padding: 80px; display: flex; flex-direction: column; justify-content: center; align-items: center; overflow-y: auto; }
        .auth-box { width: 100%; max-width: 440px; }
        .auth-box h1 { font-size: 28px; font-weight: 800; margin-bottom: 12px; }
        .auth-box p.sub { color: var(--muted); margin-bottom: 32px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
        .form-input-wrap { position: relative; display: flex; align-items: center; }
        .form-input-wrap svg { position: absolute; left: 16px; color: var(--hint); }
        .form-input-wrap input, .form-input-wrap select { width: 100%; padding: 12px 16px 12px 48px; border-radius: var(--radius-md); border: 1.5px solid var(--border); background: var(--surface); color: var(--text); font-size: 15px; outline: none; transition: all 0.2s; }
        .form-input-wrap input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }

        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; border-radius: var(--radius-md); font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.3s; border: none; gap: 8px; text-decoration: none; width: 100%; }
        .btn-primary { background: var(--accent); color: white; }
        .btn-primary:hover { background: var(--accent-hover); transform: translateY(-2px); }
        .btn-outline { background: transparent; border: 1.5px solid var(--accent); color: var(--accent); }
        .btn-ghost { background: transparent; color: var(--muted); }

        .form-options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 14px; }
        .divider { display: flex; align-items: center; gap: 16px; margin: 24px 0; color: var(--hint); font-size: 13px; font-weight: 500; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        @media (max-width: 1024px) {
            .auth-panel { display: none; }
            .auth-form-side { flex: 1; padding: 40px; }
        }
    </style>
</head>
<body>
    <div class="auth-split">
        <div class="auth-panel">
            <div class="auth-content">
                <h2>@yield('panel_title')</h2>
                <p>@yield('panel_text')</p>
            </div>
        </div>
        <div class="auth-form-side">
            <div class="auth-box">
                <a href="{{ url('/') }}" class="btn btn-ghost" style="width: auto; padding: 0; margin-bottom: 40px; justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Kembali ke Beranda
                </a>
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>

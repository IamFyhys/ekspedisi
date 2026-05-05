<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard — {{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #185FA5;
            --bg: #F8FAFC;
            --surface: #FFFFFF;
            --text: #1E293B;
            --muted: #64748B;
            --border: #E2E8F0;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --sidebar-width: 220px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: var(--sidebar-width); background: var(--surface); border-right: 1px solid var(--border); position: fixed; height: 100vh; display: flex; flex-direction: column; z-index: 100; }
        .logo-section { padding: 32px 24px; border-bottom: 1px solid var(--border); font-weight: 800; font-size: 20px; color: var(--primary); display: flex; align-items: center; gap: 10px; }
        .logo-icon { width: 32px; height: 32px; background: var(--primary); border-radius: 8px; }
        
        .nav-section { padding: 24px 0; flex: 1; overflow-y: auto; }
        .nav-label { font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--muted); padding: 0 24px; margin-bottom: 12px; letter-spacing: 1px; }
        .nav-menu { list-style: none; margin-bottom: 24px; }
        .nav-item a { display: flex; align-items: center; gap: 12px; padding: 12px 24px; text-decoration: none; color: var(--muted); font-size: 14px; font-weight: 600; transition: all 0.2s; position: relative; }
        .nav-item a:hover { color: var(--primary); background: rgba(24, 95, 165, 0.04); }
        .nav-item.active a { color: var(--primary); background: rgba(24, 95, 165, 0.08); border-left: 4px solid var(--primary); }
        .nav-item svg { width: 18px; height: 18px; }

        /* Main Content */
        .main { flex: 1; margin-left: var(--sidebar-width); display: flex; flex-direction: column; min-width: 0; }
        
        /* Topbar */
        .topbar { height: 70px; background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 40px; position: sticky; top: 0; z-index: 90; }
        .page-title { font-size: 18px; font-weight: 700; }
        .topbar-right { display: flex; align-items: center; gap: 24px; }
        .date-display { font-size: 13px; color: var(--muted); font-weight: 600; }
        .user-pill { display: flex; align-items: center; gap: 12px; padding: 6px 12px; border: 1px solid var(--border); border-radius: 50px; cursor: pointer; }
        .user-pill .avatar { width: 30px; height: 30px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }

        /* Content Area */
        .content { padding: 40px; }

        /* Components */
        .card { background: var(--surface); border-radius: 12px; border: 1px solid var(--border); padding: 24px; margin-bottom: 24px; }
        .card-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 24px; }
        .stat-card { background: var(--surface); padding: 24px; border-radius: 12px; border: 1px solid var(--border); }
        .stat-label { font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 8px; }
        .stat-value { font-size: 24px; font-weight: 800; color: var(--text); }
        
        .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .badge-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .badge-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
        .badge-primary { background: rgba(24, 95, 165, 0.1); color: var(--primary); }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 11px; text-transform: uppercase; color: var(--muted); padding: 12px 16px; border-bottom: 1px solid var(--border); letter-spacing: 0.5px; }
        td { padding: 16px; font-size: 14px; border-bottom: 1px solid var(--border); }
        tr:last-child td { border-bottom: none; }

        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; gap: 8px; text-decoration: none; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: #15528e; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-disabled { opacity: 0.5; cursor: not-allowed; }

        input, select, textarea { width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border); font-size: 14px; outline: none; }
        input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(24, 95, 165, 0.1); }

        @media (max-width: 1280px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo-section">
            <div class="logo-icon"></div>
            Expedition
        </div>
        <div class="nav-section">
            <div class="nav-label">Dashboard</div>
            <ul class="nav-menu">
                <li class="nav-item {{ Route::is('manager.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('manager.dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Ringkasan Cabang
                    </a>
                </li>
            </ul>

            <div class="nav-label">Operasional</div>
            <ul class="nav-menu">
                <li class="nav-item {{ Route::is('manager.transaksi') ? 'active' : '' }}">
                    <a href="{{ route('manager.transaksi') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Daftar Transaksi
                    </a>
                </li>
                <li class="nav-item {{ Route::is('manager.gudang') ? 'active' : '' }}">
                    <a href="{{ route('manager.gudang') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        Monitoring Gudang
                    </a>
                </li>
            </ul>

            <div class="nav-label">Staff Management</div>
            <ul class="nav-menu">
                <li class="nav-item {{ Route::is('manager.staff') ? 'active' : '' }}">
                    <a href="{{ route('manager.staff') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Daftar Staff Aktif
                    </a>
                </li>
                <li class="nav-item {{ Route::is('manager.staff.apply') ? 'active' : '' }}">
                    <a href="{{ route('manager.staff.apply') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="16" y1="11" x2="22" y2="11"></line></svg>
                        Apply Staff Baru
                    </a>
                </li>
                <li class="nav-item {{ Route::is('manager.shift') ? 'active' : '' }}">
                    <a href="{{ route('manager.shift') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Shift History
                    </a>
                </li>
            </ul>

            <div class="nav-label">Finance & Audit</div>
            <ul class="nav-menu">
                <li class="nav-item {{ Route::is('manager.audit') ? 'active' : '' }}">
                    <a href="{{ route('manager.audit') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        Audit Cash Drawer
                    </a>
                </li>
                <li class="nav-item {{ Route::is('manager.omzet') ? 'active' : '' }}">
                    <a href="{{ route('manager.omzet') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        Rekap Pendapatan
                    </a>
                </li>
            </ul>

            <div class="nav-label">System</div>
            <ul class="nav-menu">
                <li class="nav-item {{ Route::is('manager.profile') ? 'active' : '' }}">
                    <a href="{{ route('manager.profile') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        Profile Saya
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Sign Out
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="page-title">@yield('header_title', 'Dashboard')</div>
            <div class="topbar-right">
                <div class="date-display">{{ Carbon\Carbon::now()->format('l, d F Y') }}</div>
                <div class="user-pill">
                    <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div style="font-size: 13px; font-weight: 700;">{{ Auth::user()->name }}</div>
                </div>
            </div>
        </header>

        <div class="content">
            @if(session('success'))
                <div class="card" style="background: rgba(16, 185, 129, 0.1); border-color: var(--success); color: var(--success); padding: 16px; margin-bottom: 24px; font-weight: 700;">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>
    @yield('scripts')
</body>
</html>

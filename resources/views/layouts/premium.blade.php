<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Expedition'))</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Vite Assets (Local Packages) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // PREVENT FOUC (Flash of Unstyled Content)
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <style>
        :root {
            --bg: #f1f5f9;
            --bg-base: #f1f5f9;
            --bg-surface: #FFFFFF;
            --bg-elevated: #EEF1F8;
            --bg2: rgba(255, 255, 255, 0.8);
            --bg3: #EEF1F8;
            --surface: #FFFFFF;
            --border: rgba(0,0,0,0.06);
            --text: #1e2d4a;
            --muted: #64748b;
            --hint: #94A3B8;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --green: #16a34a;
            --green-hover: #15803d;
            --red: #EF4444;
            --amber: #F59E0B;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.12);
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --nav-height: 80px;
        }

        [data-theme="dark"] {
            --bg: #0f172a;
            --bg-base: #0f172a;
            --bg-surface: #1e293b;
            --bg-elevated: #334155;
            --bg2: rgba(30, 41, 59, 0.92);
            --bg3: #1E2435;
            --surface: #1e293b;
            --border: rgba(255,255,255,0.05);
            --text: #f8fafc;
            --muted: #94a3b8;
            --hint: #64748B;
            --accent: #818cf8;
            --accent-hover: #6366f1;
            --green: #4ade80;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.4);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.5);
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.4s ease, border-color 0.4s ease, color 0.4s ease; }
        html { scroll-behavior: smooth; }
        body { background-color: var(--bg-base); color: var(--text); overflow-x: hidden; }

        .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; border-radius: var(--radius-md); font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: none; gap: 8px; text-decoration: none; }
        .btn-primary { background: var(--accent); color: white; }
        .btn-primary:hover { background: var(--accent-hover); transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .btn-outline { background: transparent; border: 1.5px solid var(--accent); color: var(--accent); }
        .btn-outline:hover { background: rgba(79, 70, 229, 0.08); }
        .btn-ghost { background: transparent; color: var(--accent); }
        .btn-ghost:hover { background: rgba(79, 70, 229, 0.05); }

        .animate-target { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        
        ::view-transition-old(root),
        ::view-transition-new(root) { animation: none; mix-blend-mode: normal; }
        ::view-transition-old(root) { z-index: 1; }
        ::view-transition-new(root) { z-index: 9999; }
        [data-theme="dark"]::view-transition-old(root) { z-index: 9999; }
        [data-theme="dark"]::view-transition-new(root) { z-index: 1; }

        nav { position: fixed; top: 0; left: 0; width: 100%; height: var(--nav-height); display: flex; align-items: center; z-index: 1000; background: #fff; border-bottom: 1px solid transparent; transition: all 0.3s ease; }
        nav.scrolled { height: 70px; background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.06); box-shadow: 0 1px 20px rgba(0,0,0,0.08); }
        .nav-container { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        .logo { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 22px; color: #1e2d4a; text-decoration: none; letter-spacing: -0.5px; }
        .logo-box { width: 40px; height: 40px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; }
        .nav-menu { display: flex; gap: 32px; list-style: none; }
        .nav-menu a { text-decoration: none; color: var(--muted); font-weight: 500; font-size: 15px; transition: color 0.3s; position: relative; }
        .nav-menu a::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: var(--accent); transition: width 0.3s ease; }
        .nav-menu a:hover { color: var(--text); }
        .nav-menu a:hover::after { width: 100%; }
        .nav-actions { display: flex; align-items: center; gap: 16px; }

        /* Mobile Menu */
        .menu-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--text); }
        .mobile-nav { position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; background: var(--surface); z-index: 2000; padding: 80px 40px; box-shadow: var(--shadow-lg); transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column; gap: 24px; }
        .mobile-nav.open { right: 0; }
        .mobile-nav-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1999; display: none; opacity: 0; transition: opacity 0.3s; }
        .mobile-nav-overlay.show { display: block; opacity: 1; }
        .mobile-nav a { text-decoration: none; color: var(--text); font-size: 18px; font-weight: 700; }

        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .menu-toggle { display: block; }
        }

        .theme-toggle { background: var(--bg3); border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text); transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); }

        .user-profile { position: relative; display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 6px 12px; border-radius: 50px; transition: background 0.2s; }
        .user-profile:hover { background: var(--bg3); }
        .avatar { width: 36px; height: 36px; background: var(--accent); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; position: relative; }
        .avatar .staff-badge { position: absolute; bottom: -2px; right: -2px; width: 12px; height: 12px; background: var(--green); border: 2px solid var(--surface); border-radius: 50%; }

        .dropdown-menu { position: absolute; top: calc(100% + 12px); right: 0; width: 220px; background: var(--surface); border-radius: var(--radius-md); box-shadow: var(--shadow-lg); border: 1px solid var(--border); padding: 8px; display: none; transform-origin: top right; animation: dropdownIn 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes dropdownIn { from { opacity: 0; transform: scale(0.95) translateY(-10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .dropdown-item { padding: 10px 16px; border-radius: 8px; color: var(--text); text-decoration: none; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; transition: background 0.2s; }
        .dropdown-item:hover { background: var(--bg3); color: var(--accent); }
        .dropdown-divider { height: 1px; background: var(--border); margin: 8px 0; }
        .dropdown-item.logout { color: var(--red); }

        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

    </style>
    @yield('styles')
</head>
<body>
    <!-- View transition API will handle the ripple -->

    <nav id="navbar">
        <div class="container nav-container">
            <a href="{{ url('/') }}" class="logo">
                <div class="logo-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>
                </div>
                SKYNET
            </a>

            <ul class="nav-menu">
                <li><a href="{{ url('/') }}#hero">Beranda</a></li>
                <li><a href="{{ url('/') }}#tracking">Lacak Paket</a></li>
                <li><a href="{{ url('/') }}#layanan">Layanan</a></li>
                <li><a href="{{ url('/') }}#stats">Tentang</a></li>
            </ul>

            <div class="nav-actions">
                <button class="theme-toggle" id="theme-btn" onclick="toggleThemeWithRipple(event)">
                    <svg id="theme-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>
                
                <button class="menu-toggle" onclick="toggleMobileNav()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>

                @guest
                    <div style="display: flex; gap: 12px;">
                        <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    </div>
                @else
                    <div class="user-profile" id="user-profile" onclick="toggleDropdown(event)">
                        <div class="avatar" id="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            @if(Auth::user()->hasRole('courier', 'staff', 'admin', 'manager'))
                                <div class="staff-badge"></div>
                            @endif
                        </div>
                        <span style="font-weight: 600; font-size: 14px;">{{ Auth::user()->name }}</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                        
                        <div class="dropdown-menu" id="user-dropdown">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                Profil Saya
                            </a>
                            @if(Auth::user()->hasRole('courier', 'staff', 'admin', 'manager'))
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                    Dashboard Staff
                                </a>
                            @else
                                <a href="#" class="dropdown-item">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4"></path><path d="m4.93 4.93 2.83 2.83"></path><path d="M2 12h4"></path><path d="m4.93 19.07 2.83-2.83"></path><path d="M12 22v-4"></path><path d="m19.07 19.07-2.83-2.83"></path><path d="M22 12h-4"></path><path d="m19.07 4.93-2.83 2.83"></path></svg>
                                    Riwayat Pesanan
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout" style="width: 100%; border: none; background: none; cursor: pointer;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <div class="mobile-nav-overlay" id="mobile-overlay" onclick="toggleMobileNav()"></div>
    <div class="mobile-nav" id="mobile-nav">
        <button onclick="toggleMobileNav()" style="position: absolute; top: 24px; right: 24px; background: none; border: none; color: var(--text); cursor: pointer;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <a href="{{ url('/') }}#hero" onclick="toggleMobileNav()">Beranda</a>
        <a href="{{ url('/') }}#tracking" onclick="toggleMobileNav()">Lacak Paket</a>
        <a href="{{ url('/') }}#layanan" onclick="toggleMobileNav()">Layanan</a>
        <a href="{{ url('/') }}#stats" onclick="toggleMobileNav()">Tentang</a>
        <div class="dropdown-divider"></div>
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-outline">Daftar</a>
        @else
            <a href="{{ route('profile.edit') }}">Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background: none; border: none; color: var(--red); font-weight: 700; font-size: 18px; cursor: pointer; padding: 0;">Keluar</button>
            </form>
        @endguest
    </div>

    <main>
        @yield('content')
    </main>

    @yield('footer')

    <script>
        // Theme Logic with View Transitions
        let currentTheme = localStorage.getItem('theme') || 'light';
        // (data-theme was already applied in the head script to prevent FOUC)

        document.addEventListener('DOMContentLoaded', () => {
            const icon = document.getElementById('theme-icon');
            if (currentTheme === 'dark') {
                icon.innerHTML = '<path d="M12 3V1m0 22v-2m9-9h2M1 12h2m15.364 6.364l1.414 1.414M4.222 4.222l1.414 1.414m12.728 0l-1.414 1.414M6.364 17.636l-1.414 1.414M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10z"></path>';
            } else {
                icon.innerHTML = '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>';
            }
        });

        function toggleThemeWithRipple(e) {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const nextTheme = isDark ? 'light' : 'dark';
            
            // Fallback untuk browser lama
            if (!document.startViewTransition) {
                applyTheme(nextTheme);
                return;
            }

            const x = e.clientX;
            const y = e.clientY;
            const maxRadius = Math.hypot(
                Math.max(x, window.innerWidth - x),
                Math.max(y, window.innerHeight - y)
            );

            const transition = document.startViewTransition(() => {
                applyTheme(nextTheme);
            });

            transition.ready.then(() => {
                document.documentElement.animate(
                    {
                        clipPath: [
                            `circle(0px at ${x}px ${y}px)`,
                            `circle(${maxRadius}px at ${x}px ${y}px)`
                        ]
                    },
                    {
                        duration: 600,
                        easing: 'ease-out',
                        pseudoElement: '::view-transition-new(root)'
                    }
                );
            });
        }

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            currentTheme = theme;
            const icon = document.getElementById('theme-icon');
            if (theme === 'dark') {
                icon.innerHTML = '<path d="M12 3V1m0 22v-2m9-9h2M1 12h2m15.364 6.364l1.414 1.414M4.222 4.222l1.414 1.414m12.728 0l-1.414 1.414M6.364 17.636l-1.414 1.414M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10z"></path>';
            } else {
                icon.innerHTML = '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>';
            }
        }

        // Navbar scroll
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Dropdown toggle
        function toggleDropdown(e) {
            e.stopPropagation();
            const dd = document.getElementById('user-dropdown');
            dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
        }

        function toggleMobileNav() {
            const nav = document.getElementById('mobile-nav');
            const overlay = document.getElementById('mobile-overlay');
            nav.classList.toggle('open');
            overlay.classList.toggle('show');
            document.body.style.overflow = nav.classList.contains('open') ? 'hidden' : 'auto';
        }

        window.onclick = () => { if(document.getElementById('user-dropdown')) document.getElementById('user-dropdown').style.display = 'none'; };

        // Reveal animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('is-visible'); });
        }, { threshold: 0.15 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
    @stack('scripts')
</body>
</html>

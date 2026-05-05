<aside class="glass-sidebar h-screen transition-all duration-500 fixed left-0 top-0 z-50 flex flex-col" 
       :class="sidebarOpen ? 'w-[260px]' : 'w-20'">
    
    <!-- Premium Branding -->
    <div class="h-20 flex items-center px-8 shrink-0">
        <div class="w-8 h-8 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/30">
            <span class="text-white font-black text-sm">E</span>
        </div>
        <span x-show="sidebarOpen" class="ml-4 text-white font-black text-sm tracking-tighter uppercase">Expedition<span class="text-primary">.</span></span>
    </div>

    <!-- Navigation Scroll -->
    <div class="flex-1 overflow-y-auto custom-scrollbar py-8">
        @if(auth()->user()->role === 'manager')
        <!-- GROUP: DASHBOARD -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Dashboard</p>
            <div class="space-y-1">
                <a href="{{ route('manager.dashboard') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.dashboard') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Ringkasan Cabang</span>
                </a>
            </div>
        </div>

        <!-- GROUP: OPERASIONAL -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Operasional</p>
            <div class="space-y-1">
                <a href="{{ route('manager.transaksi') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.transaksi') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Daftar Transaksi</span>
                </a>
                <a href="{{ route('manager.gudang') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.gudang') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Monitoring Gudang</span>
                </a>
                <a href="{{ route('manager.pickups') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.pickups') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Daftar Pickup</span>
                </a>
            </div>
        </div>

        <!-- GROUP: STAFF -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Staff Management</p>
            <div class="space-y-1">
                <a href="{{ route('manager.staff') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.staff') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Daftar Staff Aktif</span>
                </a>
                <a href="{{ route('manager.staff.lamaran') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.staff.lamaran') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Lamaran Masuk</span>
                </a>
                <a href="{{ route('manager.shift') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.shift') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Shift History</span>
                </a>
            </div>
        </div>

        <!-- GROUP: FINANCE -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Finance & Audit</p>
            <div class="space-y-1">
                <a href="{{ route('manager.audit') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.audit') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Audit Cash Drawer</span>
                </a>
                <a href="{{ route('manager.omzet') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.omzet') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Rekap Pendapatan</span>
                </a>
            </div>
        </div>

        <!-- GROUP: SYSTEM -->
        <div class="mt-auto">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">System</p>
            <div class="space-y-1">
                <a href="{{ route('manager.profile') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('manager.profile') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Profile</span>
                </a>
            </div>
        </div>

        @elseif(auth()->user()->role === 'courier_transit')
        <!-- TRANSIT DASHBOARD -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Dashboard</p>
            <div class="space-y-1">
                <a href="{{ route('courier.transit.dashboard') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('courier.transit.dashboard') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Ringkasan</span>
                </a>
            </div>
        </div>
        <!-- TRANSIT MANIFEST -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Manifest</p>
            <div class="space-y-1">
                <a href="{{ route('courier.transit.manifest-out') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('courier.transit.manifest-out') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Manifest Out</span>
                </a>
                <a href="{{ route('courier.transit.manifest-in') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('courier.transit.manifest-in') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Manifest In</span>
                </a>
            </div>
        </div>
        <!-- TRANSIT LAPORAN -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Laporan</p>
            <div class="space-y-1">
                <a href="{{ route('courier.transit.trips') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('courier.transit.trips') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Trip Logs</span>
                </a>
                <a href="{{ route('courier.transit.laporan') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('courier.transit.laporan') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Performa Saya</span>
                </a>
            </div>
        </div>
        <!-- TRANSIT SYSTEM -->
        <div class="mt-auto">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">System</p>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('profile.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Profile</span>
                </a>
            </div>
        </div>

        @elseif(auth()->user()->role === 'courier_delivery' || auth()->user()->role === 'courier_pickup')
        <!-- UNIFIED COURIER DASHBOARD -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Dashboard</p>
            <div class="space-y-1">
                <a href="{{ route('courier.delivery.dashboard') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('courier.delivery.dashboard') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Daftar Tugas</span>
                </a>
            </div>
        </div>
        <!-- COURIER LAPORAN -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Laporan</p>
            <div class="space-y-1">
                <a href="{{ route('courier.delivery.laporan') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('courier.delivery.laporan') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Performa Saya</span>
                </a>
            </div>
        </div>

        <!-- COURIER SYSTEM -->
        <div class="mt-auto">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">System</p>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('profile.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Profile</span>
                </a>
            </div>
        </div>
        @elseif(auth()->user()->role === 'admin')
        <!-- ADMIN DASHBOARD -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Dashboard</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Dashboard</span>
                </a>
            </div>
        </div>
        <!-- ADMIN MANAGEMENT -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Management</p>
            <div class="space-y-1">
                <a href="{{ route('shipments.index') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('shipments.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">All Shipments</span>
                </a>
                <a href="{{ route('branches.index') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('branches.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Branches</span>
                </a>
                <a href="{{ route('rates.index') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('rates.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Rates</span>
                </a>
                <a href="{{ route('admin.approvals.index') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('admin.approvals.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Approvals</span>
                </a>
                <a href="{{ route('admin.monitoring') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('admin.monitoring') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Global Monitoring</span>
                </a>
            </div>
        </div>
        <!-- ADMIN SYSTEM -->
        <div class="mt-auto">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">System</p>
            <div class="space-y-1">
                <a href="{{ route('reports.index') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('reports.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Reports</span>
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('profile.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Profile</span>
                </a>
            </div>
        </div>

        @elseif(auth()->user()->role === 'cashier')
        <!-- CASHIER DASHBOARD -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Dashboard</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Dashboard</span>
                </a>
            </div>
        </div>
        <!-- CASHIER OPERATIONS -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Operasional</p>
            <div class="space-y-1">
                <a href="{{ route('shipments.index') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('shipments.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Shipments</span>
                </a>
                <a href="{{ route('cashier.pickups') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('cashier.pickups') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Pickup Requests</span>
                </a>
                <a href="{{ route('cashier.drawer') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('cashier.drawer') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Cash Drawer</span>
                </a>
                <a href="{{ route('cashier.shifts') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('cashier.shifts') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">My Shifts</span>
                </a>
            </div>
        </div>
        <!-- CASHIER SYSTEM -->
        <div class="mt-auto">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">System</p>
            <div class="space-y-1">
                <a href="{{ route('reports.index') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('reports.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Reports</span>
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('profile.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Profile</span>
                </a>
            </div>
        </div>

        @else
        <!-- DEFAULT/FALLBACK DASHBOARD -->
        <div class="mb-10">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Dashboard</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Dashboard</span>
                </a>
            </div>
        </div>
        <!-- SYSTEM -->
        <div class="mt-auto">
            <p x-show="sidebarOpen" class="px-8 text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">System</p>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center text-slate-400 hover:text-white transition-all group {{ request()->routeIs('profile.*') ? 'nav-link-active' : '' }}"
                   :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span x-show="sidebarOpen" class="text-xs font-bold whitespace-nowrap">Profile</span>
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-white/5">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center text-slate-400 hover:text-rose-500 transition-all group hover:bg-rose-500/10"
                    :class="sidebarOpen ? 'px-8 py-3 gap-4' : 'p-3 justify-center'">
                <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span x-show="sidebarOpen" class="text-xs font-bold">Sign Out</span>
            </button>
        </form>
    </div>
</aside>

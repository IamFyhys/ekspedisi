<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: true }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Expedition Premium') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- External Libraries (Priority) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { background-color: #f1f5f9; color: #1E293B; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

        .premium-card {
            background: white;
            border-radius: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 1);
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.1);
        }

        .glass-sidebar {
            background: #0f172a;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-link-active {
            background: linear-gradient(90deg, rgba(24, 95, 165, 0.15) 0%, rgba(24, 95, 165, 0) 100%);
            border-left: 4px solid #185FA5;
            color: white !important;
        }

        .animate-reveal {
            animation: reveal 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes reveal {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-500" 
             :class="sidebarOpen ? 'ml-[260px]' : 'ml-20'">
            
            <!-- Refined Topbar -->
            <header class="h-20 bg-white/70 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-10 shrink-0 z-40 sticky top-0">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl hover:bg-slate-50 text-slate-400 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <div class="hidden sm:block">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Platform / <span class="text-slate-900">@yield('title_breadcrumb', 'Dashboard')</span></p>
                    </div>
                </div>
                
                <div class="flex items-center gap-8">
                    <div class="hidden lg:flex items-center bg-slate-50 border border-slate-100 rounded-2xl px-4 py-2 gap-3 focus-within:ring-2 focus-within:ring-primary/10 transition-all">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        <input type="text" placeholder="Search data..." class="bg-transparent border-none text-sm font-medium focus:ring-0 w-48">
                    </div>

                    <div class="flex items-center gap-4 pl-8 border-l border-slate-100">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-black text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[9px] font-bold text-primary uppercase tracking-widest mt-1">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-primary flex items-center justify-center text-white font-black text-sm shadow-lg shadow-primary/20 overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-12 custom-scrollbar bg-[#f8fafc]">
                <div class="max-w-[1440px] mx-auto animate-reveal">
                    @if(isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>
            </main>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')
</body>
</html>

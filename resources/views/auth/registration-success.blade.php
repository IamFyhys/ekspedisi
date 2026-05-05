<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success — Skynet Logistics</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0f172a; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .success-blob { filter: blur(80px); animation: move 10s infinite alternate; }
        @keyframes move { from { transform: translate(-20%, -20%) scale(1); } to { transform: translate(20%, 20%) scale(1.2); } }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6 overflow-hidden">
    <!-- Animated background -->
    <div class="absolute inset-0 overflow-hidden -z-10">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-600/20 rounded-full success-blob"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-600/20 rounded-full success-blob" style="animation-delay: -5s;"></div>
    </div>

    <div class="w-full max-w-2xl glass p-12 md:p-16 rounded-[3rem] shadow-2xl text-center space-y-10 relative overflow-hidden">
        <div class="relative z-10">
            <!-- Icon -->
            <div class="w-24 h-24 bg-emerald-500/10 rounded-[2.5rem] flex items-center justify-center mx-auto mb-10 shadow-inner">
                <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4">Lamaran Terkirim!</h1>
            <p class="text-slate-400 text-lg font-medium leading-relaxed max-w-md mx-auto">
                Terima kasih telah melamar di <span class="text-blue-400 font-bold">Skynet Logistics</span>. Tim kami akan segera meninjau berkas Anda.
            </p>

            <div class="mt-12 space-y-4">
                <div class="p-8 bg-white/5 rounded-3xl border border-white/5 text-left">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Langkah Selanjutnya</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-lg bg-blue-500/20 flex items-center justify-center shrink-0 mt-1">
                                <span class="text-[10px] font-bold text-blue-400">1</span>
                            </div>
                            <p class="text-sm text-slate-300 font-medium">Manager Cabang akan meninjau berkas identitas Anda dalam 1-2 hari kerja.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-lg bg-indigo-500/20 flex items-center justify-center shrink-0 mt-1">
                                <span class="text-[10px] font-bold text-indigo-400">2</span>
                            </div>
                            <p class="text-sm text-slate-300 font-medium">Setelah disetujui Manager, Admin Pusat akan mengaktifkan akun Anda.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-lg bg-emerald-500/20 flex items-center justify-center shrink-0 mt-1">
                                <span class="text-[10px] font-bold text-emerald-400">3</span>
                            </div>
                            <p class="text-sm text-slate-300 font-medium">Anda akan menerima email notifikasi setelah akun aktif dan siap untuk login.</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/" class="px-10 py-5 bg-white text-slate-900 font-black rounded-2xl hover:bg-slate-100 transition-all text-sm uppercase tracking-widest">
                    Kembali Ke Beranda
                </a>
                <a href="/login" class="px-10 py-5 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-500 transition-all text-sm uppercase tracking-widest shadow-xl shadow-blue-900/20">
                    Cek Status Login
                </a>
            </div>
        </div>

        <!-- Abstract shapes -->
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
    </div>
</body>
</html>

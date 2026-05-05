@extends('layouts.admin')

@section('title_breadcrumb', 'Lamaran Masuk')

@section('content')
<div class="p-8" x-data="{ showModal: false, selectedApp: null }">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">LAMARAN <span class="text-primary">MASUK</span></h1>
            <p class="text-slate-500 font-medium mt-1">Review calon staff untuk cabang {{ auth()->user()->branch->name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($applications as $app)
        <div class="premium-card p-8 bg-white flex flex-col md:flex-row items-center justify-between gap-8 group">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-[2rem] bg-slate-50 flex items-center justify-center text-primary font-black text-2xl group-hover:scale-110 transition-transform shadow-inner">
                    {{ substr($app->user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900">{{ $app->user->name }}</h3>
                    <p class="text-sm font-bold text-slate-400 mt-0.5">{{ $app->user->email }}</p>
                    <div class="flex items-center gap-3 mt-3">
                        <span class="px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/10">
                            {{ str_replace('_', ' ', $app->position) }}
                        </span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Daftar pada {{ $app->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button @click="selectedApp = {{ $app->load('user') }}; showModal = true" class="px-6 py-4 bg-slate-50 text-slate-600 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-100 transition-all">
                    Pratinjau Berkas
                </button>
                <form action="{{ route('manager.applications.review', $app->id) }}" method="POST">
                    @csrf
                    <button class="px-8 py-4 bg-primary text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-primary/90 transition-all shadow-xl shadow-primary/20">
                        Teruskan ke Admin
                    </button>
                </form>
                <form action="{{ route('manager.applications.reject', $app->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak lamaran ini?')">
                    @csrf
                    <button class="p-4 bg-rose-50 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="premium-card p-20 bg-white text-center">
            <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mx-auto text-slate-300 mb-6 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-900">Belum ada lamaran baru</h3>
            <p class="text-slate-500 font-medium max-w-sm mx-auto mt-2">Semua lamaran masuk telah diproses atau belum ada pelamar baru saat ini.</p>
        </div>
        @endforelse
    </div>

    <!-- Preview Modal -->
    <template x-if="showModal">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-8 bg-slate-900/60 backdrop-blur-md" x-transition>
            <div class="bg-white rounded-[3rem] w-full max-w-5xl h-[85vh] flex overflow-hidden shadow-2xl animate-reveal" @click.away="showModal = false">
                <!-- Left: Info -->
                <div class="w-1/3 bg-slate-50 p-12 border-r border-slate-100 flex flex-col">
                    <div class="flex-1 space-y-10">
                        <div>
                            <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-2">Pelamar</p>
                            <h2 class="text-3xl font-black text-slate-900 leading-tight" x-text="selectedApp.user.name"></h2>
                            <p class="text-slate-500 font-medium" x-text="selectedApp.user.email"></p>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Posisi Dilamar</p>
                                <p class="text-sm font-black text-slate-700 uppercase tracking-wider" x-text="selectedApp.position.replace('_', ' ')"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor HP</p>
                                <p class="text-sm font-black text-slate-700" x-text="selectedApp.user.phone || '-'"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat</p>
                                <p class="text-sm font-bold text-slate-600 leading-relaxed" x-text="selectedApp.user.address || '-'"></p>
                            </div>
                        </div>
                    </div>

                    <button @click="showModal = false" class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl uppercase tracking-widest text-[10px] hover:bg-slate-800 transition-all">Tutup</button>
                </div>

                <!-- Right: Document Previews -->
                <div class="w-2/3 p-12 overflow-y-auto custom-scrollbar bg-white">
                    <div class="space-y-12">
                        <div>
                            <h4 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                                <div class="w-2 h-8 bg-primary rounded-full"></div>
                                Dokumen Identitas
                            </h4>
                            <div class="grid grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Foto KTP</p>
                                    <div class="aspect-[3/2] rounded-3xl bg-slate-50 overflow-hidden border-2 border-slate-100 shadow-inner group/img">
                                        <template x-if="selectedApp.user.ktp_photo">
                                            <img :src="'/storage/' + selectedApp.user.ktp_photo" class="w-full h-full object-cover group-hover/img:scale-110 transition-transform duration-700">
                                        </template>
                                        <template x-if="!selectedApp.user.ktp_photo">
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Selfie + KTP</p>
                                    <div class="aspect-[3/2] rounded-3xl bg-slate-50 overflow-hidden border-2 border-slate-100 shadow-inner group/img">
                                        <template x-if="selectedApp.user.selfie_photo">
                                            <img :src="'/storage/' + selectedApp.user.selfie_photo" class="w-full h-full object-cover group-hover/img:scale-110 transition-transform duration-700">
                                        </template>
                                        <template x-if="!selectedApp.user.selfie_photo">
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                                <div class="w-2 h-8 bg-primary rounded-full"></div>
                                Informasi Akun
                            </h4>
                            <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-slate-200/50">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Username</span>
                                    <span class="text-sm font-bold text-slate-700" x-text="selectedApp.user.username || '-'"></span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Saat Ini</span>
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[9px] font-black uppercase tracking-widest" x-text="selectedApp.user.status"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection

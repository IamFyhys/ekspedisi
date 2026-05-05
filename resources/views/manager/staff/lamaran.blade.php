<x-admin-layout>
    @section('title_breadcrumb', 'Lamaran Masuk')
    <div class="space-y-10 animate-reveal" x-data="{ detailOpen: false, selectedApp: null, rejectForm: false }">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Lamaran Masuk — <span class="text-primary">{{ Auth::user()->role === 'admin' ? 'Semua Cabang' : (Auth::user()->branch->name ?? 'Cabang') }}</span></h1>
                <p class="text-slate-500 font-medium">Review pelamar yang mendaftar mandiri ke sistem kami.</p>
            </div>
            
            <div class="flex p-1.5 bg-slate-100 rounded-2xl w-fit">
                <a href="?status=pending" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $status === 'pending' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Pending</a>
                <a href="?status=review" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $status === 'review' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Diteruskan</a>
                <a href="?status=rejected" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $status === 'rejected' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">Ditolak</a>
            </div>
        </div>

        <!-- Table Container -->
        <div class="premium-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Cabang</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Posisi</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tgl Daftar</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($applications as $app)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <p class="text-sm font-black text-slate-900 leading-none mb-1">{{ $app->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400">{{ $app->email }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                    {{ $app->branch->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-500 capitalize">{{ str_replace('_', ' ', $app->role) }}</td>
                            <td class="px-8 py-6 text-sm font-medium text-slate-600">{{ $app->created_at->format('d/m') }}</td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                                    {{ $app->status === 'pending' ? 'bg-amber-50 text-amber-600' : ($app->status === 'review' ? 'bg-indigo-50 text-indigo-600' : 'bg-rose-50 text-rose-600') }}">
                                    {{ $app->status === 'pending' ? 'PENDING' : ($app->status === 'review' ? 'DITERUSKAN' : 'DITOLAK') }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button @click="selectedApp = @js($app); detailOpen = true; rejectForm = false" class="px-6 py-2.5 bg-slate-100 text-slate-600 text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-primary hover:text-white transition-all">Detail</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Tidak ada lamaran ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-6 border-t border-slate-50">
                {{ $applications->links() }}
            </div>
        </div>

        <!-- Detail Modal -->
        <div x-show="detailOpen" 
             class="fixed inset-0 z-[999] overflow-y-auto" 
             x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="detailOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-md" 
                     @click="detailOpen = false"
                     aria-hidden="true"></div>

                <!-- Trick to center modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div x-show="detailOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-[3rem] border border-slate-100">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-xl font-black text-slate-900">Detail Lamaran</h3>
                        <button @click="detailOpen = false" class="text-slate-400 hover:text-rose-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-6 text-sm">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</p>
                                <p class="font-bold text-slate-900" x-text="selectedApp?.name"></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</p>
                                <p class="font-bold text-slate-900" x-text="selectedApp?.email"></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No. HP</p>
                                <p class="font-bold text-slate-900" x-text="selectedApp?.phone || '-'"></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Lahir</p>
                                <p class="font-bold text-slate-900" x-text="selectedApp?.birth_date ? new Date(selectedApp.birth_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-'"></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Posisi</p>
                                <p class="font-bold text-primary capitalize" x-text="selectedApp?.role?.replace('_', ' ')"></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cabang Tujuan</p>
                                <p class="font-bold text-slate-900" x-text="selectedApp?.branch?.name || 'N/A'"></p>
                            </div>
                        </div>

                        <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 space-y-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Domisili</p>
                                <p class="text-sm font-bold text-slate-900">
                                    <span x-text="selectedApp?.district_name"></span>, 
                                    <span x-text="selectedApp?.regency_name"></span>, 
                                    <span x-text="selectedApp?.province_name"></span>
                                </p>
                                <p class="text-xs text-slate-500 mt-1" x-text="selectedApp?.address_detail"></p>
                            </div>
                        </div>

                        <template x-if="selectedApp?.role?.includes('courier')">
                            <div class="p-6 bg-blue-50/50 rounded-3xl border border-blue-100 space-y-4">
                                <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Informasi Kendaraan & SIM</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">Tipe SIM</p>
                                        <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.sim_type"></p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">Kendaraan</p>
                                        <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.vehicle_type"></p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">Plat Nomor</p>
                                        <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.vehicle_plate"></p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengalaman</p>
                            <p class="text-sm font-medium text-slate-600" x-text="selectedApp?.experience || 'Tidak ada catatan pengalaman.'"></p>
                        </div>

                        <div class="space-y-3">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Berkas & Foto</p>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <div class="aspect-square bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 cursor-pointer group relative" @click="window.open('/storage/' + selectedApp?.ktp_photo)">
                                        <template x-if="selectedApp?.ktp_photo">
                                            <img :src="'/storage/' + selectedApp?.ktp_photo" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                        </template>
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </div>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase text-center">KTP</p>
                                </div>

                                <div class="space-y-2">
                                    <div class="aspect-square bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 cursor-pointer group relative" @click="window.open('/storage/' + selectedApp?.selfie_photo)">
                                        <template x-if="selectedApp?.selfie_photo">
                                            <img :src="'/storage/' + selectedApp?.selfie_photo" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                        </template>
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </div>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase text-center">Selfie</p>
                                </div>

                                <template x-if="selectedApp?.sim_photo">
                                    <div class="space-y-2">
                                        <div class="aspect-square bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 cursor-pointer group relative" @click="window.open('/storage/' + selectedApp?.sim_photo)">
                                            <img :src="'/storage/' + selectedApp?.sim_photo" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </div>
                                        </div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase text-center">SIM</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="selectedApp?.status === 'pending'" class="pt-6 border-t border-slate-50 space-y-6">
                            <form :id="'form-forward-' + selectedApp?.id" :action="'/manager/staff/lamaran/' + selectedApp?.id + '/forward'" method="POST" class="space-y-4">
                                @csrf
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Catatan untuk Admin (opsional)</label>
                                    <textarea name="note" rows="2" class="w-full px-5 py-3.5 rounded-xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all text-sm font-medium resize-none" placeholder="Tambahkan catatan..."></textarea>
                                </div>
                                <div class="flex gap-4">
                                    <button type="button" @click="rejectConfirm(selectedApp?.id)" class="flex-1 py-4 bg-rose-50 text-rose-500 font-black rounded-xl hover:bg-rose-100 transition-all uppercase tracking-widest text-[10px]">Tolak</button>
                                    <button type="button" @click="forwardConfirm(selectedApp?.id)" class="flex-1 py-4 bg-primary text-white font-black rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all uppercase tracking-widest text-[10px]">Teruskan ke Admin</button>
                                </div>
                            </form>

                            <form :id="'form-reject-' + selectedApp?.id" :action="'/manager/staff/lamaran/' + selectedApp?.id + '/reject'" method="POST" class="hidden">
                                @csrf
                                <input type="hidden" name="reason" id="reject-reason">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function forwardConfirm(id) {
            Swal.fire({
                title: 'Teruskan ke Admin?',
                text: "Lamaran akan dikirim ke Admin Pusat untuk persetujuan akhir.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5',
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Ya, Teruskan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-forward-' + id).submit();
                }
            });
        }

        function rejectConfirm(id) {
            Swal.fire({
                title: 'Tolak Lamaran?',
                text: "Berikan alasan penolakan untuk pelamar ini.",
                icon: 'warning',
                input: 'textarea',
                inputPlaceholder: 'Tulis alasan penolakan di sini...',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Alasan penolakan wajib diisi!'
                    }
                },
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('form-reject-' + id);
                    form.querySelector('#reject-reason').value = result.value;
                    form.submit();
                }
            });
        }

        // Handle Success/Error Alerts
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                position: 'center',
                customClass: {
                    popup: 'rounded-[2rem]'
                }
            });
        @endif
    </script>
    @endpush
</x-admin-layout>

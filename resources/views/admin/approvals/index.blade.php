<x-admin-layout>
    <div class="space-y-10" x-data="{ detailOpen: false, selectedApp: null }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Staff <span class="text-indigo-600">Approval</span></h1>
                <p class="text-slate-500 font-medium mt-1">Persetujuan akhir akun staff baru.</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-2">
            @foreach(['review', 'active', 'rejected'] as $s)
            <a href="?status={{ $s }}" 
               class="px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $status === $s ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-slate-400 hover:bg-slate-50 border border-slate-100' }}">
                {{ $s }}
            </a>
            @endforeach
        </div>

        <!-- Approvals Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-6">Nama Pelamar</th>
                            <th class="px-8 py-6">Cabang & Posisi</th>
                            <th class="px-8 py-6">Direview Oleh</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($applications as $app)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-900">{{ $app->name }}</span>
                                    <span class="text-xs text-slate-400">{{ $app->email }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-700">{{ $app->branch->name ?? '-' }}</span>
                                    <span class="text-[10px] font-bold text-indigo-500 uppercase">{{ str_replace('_', ' ', $app->role) }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-600">{{ $app->reviewer->name ?? 'System' }}</span>
                                    <span class="text-[10px] font-medium text-slate-400">{{ $app->reviewed_at ? $app->reviewed_at->format('d M Y') : '-' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                                    @if($app->status === 'review') bg-indigo-50 text-indigo-600
                                    @elseif($app->status === 'active') bg-emerald-50 text-emerald-600
                                    @else bg-rose-50 text-rose-600 @endif">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <button @click="selectedApp = @js($app); detailOpen = true" class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all">Review</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-bold italic">Tidak ada antrian persetujuan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($applications->hasPages())
            <div class="p-8 border-t border-slate-50">
                {{ $applications->links() }}
            </div>
            @endif
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
                    <h3 class="text-2xl font-black text-slate-900">Review Persetujuan</h3>
                    <button @click="detailOpen = false" class="p-3 bg-slate-50 rounded-2xl text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</p>
                            <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.name"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Email</p>
                            <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.email"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">No. HP</p>
                            <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.phone || '-'"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Lahir</p>
                            <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.birth_date ? new Date(selectedApp.birth_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-'"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Cabang</p>
                            <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.branch?.name"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Posisi</p>
                            <p class="text-sm font-bold text-indigo-600 capitalize" x-text="selectedApp?.role?.replace('_', ' ')"></p>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 space-y-4">
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
                        <div class="p-6 bg-indigo-50/50 rounded-[2rem] border border-indigo-100 space-y-4">
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Informasi Kendaraan & SIM</p>
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

                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Review Manager</p>
                        <p class="text-sm font-bold text-slate-900" x-text="selectedApp?.reviewer?.name"></p>
                        <p class="text-sm font-medium text-slate-500 italic mt-1" x-text="selectedApp?.manager_note || 'Tidak ada catatan.'"></p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Verifikasi Berkas</p>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <img :src="'/storage/' + selectedApp?.ktp_photo" class="w-full aspect-square object-cover rounded-2xl border border-slate-100 cursor-pointer hover:ring-4 hover:ring-primary/10 transition-all" @click="window.open('/storage/' + selectedApp?.ktp_photo)">
                                <p class="text-[8px] font-black text-slate-400 uppercase text-center">KTP</p>
                            </div>
                            <div class="space-y-2">
                                <img :src="'/storage/' + selectedApp?.selfie_photo" class="w-full aspect-square object-cover rounded-2xl border border-slate-100 cursor-pointer hover:ring-4 hover:ring-primary/10 transition-all" @click="window.open('/storage/' + selectedApp?.selfie_photo)">
                                <p class="text-[8px] font-black text-slate-400 uppercase text-center">Selfie</p>
                            </div>
                            <template x-if="selectedApp?.sim_photo">
                                <div class="space-y-2">
                                    <img :src="'/storage/' + selectedApp?.sim_photo" class="w-full aspect-square object-cover rounded-2xl border border-slate-100 cursor-pointer hover:ring-4 hover:ring-primary/10 transition-all" @click="window.open('/storage/' + selectedApp?.sim_photo)">
                                    <p class="text-[8px] font-black text-slate-400 uppercase text-center">SIM</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-show="selectedApp?.status === 'review'" class="pt-6 space-y-6">
                        <form :id="'form-approve-' + selectedApp?.id" :action="'/admin/approvals/' + selectedApp?.id + '/approve'" method="POST">
                            @csrf
                            <button type="button" @click="approveConfirm(selectedApp?.id)" class="w-full py-4 bg-emerald-600 text-white font-black rounded-2xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 uppercase tracking-widest">Approve & Aktifkan Akun</button>
                        </form>

                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                            <div class="relative flex justify-center text-xs uppercase"><span class="px-2 bg-white text-slate-400">Atau</span></div>
                        </div>

                        <form :id="'form-reject-' + selectedApp?.id" :action="'/admin/approvals/' + selectedApp?.id + '/reject'" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black text-rose-400 uppercase tracking-widest mb-2">Alasan Penolakan</label>
                                <textarea name="reason" rows="2" required placeholder="Wajib diisi jika menolak..." class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-none focus:ring-2 focus:ring-rose-500 transition-all text-sm font-medium"></textarea>
                            </div>
                            <button type="button" @click="rejectConfirm(selectedApp?.id)" class="w-full py-4 bg-slate-100 text-rose-500 font-black rounded-2xl hover:bg-rose-50 transition-colors">Tolak Pendaftaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function approveConfirm(id) {
            Swal.fire({
                title: 'Setujui Pendaftaran?',
                text: "Akun staff akan langsung aktif dan bisa digunakan untuk login.",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Ya, Aktifkan!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[3rem]',
                    confirmButton: 'rounded-2xl px-8 py-4 font-black uppercase tracking-widest text-xs',
                    cancelButton: 'rounded-2xl px-8 py-4 font-black uppercase tracking-widest text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-approve-' + id).submit();
                }
            });
        }

        function rejectConfirm(id) {
            const form = document.getElementById('form-reject-' + id);
            const reason = form.querySelector('textarea[name="reason"]').value;
            
            if (!reason) {
                Swal.fire({
                    icon: 'error',
                    title: 'Alasan Wajib Diisi',
                    text: 'Mohon tuliskan alasan penolakan sebelum melanjutkan.',
                    customClass: { popup: 'rounded-[2rem]' }
                });
                return;
            }

            Swal.fire({
                title: 'Tolak Pendaftaran?',
                text: "Pelamar akan menerima notifikasi penolakan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[3rem]',
                    confirmButton: 'rounded-2xl px-8 py-4 font-black uppercase tracking-widest text-xs',
                    cancelButton: 'rounded-2xl px-8 py-4 font-black uppercase tracking-widest text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                customClass: { popup: 'rounded-[2rem]' }
            });
        @endif
    </script>
    @endpush
</x-admin-layout>

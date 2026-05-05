<x-admin-layout>
    <div class="space-y-6" x-data="branchManagement()">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Branches Management</h1>
                <p class="text-slate-500 font-medium mt-1">Kelola data gudang atau cabang operasional ekspedisi.</p>
            </div>
            <button @click="openModal('create')" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Cabang
            </button>
        </div>

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-2xl text-emerald-600 font-medium text-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-rose-50 border border-rose-100 p-4 rounded-2xl text-rose-600 font-medium text-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('error') }}
        </div>
        @endif

        <div class="premium-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Nama Cabang (Hub)</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Kota</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Kontak</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Pegawai</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($branches as $branch)
                        <tr class="group hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-5">
                                <p class="font-black text-slate-900">{{ $branch->name }}</p>
                                <p class="text-sm font-medium text-slate-500 mt-1 max-w-xs truncate">{{ $branch->address }}</p>
                            </td>
                            <td class="px-8 py-5 text-sm font-medium text-slate-600">
                                {{ $branch->city }}
                            </td>
                            <td class="px-8 py-5 text-sm font-medium text-slate-600">
                                {{ $branch->phone }}
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-blue-50 text-primary">
                                    {{ $branch->users_count }} Staff
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openModal('edit', {{ $branch }})" class="p-2 text-primary hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="inline" id="delete-form-{{ $branch->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" @click="confirmDelete('{{ $branch->id }}', '{{ $branch->name }}')" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-slate-500 font-medium">Belum ada data cabang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Form -->
        <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
            <!-- Backdrop -->
            <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal"></div>
            
            <!-- Modal Box -->
            <div x-show="isModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative premium-card shadow-2xl w-full max-w-lg overflow-hidden z-10">
                
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="text-xl font-black text-slate-900" x-text="modalMode === 'create' ? 'Tambah Cabang Baru' : 'Edit Data Cabang'"></h3>
                    <button @click="closeModal" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" class="p-8 space-y-6">
                    @csrf
                    <input type="hidden" name="_method" :value="modalMode === 'edit' ? 'PUT' : 'POST'">
                    
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Cabang / Hub <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="formData.name" placeholder="Misal: Jakarta Hub" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary transition-all text-slate-900" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kota <span class="text-rose-500">*</span></label>
                        <input type="text" name="city" x-model="formData.city" placeholder="Misal: Jakarta" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary transition-all text-slate-900" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kontak / Telepon <span class="text-rose-500">*</span></label>
                        <input type="text" name="phone" x-model="formData.phone" placeholder="Misal: 021-123456" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary transition-all text-slate-900" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Lengkap <span class="text-rose-500">*</span></label>
                        <textarea name="address" x-model="formData.address" rows="3" placeholder="Alamat lengkap operasional cabang..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary transition-all text-slate-900" required></textarea>
                    </div>

                    <div class="pt-6 flex justify-end gap-4 border-t border-slate-50">
                        <button type="button" @click="closeModal" class="px-6 py-3 font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-primary/20 transition-all" x-text="modalMode === 'create' ? 'Simpan Data' : 'Perbarui Data'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function branchManagement() {
            return {
                isModalOpen: false,
                modalMode: 'create', // 'create' or 'edit'
                formAction: '{{ route('branches.store') }}',
                formData: {
                    id: '',
                    name: '',
                    city: '',
                    phone: '',
                    address: ''
                },
                openModal(mode, data = null) {
                    this.modalMode = mode;
                    if (mode === 'edit' && data) {
                        this.formData = {
                            id: data.id,
                            name: data.name,
                            city: data.city,
                            phone: data.phone,
                            address: data.address
                        };
                        this.formAction = `/branches/${data.id}`;
                    } else {
                        this.formData = { id: '', name: '', city: '', phone: '', address: '' };
                        this.formAction = '{{ route('branches.store') }}';
                    }
                    this.isModalOpen = true;
                },
                closeModal() {
                    this.isModalOpen = false;
                },
                confirmDelete(id, name) {
                    Swal.fire({
                        title: 'Hapus Cabang?',
                        html: `Anda yakin ingin menghapus cabang <strong>${name}</strong>?<br><span class="text-sm text-red-500">Pastikan tidak ada staf atau paket yang tertaut!</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${id}`).submit();
                        }
                    });
                }
            }
        }
    </script>
</x-admin-layout>

<x-admin-layout>
    <div class="space-y-6" x-data="rateManagement()">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Rates & Pricing</h1>
                <p class="text-slate-500 font-medium mt-1">Kelola daftar harga ongkos kirim antar kota/provinsi.</p>
            </div>
            <button @click="openModal('create')" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Tarif
            </button>
        </div>

        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#10B981'
                });
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            });
        </script>
        @endif

        @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Data Tidak Valid!',
                    html: `
                        <div class="text-sm text-left text-rose-600 font-medium">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    `,
                    icon: 'warning',
                    confirmButtonColor: '#ef4444'
                });
            });
        </script>
        @endif

        <div class="premium-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Kota Asal (Origin)</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Kota Tujuan (Destination)</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Harga per KG</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Estimasi Tiba</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($rates as $rate)
                        <tr class="group hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-5">
                                <span class="font-black text-slate-900">{{ $rate->origin->name }}</span>
                                <span class="text-sm font-medium text-slate-500 block mt-1">{{ $rate->origin->province }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-black text-slate-900">{{ $rate->destination->name }}</span>
                                <span class="text-sm font-medium text-slate-500 block mt-1">{{ $rate->destination->province }}</span>
                            </td>
                            <td class="px-8 py-5 text-right font-black text-primary">
                                Rp {{ number_format($rate->price_per_kg, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600">
                                    {{ $rate->estimated_days }} Hari
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openModal('edit', {{ $rate }})" class="p-2 text-primary hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <form action="{{ route('rates.destroy', $rate) }}" method="POST" class="inline" id="delete-form-{{ $rate->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" @click="confirmDelete('{{ $rate->id }}')" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-slate-500 font-medium">Belum ada data tarif pengiriman.</td>
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
                    <h3 class="text-xl font-black text-slate-900" x-text="modalMode === 'create' ? 'Tambah Tarif Baru' : 'Edit Tarif Ongkir'"></h3>
                    <button @click="closeModal" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" class="p-8 space-y-6">
                    @csrf
                    <template x-if="modalMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kota Asal <span class="text-rose-500">*</span></label>
                            <select name="origin_location_id" x-model="formData.origin_location_id" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary transition-all text-slate-900" required>
                                <option value="">Pilih Kota Asal</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kota Tujuan <span class="text-rose-500">*</span></label>
                            <select name="destination_location_id" x-model="formData.destination_location_id" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary transition-all text-slate-900" required>
                                <option value="">Pilih Kota Tujuan</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga per KG (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" name="price_per_kg" x-model="formData.price_per_kg" placeholder="Misal: 15000" min="0" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary transition-all text-slate-900" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Estimasi Tiba (Hari) <span class="text-rose-500">*</span></label>
                        <input type="number" name="estimated_days" x-model="formData.estimated_days" placeholder="Misal: 3" min="1" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary transition-all text-slate-900" required>
                    </div>

                    <div class="pt-6 flex justify-end gap-4 border-t border-slate-50">
                        <button type="button" @click="closeModal" class="px-6 py-3 font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-primary/20 transition-all" x-text="modalMode === 'create' ? 'Simpan Tarif' : 'Perbarui Tarif'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function rateManagement() {
            return {
                isModalOpen: false,
                modalMode: 'create', // 'create' or 'edit'
                formAction: '{{ route('rates.store') }}',
                formData: {
                    id: '',
                    origin_location_id: '',
                    destination_location_id: '',
                    price_per_kg: '',
                    estimated_days: ''
                },
                openModal(mode, data = null) {
                    this.modalMode = mode;
                    if (mode === 'edit' && data) {
                        this.formData = {
                            id: data.id,
                            origin_location_id: data.origin_location_id,
                            destination_location_id: data.destination_location_id,
                            price_per_kg: Math.floor(data.price_per_kg),
                            estimated_days: data.estimated_days
                        };
                        this.formAction = `/rates/${data.id}`;
                    } else {
                        this.formData = { id: '', origin_location_id: '', destination_location_id: '', price_per_kg: '', estimated_days: '' };
                        this.formAction = '{{ route('rates.store') }}';
                    }
                    this.isModalOpen = true;
                },
                closeModal() {
                    this.isModalOpen = false;
                },
                confirmDelete(id) {
                    Swal.fire({
                        title: 'Hapus Tarif?',
                        text: "Anda yakin ingin menghapus data tarif ini?",
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

<x-admin-layout>
    @section('title_breadcrumb', 'Daftar Transaksi')
    <div class="space-y-10 animate-reveal">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Daftar <span class="text-primary">Transaksi</span> Cabang</h1>
                <p class="text-slate-500 font-medium">Monitoring semua pengiriman yang diproses di cabang ini.</p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="premium-card p-8 bg-white border border-slate-100 shadow-sm">
            <form action="{{ route('manager.transaksi') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Cari No Resi</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="EXP-xxx..." class="w-full px-5 py-3.5 rounded-xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all text-sm font-bold">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full px-5 py-3.5 rounded-xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all text-sm font-bold">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status</label>
                    <select name="status" class="w-full px-5 py-3.5 rounded-xl bg-slate-50 border-none focus:ring-4 focus:ring-primary/10 transition-all text-sm font-bold appearance-none">
                        <option value="">Semua Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-4 bg-primary text-white font-black rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all uppercase tracking-widest text-[10px]">Filter Sekarang</button>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="premium-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">No Resi</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengirim</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tujuan</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Omzet</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-6 text-sm font-black text-slate-900 tracking-tight">{{ $tx->tracking_number }}</td>
                            <td class="px-8 py-6 text-sm font-medium text-slate-600">{{ $tx->sender_name }}</td>
                            <td class="px-8 py-6 text-sm font-medium text-slate-600 truncate max-w-[150px]">{{ $tx->receiver_address }}</td>
                            <td class="px-8 py-6 text-sm font-black text-slate-900">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                                    {{ $tx->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-600' : ($tx->payment_status === 'cancelled' ? 'bg-rose-50 text-rose-600' : 'bg-amber-50 text-amber-600') }}">
                                    {{ $tx->payment_status === 'paid' ? 'Paid ✓' : ($tx->payment_status === 'cancelled' ? 'Cancelled' : 'Pending') }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('shipments.show', $tx->id) }}" class="px-6 py-2.5 bg-slate-100 text-slate-600 text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-primary hover:text-white transition-all">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-slate-400 font-bold italic">Belum ada data transaksi yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-6 border-t border-slate-50">
                {{ $transactions->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

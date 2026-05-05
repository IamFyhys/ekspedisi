<x-admin-layout>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900">Riwayat Pembayaran</h1>
            <p class="text-slate-500 font-medium mt-1">Laporan arus kas dan transaksi pengiriman.</p>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <form action="{{ route('manager.payments') }}" method="GET" class="flex flex-wrap items-end gap-4 mb-8">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="bg-slate-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-600/10">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="bg-slate-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-600/10">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Metode</label>
                    <select name="payment_method" class="bg-slate-50 border-none rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-indigo-600/10">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer (Midtrans)</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20">Filter</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">No. Resi</th>
                            <th class="px-6 py-4">Metode</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-600">{{ $payment->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 font-black text-slate-900">{{ $payment->shipment->tracking_number ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm font-medium uppercase">{{ $payment->payment_method }}</td>
                            <td class="px-6 py-4">
                                @if($payment->payment_status == 'paid')
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600">Paid</span>
                                @elseif($payment->payment_status == 'pending_refund' || $payment->payment_status == 'failed')
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-600">Void/Refund</span>
                                @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-black text-right text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

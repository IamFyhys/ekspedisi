<table class="min-w-full border-separate border-spacing-y-4 px-4 sm:px-6">
    <thead class="text-slate-400">
        <tr>
            <th class="px-6 py-2 text-left text-xs font-bold uppercase tracking-[0.1em] opacity-60">Shipment Info</th>
            <th class="px-6 py-2 text-left text-xs font-bold uppercase tracking-[0.1em] opacity-60">Participants</th>
            <th class="px-6 py-2 text-left text-xs font-bold uppercase tracking-[0.1em] opacity-60">Route</th>
            <th class="px-6 py-2 text-left text-xs font-bold uppercase tracking-[0.1em] opacity-60">Status</th>
            <th class="px-6 py-2 text-left text-xs font-bold uppercase tracking-[0.1em] opacity-60">Payment</th>
            <th class="px-6 py-2 text-center text-xs font-bold uppercase tracking-[0.1em] opacity-60">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($shipments as $shipment)
        <tr class="group bg-white hover:bg-slate-50/80 transition-all duration-200 shadow-[0_2px_10px_-3px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_20px_-6px_rgba(0,0,0,0.06)] rounded-2xl overflow-hidden">
            <td class="px-6 py-5 first:rounded-l-2xl">
                <div class="flex flex-col">
                    <span class="text-sm font-black text-slate-900 tracking-tight">{{ $shipment->tracking_number }}</span>
                    <span class="text-[11px] font-semibold text-slate-400 mt-0.5">{{ $shipment->created_at->format('M d, Y • H:i') }}</span>
                </div>
            </td>
            <td class="px-6 py-5">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold uppercase text-slate-400 tracking-tighter w-8 text-right">From:</span>
                        <span class="text-sm font-bold text-slate-700">{{ $shipment->sender_name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold uppercase text-slate-400 tracking-tighter w-8 text-right">To:</span>
                        <span class="text-sm font-bold text-slate-700">{{ $shipment->receiver_name }}</span>
                    </div>
                </div>
            </td>
            <td class="px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-bold text-slate-900">{{ $shipment->originLocation->name ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-500/40 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                    <div class="flex flex-col items-start">
                        <span class="text-xs font-bold text-slate-900">{{ $shipment->destinationLocation->name ?? '-' }}</span>
                    </div>
                </div>
            </td>
            <td class="px-6 py-5">
                @php
                    $colors = [
                        'pending' => 'bg-amber-50 text-amber-600 ring-amber-200/50',
                        'ready_to_ship' => 'bg-indigo-50 text-indigo-600 ring-indigo-200/50',
                        'delivered' => 'bg-emerald-50 text-emerald-600 ring-emerald-200/50',
                        'cancelled' => 'bg-rose-50 text-rose-600 ring-rose-200/50',
                        'in_transit' => 'bg-blue-50 text-blue-600 ring-blue-200/50',
                        'picked_up' => 'bg-violet-50 text-violet-600 ring-violet-200/50',
                        'out_for_delivery' => 'bg-sky-50 text-sky-600 ring-sky-200/50',
                    ];
                    $statusClass = $colors[$shipment->status] ?? 'bg-slate-50 text-slate-600 ring-slate-200/50';
                @endphp
                <span class="px-4 py-1.5 rounded-full text-[11px] font-black tracking-wide ring-1 shadow-sm {{ $statusClass }}">
                    {{ strtoupper(str_replace('_', ' ', $shipment->status)) }}
                </span>
            </td>
            <td class="px-6 py-5">
                <div class="flex flex-col gap-1">
                    <span class="text-sm font-black text-slate-900">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
                    @php
                        $payColors = [
                            'unpaid' => 'text-rose-500',
                            'pending' => 'text-amber-500',
                            'paid' => 'text-emerald-500'
                        ];
                    @endphp
                    <div class="flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full {{ str_replace('text', 'bg', $payColors[$shipment->payment_status] ?? 'bg-slate-400') }}"></div>
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $payColors[$shipment->payment_status] ?? 'text-slate-400' }}">
                            {{ $shipment->payment_status }}
                        </span>
                    </div>
                </div>
            </td>
            <td class="px-6 py-5 last:rounded-r-2xl text-center">
                <div class="flex items-center justify-center gap-3">
                    @if($shipment->payment_status !== 'paid')
                    <button onclick="confirmPayment({{ $shipment->id }}, '{{ $shipment->payment_method }}')"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-emerald-50 text-emerald-500 hover:bg-emerald-500 hover:text-white hover:scale-110 transition-all duration-200 shadow-sm"
                        title="Mark as Paid — {{ ucfirst($shipment->payment_status) }} ({{ $shipment->payment_method }})">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </button>
                    @endif
                    <a href="{{ route('shipments.show', $shipment) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white hover:scale-110 transition-all duration-200 shadow-sm" title="View Detail">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </a>
                    <a href="{{ route('shipments.print', $shipment) }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white hover:scale-110 transition-all duration-200 shadow-sm" title="Print Receipt">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2-2v4a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-8 py-20 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    </div>
                    <p class="text-slate-400 font-bold italic">No shipments found matching your criteria.</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="px-8 py-10">
    {{ $shipments->links() }}
</div>

<script>
function confirmPayment(id, method) {
    const isCOD = method === 'cod';
    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        html: isCOD
            ? '<p>Kurir telah menyetor uang COD untuk paket ini?</p>'
            : '<p>Tandai paket ini sebagai <b>PAID</b>?</p><p class="text-sm text-slate-500 mt-2">Pastikan pembayaran sudah diterima sebelum melanjutkan.</p>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#f43f5e',
        confirmButtonText: isCOD ? 'Ya, COD Diterima' : 'Ya, Tandai Paid',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/shipments/${id}/mark-paid`;
            const csrf = document.createElement('input');
            csrf.type = 'hidden'; csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            const payMethod = document.createElement('input');
            payMethod.type = 'hidden'; payMethod.name = 'payment_method';
            payMethod.value = method || 'cash';
            form.appendChild(csrf);
            form.appendChild(payMethod);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>


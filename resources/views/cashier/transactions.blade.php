@extends('layouts.admin')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">TRANSAKSI <span class="text-primary">RIWAYAT</span></h1>
            <p class="text-slate-400 font-medium mt-1">Daftar seluruh paket yang diproses di cabang ini</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative group">
                <input type="text" placeholder="Cari Resi atau Nama..." 
                       class="pl-12 pr-6 py-4 glass-card rounded-2xl text-sm text-white placeholder-slate-500 focus:border-primary/50 outline-none transition-all w-80">
                <svg class="w-5 h-5 text-slate-500 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-white/5 bg-white/[0.02]">
                        <th class="px-8 py-6">No. Resi</th>
                        <th class="px-8 py-6">Pengirim / Penerima</th>
                        <th class="px-8 py-6">Metode</th>
                        <th class="px-8 py-6">Status Pembayaran</th>
                        <th class="px-8 py-6">Status Paket</th>
                        <th class="px-8 py-6 text-right">Total</th>
                        <th class="px-8 py-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($shipments as $shipment)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6">
                            <span class="text-sm font-black text-white block tracking-tight">{{ $shipment->tracking_number }}</span>
                            <span class="text-[10px] text-slate-500 uppercase font-bold">{{ $shipment->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-bold text-slate-300">S: {{ $shipment->sender_name }}</span>
                                <span class="text-xs font-bold text-primary">R: {{ $shipment->receiver_name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-white/5 rounded-lg text-[10px] font-black text-slate-300 uppercase tracking-widest border border-white/5">
                                {{ $shipment->payment_method }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            @if($shipment->payment_status === 'paid')
                                <span class="flex items-center gap-2 text-green-500 font-bold text-xs">
                                    <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                    LUNAS
                                </span>
                            @else
                                <span class="flex items-center gap-2 text-amber-500 font-bold text-xs">
                                    <div class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></div>
                                    PENDING
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border
                                {{ $shipment->status === 'delivered' ? 'border-green-500/30 text-green-500 bg-green-500/5' : 'border-primary/30 text-primary bg-primary/5' }}">
                                {{ str_replace('_', ' ', $shipment->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-sm font-black text-white">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('shipments.show', $shipment) }}" class="p-2 glass-card rounded-lg hover:bg-primary transition-all group/btn">
                                    <svg class="w-4 h-4 text-slate-400 group-hover/btn:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('shipments.print', $shipment) }}" target="_blank" class="p-2 glass-card rounded-lg hover:bg-blue-500 transition-all group/btn">
                                    <svg class="w-4 h-4 text-slate-400 group-hover/btn:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-white/5">
            {{ $shipments->links() }}
        </div>
    </div>
</div>
@endsection

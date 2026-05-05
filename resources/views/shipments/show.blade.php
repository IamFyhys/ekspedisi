<x-admin-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Shipment Details</h1>
                <p class="text-slate-500 font-medium">Tracking: {{ $shipment->tracking_number }}</p>
            </div>
            @php
                $colors = [
                    'pending' => 'bg-amber-100 text-amber-700',
                    'delivered' => 'bg-emerald-100 text-emerald-700',
                    'cancelled' => 'bg-rose-100 text-rose-700',
                    'in_transit' => 'bg-blue-100 text-blue-700',
                    'picked_up' => 'bg-violet-100 text-violet-700',
                    'out_for_delivery' => 'bg-sky-100 text-sky-700',
                ];
                $statusColor = $colors[$shipment->status] ?? 'bg-slate-100 text-slate-700';
            @endphp
            <span class="px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest {{ $statusColor }}">
                {{ str_replace('_', ' ', $shipment->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Info Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Participant Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="premium-card p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Sender</h3>
                        </div>
                        <p class="text-xl font-black text-slate-900 mb-1">{{ $shipment->sender_name }}</p>
                        <p class="text-sm font-bold text-slate-400 mb-4">{{ $shipment->sender_phone }}</p>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $shipment->originLocation->name ?? '-' }}</p>
                    </div>

                    <div class="premium-card p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Receiver</h3>
                        </div>
                        <p class="text-xl font-black text-slate-900 mb-1">{{ $shipment->receiver_name }}</p>
                        <p class="text-sm font-bold text-slate-400 mb-4">{{ $shipment->receiver_phone }}</p>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $shipment->receiver_address }}, {{ $shipment->destinationLocation->name ?? '-' }}</p>
                    </div>
                </div>

                <!-- Tracking History -->
                <div class="premium-card p-8">
                    <h3 class="text-xl font-black text-slate-900 mb-10">Tracking Timeline</h3>
                    <div class="space-y-8">
                        @foreach($shipment->trackings()->latest()->get() as $tracking)
                        <div class="relative flex gap-6">
                            @if (!$loop->last)
                            <div class="absolute left-5 top-10 w-0.5 h-full bg-slate-100"></div>
                            @endif
                            <div class="z-10 w-10 h-10 rounded-full flex items-center justify-center ring-4 ring-white shadow-sm {{ $tracking->status === 'delivered' ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-400' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="flex-1 pb-10">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-black text-slate-900">{{ $tracking->description }}</h4>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $tracking->created_at->format('M d, Y • H:i') }}</span>
                                </div>
                                <p class="text-sm text-slate-500 font-medium">@ {{ $tracking->location }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Column -->
            <div class="space-y-8">
                <!-- Summary Card -->
                <div class="bg-primary rounded-[2rem] p-8 text-white shadow-xl shadow-primary/20">
                    <h3 class="text-sm font-black uppercase tracking-widest mb-6 opacity-60">Price Summary</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-white/10">
                            <span class="text-sm font-medium opacity-80">Weight</span>
                            <span class="text-lg font-black">{{ $shipment->weight / 1000 }} KG</span>
                        </div>
                        <div class="pt-4">
                            <p class="text-[10px] font-bold uppercase tracking-widest opacity-60 mb-1">Total Paid</p>
                            <p class="text-4xl font-black">Rp {{ number_format($shipment->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>

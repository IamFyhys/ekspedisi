<x-admin-layout>
    <div class="max-w-3xl mx-auto space-y-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Shipment</h1>
            <p class="text-slate-500 font-medium">Tracking: {{ $shipment->tracking_number }}</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('shipments.update', $shipment) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Readonly Info -->
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sender</label>
                            <p class="text-slate-900 font-semibold">{{ $shipment->sender->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Receiver</label>
                            <p class="text-slate-900 font-semibold">{{ $shipment->receiver->name }}</p>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- Status Update -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-bold text-slate-700">Update Status</label>
                        <select name="status" id="status" class="w-full rounded-xl border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all">
                            <option value="pending" {{ $shipment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="picked_up" {{ $shipment->status == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                            <option value="in_transit" {{ $shipment->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="arrived_at_branch" {{ $shipment->status == 'arrived_at_branch' ? 'selected' : '' }}>Arrived At Branch</option>
                            <option value="out_for_delivery" {{ $shipment->status == 'out_for_delivery' ? 'selected' : '' }}>Out For Delivery</option>
                            <option value="delivered" {{ $shipment->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $shipment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Weight Update (Price will be recalculated) -->
                    <div class="space-y-2">
                        <label for="total_weight" class="block text-sm font-bold text-slate-700">Total Weight (KG)</label>
                        <div class="relative">
                            <input type="number" step="0.1" name="total_weight" id="total_weight" value="{{ $shipment->total_weight }}" class="w-full pl-4 pr-12 py-3 rounded-xl border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-bold text-lg">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">KG</span>
                        </div>
                        <p class="text-xs text-slate-500 italic">Updating weight will automatically recalculate the shipping price based on current rates.</p>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6">
                        <a href="{{ route('shipments.index') }}" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 transition">Cancel</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg shadow-indigo-100">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

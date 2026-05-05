<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourierController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with(['originLocation', 'destinationLocation'])
            ->where('branch_id', Auth::user()->branch_id)
            ->whereIn('status', ['pending', 'picked_up', 'in_transit', 'arrived_at_branch', 'out_for_delivery'])
            ->latest()
            ->paginate(10);

        return view('courier.dashboard', compact('shipments'));
    }

    public function confirmDelivery(Request $request, Shipment $shipment)
    {
        $request->validate([
            'received_by' => 'required|string|max:255',
            'receiver_relation' => 'required|string',
            'delivery_note' => 'nullable|string',
            'proof_photo' => 'required|image|max:5120', // 5MB
            'signature' => 'nullable|string', // Base64 signature
        ]);

        $photoPath = $request->file('proof_photo')->store('delivery-proofs', 'public');
        
        $signaturePath = null;
        if ($request->signature) {
            $image = str_replace('data:image/png;base64,', '', $request->signature);
            $image = str_replace(' ', '+', $image);
            $imageName = 'sig_' . Str::random(10) . '.png';
            Storage::disk('public')->put('delivery-signatures/' . $imageName, base64_decode($image));
            $signaturePath = 'delivery-signatures/' . $imageName;
        }

        $shipment->update([
            'status' => 'delivered',
            'delivered_at' => now(),
            'received_by' => $request->received_by,
            'receiver_relation' => $request->receiver_relation,
            'delivery_note' => $request->delivery_note,
            'proof_photo' => $photoPath,
            'digital_signature' => $signaturePath,
            'courier_id' => Auth::id()
        ]);

        return redirect()->route('courier.dashboard')->with('success', "Pengiriman {$shipment->tracking_number} berhasil dikonfirmasi ✓");
    }

    public function updateStatus(Request $request, Shipment $shipment)
    {
        $request->validate([
            'status' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $shipment->update([
            'status' => $request->status,
            'courier_id' => Auth::id()
        ]);

        return back()->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}

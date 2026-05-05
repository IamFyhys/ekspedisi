<?php

namespace App\Http\Controllers;

use App\Models\PickupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupCourierController extends Controller
{
    public function dashboard()
    {
        $courierId = Auth::id();
        $today = now()->toDateString();

        $pickups = PickupRequest::where('courier_id', $courierId)
            ->whereIn('status', ['assigned_pickup', 'on_the_way', 'picked_up'])
            ->orderBy('pickup_time')
            ->get();

        $stats = [
            'today'     => PickupRequest::where('courier_id', $courierId)->whereDate('pickup_date', $today)->count(),
            'completed' => PickupRequest::where('courier_id', $courierId)->where('status', 'picked_up')->whereDate('picked_up_at', $today)->count(),
            'pending'   => PickupRequest::where('courier_id', $courierId)->where('status', 'assigned_pickup')->count(),
        ];

        return view('courier.pickup.dashboard', compact('pickups', 'stats'));
    }

    public function confirmPickup(Request $request)
    {
        $request->validate([
            'pickup_id'     => 'required|exists:pickup_requests,id',
            'actual_weight' => 'required|numeric|min:0.1',
            'pickup_photo'  => 'required|image|max:2048',
            'note'          => 'nullable|string',
        ]);

        $pickup = PickupRequest::where('id', $request->pickup_id)
            ->where('courier_id', Auth::id())
            ->firstOrFail();

        $photoPath = $request->file('pickup_photo')->store('pickup-photos', 'public');

        $pickup->update([
            'status'        => 'picked_up',
            'actual_weight' => $request->actual_weight,
            'pickup_photo'  => $photoPath,
            'pickup_note'   => $request->note,
            'picked_up_at'  => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Paket berhasil diambil!']);
    }

    public function arrivedAtBranch(Request $request)
    {
        $request->validate(['pickup_id' => 'required|exists:pickup_requests,id']);

        $pickup = PickupRequest::where('id', $request->pickup_id)
            ->where('courier_id', Auth::id())
            ->where('status', 'picked_up')
            ->firstOrFail();

        $pickup->update([
            'status'     => 'arrived_at_branch',
            'arrived_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Paket telah sampai di cabang.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminManagementController extends Controller
{
    public function monitoring(Request $request)
    {
        $branches = Branch::all();
        $query = Shipment::with(['branch', 'destinationLocation', 'originLocation']);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default show only relevant for warehouse monitoring
            $query->whereIn('status', ['ready_to_ship', 'arrived_at_hub', 'returned_to_warehouse', 'tertahan']);
        }

        $packages = $query->latest()->paginate(20);

        // Get couriers for each branch to populate modals
        $couriersByBranch = User::whereIn('role', ['courier_delivery', 'courier_transit'])
            ->get()
            ->groupBy('branch_id');

        return view('admin.monitoring', compact('packages', 'branches', 'couriersByBranch'));
    }

    public function assignCourier(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'courier_id' => 'required|exists:users,id',
        ]);

        $shipment = Shipment::findOrFail($request->shipment_id);
        $courier = User::findOrFail($request->courier_id);

        // Logic check: courier should be in the same branch as the package currently is
        if ($shipment->branch_id !== $courier->branch_id) {
            return back()->with('error', 'Kurir harus berasal dari cabang yang sama dengan lokasi paket saat ini.');
        }

        $shipment->update([
            'courier_id'  => $request->courier_id,
            'status'      => 'assigned',
            'assigned_at' => now(),
        ]);

        return back()->with('success', "Kurir {$courier->name} berhasil ditugaskan untuk resi {$shipment->tracking_number}!");
    }
}

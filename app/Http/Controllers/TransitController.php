<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Trip;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransitController extends Controller
{
    public function dashboard()
    {
        $courierId = Auth::id();
        $today = now()->toDateString();

        $paketDibawa = Shipment::where('courier_id', $courierId)
            ->whereDate('departed_at', $today)
            ->count();

        $sudahDiserahterimakan = Shipment::where('received_by', '!=', null)
            ->where('courier_id', $courierId)
            ->whereDate('arrived_at', $today)
            ->count();

        $activeTrip = Trip::where('courier_id', $courierId)
            ->where('status', 'on_the_way')
            ->latest()
            ->first();

        $recentPackages = Shipment::where('courier_id', $courierId)
            ->whereIn('status', ['in_transit', 'assigned'])
            ->latest()
            ->take(5)
            ->get();

        return view('courier.transit.dashboard', compact('paketDibawa', 'sudahDiserahterimakan', 'activeTrip', 'recentPackages'));
    }

    public function manifestOut()
    {
        $user = Auth::user();
        $branches = Branch::where('id', '!=', $user->branch_id)->get();
        
        // Ambil paket yang ada di gudang saat ini (ready_to_ship)
        $availableShipments = Shipment::where('branch_id', $user->branch_id)
            ->where('status', 'ready_to_ship')
            ->with(['destinationLocation', 'originLocation'])
            ->get();

        return view('courier.transit.manifest-out', compact('branches', 'availableShipments'));
    }

    public function scanOut(Request $request)
    {
        $shipment = Shipment::where('tracking_number', $request->resi)
            ->where('branch_id', auth()->user()->branch_id)
            ->where('status', 'ready_to_ship')
            ->first();

        if (!$shipment) {
            return response()->json([
                'success' => false,
                'message' => 'Resi tidak ditemukan atau belum siap kirim'
            ]);
        }

        // The logic for session manifest is usually handled in the frontend or a separate table
        // But I'll return the shipment data for the frontend to add to its list
        return response()->json([
            'success'  => true,
            'shipment' => $shipment
        ]);
    }

    public function depart(Request $request)
    {
        $request->validate([
            'dest_branch' => 'required|exists:branches,id',
            'tracking_numbers' => 'required|array',
        ]);

        $manifest = $request->tracking_numbers;

        return DB::transaction(function() use ($request, $manifest) {
            $trip = Trip::create([
                'courier_id'      => auth()->id(),
                'origin_branch_id'   => auth()->user()->branch_id,
                'destination_branch_id'     => $request->dest_branch,
                'total_packages'  => count($manifest),
                'departed_at'     => now(),
                'status'          => 'on_the_way',
            ]);

            Shipment::whereIn('tracking_number', $manifest)
                ->update([
                    'status'       => 'in_transit',
                    'courier_id'   => auth()->id(),
                    'departed_at'  => now(),
                    'trip_id'      => $trip->id,
                ]);

            return response()->json(['success' => true, 'message' => 'Manifest berangkat!']);
        });
    }

    public function manifestIn()
    {
        $activeTrip = Trip::with('shipments')->where('courier_id', Auth::id())
            ->where('status', 'on_the_way')
            ->first();
        return view('courier.transit.manifest-in', compact('activeTrip'));
    }

    public function scanIn(Request $request)
    {
        $shipment = Shipment::where('tracking_number', $request->resi)
            ->where('status', 'in_transit')
            ->where('courier_id', auth()->id())
            ->first();

        if (!$shipment) {
            return response()->json([
                'success' => false,
                'message' => 'Resi tidak ditemukan dalam perjalanan Anda'
            ]);
        }

        return response()->json([
            'success'  => true,
            'shipment' => $shipment
        ]);
    }

    public function confirmArrival(Request $request)
    {
        $request->validate([
            'scanned_items' => 'required|array',
            'missing_items' => 'nullable|array',
            'note' => 'nullable|string',
        ]);

        $scanned = $request->scanned_items;

        return DB::transaction(function() use ($request, $scanned) {
            Shipment::whereIn('tracking_number', $scanned)
                ->update([
                    'status'      => 'arrived_at_hub',
                    'arrived_at'  => now(),
                    'received_by' => auth()->id(),
                    'branch_id'   => auth()->user()->branch_id,
                ]);

            // Update trip sebagai selesai
            $trip = Trip::where('courier_id', auth()->id())
                ->where('status', 'on_the_way')
                ->latest()
                ->first();
            
            if ($trip) {
                $trip->update([
                    'status'          => 'completed',
                    'arrived_at'      => now(),
                    'total_received'  => count($scanned),
                    'missing_note'    => $request->note ?? null,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Penerimaan dikonfirmasi!']);
        });
    }

    public function tripLogs()
    {
        return $this->trips();
    }

    public function trips()
    {
        $trips = Trip::with(['originBranch', 'destinationBranch'])
            ->where('courier_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('courier.transit.trips', compact('trips'));
    }

    public function laporan(Request $request)
    {
        $user   = auth()->user();
        $filter = $request->filter ?? 'today';

        $range = match($filter) {
            'week'  => [now()->startOfWeek(), now()->endOfWeek()],
            'month' => [now()->startOfMonth(), now()->endOfMonth()],
            default => [now()->startOfDay(), now()->endOfDay()],
        };

        // Ambil trip dalam rentang
        $trips = Trip::with(['originBranch', 'destinationBranch'])
            ->where('courier_id', $user->id)
            ->where('status', 'completed')
            ->whereBetween('departed_at', $range)
            ->get();

        $totalTrips    = $trips->count();
        $totalDibawa   = $trips->sum('total_packages');
        $totalSampai   = $trips->sum('total_received');

        // Manifest accuracy
        $accuracy = $totalDibawa > 0
            ? round(($totalSampai / $totalDibawa) * 100, 1)
            : 0;

        // Rata-rata durasi trip (menit)
        $avgDurasi = Trip::where('courier_id', $user->id)
            ->where('status', 'completed')
            ->whereBetween('departed_at', $range)
            ->whereNotNull('arrived_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, departed_at, arrived_at)) as avg_dur')
            ->value('avg_dur');

        $avgJam   = floor(($avgDurasi ?? 0) / 60);
        $avgMenit = round(($avgDurasi ?? 0) % 60);

        // Trip dengan selisih paket
        $tripsSelisih = $trips->filter(fn($t) =>
            $t->total_packages !== $t->total_received
        )->count();

        return view('courier.transit.laporan', [
            'totalTrips'    => $totalTrips,
            'totalDibawa'   => $totalDibawa,
            'totalSampai'   => $totalSampai,
            'accuracy'      => $accuracy,
            'avgJam'        => $avgJam,
            'avgMenit'      => $avgMenit,
            'tripsSelisih'  => $tripsSelisih,
            'trips'         => $trips->sortByDesc('departed_at'),
            'filter'        => $filter,
        ]);
    }
}

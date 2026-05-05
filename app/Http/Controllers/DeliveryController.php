<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\PickupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeliveryController extends Controller
{
    public function dashboard()
    {
        $courierId = Auth::id();
        $today = now()->toDateString();
        $branchId = Auth::user()->branch_id;

        // 1. Ambil Tugas Delivery (Antar)
        $deliveries = Shipment::where('courier_id', $courierId)
            ->whereIn('status', ['assigned', 'out_for_delivery'])
            ->where(function($q) {
                $q->whereNull('scheduled_date')
                  ->orWhere('scheduled_date', '<=', today()->toDateString());
            })
            ->select('shipments.*', 'shipments.dest_lat', 'shipments.dest_lng')
            ->get();

        // 2. Ambil Tugas Pickup (Jemput)
        // Termasuk yang sudah ditugaskan ke kurir ini, ATAU yang masih pending di cabang yang sama
        $pickups = PickupRequest::where(function($q) use ($courierId, $branchId) {
                $q->where('courier_id', $courierId)
                  ->orWhere(function($sq) use ($branchId) {
                      $sq->whereNull('courier_id')
                        ->where('branch_id', $branchId)
                        ->where('status', 'pending');
                  });
            })
            ->whereIn('status', ['pending', 'assigned_pickup', 'on_the_way', 'picked_up'])
            ->get();

        // 3. Gabungkan Statistik
        $successDelivery = Shipment::where('courier_id', $courierId)
            ->where('status', 'delivered')
            ->whereDate('updated_at', $today)
            ->count();
            
        $successPickup = PickupRequest::where('courier_id', $courierId)
            ->where('status', 'picked_up')
            ->whereDate('picked_up_at', $today)
            ->count();

        $failedDelivery = Shipment::where('courier_id', $courierId)
            ->whereIn('status', ['failed_delivery', 'returned_to_warehouse'])
            ->whereDate('updated_at', $today)
            ->count();

        $remainingCount = $deliveries->count() + $pickups->whereIn('status', ['pending', 'assigned_pickup', 'on_the_way'])->count();

        $stats = [
            'total'     => $successDelivery + $successPickup + $failedDelivery + $remainingCount,
            'success'   => $successDelivery + $successPickup,
            'failed'    => $failedDelivery,
            'remaining' => $remainingCount,
        ];

        // Paket gagal untuk ditampilkan di ringkasan
        $failedDeliveries = Shipment::where('courier_id', $courierId)
            ->where('status', 'failed_delivery')
            ->latest('updated_at')
            ->get()
            ->map(function ($s) {
                $time = $s->failed_at ? $s->failed_at : $s->updated_at;
                return [
                    'id'      => $s->id,
                    'name'    => $s->receiver_name,
                    'address' => $s->receiver_address,
                    'reason'  => $s->failed_reason ?? 'Dikembalikan ke gudang',
                    'time'    => \Carbon\Carbon::parse($time)->format('H:i') . ' WIB',
                ];
            })
            ->values()
            ->toArray();

        return view('courier.delivery.dashboard', compact('deliveries', 'pickups', 'stats', 'failedDeliveries'));
    }

    public function acceptPickup(Request $request)
    {
        $request->validate(['pickup_id' => 'required|exists:pickup_requests,id']);

        $pickup = PickupRequest::where('id', $request->pickup_id)
            ->whereNull('courier_id')
            ->where('status', 'pending')
            ->firstOrFail();

        $pickup->update([
            'courier_id'  => Auth::id(),
            'status'      => 'assigned_pickup',
            'assigned_by' => Auth::id(), // Self-assigned
        ]);

        return response()->json(['success' => true, 'message' => 'Tugas penjemputan berhasil diterima!']);
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

        return response()->json(['success' => true, 'message' => 'Paket berhasil dijemput!']);
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

        return response()->json(['success' => true, 'message' => 'Paket telah sampai di gudang/cabang.']);
    }

    public function confirmDelivery(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'received_by' => 'required|string',
            'relation' => 'required|string',
            'photo' => 'required|image|max:2048',
            'note' => 'nullable|string',
            'signature' => 'nullable|string',
        ]);

        $shipment = Shipment::findOrFail($request->shipment_id);

        $photoPath = $request->file('photo')->store('delivery-proofs', 'public');

        $shipment->update([
            'status'            => 'delivered',
            'delivered_at'      => now(),
            'received_by'       => $request->received_by,
            'receiver_relation' => $request->relation,
            'proof_photo'       => $photoPath,
            'delivery_note'     => $request->note,
            'digital_signature' => $request->signature,
        ]);

        // Jika COD — update payment
        if ($shipment->payment_method === 'cod') {
            // Notifikasi kasir untuk terima setoran
            $kasir = User::where('branch_id', $shipment->branch_id)
                         ->where('role', 'cashier')
                         ->first();
            if ($kasir) {
                // $kasir->notify(new \App\Notifications\CODReadyNotification($shipment));
            }
        }

        return response()->json(['success' => true, 'message' => 'Paket berhasil diterima!']);
    }

    public function reportFailed(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'reason' => 'required|string',
            'note' => 'nullable|string',
            'photo' => 'required|image|max:2048',
        ]);

        $shipment = Shipment::findOrFail($request->shipment_id);

        $photoPath = $request->file('photo')->store('failed-delivery', 'public');

        $shipment->update([
            'status'        => 'failed_delivery',
            'failed_reason' => $request->reason,
            'failed_note'   => $request->note,
            'failed_photo'  => $photoPath,
            'failed_at'     => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan gagal kirim berhasil disimpan.']);
    }

    public function retryDelivery(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'action'      => 'required|in:retry_today,schedule_tomorrow,return_warehouse',
        ]);

        $shipment = Shipment::where('id', $request->shipment_id)
            ->where('courier_id', auth()->id())
            ->where('status', 'failed_delivery')
            ->firstOrFail();

        switch ($request->action) {
            case 'retry_today':
                $shipment->update([
                    'status'         => 'assigned',
                    'failed_reason'  => null,
                    'failed_note'    => null,
                    'failed_at'      => null,
                    'scheduled_date' => today()->toDateString(),
                ]);
                break;

            case 'schedule_tomorrow':
                $shipment->update([
                    'status'         => 'assigned',
                    'scheduled_date' => now()->addDay()->toDateString(),
                ]);
                break;

            case 'return_warehouse':
                $shipment->update([
                    'status' => 'returned_to_warehouse',
                ]);
    
                $manager = User::where('branch_id', $shipment->branch_id)
                               ->where('role', 'manager')
                               ->first();

                if ($manager) {
                    $manager->notify(
                        new \App\Notifications\PackageReturnedNotification($shipment)
                    );
                }
                break;
        }

        return response()->json([
            'success' => true,
            'action'  => $request->action,
            'status'  => $shipment->fresh()->status,
        ]);
    }

    public function laporan(Request $request)
    {
        $user     = auth()->user();
        $filter   = $request->filter ?? 'today';

        // Tentukan rentang tanggal
        // Untuk 'today', kita ambil data dari awal hari ini (Jakarta)
        // Jika baru pindah timezone, data sebelumnya mungkin tercatat di tanggal kemarin (UTC)
        $range = match($filter) {
            'week'  => [now()->startOfWeek(), now()->endOfWeek()],
            'month' => [now()->startOfMonth(), now()->endOfMonth()],
            default => [now()->subHours(24), now()->endOfDay()], // Gunakan 24 jam terakhir agar data transisi tidak hilang
        };

        // Ambil semua paket kurir dalam rentang
        $shipments = Shipment::where('courier_id', $user->id)
            ->whereBetween('updated_at', $range)
            ->whereIn('status', ['delivered', 'failed_delivery', 'returned_to_warehouse'])
            ->get();

        $delivered = $shipments->where('status', 'delivered')->count();
        $failed    = $shipments->whereIn('status', ['failed_delivery', 'returned_to_warehouse'])->count();
        $total     = $delivered + $failed;

        // Success rate
        $successRate = $total > 0
            ? round(($delivered / $total) * 100)
            : 0;

        // Retur rate
        $returRate = $total > 0
            ? round(($failed / $total) * 100)
            : 0;

        // Rata-rata waktu antar (menit)
        $avgTime = Shipment::where('courier_id', $user->id)
            ->where('status', 'delivered')
            ->whereBetween('delivered_at', $range)
            ->whereNotNull('assigned_at')
            ->whereNotNull('delivered_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, assigned_at, delivered_at)) as avg_time')
            ->value('avg_time');

        // Ambil Pickup juga
        $pickups = \App\Models\PickupRequest::where('courier_id', $user->id)
            ->whereBetween('updated_at', $range)
            ->where('status', 'arrived_at_warehouse')
            ->get();

        $pickupCount = $pickups->count();

        return view('courier.delivery.laporan', [
            'delivered'   => $delivered,
            'failed'      => $failed,
            'pickupCount' => $pickupCount,
            'total'       => $total + $pickupCount,
            'successRate' => ($total + $pickupCount) > 0 ? round((($delivered + $pickupCount) / ($total + $pickupCount)) * 100) : 0,
            'returRate'   => ($total + $pickupCount) > 0 ? round(($failed / ($total + $pickupCount)) * 100) : 0,
            'avgTime'     => round($avgTime ?? 0),
            'shipments'   => $shipments->sortByDesc('updated_at'),
            'pickups'     => $pickups->sortByDesc('updated_at'),
            'filter'      => $filter,
        ]);
    }
}

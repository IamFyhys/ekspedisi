<?php

namespace App\Http\Controllers;

use App\Models\PickupRequest;

use App\Models\CashDrawer;
use App\Models\Shift;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\User;
use App\Notifications\CODReceivedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function dashboard()
    {
        $user     = auth()->user();
        $branchId = $user->branch_id;

        $data = [
            'total_paket_hari_ini' => Shipment::where('branch_id', $branchId)
                ->whereDate('created_at', today())
                ->count(),
            'total_omzet_hari_ini' => Payment::whereHas('shipment', function($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })
                ->whereDate('created_at', today())
                ->where('status', 'success')
                ->sum('amount'),
            'cash_drawer' => CashDrawer::where('date', today())
                ->where('branch_id', $branchId)
                ->first(),
            'recent_shipments' => Shipment::where('branch_id', $branchId)
                ->latest()
                ->take(5)
                ->get(),
            'nama_kasir' => $user->name,
            'cabang'     => $user->branch->name ?? 'Cabang',
            'pickups'    => PickupRequest::where('branch_id', $branchId)
                ->whereIn('status', ['picked_up', 'arrived_at_branch'])
                ->with('courier')
                ->get(),
        ];

        return view('cashier.dashboard', $data);
    }

    public function pickups(Request $request)
    {
        $branchId = auth()->user()->branch_id;
        $query = PickupRequest::where('branch_id', $branchId)->with('courier');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('tracking_number', 'like', '%' . $request->search . '%')
                  ->orWhere('sender_name', 'like', '%' . $request->search . '%');
            });
        }

        $pickups = $query->latest()->paginate(15)->withQueryString();
        $locations = \App\Models\Location::all();
        
        return view('cashier.pickups', compact('pickups', 'locations'));
    }

    public function transactions()
    {
        $branchId = auth()->user()->branch_id;
        $shipments = Shipment::where('branch_id', $branchId)
            ->with('payments')
            ->latest()
            ->paginate(15);
            
        return view('cashier.transactions', compact('shipments'));
    }

    public function cashDrawer()
    {
        return $this->drawer();
    }

    public function drawer()
    {
        $branchId = Auth::user()->branch_id;
        $today = now()->toDateString();

        $drawer = CashDrawer::where('date', $today)
            ->where('branch_id', $branchId)
            ->first();

        $transactions = Payment::whereDate('created_at', $today)
            ->whereHas('shipment', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            })
            ->with(['shipment', 'shipment.cashier'])
            ->latest()
            ->get();

        // COD shipments pending settlement (delivered but not paid)
        $codShipments = Shipment::where('branch_id', $branchId)
            ->where('payment_method', 'cod')
            ->where('payment_status', 'pending')
            ->where('status', 'delivered')
            ->get();

        // Couriers list for COD modal
        $couriers = User::where('branch_id', $branchId)
            ->whereIn('role', ['courier', 'courier_delivery'])
            ->get();

        $summary = [
            'total_income'    => $transactions->where('status', 'success')->sum('amount'),
            'cash_income'     => $transactions->where('status', 'success')->where('payment_method', 'cash')->sum('amount'),
            'midtrans_income' => $transactions->where('status', 'success')->where('payment_method', 'midtrans')->sum('amount'),
            'transfer_income' => $transactions->where('status', 'success')->where('payment_method', 'transfer')->sum('amount'),
            'cod_income'      => $transactions->where('status', 'success')->where('payment_method', 'cod')->sum('amount'),
            'transaction_count' => $transactions->count(),
            'cod_pending'     => $codShipments->sum('total_price'),
        ];

        return view('cashier.drawer', compact('drawer', 'transactions', 'summary', 'codShipments', 'couriers'));
    }

    public function openDrawer(Request $request)
    {
        $validated = $request->validate([
            'starting_balance' => 'required|numeric|min:0'
        ]);

        CashDrawer::create([
            'branch_id' => Auth::user()->branch_id,
            'date' => now()->toDateString(),
            'starting_balance' => $validated['starting_balance'],
            'current_balance' => $validated['starting_balance'],
            'status' => 'open'
        ]);

        // Also start a shift
        Shift::create([
            'user_id' => Auth::id(),
            'branch_id' => Auth::user()->branch_id,
            'start_time' => now(),
            'status' => 'active'
        ]);

        return back()->with('success', 'Cash drawer opened and shift started.');
    }

    public function closeDrawer(Request $request)
    {
        $validated = $request->validate([
            'physical_cash' => 'required|numeric|min:0'
        ]);

        $drawer = CashDrawer::where('date', now()->toDateString())
            ->where('branch_id', Auth::user()->branch_id)
            ->where('status', 'open')
            ->firstOrFail();

        $drawer->update([
            'closing_balance' => $validated['physical_cash'],
            'status' => 'closed',
            'closed_at' => now(),
            'closed_by' => Auth::id()
        ]);

        // End shift
        $shift = Shift::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if ($shift) {
            $shift->update([
                'end_time' => now(),
                'status' => 'completed',
                // Total Transactions and Revenue should be calculated or tracked during the shift
                // For simplicity, let's grab what's in the drawer for this shift
                'total_transactions' => Payment::where('created_at', '>=', $shift->start_time)->count(),
                'total_revenue' => Payment::where('created_at', '>=', $shift->start_time)->where('status', 'success')->sum('amount')
            ]);
        }

        return back()->with('success', 'Cash drawer closed. Final reconciliation recorded.');
    }

    public function shifts()
    {
        $shifts = Shift::with(['user', 'branch'])
            ->where('branch_id', Auth::user()->branch_id)
            ->latest()
            ->paginate(15);

        return view('cashier.shifts', compact('shifts'));
    }

    public function receiveCOD(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'courier_id' => 'required|exists:users,id',
            'method' => 'required|string',
            'amount' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        $shipment = Shipment::findOrFail($request->shipment_id);

        $shipment->update([
            'payment_status'  => 'paid',
            'cod_received_by' => auth()->id(),
            'cod_received_at' => now(),
            'cod_courier_id'  => $request->courier_id,
            'cod_method'      => $request->method,
            'cod_note'        => $request->note,
        ]);

        CashDrawer::where('date', today())
            ->where('branch_id', auth()->user()->branch_id)
            ->where('status', 'open')
            ->increment('current_balance', $request->amount);

        Payment::create([
            'shipment_id' => $shipment->id,
            'amount'      => $request->amount,
            'payment_method'      => 'cod',
            'status'      => 'success',
            'received_by' => auth()->id(),
            'courier_id'  => $request->courier_id,
            'paid_at'     => now(),
        ]);

        $manager = User::where('branch_id', auth()->user()->branch_id)
                       ->where('role', 'manager')->first();
        if ($manager) {
            $manager->notify(new CODReceivedNotification($shipment));
        }

        return response()->json(['success' => true, 'message' => 'COD setoran berhasil diterima!']);
    }

    public function processPickup(Request $request, \App\Services\RateService $rateService)
    {
        $request->validate([
            'pickup_id' => 'required|exists:pickup_requests,id',
            'official_weight' => 'required|numeric|min:0.1',
            'length' => 'nullable|integer|min:1',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => 'required|exists:locations,id',
            'payment_method' => 'required|in:cash,transfer,cod,midtrans',
        ]);

        $pickup = PickupRequest::where('id', $request->pickup_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->where('status', 'arrived_at_branch')
            ->firstOrFail();

        return \Illuminate\Support\Facades\DB::transaction(function() use ($request, $pickup, $rateService) {
            // Auto calculate rate
            $rateData = $rateService->calculate(
                $request->origin_location_id, 
                $request->destination_location_id, 
                $request->official_weight,
                $request->length,
                $request->width,
                $request->height
            );

            if (!$rateData) {
                return response()->json(['success' => false, 'message' => 'Rute pengiriman tidak tersedia.'], 422);
            }

            $trackingNumber = 'EXP-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
            
            $paymentStatus = 'unpaid';
            $shipmentStatus = 'ready_to_ship';

            if ($request->payment_method === 'cash' || $request->payment_method === 'transfer') {
                $paymentStatus = 'paid';
            } elseif ($request->payment_method === 'cod') {
                $paymentStatus = 'pending';
            }

            $shipment = Shipment::create([
                'tracking_number' => $trackingNumber,
                'sender_name' => $pickup->sender_name,
                'sender_phone' => $pickup->sender_phone,
                'sender_address' => $pickup->sender_address,
                'origin_location_id' => $request->origin_location_id,
                'origin_subdistrict_id' => 1, // Optional: add subdistrict if needed
                'receiver_name' => $pickup->receiver_name,
                'receiver_phone' => $pickup->receiver_phone,
                'receiver_address' => $pickup->receiver_address,
                'destination_location_id' => $request->destination_location_id,
                'destination_subdistrict_id' => 1, // Optional
                'item_name' => $pickup->goods_type,
                'weight' => $request->official_weight,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'volumetric_weight' => $rateData['volumetric_weight'] ?? null,
                'total_price' => $rateData['total_price'],
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'status' => $shipmentStatus,
                'branch_id' => auth()->user()->branch_id,
                'cashier_id' => auth()->id()
            ]);

            Payment::create([
                'shipment_id' => $shipment->id,
                'amount' => $shipment->total_price,
                'payment_method' => $request->payment_method,
                'status' => $paymentStatus === 'paid' ? 'success' : 'pending'
            ]);

            if ($request->payment_method === 'cash') {
                $drawer = CashDrawer::where('date', today())->where('branch_id', auth()->user()->branch_id)->first();
                if ($drawer) $drawer->increment('current_balance', $shipment->total_price);
            }

            $pickup->update([
                'status' => 'processed',
                'processed_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Paket pickup berhasil diproses menjadi resi!',
                'tracking_number' => $trackingNumber
            ]);
        });
    }

    public function searchCustomer(Request $request)
    {
        $customer = Shipment::where('sender_phone', $request->phone)
            ->latest()
            ->first();

        if (!$customer) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'sender_name' => $customer->sender_name,
            'sender_address' => $customer->sender_address,
        ]);
    }
}

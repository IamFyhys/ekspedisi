<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Branch;
use App\Models\Location;
use App\Models\Subdistrict;
use App\Models\Rate;
use App\Models\Payment;
use App\Models\CashDrawer;
use App\Models\Shift;
use App\Services\RateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    protected $rateService;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function index(Request $request)
    {
        $query = Shipment::query()->with(['originLocation', 'destinationLocation', 'payments']);

        if (Auth::user()->role !== 'admin') {
            $query->where('branch_id', Auth::user()->branch_id);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('tracking_number', 'like', '%' . $request->search . '%')
                  ->orWhere('sender_name', 'like', '%' . $request->search . '%')
                  ->orWhere('receiver_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $shipments = $query->latest()->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('shipments.partials.table', compact('shipments'));
        }

        return view('shipments.index', compact('shipments'));
    }

    public function create()
    {
        $locations = Location::all();
        // Get rates for dropdown as requested
        $rates = Rate::with(['origin', 'destination'])->get();
        return view('shipments.create', compact('locations', 'rates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string',
            'sender_phone' => 'required|string',
            'origin_location_id' => 'required|exists:locations,id',
            'origin_subdistrict_id' => 'required|exists:subdistricts,id',
            'receiver_name' => 'required|string',
            'receiver_phone' => 'required|string',
            'receiver_address' => 'required|string',
            'destination_location_id' => 'required|exists:locations,id',
            'destination_subdistrict_id' => 'required|exists:subdistricts,id',
            'item_name' => 'required|string',
            'weight' => 'required|numeric|min:0.1',
            'length' => 'nullable|integer|min:1',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'payment_method' => 'required|in:cash,transfer,cod,midtrans',
        ]);

        return DB::transaction(function() use ($validated) {
            $rateData = $this->rateService->calculate(
                $validated['origin_location_id'], 
                $validated['destination_location_id'], 
                $validated['weight'],
                $validated['length'] ?? null,
                $validated['width'] ?? null,
                $validated['height'] ?? null
            );

            if (!$rateData) {
                return response()->json(['success' => false, 'message' => 'Shipping route not available.'], 422);
            }

            $trackingNumber = 'EXP-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            
            $paymentStatus = 'unpaid';
            $shipmentStatus = 'pending';

            if ($validated['payment_method'] === 'cash' || $validated['payment_method'] === 'transfer') {
                $paymentStatus = 'paid';
                $shipmentStatus = 'ready_to_ship';
            } elseif ($validated['payment_method'] === 'cod') {
                $paymentStatus = 'pending';
                $shipmentStatus = 'ready_to_ship';
            } elseif ($validated['payment_method'] === 'midtrans') {
                $paymentStatus = 'pending';
                $shipmentStatus = 'pending'; // Will be updated to ready_to_ship upon callback
            }

            $shipment = Shipment::create(array_merge($validated, [
                'tracking_number' => $trackingNumber,
                'total_price' => $rateData['total_price'],
                'volumetric_weight' => $rateData['volumetric_weight'] ?? null,
                'payment_status' => $paymentStatus,
                'status' => $shipmentStatus,
                'branch_id' => Auth::user()->branch_id,
                'cashier_id' => Auth::id()
            ]));

            // Record Payment
            $payment = Payment::create([
                'shipment_id' => $shipment->id,
                'amount' => $shipment->total_price,
                'payment_method' => $validated['payment_method'],
                'status' => $paymentStatus === 'paid' ? 'success' : 'pending'
            ]);

            // Auto-increment Cash Drawer if paid by Cash
            if ($validated['payment_method'] === 'cash') {
                $drawer = CashDrawer::firstOrCreate(
                    ['date' => now()->toDateString(), 'branch_id' => Auth::user()->branch_id, 'status' => 'open'],
                    ['starting_balance' => 0, 'current_balance' => 0]
                );
                $drawer->increment('current_balance', $shipment->total_price);
            }

            return response()->json([
                'success' => true,
                'message' => 'Shipment created successfully.',
                'shipment' => $shipment,
                'payment' => $payment
            ]);
        });
    }

    public function markAsPaid(Request $request, Shipment $shipment)
    {
        if ($shipment->payment_status === 'paid') {
            return back()->with('error', 'Already paid.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:cash,transfer,midtrans,cod'
        ]);

        DB::transaction(function() use ($shipment, $validated) {
            $updates = ['payment_status' => 'paid'];
            if ($shipment->status === 'pending') {
                $updates['status'] = 'ready_to_ship';
            }
            $shipment->update($updates);
            
            // Update or Create Payment record
            $payment = Payment::where('shipment_id', $shipment->id)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'success',
                    'payment_method' => $validated['payment_method'],
                    'paid_at' => now(),
                ]);
            } else {
                Payment::create([
                    'shipment_id' => $shipment->id,
                    'amount' => $shipment->total_price,
                    'payment_method' => $validated['payment_method'],
                    'status' => 'success',
                    'paid_at' => now(),
                ]);
            }

            if ($validated['payment_method'] === 'cash') {
                $drawer = CashDrawer::firstOrCreate(
                    ['date' => now()->toDateString(), 'branch_id' => Auth::user()->branch_id, 'status' => 'open'],
                    ['starting_balance' => 0, 'current_balance' => 0]
                );
                $drawer->increment('current_balance', $shipment->total_price);
            }
        });

        return back()->with('success', 'Payment confirmed and recorded.');
    }

    public function cancel(Shipment $shipment)
    {
        if ($shipment->status === 'delivered') {
            return response()->json(['success' => false, 'message' => 'Cannot cancel delivered shipment.'], 422);
        }

        $shipment->update(['status' => 'cancelled']);
        return response()->json(['success' => true, 'message' => 'Shipment cancelled.']);
    }

    public function show(Shipment $shipment)
    {
        if (Auth::user()->role !== 'admin' && $shipment->branch_id !== Auth::user()->branch_id) {
            abort(403);
        }

        $shipment->load(['originLocation', 'destinationLocation', 'originSubdistrict', 'destinationSubdistrict', 'trackings.user']);
        return view('shipments.show', compact('shipment'));
    }

    public function calculateRate(Request $request)
    {
        $validated = $request->validate([
            'origin_location_id' => 'required',
            'destination_location_id' => 'required',
            'weight' => 'required|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
        ]);

        $rateData = $this->rateService->calculate(
            $validated['origin_location_id'], 
            $validated['destination_location_id'], 
            $validated['weight'],
            $validated['length'] ?? null,
            $validated['width'] ?? null,
            $validated['height'] ?? null
        );

        if (!$rateData) {
            return response()->json(['error' => 'Rate not found'], 404);
        }

        return response()->json($rateData);
    }

    public function getSubdistricts(Request $request)
    {
        $subdistricts = Subdistrict::where('location_id', $request->location_id)->orderBy('name')->get();
        return response()->json($subdistricts);
    }

    public function printReceipt(Shipment $shipment)
    {
        return view('shipments.receipt', compact('shipment'));
    }
}

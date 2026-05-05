<?php

namespace App\Http\Controllers;

use App\Models\PickupRequest;

use App\Models\Shipment;
use App\Models\User;
use App\Models\Branch;
use App\Models\Shift;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $branchId = auth()->user()->branch_id;

        $statCards = [
            'paket_masuk'    => Shipment::whereDate('created_at', today())
                                    ->where('branch_id', $branchId)->count(),
            'paket_terkirim' => Shipment::where('status', 'delivered')
                                    ->whereDate('delivered_at', today())
                                    ->where('branch_id', $branchId)->count(),
            'paket_gudang'   => Shipment::where('status', 'in_warehouse')
                                    ->where('branch_id', $branchId)->count(),
            'omzet_hari_ini' => Payment::whereDate('created_at', today())
                                    ->whereHas('shipment', fn($q) => 
                                        $q->where('branch_id', $branchId))
                                    ->sum('amount'),
        ];

        $recentTransactions = Shipment::where('branch_id', $branchId)
            ->latest()
            ->take(5)
            ->get();

        $todayShifts = Shift::with('user')
            ->where('branch_id', $branchId)
            ->whereDate('start_time', today())
            ->get();

        $staffOnline = User::where('branch_id', $branchId)
            ->whereIn('role', ['cashier', 'courier', 'staff'])
            ->get()
            ->map(function($user) {
                $hasActiveShift = Shift::where('user_id', $user->id)->where('status', 'active')->exists();
                $user->status_label = $hasActiveShift ? 'Online' : 'Offline';
                // Add simulated status as per prompt example "Andi — Di Jalan"
                if ($hasActiveShift && $user->role === 'courier') $user->status_label = 'Di Jalan';
                return $user;
            });

        $chartData = Shipment::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(total_price) as total_omzet')
            )
            ->where('branch_id', $branchId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->subDays(6), now()])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get();

        $agingAlerts = Shipment::where('branch_id', $branchId)
            ->whereIn('status', ['pending', 'arrived_at_branch'])
            ->where('created_at', '<=', now()->subDays(3))
            ->get();

        $pendingPickups = PickupRequest::where('branch_id', $branchId)
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pickupCouriers = User::where('branch_id', $branchId)
            ->whereIn('role', ['courier_pickup', 'courier_delivery'])
            ->get();

        return view('manager.dashboard', compact(
            'statCards', 
            'recentTransactions', 
            'todayShifts', 
            'staffOnline', 
            'chartData',
            'pendingPickups',
            'pickupCouriers',
            'agingAlerts'
        ));
    }

    public function transaksi(Request $request)
    {
        $branchId = auth()->user()->branch_id;
        $query = Shipment::where('branch_id', $branchId);

        if ($request->filled('search')) {
            $query->where('tracking_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query->latest()->paginate(10);
        return view('manager.transaksi', compact('transactions'));
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
                $q->where('pickup_code', 'like', '%' . $request->search . '%')
                  ->orWhere('sender_name', 'like', '%' . $request->search . '%');
            });
        }

        $pickups = $query->latest()->paginate(15)->withQueryString();
        
        $pickupCouriers = User::where('branch_id', $branchId)
            ->whereIn('role', ['courier_pickup', 'courier_delivery'])
            ->get();

        return view('manager.pickups', compact('pickups', 'pickupCouriers'));
    }

    public function gudang()
    {
        $branchId = Auth::user()->branch_id;
        $packages = Shipment::where('branch_id', $branchId)
            ->whereIn('status', ['at_warehouse', 'ready_to_ship', 'tertahan', 'arrived_at_hub', 'returned_to_warehouse'])
            ->get()
            ->map(function($shipment) {
                $shipment->lama_tertahan = (int) $shipment->created_at->diffInDays(now());
                return $shipment;
            });

        $couriers = User::where('branch_id', $branchId)
            ->whereIn('role', ['courier_transit', 'courier_delivery'])
            ->get();

        return view('manager.gudang', compact('packages', 'couriers'));
    }

    public function staff(Request $request)
    {
        $branchId = auth()->user()->branch_id;
        
        $query = User::where('branch_id', $branchId)
            ->whereIn('role', ['cashier', 'courier', 'staff']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $staffs = $query->get()->map(function($user) {
            $hasActiveShift = Shift::where('user_id', $user->id)->where('status', 'active')->exists();
            $user->is_online = $hasActiveShift;
            $user->status_label = $hasActiveShift ? 'Online' : 'Offline';
            
            if ($hasActiveShift && $user->role === 'courier') {
                $user->status_label = 'Sedang Mengantar';
            }
            return $user;
        });

        $stats = [
            'total' => User::where('branch_id', $branchId)->whereIn('role', ['cashier', 'courier', 'staff'])->count(),
            'cashier' => User::where('branch_id', $branchId)->where('role', 'cashier')->count(),
            'courier' => User::where('branch_id', $branchId)->where('role', 'courier')->count(),
        ];

        return view('manager.staff', compact('staffs', 'stats'));
    }

    public function staffShow(User $user)
    {
        $branchId = auth()->user()->branch_id;
        
        // Security check: ensure staff is from the same branch
        if ($user->branch_id !== $branchId) {
            abort(403);
        }

        $shifts = Shift::where('user_id', $user->id)->latest()->take(10)->get();
        
        return view('manager.staff-show', compact('user', 'shifts'));
    }


    public function assignCourier(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'courier_id' => 'required|exists:users,id',
        ]);

        $shipment = Shipment::findOrFail($request->shipment_id);
        
        // Security: ensure shipment is in this branch
        if ($shipment->branch_id !== Auth::user()->branch_id) {
            return back()->with('error', 'Paket tidak berada di cabang Anda.');
        }

        $shipment->update([
            'courier_id'  => $request->courier_id,
            'status'      => 'assigned',
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Kurir berhasil ditugaskan!');
    }

    public function shift()
    {
        $branchId = Auth::user()->branch_id;
        $shifts = Shift::with('user')->where('branch_id', $branchId)->latest()->paginate(15);
        return view('manager.shift', compact('shifts'));
    }

    public function audit(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        $query = Shift::with('user')->where('branch_id', $branchId);

        if ($request->filled('date')) {
            $query->whereDate('start_time', $request->date);
        }

        if ($request->filled('kasir')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->kasir . '%');
            });
        }

        $shifts = $query->orderBy('start_time', 'desc')->get();
        return view('manager.audit', compact('shifts'));
    }

    public function approveShift($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->update([
            'approved_by' => Auth::id(),
            'approved_at' => Carbon::now()
        ]);
        return back()->with('success', 'Shift has been approved.');
    }

    public function omzet()
    {
        $branchId = auth()->user()->branch_id;

        $omzetHariIni = Payment::whereDate('created_at', today())
            ->whereHas('shipment', fn($q) => $q->where('branch_id', $branchId))
            ->sum('amount');

        $omzetMingguIni = Payment::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->whereHas('shipment', fn($q) => $q->where('branch_id', $branchId))
            ->sum('amount');

        $omzetBulanIni = Payment::whereMonth('created_at', now()->month)
            ->whereHas('shipment', fn($q) => $q->where('branch_id', $branchId))
            ->sum('amount');

        $chartData = Shipment::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(total_price) as total_omzet')
            )
            ->where('branch_id', $branchId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->subDays(6), now()])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get();
            
        return view('manager.omzet', compact('omzetHariIni', 'omzetMingguIni', 'omzetBulanIni', 'chartData'));
    }

    public function applications()
    {
        $branchId = auth()->user()->branch_id;
        $applications = \App\Models\StaffApplication::with('user')
            ->where('branch_id', $branchId)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('manager.applications', compact('applications'));
    }

    public function reviewApplication(Request $request, $id)
    {
        $application = \App\Models\StaffApplication::findOrFail($id);
        
        // Security check
        if ($application->branch_id !== auth()->user()->branch_id) {
            abort(403);
        }

        $application->update([
            'status' => 'reviewed',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Lamaran telah ditinjau dan diteruskan ke Admin!');
    }

    public function rejectApplication(Request $request, $id)
    {
        $application = \App\Models\StaffApplication::findOrFail($id);
        
        if ($application->branch_id !== auth()->user()->branch_id) {
            abort(403);
        }

        $application->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Also update user status to rejected
        $application->user->update(['status' => 'rejected']);

        return back()->with('success', 'Lamaran telah ditolak.');
    }

    public function assignPickupCourier(Request $request)
    {
        $request->validate([
            'pickup_id' => 'required|exists:pickup_requests,id',
            'courier_id' => 'required|exists:users,id',
        ]);

        $pickup = PickupRequest::where('id', $request->pickup_id)
            ->where('branch_id', auth()->user()->branch_id)
            ->where('status', 'pending')
            ->firstOrFail();

        $courier = User::where('id', $request->courier_id)
            ->whereIn('role', ['courier_pickup', 'courier_delivery'])
            ->where('branch_id', auth()->user()->branch_id)
            ->firstOrFail();

        $pickup->update([
            'status'      => 'assigned_pickup',
            'courier_id'  => $courier->id,
            'assigned_by' => auth()->id(),
        ]);

        return back()->with('success', 'Kurir Pickup berhasil ditugaskan!');
    }
}

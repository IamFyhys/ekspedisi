<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Payment;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        $isAdmin = Auth::user()->role === 'admin' || Auth::user()->role === 'manager';

        // Summary Statistics
        $query = Shipment::query();
        if (!$isAdmin) $query->where('branch_id', $branchId);

        $totalOmzet = Payment::where('status', 'success');
        if (!$isAdmin) {
            $totalOmzet->whereHas('shipment', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }
        $totalOmzet = $totalOmzet->sum('amount');

        $totalPackets = (clone $query)->count();
        $codPending = (clone $query)->where('payment_method', 'cod')->where('payment_status', 'pending')->sum('total_price');
        $avgTransaction = $totalPackets > 0 ? $totalOmzet / $totalPackets : 0;

        // Chart Data (Last 7 Days)
        $chartData = Payment::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'success')
            ->where('created_at', '>=', now()->subDays(7));
        
        if (!$isAdmin) {
            $chartData->whereHas('shipment', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }
        
        $chartData = $chartData->groupBy('date')
            ->orderBy('date')
            ->get();

        // Breakdown Table
        $breakdown = Payment::select(
                'payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'success');

        if (!$isAdmin) {
            $breakdown->whereHas('shipment', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $breakdown = $breakdown->groupBy('payment_method')->get();

        return view('reports.index', compact('totalOmzet', 'totalPackets', 'codPending', 'avgTransaction', 'chartData', 'breakdown'));
    }

    public function export()
    {
        // Simple export placeholder or logic
        return back()->with('info', 'Export functionality would generate a PDF or Excel file.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        
        $role = strtolower($user->role);
        // Redirect to specific dashboard if needed
        if ($role === 'courier_transit') {
            return redirect()->route('courier.transit.dashboard');
        } elseif ($role === 'courier_delivery' || $role === 'courier') {
            return redirect()->route('courier.delivery.dashboard');
        } elseif ($role === 'manager') {
            return redirect()->route('manager.dashboard');
        } elseif ($role === 'cashier') {
            return redirect()->route('cashier.dashboard');
        }

        $query = Shipment::query();

        // Scope by branch for non-global roles
        if ($user->role !== 'admin' && $user->role !== 'manager') {
            $query->where('branch_id', $user->branch_id);
        }

        $stats = [
            'total' => (clone $query)->count(),
            'delivered' => (clone $query)->where('status', 'delivered')->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'revenue' => (clone $query)->where('status', '!=', 'cancelled')->sum('total_price'),
        ];

        $recentShipments = (clone $query)->with(['originLocation', 'destinationLocation'])->latest()->take(5)->get();

        // Trends data for chart
        $trends = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trends[] = [
                'date' => now()->subDays($i)->format('D'),
                'count' => (clone $query)->whereDate('created_at', $date)->count(),
                'revenue' => (clone $query)->whereDate('created_at', $date)->where('status', '!=', 'cancelled')->sum('total_price')
            ];
        }

        return view('dashboard', compact('stats', 'recentShipments', 'trends'));
    }
}

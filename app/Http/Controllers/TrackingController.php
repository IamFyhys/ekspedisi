<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function show(Request $request)
    {
        $resi = $request->resi ?? $request->route('resi') ?? $request->tracking_number ?? $request->route('tracking_number');

        if (!$resi) {
            return view('tracking', ['shipment' => null]);
        }

        $shipment = Shipment::with([
            'courier',   // relasi ke tabel users (kurir)
            'branch',    // relasi ke tabel branches
            'trackings' => function($q) {
                $q->latest();
            },
            'originLocation',
            'destinationLocation'
        ])
        ->where('tracking_number', $resi)
        ->first();

        if (!$shipment) {
            return view('tracking', [
                'shipment'    => null,
                'notFound'    => true,
                'searchedResi'=> $resi,
            ]);
        }

        return view('tracking', compact('shipment'));
    }
}

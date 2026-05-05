<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Location;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index()
    {
        $rates = Rate::with(['origin', 'destination'])->latest()->get();
        $locations = Location::orderBy('name')->get();
        
        return view('rates.index', compact('rates', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => 'required|exists:locations,id|different:origin_location_id',
            'price_per_kg' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ], [
            'destination_location_id.different' => 'Lokasi asal dan tujuan tidak boleh sama.'
        ]);

        // Cek apakah rate sudah ada
        $exists = Rate::where('origin_location_id', $validated['origin_location_id'])
                      ->where('destination_location_id', $validated['destination_location_id'])
                      ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Tarif untuk rute ini sudah ada!');
        }

        Rate::create($validated);

        return redirect()->route('rates.index')->with('success', 'Tarif pengiriman berhasil ditambahkan!');
    }

    public function update(Request $request, Rate $rate)
    {
        $validated = $request->validate([
            'origin_location_id' => 'required|exists:locations,id',
            'destination_location_id' => 'required|exists:locations,id|different:origin_location_id',
            'price_per_kg' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
        ], [
            'destination_location_id.different' => 'Lokasi asal dan tujuan tidak boleh sama.'
        ]);

        // Cek duplikasi jika mengubah rute
        if ($rate->origin_location_id != $validated['origin_location_id'] || $rate->destination_location_id != $validated['destination_location_id']) {
            $exists = Rate::where('origin_location_id', $validated['origin_location_id'])
                          ->where('destination_location_id', $validated['destination_location_id'])
                          ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Tarif untuk rute ini sudah ada!');
            }
        }

        $rate->update($validated);

        return redirect()->route('rates.index')->with('success', 'Tarif pengiriman berhasil diperbarui!');
    }

    public function destroy(Rate $rate)
    {
        $rate->delete();
        return redirect()->route('rates.index')->with('success', 'Tarif pengiriman berhasil dihapus!');
    }
}

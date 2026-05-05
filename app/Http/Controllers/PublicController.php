<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Rate;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function cekTarif(Request $request)
    {
        $branches = Branch::all();
        return view('public.cek-tarif', compact('branches'));
    }

    public function hitungTarif(Request $request)
    {
        $request->validate([
            'asal'  => 'required|string',
            'tujuan'=> 'required|string',
            'berat' => 'required|numeric|min:0.1',
        ]);

        // Find rate by city names (case insensitive)
        $rate = Rate::whereHas('origin', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->asal . '%');
            })
            ->whereHas('destination', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->tujuan . '%');
            })
            ->first();

        if (!$rate) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Rute ' . $request->asal . ' ke ' . $request->tujuan . ' belum tersedia di sistem kami.']);
            }
            return back()->with('error', 'Rute ' . $request->asal . ' ke ' . $request->tujuan . ' belum tersedia di sistem kami.');
        }

        $berat = ceil($request->berat);
        $baseOngkir = $berat * $rate->price_per_kg;

        $layanan = [
            [
                'nama'      => 'SKY-ECO',
                'desc'      => 'Ekonomis',
                'estimasi'  => '4-7 hari',
                'multiplier'=> 0.8,
                'icon'      => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>'
            ],
            [
                'nama'      => 'SKY-REG',
                'desc'      => 'Reguler',
                'estimasi'  => '2-3 hari',
                'multiplier'=> 1.0,
                'icon'      => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>'
            ],
            [
                'nama'      => 'SKY-FAST',
                'desc'      => 'Cepat',
                'estimasi'  => '1-2 hari',
                'multiplier'=> 1.5,
                'icon'      => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"></path></svg>'
            ],
        ];

        foreach ($layanan as &$l) {
            $l['harga'] = $baseOngkir * $l['multiplier'];
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'layanan' => $layanan,
                'asal'    => $request->asal,
                'tujuan'  => $request->tujuan,
                'berat'   => $request->berat,
            ]);
        }

        return back()->with([
            'hasil'  => $layanan,
            'asal'   => $request->asal,
            'tujuan' => $request->tujuan,
            'berat'  => $request->berat,
        ]);
    }

    public function cabang(Request $request)
    {
        $query = Branch::query();
        
        if ($request->kota) {
            $query->where('city', 'like', '%' . $request->kota . '%')
                  ->orWhere('name', 'like', '%' . $request->kota . '%');
        }

        $branches = $query->get();
        return view('public.cabang', compact('branches'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    public function getProvinces()
    {
        return Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json')->json();
    }

    public function getRegencies($provinceId)
    {
        return Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinceId}.json")->json();
    }

    public function getDistricts($regencyId)
    {
        return Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$regencyId}.json")->json();
    }

    public function ensureLocation(Request $request)
    {
        $request->validate([
            'regency_name' => 'required',
            'province_name' => 'required',
            'district_name' => 'required'
        ]);

        // 1. Ensure Location (City) exists
        $location = Location::firstOrCreate(
            ['name' => $request->regency_name],
            ['province' => $request->province_name]
        );

        // 2. Ensure Subdistrict exists
        $subdistrict = Subdistrict::firstOrCreate(
            [
                'location_id' => $location->id,
                'name' => $request->district_name
            ]
        );

        return response()->json([
            'location_id' => $location->id,
            'subdistrict_id' => $subdistrict->id
        ]);
    }
}

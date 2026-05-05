<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Notifications\StaffApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\Http;

class StaffRegistrationController extends Controller
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

    public function create()
    {
        $branches = Branch::all();
        return view('auth.register-staff', compact('branches'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users',
            'phone'          => 'required|string',
            'birth_day'      => 'required|integer|between:1,31',
            'birth_month'    => 'required|integer|between:1,12',
            'birth_year'     => 'required|integer',
            'province_id'    => 'required|string',
            'regency_id'     => 'required|string',
            'district_id'    => 'required|string',
            'address_detail' => 'required|string',
            'branch_id'      => 'required|exists:branches,id',
            'position'       => 'required|in:cashier,courier_transit,courier_delivery',
            'experience'     => 'nullable|string',
            'ktp_photo'      => 'required|image|max:2048',
            'selfie_photo'   => 'required|image|max:2048',
            'password'       => 'required|min:8|confirmed',
            'terms'          => 'required|accepted',
        ];

        // Tambah validasi jika posisi kurir
        if (in_array($request->position, ['courier_transit', 'courier_delivery'])) {
            $rules['sim_type']      = 'required|string';
            $rules['sim_photo']     = 'required|image|max:2048';
            $rules['vehicle_type']  = 'required|string';
            $rules['vehicle_plate'] = 'required|string';
        }

        $request->validate($rules);

        $birthDate = $request->birth_year . '-' . 
                    str_pad($request->birth_month, 2, '0', STR_PAD_LEFT) . '-' . 
                    str_pad($request->birth_day, 2, '0', STR_PAD_LEFT);

        $branch = Branch::findOrFail($request->branch_id);

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'birth_date'     => $birthDate,
            'province_id'    => $request->province_id,
            'province_name'  => $request->province_name,
            'regency_id'     => $request->regency_id,
            'regency_name'   => $request->regency_name,
            'district_id'    => $request->district_id,
            'district_name'  => $request->district_name,
            'address_detail' => $request->address_detail,
            'branch_id'      => $request->branch_id,
            'role'           => $request->position,
            'experience'     => $request->experience,
            'ktp_photo'      => $request->file('ktp_photo')->store('staff/ktp', 'public'),
            'selfie_photo'   => $request->file('selfie_photo')->store('staff/staffie', 'public'),
            'sim_type'       => $request->sim_type,
            'sim_photo'      => $request->file('sim_photo') ? $request->file('sim_photo')->store('staff/sim', 'public') : null,
            'vehicle_type'   => $request->vehicle_type,
            'vehicle_plate'  => strtoupper($request->vehicle_plate),
            'status'         => 'pending',
            'password'       => Hash::make($request->password),
        ]);

        // Notify Manager of the branch
        $manager = User::where('branch_id', $request->branch_id)
            ->where('role', 'manager')
            ->first();

        if ($manager) {
            $manager->notify(new StaffApplicationNotification($user));
        }

        if (Auth::check() && Auth::user()->role === 'manager') {
            return redirect()->route('manager.staff.apply')->with('success', 'Aplikasi staff berhasil didaftarkan.');
        }

        return redirect()->route('register.success')
            ->with('registered_email', $user->email)
            ->with('branch_name', $branch->name);
    }
}

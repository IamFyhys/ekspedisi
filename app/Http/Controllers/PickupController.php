<?php

namespace App\Http\Controllers;

use App\Models\PickupRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PickupController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('pickup.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_name'       => 'required|string',
            'sender_phone'      => 'required|string',
            'sender_address'    => 'required|string',
            'sender_city'       => 'required|string',
            'branch_id'         => 'required|exists:branches,id',
            'goods_type'        => 'required|string',
            'estimated_weight'  => 'required|numeric|min:0.1',
            'receiver_name'     => 'required|string',
            'receiver_phone'    => 'required|string',
            'receiver_address'  => 'required|string',
            'receiver_city'     => 'required|string',
            'pickup_date'       => 'required|date|after_or_equal:today',
            'pickup_time'       => 'required|string',
        ]);

        // Generate unique pickup code
        $code = 'PKP-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $pickup = PickupRequest::create(array_merge($request->all(), [
            'pickup_code' => $code,
            'customer_id' => auth()->id() ?? null,
            'status'      => 'pending',
        ]));

        // Optional: Notify branch manager
        $manager = User::where('branch_id', $request->branch_id)
                       ->where('role', 'manager')
                       ->first();
        // if ($manager) $manager->notify(new NewPickupRequestNotification($pickup));

        return redirect()->route('pickup.success')
            ->with('pickup_code', $code);
    }

    public function success()
    {
        if (!session('pickup_code')) {
            return redirect()->route('pickup.index');
        }
        return view('pickup.success');
    }

    public function track(Request $request, $code = null)
    {
        $code = $code ?? $request->code;
        
        if (!$code) {
            return view('pickup.track', ['pickup' => null]);
        }

        $pickup = PickupRequest::where('pickup_code', $code)->first();

        if (!$pickup) {
            return view('pickup.track', [
                'pickup' => null,
                'notFound' => true,
                'searchedCode' => $code
            ]);
        }

        return view('pickup.track', compact('pickup'));
    }
}

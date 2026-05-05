<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\StaffApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ManagerApplicationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $branchId = auth()->user()->branch_id;
        $isAdmin = auth()->user()->role === 'admin';
        
        $applications = User::whereIn('status', ['pending', 'review', 'rejected'])
            ->when(!$isAdmin, function($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            })
            ->when($status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->with(['branch'])
            ->latest()
            ->paginate(15);

        return view('manager.staff.lamaran', compact('applications', 'status'));
    }

    public function forward(Request $request, User $user)
    {
        $user->update([
            'status' => 'review',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'manager_note' => $request->note,
        ]);

        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new StaffApplicationNotification($user));

        return back()->with('success', 'Lamaran berhasil diteruskan ke Admin Pusat.');
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string'
        ]);

        $user->update([
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_reason' => $request->reason,
        ]);

        // Here you would send a rejection email
        // Mail::to($user->email)->send(new AccountRejectedMail($user));

        return back()->with('success', 'Lamaran telah ditolak.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminApprovalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'review');
        
        $applications = User::with('branch', 'reviewer')
            ->whereIn('status', ['review', 'active', 'rejected'])
            ->when($status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.approvals.index', compact('applications', 'status'));
    }

    public function approve(Request $request, User $user)
    {
        $user->update([
            'status' => 'active',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Send Approval Email
        // Mail::to($user->email)->send(new AccountApprovedMail($user));

        return back()->with('success', "Akun staff {$user->name} telah aktif.");
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

        // Send Rejection Email
        // Mail::to($user->email)->send(new AccountRejectedMail($user));

        return back()->with('success', 'Lamaran telah ditolak.');
    }
}

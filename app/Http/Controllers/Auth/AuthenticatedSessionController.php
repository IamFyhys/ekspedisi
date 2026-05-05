<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Check user status
        if ($user->role !== 'customer' && $user->role !== 'admin' && $user->status !== 'active') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = match($user->status) {
                'pending' => 'Akun Anda sedang dalam antrian review oleh Manager cabang.',
                'review' => 'Akun Anda telah direview Manager dan sedang menunggu persetujuan Admin Pusat.',
                'rejected' => 'Mohon maaf, lamaran Anda telah ditolak. Silakan hubungi admin untuk informasi lebih lanjut.',
                default => 'Akun Anda belum aktif. Silakan hubungi administrator.',
            };

            return redirect()->route('login')->withErrors([
                'email' => $message,
            ]);
        }

        $request->session()->regenerate();

        // Redirect sesuai role
        return redirect(match($user->role) {
            'admin'              => '/dashboard',
            'manager'            => '/manager/dashboard',
            'cashier'            => '/cashier/dashboard',
            'courier_transit'    => '/courier/transit',
            'courier_delivery'   => '/courier/delivery',
            'customer'           => '/customer/dashboard',
            default              => '/login',
        });
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

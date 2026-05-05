@extends('layouts.auth-premium')

@php
    $isStaff = Route::is('staff.login');
@endphp

@section('title', $isStaff ? 'Staff Login — Expedition' : 'Login Customer — Expedition')

@section('panel_title', $isStaff ? 'Portal Operasional Staff.' : 'Kirim Paket Jadi Lebih Mudah.')
@section('panel_text', $isStaff ? 'Akses dashboard khusus tim ekspedisi untuk mengelola kiriman dan operasional harian.' : 'Masuk ke akun Anda untuk menikmati fitur pengiriman yang lebih lengkap dan terintegrasi.')

@section('content')
    @if($isStaff)
        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: var(--green); border-radius: 50px; font-size: 12px; font-weight: 700; margin-bottom: 24px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Portal Staff & Kurir — Akses Terbatas
        </div>
    @endif

    <h1>{{ $isStaff ? 'Login Staff' : 'Selamat datang kembali' }}</h1>
    <p class="sub">{{ $isStaff ? 'Silakan masukkan email staff dan password Anda.' : 'Silakan masukkan email dan password Anda.' }}</p>

    <!-- Session Status -->
    @if (session('status'))
        <div style="color: var(--green); margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            {{ session('status') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div style="color: var(--red); margin-bottom: 20px; font-size: 14px; font-weight: 600;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <div class="form-input-wrap">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{ $isStaff ? 'staff@expedition.id' : 'nama@email.com' }}" required autofocus autocomplete="username">
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="form-input-wrap">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>
        </div>

        <div class="form-options">
            <label class="checkbox-group" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="width: auto;"> Ingat saya
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary {{ $isStaff ? 'btn-emerald' : '' }}" style="{{ $isStaff ? 'background: var(--green);' : '' }}">
            {{ $isStaff ? 'Masuk ke Dashboard' : 'Masuk' }}
        </button>
    </form>

    @if(!$isStaff)
        <div class="divider">atau</div>
        <a href="{{ route('register') }}" class="btn btn-outline">Daftar akun baru</a>
    @endif
@endsection

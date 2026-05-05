@extends('layouts.auth-premium')

@section('title', 'Daftar Akun — Expedition')

@section('panel_title', 'Bergabunglah Bersama Kami.')
@section('panel_text', 'Nikmati kemudahan logistik dalam genggaman Anda. Daftar sekarang, gratis!')

@section('content')
    <div class="step-indicator" style="display: flex; align-items: center; gap: 12px; margin-bottom: 32px;">
        <div class="step-dot active" id="step-dot-1" style="width: 32px; height: 32px; border-radius: 50%; background: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: white; transition: all 0.3s;">1</div>
        <div class="step-line" id="step-line-1" style="flex: 1; height: 2px; background: var(--border);"></div>
        <div class="step-dot" id="step-dot-2" style="width: 32px; height: 32px; border-radius: 50%; background: var(--bg3); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: var(--muted); transition: all 0.3s;">2</div>
    </div>

    <form method="POST" action="{{ route('register') }}" id="reg-form">
        @csrf
        <input type="hidden" name="role" id="role-input" value="customer">

        <!-- Step 1: Role Selection -->
        <div id="reg-step-1">
            <h1>Siapa Anda?</h1>
            <p class="sub">Pilih jenis akun yang ingin Anda buat.</p>
            
            <div class="role-selector" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 32px;">
                <div class="role-option selected" id="role-cust" onclick="selectRole('customer')" style="border: 2px solid var(--accent); padding: 24px; border-radius: var(--radius-md); cursor: pointer; text-align: center; background: rgba(79, 70, 229, 0.05);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <h4 style="margin-top: 12px; margin-bottom: 4px;">Customer</h4>
                    <p style="font-size: 12px; color: var(--muted);">Kirim & lacak paket</p>
                </div>
                <div class="role-option" id="role-staff" onclick="selectRole('staff')" style="border: 2px solid var(--border); padding: 24px; border-radius: var(--radius-md); cursor: pointer; text-align: center;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><rect x="14" y="3" width="7" height="18" rx="2"></rect><path d="M1 3h15V1H1v2zm0 4h15V5H1v2zm0 4h15V9H1v2zm0 4h15v-2H1v2z"></path></svg>
                    <h4 style="margin-top: 12px; margin-bottom: 4px;">Staff / Kurir</h4>
                    <p style="font-size: 12px; color: var(--muted);">Dashboard operasional</p>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="nextStep()">Lanjut <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14m-7-7 7 7-7 7"></path></svg></button>
        </div>

        <!-- Step 2: Data Input -->
        <div id="reg-step-2" style="display: none;">
            <h1 id="reg-title">Daftar Customer</h1>
            <p class="sub">Lengkapi data diri Anda di bawah ini.</p>
            
            <!-- Validation Errors -->
            @if ($errors->any())
                <div style="color: var(--red); margin-bottom: 20px; font-size: 14px; font-weight: 600;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <div class="form-input-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Budi Santoso" required autofocus autocomplete="name">
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <div class="form-input-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autocomplete="username">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="form-input-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="form-input-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="reg-submit-btn">Buat Akun</button>
            <button type="button" class="btn btn-ghost" style="margin-top: 12px;" onclick="prevStep()">← Sebelumnya</button>
        </div>
    </form>

    <div class="divider">atau sudah punya akun?</div>
    <a href="{{ route('login') }}" class="btn btn-outline">Masuk ke akun</a>

    <script>
        function selectRole(role) {
            document.getElementById('role-input').value = role;
            document.getElementById('role-cust').style.border = role === 'customer' ? '2px solid var(--accent)' : '2px solid var(--border)';
            document.getElementById('role-cust').style.background = role === 'customer' ? 'rgba(79, 70, 229, 0.05)' : 'none';
            
            document.getElementById('role-staff').style.border = role === 'staff' ? '2px solid var(--green)' : '2px solid var(--border)';
            document.getElementById('role-staff').style.background = role === 'staff' ? 'rgba(16, 185, 129, 0.05)' : 'none';
        }

        function nextStep() {
            const role = document.getElementById('role-input').value;

            // Jika pilih staff, arahkan ke formulir lamaran lengkap (Recruitment Portal)
            if(role === 'staff') {
                window.location.href = "{{ route('register.staff') }}";
                return;
            }

            document.getElementById('reg-step-1').style.display = 'none';
            document.getElementById('reg-step-2').style.display = 'block';
            
            document.getElementById('step-dot-1').style.background = 'var(--green)';
            document.getElementById('step-dot-1').innerHTML = '✓';
            document.getElementById('step-dot-2').style.background = 'var(--accent)';
            document.getElementById('step-dot-2').style.color = 'white';
            document.getElementById('step-line-1').style.background = 'var(--green)';

            const title = document.getElementById('reg-title');
            const btn = document.getElementById('reg-submit-btn');

            title.textContent = 'Daftar Akun Customer';
            btn.textContent = 'Buat Akun';
            btn.style.background = 'var(--accent)';
        }

        function prevStep() {
            document.getElementById('reg-step-1').style.display = 'block';
            document.getElementById('reg-step-2').style.display = 'none';
            
            document.getElementById('step-dot-1').style.background = 'var(--accent)';
            document.getElementById('step-dot-1').innerHTML = '1';
            document.getElementById('step-dot-2').style.background = 'var(--bg3)';
            document.getElementById('step-dot-2').style.color = 'var(--muted)';
            document.getElementById('step-line-1').style.background = 'var(--border)';
        }

        // Preserve step 2 if there are errors
        @if ($errors->any())
            window.onload = nextStep;
        @endif
    </script>
@endsection

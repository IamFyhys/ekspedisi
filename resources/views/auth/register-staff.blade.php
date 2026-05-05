@extends('layouts.premium')

@section('title', 'Gabung Tim Ekspedisi — Skynet Logistics')

@section('styles')
<style>
    .registration-page { padding-top: 140px; padding-bottom: 80px; background-color: #f8fafc; min-height: 100vh; }
    
    .reg-container { max-width: 800px; margin: 0 auto; }
    
    .form-card { 
        background: #ffffff; 
        padding: 60px; 
        border-radius: 24px; 
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); 
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: #6366f1;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 40px 0 24px;
    }

    .form-section-title:first-child { margin-top: 0; }

    .form-section-title span {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #64748b;
        white-space: nowrap;
    }

    .form-section-title .line {
        height: 1px;
        background: #e2e8f0;
        flex: 1;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .form-group { margin-bottom: 0; }
    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-field {
        width: 100%;
        padding: 0 16px;
        height: 52px;
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        transition: all 0.3s;
        outline: none;
        line-height: 52px; /* Ensure text centering */
    }

    select.input-field {
        line-height: normal; /* Reset for selects */
        padding-top: 0;
        padding-bottom: 0;
    }

    .input-field:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .input-field::placeholder { color: #94a3b8; font-weight: 500; }

    select.input-field {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
    }

    .upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background: #f8fafc;
        transition: all 0.2s;
        overflow: hidden;
        position: relative;
    }

    .upload-box:hover {
        border-color: #6366f1;
        background: #f5f3ff;
    }

    .preview-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 15px;
        z-index: 10;
        backdrop-filter: blur(2px);
    }

    .preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .success-icon {
        width: 50px;
        height: 50px;
        min-width: 50px; /* Force dimensions */
        min-height: 50px;
        background: #16a34a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(22, 163, 74, 0.4);
        position: relative;
        z-index: 11;
        flex-shrink: 0;
    }

    .success-icon svg {
        width: 28px;
        height: 28px;
        stroke-width: 4;
        display: block;
        flex-shrink: 0; /* Prevent squishing */
    }

    .btn-change-photo {
        background: #ffffff;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        z-index: 11;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .btn-change-photo:hover { background: #ffffff; }

    .submit-btn {
        width: 100%;
        height: 56px;
        background: #6366f1;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        transition: all 0.3s;
        margin-top: 40px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4);
    }

    .field-kurir {
        display: none;
        background: #f0f7ff;
        border: 1px solid #dbeafe;
        border-radius: 16px;
        padding: 24px;
        margin-top: 24px;
    }

    .checkbox-container {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        cursor: pointer;
        align-items: flex-start;
    }

    .checkbox-container input {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid #cbd5e1;
        cursor: pointer;
        accent-color: #6366f1;
        flex-shrink: 0;
    }

    .checkbox-container span {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
        font-weight: 500;
    }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-card { padding: 40px 24px; }
    }

    .reveal { opacity: 0; transform: translateY(20px); transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1); }
    .reveal.is-visible { opacity: 1; transform: translateY(0); }
</style>
@endsection

@section('content')
<div class="registration-page">
    <div class="reg-container">
        <div style="text-align: center; margin-bottom: 50px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; background: rgba(99, 102, 241, 0.1); color: #6366f1; border-radius: 50px; font-size: 12px; font-weight: 700; margin-bottom: 16px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                GABUNG TIM EKSPEDISI KAMI
            </div>
            <h1 style="font-size: 32px; font-weight: 800; color: #1e293b; letter-spacing: -1px;">Formulir Pendaftaran Staff</h1>
            <p style="color: #64748b; margin-top: 8px;">Lengkapi data diri Anda untuk memulai karir bersama Skynet Logistics.</p>
        </div>

        <div class="form-card reveal">
            <form action="{{ route('register.staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Section: Data Diri -->
                <div class="form-section-title">
                    <span>Data Diri</span>
                    <div class="line"></div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="name" class="input-field" placeholder="Budi Santoso" required value="{{ old('name') }}">
                        @error('name') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email Aktif *</label>
                        <input type="email" name="email" class="input-field" placeholder="nama@email.com" required value="{{ old('email') }}">
                        @error('email') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>No. HP / Whatsapp *</label>
                        <input type="text" name="phone" class="input-field" placeholder="0812..." required value="{{ old('phone') }}">
                        @error('phone') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir *</label>
                        <div style="display:grid;grid-template-columns: 70px 1fr 90px; gap: 8px;">
                            <select name="birth_day" required class="input-field" style="padding: 0 10px;">
                                <option value="">Tgl</option>
                                @for($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" {{ old('birth_day') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endfor
                            </select>
                            <select name="birth_month" required class="input-field" style="padding: 0 10px;">
                                <option value="">Bulan</option>
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
                                <option value="{{ $i + 1 }}" {{ old('birth_month') == ($i+1) ? 'selected' : '' }}>{{ $bulan }}</option>
                                @endforeach
                            </select>
                            <select name="birth_year" required class="input-field" style="padding: 0 10px;">
                                <option value="">Tahun</option>
                                @for($y = date('Y') - 17; $y >= 1900; $y--)
                                <option value="{{ $y }}" {{ old('birth_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <p style="font-size: 11px; color: #94a3b8; margin-top: 6px; font-weight: 500;">Minimal usia 17 tahun</p>
                        @error('birth_day') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Section: Alamat Lengkap -->
                <div class="form-section-title">
                    <span>Alamat Domisili</span>
                    <div class="line"></div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Provinsi *</label>
                        <select name="province_id" class="input-field" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        <input type="hidden" name="province_name" id="province_name">
                    </div>
                    <div class="form-group">
                        <label>Kabupaten / Kota *</label>
                        <select name="regency_id" class="input-field" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                        <input type="hidden" name="regency_name" id="regency_name">
                    </div>
                    <div class="form-group">
                        <label>Kecamatan *</label>
                        <select name="district_id" class="input-field" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <input type="hidden" name="district_name" id="district_name">
                    </div>
                </div>
                <div class="form-group" style="margin-top: 24px;">
                    <label>Alamat Detail *</label>
                    <textarea name="address_detail" class="input-field" style="height: 100px; padding: 14px 20px; resize: none;" placeholder="Nomor rumah, nama jalan, RT/RW, patokan" required>{{ old('address_detail') }}</textarea>
                    @error('address_detail') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <!-- Section: Informasi Lamaran -->
                <div class="form-section-title">
                    <span>Informasi Lamaran</span>
                    <div class="line"></div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Pilih Cabang *</label>
                        <select name="branch_id" class="input-field" required>
                            <option value="">Pilih Cabang</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Posisi Dilamar *</label>
                        <select name="position" class="input-field" required>
                            <option value="">Pilih Posisi</option>
                            <option value="cashier" {{ old('position') == 'cashier' ? 'selected' : '' }}>Kasir</option>
                            <option value="courier_transit" {{ old('position') == 'courier_transit' ? 'selected' : '' }}>Kurir Transit</option>
                            <option value="courier_delivery" {{ old('position') == 'courier_delivery' ? 'selected' : '' }}>Kurir Antar</option>
                        </select>
                        @error('position') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Conditional Courier Fields -->
                <div id="fieldKurir" class="field-kurir">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <div style="width: 32px; height: 32px; background: #6366f1; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        </div>
                        <span style="font-size: 13px; font-weight: 800; color: #1e293b; letter-spacing: 0.5px;">INFORMASI KENDARAAN</span>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Jenis SIM *</label>
                            <select name="sim_type" class="input-field">
                                <option value="">Pilih Jenis SIM</option>
                                <option value="A">SIM A (Mobil)</option>
                                <option value="C">SIM C (Motor)</option>
                                <option value="B1">SIM B1 (Truk Kecil)</option>
                                <option value="B2">SIM B2 (Truk Besar)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kendaraan *</label>
                            <select name="vehicle_type" class="input-field">
                                <option value="">Pilih Jenis Kendaraan</option>
                                <option value="Motor">Motor</option>
                                <option value="Mobil">Mobil</option>
                                <option value="Pickup">Pickup</option>
                                <option value="Truk">Truk</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <label>Nomor Plat Kendaraan *</label>
                        <input type="text" name="vehicle_plate" class="input-field" placeholder="Contoh: B 1234 ABC" style="text-transform: uppercase;">
                    </div>
                    
                    <div class="form-group" style="margin-top: 20px;">
                        <label>Upload Foto SIM *</label>
                        <div id="dropSIM" class="upload-box">
                            <div id="simEmpty" style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><line x1="15" y1="8" x2="19" y2="8"/><line x1="15" y1="12" x2="19" y2="12"/><line x1="7" y1="16" x2="17" y2="16"/></svg>
                                <div style="font-size:13px;font-weight:700;color:#6366f1;">Klik atau seret foto SIM ke sini</div>
                                <div style="font-size:11px;color:#94a3b8;">SIM A, B1, atau C — Maksimal 2MB</div>
                            </div>
                            <div id="simPreview" class="preview-overlay">
                                <img id="simPreviewImg" class="preview-img">
                                <div class="success-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                                </div>
                                <button type="button" class="btn-change-photo" onclick="hapusFoto(event, 'dropSIM', 'inputSIM', 'simEmpty', 'simPreview')">Ganti Foto</button>
                            </div>
                        </div>
                        <input type="file" id="inputSIM" name="sim_photo" accept="image/*" style="display:none">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 24px;">
                    <label>Pengalaman Kerja</label>
                    <textarea name="experience" class="input-field" style="height: 100px; padding: 14px 20px; resize: none;" placeholder="Contoh: Pernah bekerja sebagai kurir selama 2 tahun di perusahaan ekspedisi X, terbiasa dengan rute area Jakarta Selatan">{{ old('experience') }}</textarea>
                    @error('experience') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <!-- Section: Dokumen Pendukung -->
                <div class="form-section-title">
                    <span>Dokumen Pendukung</span>
                    <div class="line"></div>
                </div>

                <div class="form-grid">
                    <!-- Upload KTP -->
                    <div class="form-group">
                        <label>Foto KTP *</label>
                        <div id="dropKTP" class="upload-box">
                            <div id="ktpEmpty" style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><line x1="15" y1="8" x2="19" y2="8"/><line x1="15" y1="12" x2="19" y2="12"/><line x1="7" y1="16" x2="17" y2="16"/></svg>
                                <div style="font-size:13px;font-weight:700;color:#6366f1;">Klik atau seret foto KTP ke sini</div>
                                <div style="font-size:11px;color:#94a3b8;">JPG, PNG — Maksimal 2MB</div>
                            </div>
                            <div id="ktpPreview" class="preview-overlay">
                                <img id="ktpPreviewImg" class="preview-img">
                                <div class="success-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                                </div>
                                <button type="button" class="btn-change-photo" onclick="hapusFoto(event, 'dropKTP', 'inputKTP', 'ktpEmpty', 'ktpPreview')">Ganti Foto</button>
                            </div>
                        </div>
                        <input type="file" id="inputKTP" name="ktp_photo" accept="image/*" style="display:none">
                        @error('ktp_photo') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>

                    <!-- Upload Selfie -->
                    <div class="form-group">
                        <label>Selfie + KTP *</label>
                        <div id="dropSelfie" class="upload-box">
                            <div id="selfieEmpty" style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                <div style="font-size:13px;font-weight:700;color:#6366f1;">Klik atau seret foto Selfie + KTP</div>
                                <div style="font-size:11px;color:#94a3b8;">Pastikan wajah dan KTP terlihat jelas</div>
                            </div>
                            <div id="selfiePreview" class="preview-overlay">
                                <img id="selfiePreviewImg" class="preview-img">
                                <div class="success-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                                </div>
                                <button type="button" class="btn-change-photo" onclick="hapusFoto(event, 'dropSelfie', 'inputSelfie', 'selfieEmpty', 'selfiePreview')">Ganti Foto</button>
                            </div>
                        </div>
                        <input type="file" id="inputSelfie" name="selfie_photo" accept="image/*" capture="user" style="display:none">
                        @error('selfie_photo') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Section: Keamanan Akun -->
                <div class="form-section-title">
                    <span>Keamanan Akun</span>
                    <div class="line"></div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Buat Password *</label>
                        <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                        @error('password') <p style="color: #ef4444; font-size: 11px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" class="input-field" placeholder="••••••••" required>
                    </div>
                </div>

                <label class="checkbox-container">
                    <input type="checkbox" name="terms" required>
                    <span>Saya menyatakan bahwa saya sehat jasmani dan rohani, tidak buta warna, bersedia memiliki kendaraan pribadi yang layak, dan seluruh data yang saya isi adalah benar serta dapat dipertanggungjawabkan.</span>
                </label>

                <button type="submit" class="submit-btn">Kirim Lamaran Pekerjaan</button>
                
                <p style="text-align: center; margin-top: 24px; font-size: 14px; font-weight: 600; color: #64748b;">
                    Sudah punya akun? <a href="{{ route('login') }}" style="color: #6366f1; text-decoration: none;">Masuk di sini</a>
                </p>
            </form>
        </div>

        <p style="text-align: center; margin-top: 40px; color: #94a3b8; font-size: 11px; font-weight: 700; letter-spacing: 1px;">© 2026 SKYNET LOGISTICS — ALL RIGHTS RESERVED</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Alamat Bertingkat (API Wilayah) ───────────────────────────
    document.addEventListener('DOMContentLoaded', function() {
        const provSel = document.querySelector('[name="province_id"]');
        const regSel = document.querySelector('[name="regency_id"]');
        const distSel = document.querySelector('[name="district_id"]');

        const provName = document.getElementById('province_name');
        const regName = document.getElementById('regency_name');
        const distName = document.getElementById('district_name');

        // Fetch Provinsi via Proxy
        fetch('/api/wilayah/provinces')
            .then(r => r.json())
            .then(data => {
                provSel.innerHTML = '<option value="">Pilih Provinsi</option>';
                data.forEach(p => {
                    provSel.innerHTML += `<option value="${p.id}">${p.name}</option>`;
                });
            })
            .catch(err => {
                console.error('Gagal mengambil data provinsi:', err);
                provSel.innerHTML = '<option value="">Error memuat data</option>';
            });

        provSel.addEventListener('change', function() {
            if (!this.value) {
                provName.value = '';
                return;
            }
            provName.value = this.options[this.selectedIndex].text;
            regSel.innerHTML = '<option value="">Memuat...</option>';
            distSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
            regName.value = '';
            distName.value = '';

            fetch(`/api/wilayah/regencies/${this.value}`)
                .then(r => r.json())
                .then(data => {
                    regSel.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                    data.forEach(r => {
                        regSel.innerHTML += `<option value="${r.id}">${r.name}</option>`;
                    });
                })
                .catch(err => {
                    console.error('Gagal mengambil data kabupaten:', err);
                    regSel.innerHTML = '<option value="">Error memuat data</option>';
                });
        });

        regSel.addEventListener('change', function() {
            if (!this.value) {
                regName.value = '';
                return;
            }
            regName.value = this.options[this.selectedIndex].text;
            distSel.innerHTML = '<option value="">Memuat...</option>';
            distName.value = '';

            fetch(`/api/wilayah/districts/${this.value}`)
                .then(r => r.json())
                .then(data => {
                    distSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(d => {
                        distSel.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                    });
                })
                .catch(err => {
                    console.error('Gagal mengambil data kecamatan:', err);
                    distSel.innerHTML = '<option value="">Error memuat data</option>';
                });
        });

        distSel.addEventListener('change', function() {
            distName.value = this.options[this.selectedIndex].text;
        });

        // ── Conditional Courier Fields ──────────────────────────
        const posisi = document.querySelector('[name="position"]');
        const fieldKurir = document.getElementById('fieldKurir');
        const kurirFields = fieldKurir.querySelectorAll('select, input');

        posisi.addEventListener('change', function() {
            const isKurir = ['courier_transit', 'courier_delivery'].includes(this.value);
            fieldKurir.style.display = isKurir ? 'block' : 'none';
            kurirFields.forEach(f => {
                if (f.type !== 'file') f.required = isKurir;
            });
        });

        // ── Photo Upload Pattern ───────────────────────────────
        function setupUpload(dropId, inputId, emptyId, previewId, imgId) {
            const drop = document.getElementById(dropId);
            const input = document.getElementById(inputId);

            drop.addEventListener('click', () => input.click());

            input.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB');
                    this.value = ''; return;
                }
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById(imgId).src = e.target.result;
                    document.getElementById(emptyId).style.display = 'none';
                    document.getElementById(previewId).style.display = 'flex';
                    drop.style.borderColor = '#16a34a';
                    drop.style.background = '#f0fdf4';
                };
                reader.readAsDataURL(file);
            });

            drop.addEventListener('dragover', e => {
                e.preventDefault();
                drop.style.borderColor = '#6366f1';
                drop.style.background = '#f5f3ff';
            });

            drop.addEventListener('dragleave', () => {
                drop.style.borderColor = '#cbd5e1';
                drop.style.background = '#f8fafc';
            });

            drop.addEventListener('drop', e => {
                e.preventDefault();
                const file = e.dataTransfer.files[0];
                if (!file?.type.startsWith('image/')) return;
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            });
        }

        setupUpload('dropKTP', 'inputKTP', 'ktpEmpty', 'ktpPreview', 'ktpPreviewImg');
        setupUpload('dropSelfie', 'inputSelfie', 'selfieEmpty', 'selfiePreview', 'selfiePreviewImg');
        setupUpload('dropSIM', 'inputSIM', 'simEmpty', 'simPreview', 'simPreviewImg');

        // Initial scroll reveal
        setTimeout(() => {
            document.querySelector('.reveal').classList.add('is-visible');
        }, 100);
    });

    function hapusFoto(e, dropId, inputId, emptyId, previewId) {
        e.stopPropagation();
        document.getElementById(inputId).value = '';
        document.getElementById(emptyId).style.display = 'flex';
        document.getElementById(previewId).style.display = 'none';
        document.getElementById(dropId).style.borderColor = '#cbd5e1';
        document.getElementById(dropId).style.background = '#f8fafc';
    }
</script>
@endpush


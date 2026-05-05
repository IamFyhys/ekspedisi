<x-admin-layout>
@section('title_breadcrumb', 'Profile')

<style>
.profile-wrap{max-width:900px;margin:0 auto;display:grid;grid-template-columns:300px 1fr;gap:24px}
.profile-card{background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:32px 24px}
.profile-card.right{padding:28px}
.avatar-circle{width:120px;height:120px;border-radius:50%;overflow:hidden;border:3px solid #e2e8f0;margin:0 auto 16px}
.avatar-circle img{width:100%;height:100%;object-fit:cover;display:block}
.avatar-initial{width:100%;height:100%;background:#6366f1;display:flex;align-items:center;justify-content:center;color:#fff;font-size:36px;font-weight:700}
.btn-ganti-foto{display:inline-flex;align-items:center;gap:6px;border:1px solid #e2e8f0;background:#fff;padding:8px 16px;border-radius:10px;font-size:12px;color:#6366f1;font-weight:600;cursor:pointer;margin-bottom:16px}
.btn-ganti-foto:hover{background:#eef2ff;border-color:#6366f1}
.profile-name{font-size:18px;font-weight:700;color:#1e2d4a;margin-bottom:6px}
.role-badge{display:inline-block;background:#eef2ff;color:#6366f1;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;margin-bottom:6px}
.profile-email{font-size:13px;color:#64748b;margin-bottom:4px}
.profile-branch{font-size:12px;color:#94a3b8}
.profile-divider{border:none;border-top:1px solid #f1f5f9;margin:16px 0}
.stats-row{display:flex;gap:16px;justify-content:center}
.stat-item{text-align:center;flex:1}
.stat-item .lbl{font-size:11px;color:#94a3b8;margin-bottom:2px}
.stat-item .val{font-size:13px;font-weight:600;color:#1e2d4a}
.form-header{border-bottom:1px solid #f1f5f9;padding-bottom:16px;margin-bottom:20px}
.form-header h3{font-size:16px;font-weight:700;color:#1e2d4a}
.form-header p{font-size:13px;color:#64748b;margin-top:4px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.form-grid .full{grid-column:1/-1}
.field-label{display:block;font-size:11px;font-weight:700;color:#374151;letter-spacing:0.06em;margin-bottom:6px;text-transform:uppercase}
.field-input{width:100%;height:46px;border:1.5px solid #e2e8f0;border-radius:10px;padding:0 14px;font-size:14px;outline:none;transition:all .2s}
.field-input:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,0.1)}
.field-input.readonly{background:#f8fafc;color:#94a3b8;cursor:not-allowed}
.btn-simpan{display:inline-flex;align-items:center;gap:8px;background:#6366f1;color:#fff;height:44px;padding:0 28px;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;transition:all .2s;float:right;margin-top:8px}
.btn-simpan:hover{background:#4f46e5;transform:scale(1.02)}
.btn-simpan:disabled{opacity:.6;cursor:not-allowed}
.toggle-pw{background:none;border:none;color:#6366f1;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:4px;padding:8px 0}
.pw-section{max-height:0;overflow:hidden;transition:max-height .3s ease}
.pw-section.open{max-height:200px}
/* Modal crop */
.crop-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);z-index:9999;display:none;align-items:center;justify-content:center}
.crop-overlay.show{display:flex}
.crop-modal{background:#fff;border-radius:20px;width:480px;max-width:calc(100vw - 32px);overflow:hidden}
.crop-head{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #f1f5f9}
.crop-head h4{font-size:15px;font-weight:700;color:#1e2d4a}
.crop-head small{display:block;font-size:12px;color:#64748b;font-weight:400}
.crop-close{background:none;border:none;cursor:pointer;color:#94a3b8;font-size:20px}
.crop-area{background:#1e2d4a;height:360px;position:relative;overflow:hidden}
.crop-area img{display:block;max-width:100%;max-height:100%}
.crop-tools{display:flex;gap:8px;justify-content:center;padding:12px 20px;background:#f8fafc}
.crop-tool-btn{width:40px;height:40px;background:#fff;border:1px solid #e2e8f0;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s}
.crop-tool-btn:hover{background:#eef2ff;border-color:#6366f1}
.crop-tool-btn svg{width:16px;height:16px;stroke:#6366f1;fill:none;stroke-width:2}
.crop-foot{display:flex;justify-content:flex-end;gap:10px;padding:16px 20px}
.crop-btn-cancel{background:transparent;color:#64748b;border:1px solid #e2e8f0;height:42px;border-radius:10px;padding:0 20px;font-size:13px;font-weight:600;cursor:pointer}
.crop-btn-save{background:#6366f1;color:#fff;border:none;height:42px;border-radius:10px;padding:0 20px;font-size:13px;font-weight:600;cursor:pointer}
.crop-btn-save:hover{background:#4f46e5}
.crop-btn-save:disabled{opacity:.6;cursor:not-allowed}
/* CRITICAL: Override Tailwind img rules that break Cropper.js */
.cropper-container img {
    display: block !important;
    height: 100% !important;
    image-orientation: 0deg !important;
    max-height: none !important;
    max-width: none !important;
    min-height: 0 !important;
    min-width: 0 !important;
    width: 100% !important;
}
.cropper-view-box,.cropper-face{border-radius:50%}
.cropper-view-box{outline:2px solid rgba(255,255,255,0.75)}
/* Toast */
.toast-msg{position:fixed;bottom:24px;right:24px;background:#1e2d4a;color:#fff;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:500;z-index:99999;opacity:0;transform:translateY(8px);transition:opacity .3s,transform .3s}
.toast-msg.show{opacity:1;transform:translateY(0)}
@media(max-width:768px){.profile-wrap{grid-template-columns:1fr}.form-grid{grid-template-columns:1fr}}

@keyframes spin{from{transform:rotate(0)}to{transform:rotate(360deg)}}
</style>

<div class="profile-wrap">

    {{-- === LEFT CARD === --}}
    <div class="profile-card" style="text-align:center">
        <div class="avatar-circle">
            @if($user->avatar)
                <img id="fotoProfilPreview" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
            @else
                <div class="avatar-initial" id="fotoProfilInitial">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <img id="fotoProfilPreview" src="" alt="" style="display:none">
            @endif
        </div>

        <button type="button" class="btn-ganti-foto" id="btnGantiFoto">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
            Ganti Foto
        </button>
        <input type="file" id="inputFotoProfil" accept="image/*" style="display:none">

        <div class="profile-name">{{ $user->name }}</div>
        <div><span class="role-badge">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span></div>
        <div class="profile-email">{{ $user->email }}</div>
        @if($user->branch)
            <div class="profile-branch">{{ $user->branch->name }}</div>
        @endif

        <hr class="profile-divider">

        <div class="stats-row">
            <div class="stat-item">
                <div class="lbl">Bergabung</div>
                <div class="val">{{ $user->created_at->format('d M Y') }}</div>
            </div>
            <div class="stat-item">
                <div class="lbl">Status</div>
                <div class="val" style="color:#10b981">● Aktif</div>
            </div>
            <div class="stat-item">
                <div class="lbl">Role</div>
                <div class="val">{{ ucfirst($user->role) }}</div>
            </div>
        </div>
    </div>

    {{-- === RIGHT CARD === --}}
    <div class="profile-card right">
        <div class="form-header">
            <h3>Informasi Akun</h3>
            <p>Perbarui data profil Anda</p>
        </div>

        @if(session('success'))
            <div style="background:#ecfdf5;color:#059669;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" id="formProfile">
            @csrf
            @method('PATCH')

            <div class="form-grid">
                <div class="full">
                    <label class="field-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="field-input" required>
                    @error('name')<p style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</p>@enderror
                </div>

                <div class="full">
                    <label class="field-label">Email</label>
                    <input type="email" value="{{ $user->email }}" class="field-input readonly" disabled>
                </div>

                <div>
                    <label class="field-label">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="field-input" placeholder="08xxxxxxxxxx">
                </div>

                <div>
                    <label class="field-label">Role</label>
                    <input type="text" value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" class="field-input readonly" disabled>
                </div>

                @if($user->branch)
                <div class="full">
                    <label class="field-label">Cabang</label>
                    <input type="text" value="{{ $user->branch->name }}" class="field-input readonly" disabled>
                </div>
                @endif

                <div class="full">
                    <button type="button" class="toggle-pw" onclick="togglePassword()">
                        <span id="pwChevron">▸</span> Ganti Password
                    </button>
                    <div class="pw-section" id="pwSection">
                        <div class="form-grid" style="margin-top:12px">
                            <div>
                                <label class="field-label">Password Baru</label>
                                <input type="password" name="password" class="field-input" placeholder="Min 8 karakter">
                            </div>
                            <div>
                                <label class="field-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="field-input">
                            </div>
                        </div>
                    </div>
                    @error('password')<p style="color:#ef4444;font-size:12px;margin-top:4px">{{ $message }}</p>@enderror
                </div>

                <div class="full" style="text-align:right">
                    <button type="submit" class="btn-simpan" id="btnSimpanProfil">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- === MODAL CROP === --}}
<div class="crop-overlay" id="modalCrop">
    <div class="crop-modal">
        <div class="crop-head">
            <div>
                <h4>Atur Foto Profil</h4>
                <small>Geser dan perbesar untuk mengatur posisi foto</small>
            </div>
            <button class="crop-close" id="btnTutupCrop1">✕</button>
        </div>
        <div class="crop-area">
            <img id="cropImage" src="">
        </div>
        <div class="crop-tools">
            <button class="crop-tool-btn" id="btnRotateL" title="Putar Kiri">
                <svg viewBox="0 0 24 24"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
            </button>
            <button class="crop-tool-btn" id="btnRotateR" title="Putar Kanan">
                <svg viewBox="0 0 24 24"><path d="M23 4v6h-6"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
            </button>
            <button class="crop-tool-btn" id="btnFlip" title="Flip">
                <svg viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 014-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 01-4 4H3"/></svg>
            </button>
            <button class="crop-tool-btn" id="btnZoomIn" title="Zoom In">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </button>
            <button class="crop-tool-btn" id="btnZoomOut" title="Zoom Out">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </button>
        </div>
        <div class="crop-foot">
            <button class="crop-btn-cancel" id="btnTutupCrop2">Batal</button>
            <button class="crop-btn-save" id="btnSimpanFoto">Simpan Foto</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var myProfileCropper = null;
    var currentScaleX = 1;

    // Ganti foto
    document.getElementById('btnGantiFoto').addEventListener('click', function() {
        document.getElementById('inputFotoProfil').click();
    });

    // File dipilih
    document.getElementById('inputFotoProfil').addEventListener('change', function() {
    var file = this.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) { alert('File harus berupa gambar.'); return; }
    if (file.size > 5 * 1024 * 1024) { alert('Ukuran foto maksimal 5MB.'); return; }

    var reader = new FileReader();
    reader.onload = function(e) {
        var cropImg = document.getElementById('cropImage');
        cropImg.src = e.target.result;

        document.getElementById('modalCrop').classList.add('show');

        if (myProfileCropper) { myProfileCropper.destroy(); myProfileCropper = null; }

        cropImg.onload = function() {
            // Wait for modal to be fully rendered before initializing Cropper
            setTimeout(function() {
                myProfileCropper = new Cropper(cropImg, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.8,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    background: false,
                });
            }, 100);
            cropImg.onload = null;
        };
    };
    reader.readAsDataURL(file);
    this.value = '';
});

    function rotateCrop(deg) { if (myProfileCropper) myProfileCropper.rotate(deg); }
    function flipCropH() { if (myProfileCropper) { currentScaleX *= -1; myProfileCropper.scaleX(currentScaleX); } }
    function zoomCrop(r) { if (myProfileCropper) myProfileCropper.zoom(r); }

    // Attach events safely outside Alpine
    document.getElementById('btnRotateL').addEventListener('click', function() { rotateCrop(-90); });
    document.getElementById('btnRotateR').addEventListener('click', function() { rotateCrop(90); });
    document.getElementById('btnFlip').addEventListener('click', function() { flipCropH(); });
    document.getElementById('btnZoomIn').addEventListener('click', function() { zoomCrop(0.1); });
    document.getElementById('btnZoomOut').addEventListener('click', function() { zoomCrop(-0.1); });
    document.getElementById('btnTutupCrop1').addEventListener('click', tutupModalCrop);
    document.getElementById('btnTutupCrop2').addEventListener('click', tutupModalCrop);
    document.getElementById('btnSimpanFoto').addEventListener('click', simpanFotoCrop);

    function tutupModalCrop() {
        document.getElementById('modalCrop').classList.remove('show');
        if (myProfileCropper) { myProfileCropper.destroy(); myProfileCropper = null; }
        currentScaleX = 1;
    }

    document.getElementById('modalCrop').addEventListener('click', function(e) {
        if (e.target === this) tutupModalCrop();
    });

    function simpanFotoCrop() {
        if (!myProfileCropper) { alert('Cropper belum siap.'); return; }
        var btn = document.getElementById('btnSimpanFoto');
        btn.textContent = 'Memproses...';
        btn.disabled = true;

        try {
            var canvas = myProfileCropper.getCroppedCanvas({ width: 400, height: 400, imageSmoothingEnabled: true, imageSmoothingQuality: 'high' });
        if (!canvas) { alert('Gagal crop. Coba gambar lain.'); btn.textContent = 'Simpan Foto'; btn.disabled = false; return; }

        canvas.toBlob(function(blob) {
            if (!blob) { alert('Gagal convert gambar.'); btn.textContent = 'Simpan Foto'; btn.disabled = false; return; }

            // Update preview langsung
            var preview = document.getElementById('fotoProfilPreview');
            preview.src = URL.createObjectURL(blob);
            preview.style.display = 'block';
            var initial = document.getElementById('fotoProfilInitial');
            if (initial) initial.style.display = 'none';

            var fd = new FormData();
            fd.append('foto_profil', blob, 'profil.jpg');
            fd.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("profile.upload-foto") }}', {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function(r) {
                if (!r.ok) throw new Error('Server error: ' + r.status);
                return r.json();
            })
            .then(function(data) {
                if (data.success) {
                    // Update navbar avatar
                    var navAvatars = document.querySelectorAll('header img[alt="Avatar"]');
                    navAvatars.forEach(function(el) { el.src = data.foto_url; });
                    tutupModalCrop();
                    tampilkanToast('Foto profil berhasil diperbarui');
                } else {
                    alert('Gagal: ' + JSON.stringify(data));
                }
            })
            .catch(function(err) { console.error(err); alert('Error: ' + err.message); })
            .finally(function() { btn.textContent = 'Simpan Foto'; btn.disabled = false; });
        }, 'image/jpeg', 0.85);
    } catch(err) {
        console.error(err);
        alert('Error crop: ' + err.message);
        btn.textContent = 'Simpan Foto';
        btn.disabled = false;
    }
}

function tampilkanToast(msg) {
    var t = document.createElement('div');
    t.className = 'toast-msg';
    t.textContent = msg;
    document.body.appendChild(t);
    requestAnimationFrame(function() { t.classList.add('show'); });
    setTimeout(function() { t.classList.remove('show'); setTimeout(function() { t.remove(); }, 300); }, 3000);
}

    function togglePassword() {
        var s = document.getElementById('pwSection');
        var c = document.getElementById('pwChevron');
        s.classList.toggle('open');
        c.textContent = s.classList.contains('open') ? '▾' : '▸';
    }

    document.getElementById('formProfile').addEventListener('submit', function() {
        var btn = document.getElementById('btnSimpanProfil');
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 11-6.219-8.56"/></svg> Menyimpan...';
        btn.disabled = true;
    });

    // Expose togglePassword to global scope so inline onclick="togglePassword()" works
    window.togglePassword = togglePassword;
});
</script>

</x-admin-layout>

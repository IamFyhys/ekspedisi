<section>
    <header class="mb-10">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            Pengaturan Profil
        </h2>
        <p class="mt-2 text-sm text-slate-500 font-medium">Kelola informasi pribadi dan foto profil Anda.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" id="profile-info-form">
        @csrf
        @method('patch')
        <input type="hidden" name="avatar_cropped" id="avatar_cropped_input">
        {{-- Hidden email field so validation passes --}}
        <input type="hidden" name="email" value="{{ $user->email }}">

        <!-- Avatar -->
        <div class="flex flex-col items-center">
            <div class="relative group cursor-pointer" onclick="document.getElementById('avatar_file_input').click()">
                <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-white shadow-2xl bg-slate-100">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-black text-4xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="absolute bottom-1 right-1 w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow-lg border-3 border-white group-hover:bg-slate-900 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                </div>
                <input type="file" id="avatar_file_input" accept="image/*" class="hidden" onchange="handleFileSelect(this)">
            </div>
            <p class="mt-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Klik untuk ubah foto</p>
        </div>

        <!-- Name & Email -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                <input name="name" type="text" value="{{ old('name', $user->name) }}" required
                       class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
                <input type="email" value="{{ $user->email }}" readonly
                       class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold text-slate-400 cursor-not-allowed">
            </div>
        </div>

        <button type="submit" class="bg-slate-900 hover:bg-indigo-600 text-white font-black py-4 px-10 rounded-2xl shadow-xl transition-all text-[11px] uppercase tracking-widest">
            Simpan Perubahan
        </button>
    </form>

    {{-- CROP MODAL - completely outside of any Tailwind/Alpine scope --}}
    <div id="cropModal" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,0.95); flex-direction:column;">
        
        {{-- Top bar --}}
        <div style="display:flex; align-items:center; justify-content:space-between; padding:20px 24px; background:#000;">
            <button type="button" onclick="closeCropModal()" style="color:#fff; background:none; border:none; cursor:pointer; font-size:16px; font-weight:700;">
                ✕ Batal
            </button>
            <span style="color:#fff; font-weight:800; font-size:16px;">Potong Foto</span>
            <button type="button" onclick="doCropAndSave()" id="btnCropSave" style="color:#818cf8; background:none; border:none; cursor:pointer; font-size:16px; font-weight:800;">
                Terapkan ✓
            </button>
        </div>
        
        {{-- Image area - INTENTIONALLY using inline styles only, NO Tailwind --}}
        <div style="flex:1; display:flex; align-items:center; justify-content:center; overflow:hidden; padding:16px;">
            <img id="cropTarget" src="" style="display:block; max-width:100%; max-height:100%;">
        </div>
        
    </div>
</section>

{{-- 
  CRITICAL: These styles MUST override Tailwind's img defaults 
  which break Cropper.js rendering.
--}}
<style>
    /* Fix: Tailwind sets img { max-width:100% } which breaks Cropper.js */
    .cropper-container img {
        max-width: none !important;
        max-height: none !important;
    }
    /* Circle crop overlay like WhatsApp */
    .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
    }
    .cropper-view-box {
        outline: 2px solid rgba(255,255,255,0.8);
    }
    /* Hide resize handles - user only moves the image */
    .cropper-point,
    .cropper-line {
        display: none !important;
    }
</style>

<script>
var myCropper = null;

function handleFileSelect(input) {
    var file = input.files[0];
    if (!file) return;

    var reader = new FileReader();
    reader.onload = function(e) {
        // Destroy old cropper
        if (myCropper) {
            myCropper.destroy();
            myCropper = null;
        }
        
        var img = document.getElementById('cropTarget');
        img.src = e.target.result;
        
        // Show modal
        var modal = document.getElementById('cropModal');
        modal.style.display = 'flex';
        
        // Wait for image to actually load in the DOM before initializing Cropper
        img.onload = function() {
            myCropper = new Cropper(img, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.85,
                background: false,
                guides: false,
                center: true,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
                minContainerWidth: 200,
                minContainerHeight: 200,
            });
        };
    };
    reader.readAsDataURL(file);
}

function doCropAndSave() {
    if (!myCropper) {
        alert('Cropper belum siap. Coba lagi.');
        return;
    }

    var btn = document.getElementById('btnCropSave');
    btn.textContent = 'Memproses...';
    btn.style.pointerEvents = 'none';

    try {
        var canvas = myCropper.getCroppedCanvas({
            width: 500,
            height: 500,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });

        if (!canvas) {
            alert('Gagal memotong gambar. Coba pilih gambar lain.');
            btn.textContent = 'Terapkan ✓';
            btn.style.pointerEvents = 'auto';
            return;
        }

        var base64 = canvas.toDataURL('image/png');
        document.getElementById('avatar_cropped_input').value = base64;
        
        // Force submit the form
        document.getElementById('profile-info-form').submit();
    } catch(err) {
        alert('Error: ' + err.message);
        btn.textContent = 'Terapkan ✓';
        btn.style.pointerEvents = 'auto';
    }
}

function closeCropModal() {
    var modal = document.getElementById('cropModal');
    modal.style.display = 'none';
    if (myCropper) {
        myCropper.destroy();
        myCropper = null;
    }
    document.getElementById('avatar_file_input').value = '';
}
</script>

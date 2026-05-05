<section x-data="passwordForm()">
    <header class="mb-6">
        <h2 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            Update Password
        </h2>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wider">Current Password</label>
            <div class="relative">
                <input id="update_password_current_password" name="current_password" :type="showCurrentPw ? 'text' : 'password'" autocomplete="current-password"
                       class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 pr-12 text-sm font-medium focus:ring-2 focus:ring-indigo-500 dark:text-white transition">
                <button type="button" @click="showCurrentPw = !showCurrentPw" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors" tabindex="-1">
                    <svg x-show="!showCurrentPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="showCurrentPw" style="display:none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wider">New Password</label>
            <div class="relative">
                <input id="update_password_password" name="password" :type="showNewPw ? 'text' : 'password'" autocomplete="new-password"
                       x-model="newPassword" @input="checkStrength()" @keyup="checkMatch()"
                       class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 pr-12 text-sm font-medium focus:ring-2 focus:ring-indigo-500 dark:text-white transition">
                <button type="button" @click="showNewPw = !showNewPw" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors" tabindex="-1">
                    <svg x-show="!showNewPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="showNewPw" style="display:none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                </button>
            </div>
            @error('password', 'updatePassword')
                <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
            @enderror

            <!-- Password Strength Indicator -->
            <div class="mt-3" x-show="newPassword.length > 0">
                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2 overflow-hidden">
                    <div class="h-2 rounded-full transition-all duration-500 ease-out"
                         :class="{
                            'bg-rose-500 w-1/4': strengthLevel === 1,
                            'bg-amber-500 w-2/4': strengthLevel === 2,
                            'bg-emerald-500 w-3/4': strengthLevel === 3,
                            'bg-indigo-600 w-full': strengthLevel === 4
                         }"
                         :style="'width:' + (strengthLevel * 25) + '%'"></div>
                </div>
                <p class="text-[10px] font-bold mt-1.5 uppercase tracking-widest"
                   :class="{
                      'text-rose-500': strengthLevel === 1,
                      'text-amber-500': strengthLevel === 2,
                      'text-emerald-500': strengthLevel === 3,
                      'text-indigo-600': strengthLevel === 4
                   }" x-text="strengthLabel"></p>
            </div>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wider">Confirm Password</label>
            <div class="relative">
                <input id="update_password_password_confirmation" name="password_confirmation" :type="showConfirmPw ? 'text' : 'password'" autocomplete="new-password"
                       x-model="confirmPassword" @keyup="checkMatch()"
                       class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 pr-12 text-sm font-medium focus:ring-2 focus:ring-indigo-500 dark:text-white transition"
                       :class="confirmPassword.length > 0 && !passwordsMatch ? 'ring-2 ring-rose-400' : ''">
                <button type="button" @click="showConfirmPw = !showConfirmPw" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors" tabindex="-1">
                    <svg x-show="!showConfirmPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="showConfirmPw" style="display:none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                </button>
            </div>
            @error('password_confirmation', 'updatePassword')
                <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
            @enderror
            <p x-show="confirmPassword.length > 0 && !passwordsMatch" class="text-xs text-rose-500 mt-2 font-medium" style="display:none;">Passwords do not match.</p>
            <p x-show="confirmPassword.length > 0 && passwordsMatch" class="text-xs text-emerald-500 mt-2 font-medium" style="display:none;">Passwords match!</p>
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" :disabled="!passwordsMatch || newPassword.length === 0"
                    class="bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 disabled:shadow-none disabled:cursor-not-allowed text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-600/20 transition-all text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-emerald-600 font-bold">Password updated!</p>
            @endif
        </div>
    </form>
</section>

<script>
function passwordForm() {
    return {
        showCurrentPw: false,
        showNewPw: false,
        showConfirmPw: false,
        newPassword: '',
        confirmPassword: '',
        strengthLevel: 0,
        strengthLabel: '',
        passwordsMatch: false,
        checkStrength() {
            const pw = this.newPassword;
            let score = 0;
            if (pw.length >= 6) score++;
            if (pw.length >= 10) score++;
            if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
            if (/[0-9]/.test(pw)) score++;
            if (/[^A-Za-z0-9]/.test(pw)) score++;

            if (score <= 1) { this.strengthLevel = 1; this.strengthLabel = 'Weak'; }
            else if (score === 2) { this.strengthLevel = 2; this.strengthLabel = 'Fair'; }
            else if (score === 3) { this.strengthLevel = 3; this.strengthLabel = 'Strong'; }
            else { this.strengthLevel = 4; this.strengthLabel = 'Very Strong'; }
        },
        checkMatch() {
            this.passwordsMatch = this.newPassword.length > 0 && this.newPassword === this.confirmPassword;
        }
    }
}
</script>

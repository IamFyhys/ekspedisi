<section x-data="deleteAccountForm()">
    <header class="mb-6">
        <h2 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600 dark:text-rose-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </div>
            Delete Account
        </h2>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Permanently remove your account and all associated data.</p>
    </header>

    <!-- Warning Card -->
    <div class="bg-rose-50 dark:bg-rose-500/5 border border-rose-200 dark:border-rose-500/20 rounded-2xl p-5 mb-6">
        <div class="flex gap-4">
            <div class="shrink-0 mt-0.5">
                <div class="w-10 h-10 rounded-full bg-rose-100 dark:bg-rose-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                </div>
            </div>
            <div class="space-y-1.5">
                <p class="text-sm font-bold text-rose-700 dark:text-rose-400">Danger Zone — Please read carefully</p>
                <ul class="text-xs text-rose-600 dark:text-rose-400/80 space-y-1">
                    <li class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        All profile data will be permanently deleted
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        This action cannot be undone
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        Download your data before proceeding
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Delete Button -->
    <button type="button" @click="showDeleteModal = true"
            class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-rose-600/20 transition-all text-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
        Delete Account
    </button>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" style="display:none;" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm" @click="showDeleteModal = false"></div>
        <div x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl w-full max-w-md border border-slate-100 dark:border-white/10 overflow-hidden z-10">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="p-8 text-center">
                    <!-- Warning Icon -->
                    <div class="w-16 h-16 rounded-full bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2">Delete account permanently?</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">This action is irreversible. All your data will be lost forever.</p>
                    
                    <div class="text-left mb-6">
                        <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">
                            Type <span class="text-rose-500 font-black">HAPUS</span> to confirm
                        </label>
                        <input type="text" name="confirm_text" x-model="confirmText" @input="validateConfirm()"
                               placeholder="Type HAPUS here..."
                               class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-rose-500 dark:text-white transition"
                               autocomplete="off">
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="showDeleteModal = false; confirmText = ''; canDelete = false;"
                                class="flex-1 px-5 py-3 font-bold text-slate-500 hover:text-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl transition-colors text-sm">
                            Cancel
                        </button>
                        <button type="submit" :disabled="!canDelete"
                                class="flex-1 bg-rose-600 hover:bg-rose-700 disabled:bg-slate-300 dark:disabled:bg-slate-700 disabled:cursor-not-allowed text-white font-bold py-3 px-5 rounded-xl shadow-lg shadow-rose-600/20 disabled:shadow-none transition-all text-sm">
                            Delete Forever
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
function deleteAccountForm() {
    return {
        showDeleteModal: false,
        confirmText: '',
        canDelete: false,
        validateConfirm() {
            this.canDelete = this.confirmText === 'HAPUS';
        }
    }
}
</script>

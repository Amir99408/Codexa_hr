<div class="max-w-lg mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-1 w-full" style="background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8)"></div>

        <div class="p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5)">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900" style="font-family:'Syne',sans-serif">Change Password</h2>
                    <p class="text-xs text-gray-500">Update your account password</p>
                </div>
            </div>

            {{-- Success / Error message --}}
            @if($message)
                <div class="mb-5 flex items-center gap-3 p-4 rounded-xl border
                    {{ $messageType === 'success' ? 'bg-emerald-50 border-emerald-100' : 'bg-red-50 border-red-100' }}">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0
                        {{ $messageType === 'success' ? 'bg-emerald-100' : 'bg-red-100' }}">
                        @if($messageType === 'success')
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        @endif
                    </div>
                    <p class="text-sm font-semibold {{ $messageType === 'success' ? 'text-emerald-700' : 'text-red-700' }}">
                        {{ $message }}
                    </p>
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-5">

                {{-- Current Password --}}
                <div x-data="{ show: false }">
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                        Current Password
                    </label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'"
                               wire:model="current_password"
                               placeholder="Enter your current password"
                               class="w-full px-4 py-2.5 pr-10 text-sm border rounded-xl outline-none transition-all
                                      {{ $errors->has('current_password') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white focus:border-[#0f4c81]' }}"
                               style="font-family:'DM Sans',sans-serif"/>
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0f4c81] transition-colors">
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5 font-medium">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div x-data="{ show: false }">
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                        New Password
                    </label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'"
                               wire:model="new_password"
                               placeholder="Minimum 8 characters"
                               class="w-full px-4 py-2.5 pr-10 text-sm border rounded-xl outline-none transition-all
                                      {{ $errors->has('new_password') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white focus:border-[#0f4c81]' }}"
                               style="font-family:'DM Sans',sans-serif"/>
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0f4c81] transition-colors">
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('new_password')
                        <p class="flex items-center gap-1 text-red-500 text-xs mt-1.5 font-medium">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Confirm New Password --}}
                <div x-data="{ show: false }">
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'"
                               wire:model="new_password_confirmation"
                               placeholder="Repeat new password"
                               class="w-full px-4 py-2.5 pr-10 text-sm border rounded-xl outline-none transition-all
                                      border-gray-200 bg-gray-50 focus:bg-white focus:border-[#0f4c81]"
                               style="font-family:'DM Sans',sans-serif"/>
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0f4c81] transition-colors">
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Password requirements hint --}}
                <p class="text-xs text-gray-400">Password must be at least 8 characters long.</p>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                        style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Password
                </button>

            </form>
        </div>
    </div>

</div>

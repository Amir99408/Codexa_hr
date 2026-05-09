<div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .mesh-bg {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 20% 10%, rgba(15,76,129,0.05) 0px, transparent 50%),
                radial-gradient(at 80% 5%,  rgba(255,107,53,0.04) 0px, transparent 50%);
        }

        @keyframes fadeIn   { from{opacity:0} to{opacity:1} }
        @keyframes scaleUp  { from{opacity:0;transform:scale(0.96) translateY(8px)} to{opacity:1;transform:scale(1) translateY(0)} }
        @keyframes slideDown{ from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }

        .fade-in    { animation: fadeIn    0.25s ease both; }
        .scale-up   { animation: scaleUp   0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }

        .form-input {
            width: 100%;
            padding: 0.5625rem 0.875rem 0.5625rem 2.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            transition: all 0.18s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-input:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .form-input::placeholder { color:#9ca3af; font-weight:400; }

        .form-input-red:focus {
            background: #fff;
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.08);
        }

        .fi-wrap { position: relative; }
        .fi-icon {
            position: absolute; left:0.75rem; top:50%;
            transform: translateY(-50%);
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .fi-wrap:focus-within .fi-icon { color:#0f4c81; }
        .fi-wrap-red:focus-within .fi-icon { color:#ef4444; }

        .pw-toggle {
            position: absolute; right:0.75rem; top:50%;
            transform: translateY(-50%);
            background:none; border:none; cursor:pointer;
            color:#9ca3af; padding:0.125rem;
            transition: color 0.18s;
        }
        .pw-toggle:hover { color:#0f4c81; }
        .form-input-pw { padding-right: 2.5rem; }

        .field-label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 800;
            color: #374151;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .card-stripe-blue { height:2px; background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8); border-radius:1rem 1rem 0 0; }
        .card-stripe-red  { height:2px; background:linear-gradient(90deg,#ef4444,#f87171); border-radius:1rem 1rem 0 0; }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">
        <div class="max-w-2xl mx-auto">

            {{-- ── Page Header ──────────────────────────────────── --}}
            <div class="flex items-center gap-3 mb-8 slide-down">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Settings</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Profile Settings</h2>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">Manage your account</p>
                </div>
            </div>

            {{-- ── Top nav (Company / My Profile) ──────────────── --}}
            <div class="flex items-center gap-2 mb-6">
                <a href="{{ route('settings.company') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Company
                </a>
                <span class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20"
                      style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </span>
            </div>

            {{-- ── Inner tabs + content ─────────────────────────── --}}
            <div x-data="{ tab: 'profile' }" class="scale-up">

                {{-- Tab bar --}}
                <div class="flex bg-white border border-gray-100 rounded-2xl p-1 shadow-sm mb-5">
                    <button type="button"
                            @click="tab = 'profile'"
                            :class="tab === 'profile'
                                ? 'text-white shadow-md shadow-blue-900/20'
                                : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-200"
                            :style="tab === 'profile' ? 'background:linear-gradient(135deg,#0f4c81,#1a6eb5)' : ''">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile Info
                    </button>
                    <button type="button"
                            @click="tab = 'security'; $wire.set('passwordMessage', '')"
                            :class="tab === 'security'
                                ? 'text-white shadow-md shadow-red-500/20'
                                : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-200"
                            :style="tab === 'security' ? 'background:linear-gradient(135deg,#ef4444,#dc2626)' : ''">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Security
                    </button>
                </div>

                {{-- ══ PROFILE INFO tab ══════════════════════════ --}}
                <div x-show="tab === 'profile'" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

                    {{-- Success toast --}}
                    @if($message)
                        <div class="mb-4 flex items-center justify-between gap-4 p-4 bg-white rounded-2xl border border-emerald-100 shadow-sm slide-down">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">{{ $message }}</p>
                            </div>
                            <button wire:click="$set('message', '')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="card-stripe-blue"></div>
                        <div class="p-6">

                            <form wire:submit.prevent="updateProfile" class="space-y-5">

                                {{-- Avatar --}}
                                <div class="flex items-center gap-4 pb-5 border-b border-gray-100">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 shadow-sm border-2 border-gray-100"
                                         style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                        @if($new_photo)
                                            <img src="{{ $new_photo->temporaryUrl() }}" class="w-full h-full object-cover"/>
                                        @elseif(auth()->user()->photo)
                                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-full h-full object-cover"/>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-white text-2xl font-extrabold">
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-bold text-gray-700 mb-1">Profile Photo</p>
                                        <input wire:model="new_photo"
                                               type="file"
                                               accept="image/png, image/jpeg"
                                               class="text-xs text-gray-500
                                                      file:mr-3 file:py-1.5 file:px-3
                                                      file:rounded-lg file:border-0
                                                      file:text-xs file:font-bold file:text-white
                                                      file:cursor-pointer"
                                               style="--file-bg:#0f4c81;"/>
                                        <p class="text-[11px] text-gray-400 mt-1">JPG, PNG — max 2MB. Saves automatically.</p>
                                        <div wire:loading wire:target="new_photo" class="mt-1 flex items-center gap-1.5 text-[11px] text-[#0f4c81] font-semibold">
                                            <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                            </svg>
                                            Uploading...
                                        </div>
                                    </div>
                                </div>

                                {{-- Name --}}
                                <div>
                                    <label class="field-label">Full Name <span class="text-red-400 normal-case tracking-normal">*</span></label>
                                    <div class="fi-wrap">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <input wire:model="name" type="text" placeholder="John Doe"
                                               class="form-input {{ $errors->has('name') ? 'border-red-300' : '' }}"/>
                                    </div>
                                    @error('name')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label class="field-label">Email Address <span class="text-red-400 normal-case tracking-normal">*</span></label>
                                    <div class="fi-wrap">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <input wire:model="email" type="email" placeholder="you@company.com"
                                               class="form-input {{ $errors->has('email') ? 'border-red-300' : '' }}"/>
                                    </div>
                                    @error('email')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                                <div class="flex items-center justify-between">
                                    <p class="text-[11px] text-gray-400"><span class="text-red-400">*</span> Required fields</p>
                                    <button type="submit"
                                            class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                                            style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Save Profile
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                {{-- ══ SECURITY tab ══════════════════════════════ --}}
                <div x-show="tab === 'security'" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                     style="display:none">

                    {{-- Success toast --}}
                    @if($passwordMessage)
                        <div class="mb-4 flex items-center justify-between gap-4 p-4 bg-white rounded-2xl border border-emerald-100 shadow-sm slide-down">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">{{ $passwordMessage }}</p>
                            </div>
                            <button wire:click="$set('passwordMessage', '')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="card-stripe-red"></div>
                        <div class="p-6">

                            <p class="text-xs text-gray-400 mb-5">Choose a strong password you don't use anywhere else.</p>

                            <form wire:submit.prevent="updatePassword" class="space-y-4">

                                {{-- Current Password --}}
                                <div x-data="{ show: false }">
                                    <label class="field-label">Current Password</label>
                                    <div class="fi-wrap fi-wrap-red">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <input wire:model="current_password" :type="show ? 'text' : 'password'"
                                               placeholder="••••••••"
                                               class="form-input form-input-pw form-input-red {{ $errors->has('current_password') ? 'border-red-300' : '' }}"/>
                                        <button type="button" class="pw-toggle" @click="show = !show">
                                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- New Password --}}
                                <div x-data="{ show: false }">
                                    <label class="field-label">New Password</label>
                                    <div class="fi-wrap fi-wrap-red">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                        <input wire:model="new_password" :type="show ? 'text' : 'password'"
                                               placeholder="Min. 8 characters"
                                               class="form-input form-input-pw form-input-red {{ $errors->has('new_password') ? 'border-red-300' : '' }}"/>
                                        <button type="button" class="pw-toggle" @click="show = !show">
                                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div x-data="{ show: false }">
                                    <label class="field-label">Confirm New Password</label>
                                    <div class="fi-wrap fi-wrap-red">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <input wire:model="new_password_confirmation" :type="show ? 'text' : 'password'"
                                               placeholder="Repeat new password"
                                               class="form-input form-input-pw form-input-red"/>
                                        <button type="button" class="pw-toggle" @click="show = !show">
                                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-200"
                                            style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Update Password
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>{{-- end x-data tabs --}}

        </div>
    </div>
</div>

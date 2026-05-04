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
            font-weight: 600;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            transition: all 0.18s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 0.5px;
        }
        .form-input:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .form-input::placeholder { color:#9ca3af; font-weight:400; letter-spacing:0; }

        .fi-wrap { position: relative; }
        .fi-icon {
            position: absolute; left:0.75rem; top:50%;
            transform: translateY(-50%);
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .fi-wrap:focus-within .fi-icon { color:#0f4c81; }

        .field-label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 800;
            color: #374151;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.875rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .section-label span {
            font-size: 0.8125rem;
            font-weight: 800;
            color: #111827;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, #f3f4f6, transparent);
        }

        .card-stripe { height:2px; background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8); border-radius:1rem 1rem 0 0; }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">
        <div class="max-w-3xl mx-auto">

            {{-- Page Header --}}
            <div class="flex items-center gap-3 mb-8 slide-down">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Settings</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">License Settings</h2>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">Manage your DevStaq HR license</p>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="flex items-center gap-2 mb-6 flex-wrap">
                <a href="{{ route('settings.company') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Company
                </a>
                <a href="{{ route('settings.profile') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </a>
                <span class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20"
                      style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    License
                </span>
            </div>

            {{-- Toast --}}
            @if($message)
                <div class="mb-6 flex items-center justify-between gap-4 p-4 bg-white rounded-2xl border shadow-sm slide-down
                    {{ $messageType === 'success' ? 'border-emerald-100' : 'border-red-100' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0
                            {{ $messageType === 'success' ? 'bg-emerald-50' : 'bg-red-50' }}">
                            @if($messageType === 'success')
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
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

            <div class="space-y-5 scale-up">

                {{-- License Status Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="card-stripe"></div>
                    <div class="p-6">
                        <div class="section-label">
                            <svg class="w-4 h-4 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>License Status</span>
                        </div>

                        @if($licenseInfo)
                            @php
                                $isValid  = $licenseInfo['valid'] ?? false;
                                $status   = $licenseInfo['status'] ?? ($licenseInfo['reason'] ?? 'unknown');
                                $plan     = $licenseInfo['plan'] ?? 'N/A';
                                $expires  = $licenseInfo['expires_at'] ?? null;
                            @endphp
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                    <p class="text-xs font-700 text-gray-400 uppercase tracking-wider mb-2">Status</p>
                                    @if($isValid)
                                        <span class="status-pill" style="background:#f0fdf4;color:#16a34a;">
                                            <span class="status-dot" style="background:#16a34a;"></span>
                                            Active
                                        </span>
                                    @elseif($status === 'suspended')
                                        <span class="status-pill" style="background:#fff7ed;color:#c2410c;">
                                            <span class="status-dot" style="background:#f97316;"></span>
                                            Suspended
                                        </span>
                                    @else
                                        <span class="status-pill" style="background:#fef2f2;color:#dc2626;">
                                            <span class="status-dot" style="background:#ef4444;"></span>
                                            {{ ucfirst($status) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                    <p class="text-xs font-700 text-gray-400 uppercase tracking-wider mb-2">Plan</p>
                                    <p class="text-sm font-bold text-gray-800">{{ $plan }}</p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                    <p class="text-xs font-700 text-gray-400 uppercase tracking-wider mb-2">Expires</p>
                                    <p class="text-sm font-bold text-gray-800">
                                        {{ $expires ? \Carbon\Carbon::parse($expires)->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-gray-500">No license information available.</p>
                            </div>
                        @endif

                        <div class="mt-4 flex justify-end">
                            <button wire:click="refresh"
                                    class="flex items-center gap-2 px-4 py-2 text-xs font-700 text-[#0f4c81] bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors border border-blue-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Refresh Status
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Update License Key --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="card-stripe"></div>
                    <div class="p-6">
                        <div class="section-label">
                            <svg class="w-4 h-4 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            <span>Update License Key</span>
                        </div>

                        <form wire:submit="save">
                            <div class="mb-5">
                                <label class="field-label">License Key</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    <input
                                        type="text"
                                        wire:model="license_key"
                                        class="form-input"
                                        placeholder="XXXX-****-****-XXXX"
                                        autocomplete="off"
                                        spellcheck="false"
                                    >
                                </div>
                                @error('license_key')
                                    <p class="text-xs text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-400 mt-1.5">Current key is masked for security. Enter a new key to update.</p>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white rounded-xl shadow-sm transition-all hover:opacity-90"
                                        style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Verify & Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Support --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="section-label">
                        <svg class="w-4 h-4 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Need Help?</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <a href="https://devstaq3.com" target="_blank"
                           class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-gray-100 transition-colors text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 text-[#0f4c81] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="1.8"/>
                                <path d="M2 12h20M12 2c-2.5 3-4 6.5-4 10s1.5 7 4 10M12 2c2.5 3 4 6.5 4 10s-1.5 7-4 10" stroke-linecap="round" stroke-width="1.8"/>
                            </svg>
                            devstaq3.com
                        </a>
                        <a href="mailto:support@devstaq3.com"
                           class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-gray-100 transition-colors text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 text-[#0f4c81] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            support@devstaq3.com
                        </a>
                        <a href="https://wa.me/923001234567" target="_blank"
                           class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-gray-100 transition-colors text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.979-1.406A9.96 9.96 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" stroke="#25d366" stroke-width="1.8" stroke-linejoin="round"/>
                                <path d="M8.5 9.5c.5 1 1.5 3 3.5 4s3-1 3-1-.5-1.5-1-1.5-1 .5-1 .5c-.5 0-2-1-2.5-2.5 0 0 .5-.5.5-1S9 7.5 9 7.5 8 8.5 8.5 9.5z" stroke="#25d366" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            +92 300 123 4567
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

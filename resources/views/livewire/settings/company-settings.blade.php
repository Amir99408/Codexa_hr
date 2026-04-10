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

        /* ── Form inputs ──────────────────────────────────────── */
        .form-input, .form-select, .form-textarea {
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
        .form-select { appearance: none; cursor: pointer; }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .form-input::placeholder, .form-textarea::placeholder { color:#9ca3af; font-weight:400; }
        .form-textarea { resize: none; padding-top: 0.625rem; }

        .fi-wrap { position: relative; }
        .fi-icon {
            position: absolute; left:0.75rem; top:50%;
            transform: translateY(-50%);
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .fi-icon-top {
            position: absolute; left:0.75rem; top:0.75rem;
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
        }
        .fi-wrap:focus-within .fi-icon,
        .fi-wrap:focus-within .fi-icon-top { color:#0f4c81; }

        /* ── Field label ──────────────────────────────────────── */
        .field-label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 800;
            color: #374151;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* ── Section divider ──────────────────────────────────── */
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

        /* ── Card stripe ──────────────────────────────────────── */
        .card-stripe { height:2px; background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8); border-radius:1rem 1rem 0 0; }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">
        <div class="max-w-3xl mx-auto">

            {{-- ── Page Header ──────────────────────────────────── --}}
            <div class="flex items-center gap-3 mb-8 slide-down">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Settings</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Company Settings</h2>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">Manage your company information</p>
                </div>
            </div>

            {{-- ── Tabs ─────────────────────────────────────────── --}}
            <div class="flex items-center gap-2 mb-6">
                <span class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20"
                      style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Company
                </span>
                <a href="{{ route('settings.profile') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </a>
            </div>

            {{-- ── Toast ───────────────────────────────────────── --}}
            @if($message)
                <div class="mb-6 flex items-center justify-between gap-4 p-4 bg-white rounded-2xl border border-emerald-100 shadow-sm slide-down">
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

            <form wire:submit="save" class="space-y-5 scale-up">

                {{-- ── Company Information ──────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="card-stripe"></div>
                    <div class="p-6">
                        <div class="section-label">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span>Company Information</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- Company Name --}}
                            <div class="md:col-span-2">
                                <label class="field-label">Company Name <span class="text-red-500 normal-case tracking-normal">*</span></label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <input wire:model="company_name" type="text" placeholder="Acme Corporation" class="form-input"/>
                                </div>
                                @error('company_name')
                                    <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="field-label">Email</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <input wire:model="company_email" type="email" placeholder="hello@company.com" class="form-input"/>
                                </div>
                                @error('company_email')
                                    <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label class="field-label">Phone</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <input wire:model="company_phone" type="text" placeholder="+1 234 567 8900" class="form-input"/>
                                </div>
                            </div>

                            {{-- Website --}}
                            <div>
                                <label class="field-label">Website</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <input wire:model="company_website" type="text" placeholder="https://company.com" class="form-input"/>
                                </div>
                            </div>

                            {{-- Working Days --}}
                            <div>
                                <label class="field-label">Working Days / Month</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <input wire:model="working_days" type="number" min="1" max="31" placeholder="26" class="form-input"/>
                                </div>
                                @error('working_days')
                                    <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="md:col-span-2">
                                <label class="field-label">Address</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon-top" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <textarea wire:model="company_address" rows="2" placeholder="123 Business St, City, Country" class="form-textarea"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Localization ──────────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-0.5 w-full" style="background:linear-gradient(90deg,#ff6b35,#f97316,#fbbf24)"></div>
                    <div class="p-6">
                        <div class="section-label">
                            <div class="w-7 h-7 rounded-lg bg-orange-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-[#ff6b35]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span>Localization</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <div>
                                <label class="field-label">Currency</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <select wire:model="currency" class="form-select">
                                        <option value="PKR">PKR — Pakistani Rupee</option>
                                        <option value="USD">USD — US Dollar</option>
                                        <option value="EUR">EUR — Euro</option>
                                        <option value="GBP">GBP — British Pound</option>
                                        <option value="AED">AED — UAE Dirham</option>
                                        <option value="SAR">SAR — Saudi Riyal</option>
                                        <option value="INR">INR — Indian Rupee</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Timezone</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <select wire:model="timezone" class="form-select">
                                        <option value="Asia/Karachi">Asia/Karachi (PKT)</option>
                                        <option value="Asia/Dubai">Asia/Dubai (GST)</option>
                                        <option value="Asia/Riyadh">Asia/Riyadh (AST)</option>
                                        <option value="Asia/Kolkata">Asia/Kolkata (IST)</option>
                                        <option value="America/New_York">America/New_York (EST)</option>
                                        <option value="Europe/London">Europe/London (GMT)</option>
                                        <option value="UTC">UTC</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Date Format</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <select wire:model="date_format" class="form-select">
                                        <option value="d M Y">01 Jan 2026</option>
                                        <option value="d/m/Y">01/01/2026</option>
                                        <option value="m/d/Y">01/01/2026 (US)</option>
                                        <option value="Y-m-d">2026-01-01</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Language ──────────────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-0.5 w-full" style="background:linear-gradient(90deg,#7c3aed,#a78bfa,#c4b5fd)"></div>
                    <div class="p-6">
                        <div class="section-label">
                            <div class="w-7 h-7 rounded-lg bg-violet-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                            </div>
                            <span>Language</span>
                        </div>

                        <div class="flex flex-wrap gap-2.5">
                            <a href="{{ route('language.switch', 'en') }}"
                               class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-150
                                      {{ app()->getLocale() === 'en' ? 'text-white shadow-lg shadow-blue-900/20' : 'border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 shadow-sm' }}"
                               @if(app()->getLocale() === 'en') style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);" @endif>
                                🇬🇧 English
                            </a>
                            <a href="{{ route('language.switch', 'ur') }}"
                               class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-150
                                      {{ app()->getLocale() === 'ur' ? 'text-white shadow-lg shadow-blue-900/20' : 'border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 shadow-sm' }}"
                               @if(app()->getLocale() === 'ur') style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);" @endif>
                                🇵🇰 اردو
                            </a>
                            <a href="{{ route('language.switch', 'ar') }}"
                               class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-150
                                      {{ app()->getLocale() === 'ar' ? 'text-white shadow-lg shadow-blue-900/20' : 'border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 shadow-sm' }}"
                               @if(app()->getLocale() === 'ar') style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);" @endif>
                                🇸🇦 عربي
                            </a>
                        </div>
                        <p class="text-[11px] text-gray-400 font-medium mt-3">Page will reload when you switch language.</p>
                    </div>
                </div>

                {{-- ── Divider + Save ────────────────────────────── --}}
                <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                <div class="flex items-center justify-between">
                    <p class="text-[11px] text-gray-400 font-medium">
                        <span class="text-red-400">*</span> Required fields
                    </p>
                    <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                            style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Settings
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
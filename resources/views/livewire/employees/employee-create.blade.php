<div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .mesh-bg {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 15% 10%, rgba(15, 76, 129, 0.06) 0px, transparent 50%),
                radial-gradient(at 85% 5%, rgba(255, 107, 53, 0.05) 0px, transparent 50%),
                radial-gradient(at 90% 90%, rgba(15, 76, 129, 0.04) 0px, transparent 50%);
        }

        /* Slide-up entrance */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            animation: slideUp 0.45s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        .delay-1 {
            animation-delay: 0.05s;
        }

        .delay-2 {
            animation-delay: 0.10s;
        }

        .delay-3 {
            animation-delay: 0.15s;
        }

        .delay-4 {
            animation-delay: 0.20s;
        }

        /* Input focus enhancement */
        .field-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            background: #fafafa;
            color: #111827;
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .field-input:focus {
            border-color: #0f4c81;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(15, 76, 129, 0.08), 0 2px 8px rgba(15, 76, 129, 0.06);
        }

        .field-input::placeholder {
            color: #9ca3af;
        }

        .field-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.375rem;
            letter-spacing: -0.01em;
        }

        /* Icon-prefixed input wrapper */
        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #9ca3af;
            transition: color 0.18s;
        }

        .input-icon-wrap:focus-within .input-icon {
            color: #0f4c81;
        }

        .input-icon-wrap .field-input {
            padding-left: 2.5rem;
        }

        /* Currency badge input */
        .salary-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .salary-badge {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            padding: 0 0.75rem;
            background: #f1f5f9;
            border: 1.5px solid #e5e7eb;
            border-right: none;
            border-radius: 0.75rem 0 0 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.03em;
            transition: border-color 0.18s;
        }

        .salary-wrap:focus-within .salary-badge {
            border-color: #0f4c81;
        }

        .salary-wrap .field-input {
            padding-left: 3.5rem;
            border-radius: 0 0.75rem 0.75rem 0;
        }

        .salary-wrap:focus-within .field-input {
            border-color: #0f4c81;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15, 76, 129, 0.08), 0 2px 8px rgba(15, 76, 129, 0.06);
        }

        /* Toggle switch */
        .toggle-track {
            width: 2.75rem;
            height: 1.5rem;
            background: #e5e7eb;
            border-radius: 9999px;
            position: relative;
            transition: background 0.22s;
            cursor: pointer;
            flex-shrink: 0;
        }

        .toggle-track.on {
            background: #0f4c81;
        }

        .toggle-thumb {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 1.125rem;
            height: 1.125rem;
            background: white;
            border-radius: 50%;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.18);
            transition: transform 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-track.on .toggle-thumb {
            transform: translateX(1.25rem);
        }

        /* Step sidebar */
        .step-dot {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
            flex-shrink: 0;
            transition: all 0.22s;
        }

        .step-dot.active {
            background: #0f4c81;
            color: white;
            box-shadow: 0 4px 12px rgba(15, 76, 129, 0.3);
        }

        .step-dot.complete {
            background: #ecfdf5;
            color: #059669;
            border: 2px solid #059669;
        }

        .step-dot.pending {
            background: #f8fafc;
            color: #9ca3af;
            border: 2px solid #e5e7eb;
        }

        .step-line {
            width: 2px;
            height: 2.5rem;
            margin-left: calc(1rem - 1px);
            background: linear-gradient(to bottom, #e5e7eb, #f1f5f9);
            border-radius: 9999px;
        }

        /* Section card header badge */
        .section-badge {
            width: 2rem;
            height: 2rem;
            border-radius: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        /* Credential fields reveal */
        .credential-reveal {
            overflow: hidden;
            transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s;
        }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">
        <div class="max-w-5xl mx-auto">

            {{-- ── Page Header ───────────────────────────────────────── --}}
            <div class="flex items-center gap-4 mb-8 slide-up">
                <a href="{{ route('employees.index') }}"
                    class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-500 hover:text-[#0f4c81] hover:border-[#0f4c81] hover:bg-blue-50 rounded-xl shadow-sm transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR
                            Management</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">New Employee</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Add New Employee</h2>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">Complete all sections to register a new team
                        member</p>
                </div>

                {{-- Progress pills --}}
                <div class="hidden lg:flex items-center gap-1.5">
                    <span class="text-xs font-semibold text-[#0f4c81] bg-blue-50 px-3 py-1.5 rounded-full">3
                        sections</span>
                    <span class="text-xs font-semibold text-gray-400 bg-gray-50 px-3 py-1.5 rounded-full">~2 min</span>
                </div>
            </div>

            {{-- ── Two-column layout: sidebar + form ─────────────────── --}}
            <div class="flex gap-7 items-start">

                {{-- Step Sidebar (desktop) ──────────────────────────── --}}
                <div class="hidden lg:block w-52 flex-shrink-0 sticky top-8">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-4">Form Sections</p>

                        {{-- Step 1 --}}
                        <div class="flex items-start gap-3">
                            <div class="flex flex-col items-center">
                                <div class="step-dot active">1</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-xs font-bold text-[#0f4c81]">Personal Info</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Name, phone, DOB</p>
                            </div>
                        </div>

                        {{-- Step 2 --}}
                        <div class="flex items-start gap-3">
                            <div class="flex flex-col items-center">
                                <div class="step-dot pending">2</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-xs font-semibold text-gray-500">Job Information</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Role, dept, salary</p>
                            </div>
                        </div>

                        {{-- Step 3 --}}
                        <div class="flex items-start gap-3">
                            <div class="flex flex-col items-center">
                                <div class="step-dot pending">3</div>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-xs font-semibold text-gray-500">Portal Access</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Login credentials</p>
                            </div>
                        </div>

                        {{-- Tip card --}}
                        <div class="mt-5 p-3 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="flex items-center gap-1.5 mb-1">
                                <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-[10px] font-bold text-[#0f4c81] uppercase tracking-wider">Tip</span>
                            </div>
                            <p class="text-[11px] text-blue-600/80 leading-relaxed">Fields marked with <span
                                    class="text-red-500 font-bold">*</span> are required to save the employee.</p>
                        </div>
                    </div>
                </div>

                {{-- ── Form ────────────────────────────────────────────── --}}
                <form wire:submit="save" class="flex-1 space-y-5 min-w-0">

                    {{-- ── Section 1: Personal Information ───────────── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden slide-up delay-1">
                        {{-- Card header --}}
                        <div
                            class="flex items-center gap-3.5 px-6 py-4 border-b border-gray-50 bg-gradient-to-r from-white to-blue-50/40">
                            <div
                                class="section-badge bg-gradient-to-br from-[#0f4c81] to-[#1a6eb5] text-white shadow-lg shadow-blue-900/20">
                                1</div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-gray-900">Personal Information</h3>
                                <p class="text-[11px] text-gray-400 font-medium">Basic personal details of the employee
                                </p>
                            </div>
                            <svg class="w-4 h-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>

                        <div class="p-6 space-y-5">
                            {{-- First / Last Name --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <input wire:model="first_name" type="text" placeholder="John"
                                            class="field-input" />
                                    </div>
                                    @error('first_name')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">
                                        Last Name <span class="text-red-500">*</span>
                                    </label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <input wire:model="last_name" type="text" placeholder="Doe"
                                            class="field-input" />
                                    </div>
                                    @error('last_name')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Phone / Gender --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Phone</label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <input wire:model="phone" type="text" placeholder="+92 300 0000000"
                                            class="field-input" />
                                    </div>
                                    @error('phone')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Gender</label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <select wire:model="gender"
                                            class="field-input appearance-none cursor-pointer">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- DOB / Address --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Date of Birth</label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <input wire:model="date_of_birth" type="date" class="field-input" />
                                    </div>
                                    @error('date_of_birth')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Address</label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <input wire:model="address" type="text"
                                            placeholder="Street, City, Country" class="field-input" />
                                    </div>
                                    @error('address')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            </div>
                            <div class="flex items-center gap-5 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div id="photo-preview-create"
                                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#0f4c81] to-blue-400 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0 overflow-hidden">
                                    {{ strtoupper(substr($first_name ?: 'E', 0, 1)) }}
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                                    <input wire:model="photo" type="file" accept="image/*"
                                        onchange="previewPhoto(this, 'photo-preview-create')"
                                        class="text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                                         file:bg-[#0f4c81] file:text-white file:text-xs file:font-medium
                                         file:cursor-pointer hover:file:bg-blue-800" />
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG — max 2MB</p>
                                    @error('photo')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Section 2: Job Information ─────────────────── --}}
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden slide-up delay-2">
                        <div
                            class="flex items-center gap-3.5 px-6 py-4 border-b border-gray-50 bg-gradient-to-r from-white to-orange-50/40">
                            <div
                                class="section-badge bg-gradient-to-br from-[#ff6b35] to-orange-400 text-white shadow-lg shadow-orange-400/20">
                                2</div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-gray-900">Job Information</h3>
                                <p class="text-[11px] text-gray-400 font-medium">Role, department, salary and
                                    employment details</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <div class="p-6 space-y-5">
                            {{-- Designation / Department --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Designation</label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <input wire:model="designation" type="text"
                                            placeholder="e.g. Software Engineer" class="field-input" />
                                    </div>
                                    @error('designation')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Department</label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <select wire:model="department_id"
                                            class="field-input appearance-none cursor-pointer">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('department_id')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Join Date / Status --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">
                                        Join Date <span class="text-red-500">*</span>
                                    </label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <input wire:model="join_date" type="date" class="field-input" />
                                    </div>
                                    @error('join_date')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Employment Status</label>
                                    <div class="input-icon-wrap">
                                        <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <select wire:model="status"
                                            class="field-input appearance-none cursor-pointer">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="terminated">Terminated</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Basic Salary --}}
                            <div>
                                <label class="field-label">
                                    Basic Salary <span class="text-red-500">*</span>
                                </label>
                                <div class="salary-wrap">
                                    <span class="salary-badge">PKR</span>
                                    <input wire:model="basic_salary" type="number" placeholder="50,000"
                                        class="field-input w-full" style="padding-left:3.75rem;" />
                                </div>
                                @error('basic_salary')
                                    <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── Section 3: Portal Access ───────────────────── --}}
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden slide-up delay-3">
                        <div
                            class="flex items-center gap-3.5 px-6 py-4 border-b border-gray-50 bg-gradient-to-r from-white to-emerald-50/40">
                            <div
                                class="section-badge bg-gradient-to-br from-emerald-600 to-emerald-400 text-white shadow-lg shadow-emerald-400/20">
                                3</div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-gray-900">Portal Access</h3>
                                <p class="text-[11px] text-gray-400 font-medium">Set up login credentials for the
                                    employee portal</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>

                        <div class="p-6">
                            {{-- Toggle row --}}
                            <label
                                class="flex items-center justify-between p-4 rounded-xl bg-gray-50 hover:bg-gray-100/60 border border-gray-100 cursor-pointer transition-colors duration-150 group">
                                <div class="flex items-center gap-3.5">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-emerald-50 group-hover:bg-emerald-100 flex items-center justify-center transition-colors">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Create Employee Login Account</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Employee can log in to the self-service
                                            portal</p>
                                    </div>
                                </div>

                                {{-- Visual toggle (the real checkbox is hidden, Livewire controls state) --}}
                                <div class="toggle-track {{ $create_account ? 'on' : '' }}">
                                    <div class="toggle-thumb"></div>
                                </div>
                                <input wire:model.live="create_account" type="checkbox" class="sr-only" />
                            </label>

                            {{-- Credential fields --}}
                            @if ($create_account)
                                <div class="mt-5 pt-5 border-t border-gray-50 space-y-5">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span
                                            class="text-[10px] font-bold tracking-widest text-emerald-600/70 uppercase">Login
                                            Credentials</span>
                                        <div class="flex-1 h-px bg-emerald-100"></div>
                                    </div>

                                    <div>
                                        <label class="field-label">
                                            Login Email <span class="text-red-500">*</span>
                                        </label>
                                        <div class="input-icon-wrap">
                                            <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                            <input wire:model="account_email" type="email"
                                                placeholder="employee@company.com" class="field-input" />
                                        </div>
                                        @error('account_email')
                                            <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="field-label">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <div class="input-icon-wrap">
                                            <svg class="input-icon w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            <input wire:model="account_password" type="password"
                                                placeholder="Min. 8 characters" class="field-input" />
                                        </div>
                                        @error('account_password')
                                            <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror

                                        {{-- Password hint --}}
                                        <div
                                            class="flex items-center gap-1.5 mt-2 p-2.5 bg-blue-50 rounded-lg border border-blue-100">
                                            <svg class="w-3.5 h-3.5 text-[#0f4c81] flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-[11px] text-blue-600/80">Use at least 8 characters with a
                                                mix of letters and numbers for a strong password.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ── Action Buttons ─────────────────────────────── --}}
                    <div
                        class="slide-up delay-4 flex items-center justify-between gap-3 bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4">
                        <div class="flex items-center gap-2 text-[11px] text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Data is saved securely
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('employees.index') }}"
                                class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="flex items-center gap-2 px-6 py-2.5 bg-[#0f4c81] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-900/20 hover:bg-blue-800 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Save Employee
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

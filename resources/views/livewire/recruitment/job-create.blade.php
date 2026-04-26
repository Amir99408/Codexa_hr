<div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .mesh-bg {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 15% 10%, rgba(15,76,129,0.06) 0px, transparent 50%),
                radial-gradient(at 85% 5%,  rgba(255,107,53,0.05) 0px, transparent 50%),
                radial-gradient(at 90% 90%, rgba(15,76,129,0.04) 0px, transparent 50%);
        }

        @keyframes slideUp {
            from { opacity:0; transform:translateY(18px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .slide-up  { animation: slideUp 0.45s cubic-bezier(0.4,0,0.2,1) both; }
        .delay-1   { animation-delay: 0.05s; }
        .delay-2   { animation-delay: 0.10s; }
        .delay-3   { animation-delay: 0.15s; }

        /* Field styles */
        .field-input, .field-select, .field-textarea {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.5rem;
            font-size: 0.875rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            background: #fafafa;
            color: #111827;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
            outline: none;
        }
        .field-textarea {
            resize: none;
            padding-top: 0.75rem;
            line-height: 1.6;
        }
        .field-select { appearance: none; cursor: pointer; }
        .field-input:focus, .field-select:focus, .field-textarea:focus {
            border-color: #0f4c81;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .field-input::placeholder,
        .field-textarea::placeholder { color:#9ca3af; font-weight:400; }

        /* Icon wrapper */
        .fi-wrap { position: relative; }
        .fi-wrap .fi {
            position: absolute; left: 0.75rem; top: 50%;
            transform: translateY(-50%);
            pointer-events: none; color: #9ca3af;
            width: 1rem; height: 1rem;
            transition: color 0.18s;
        }
        .fi-wrap.top .fi { top: 0.9rem; transform: none; }
        .fi-wrap:focus-within .fi { color: #0f4c81; }

        /* Salary range dual input */
        .salary-badge {
            position: absolute; left:0; top:0; bottom:0;
            display:flex; align-items:center;
            padding: 0 0.75rem;
            background: #f1f5f9;
            border: 1.5px solid #e5e7eb;
            border-right: none;
            border-radius: 0.75rem 0 0 0.75rem;
            font-size: 0.7rem; font-weight: 800;
            color: #64748b; letter-spacing: 0.03em;
            transition: border-color 0.18s;
        }
        .salary-wrap { position: relative; display: flex; align-items: center; }
        .salary-wrap:focus-within .salary-badge { border-color: #0f4c81; }
        .salary-wrap .field-input {
            padding-left: 3.75rem;
            border-radius: 0 0.75rem 0.75rem 0;
        }
        .salary-wrap:focus-within .field-input {
            border-color: #0f4c81;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }

        /* Field label */
        .field-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.4rem;
            letter-spacing: -0.01em;
        }

        /* Section badge */
        .section-badge {
            width: 2rem; height: 2rem;
            border-radius: 0.625rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 800;
            flex-shrink: 0;
        }

        /* Step sidebar */
        .step-dot {
            width: 2rem; height: 2rem;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 800; flex-shrink: 0;
            transition: all 0.22s;
        }
        .step-dot.active  { background:#0f4c81; color:#fff; box-shadow:0 4px 12px rgba(15,76,129,0.3); }
        .step-dot.pending { background:#f8fafc; color:#9ca3af; border:2px solid #e5e7eb; }
        .step-line {
            width:2px; height:2.5rem;
            margin-left: calc(1rem - 1px);
            background: linear-gradient(to bottom,#e5e7eb,#f1f5f9);
            border-radius:9999px;
        }

        /* Error message */
        .field-error {
            display: flex; align-items: center; gap: 0.25rem;
            color: #ef4444; font-size: 0.6875rem; font-weight: 600; margin-top: 0.375rem;
        }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">
        <div class="max-w-5xl mx-auto">

            {{-- ── Page Header ──────────────────────────────────── --}}
            <div class="flex items-center gap-4 mb-8 slide-up">
                <a href="{{ route('recruitment.jobs') }}"
                   class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-500 hover:text-[#0f4c81] hover:border-[#0f4c81] hover:bg-blue-50 rounded-xl shadow-sm transition-all duration-200 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">Recruitment</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                            {{ $editId ? 'Edit Job' : 'New Job' }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                        {{ $editId ? 'Edit Job Posting' : 'Post New Job' }}
                    </h2>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">
                        {{ $editId ? 'Update the job details below' : 'Fill in the details to create a new job posting' }}
                    </p>
                </div>
                <div class="hidden lg:flex items-center gap-1.5">
                    <span class="text-xs font-semibold text-[#0f4c81] bg-blue-50 px-3 py-1.5 rounded-full">2 sections</span>
                    <span class="text-xs font-semibold text-gray-400 bg-gray-50 px-3 py-1.5 rounded-full">~3 min</span>
                </div>
            </div>

            {{-- ── Two-column layout ────────────────────────────── --}}
            <div class="flex gap-7 items-start">

                {{-- ── Sidebar ──────────────────────────────────── --}}
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
                                <p class="text-xs font-bold text-[#0f4c81]">Job Details</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Title, type, location</p>
                            </div>
                        </div>

                        {{-- Step 2 --}}
                        <div class="flex items-start gap-3">
                            <div class="flex flex-col items-center">
                                <div class="step-dot pending">2</div>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-xs font-semibold text-gray-500">Compensation</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Salary, deadline, status</p>
                            </div>
                        </div>

                        {{-- Tip --}}
                        <div class="mt-5 p-3 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="flex items-center gap-1.5 mb-1">
                                <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-[10px] font-bold text-[#0f4c81] uppercase tracking-wider">Tip</span>
                            </div>
                            <p class="text-[11px] text-blue-600/80 leading-relaxed">
                                A clear job description increases quality applicants by up to 3×.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ── Form ─────────────────────────────────────── --}}
                <form wire:submit="save" class="flex-1 space-y-5 min-w-0">

                    {{-- ── Section 1: Job Details ────────────────── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden slide-up delay-1">
                        <div class="flex items-center gap-3.5 px-6 py-4 border-b border-gray-50"
                             style="background:linear-gradient(90deg,#fff 0%,#eff6ff 100%);">
                            <div class="section-badge bg-gradient-to-br from-[#0f4c81] to-[#1a6eb5] text-white shadow-lg shadow-blue-900/20">1</div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-gray-900">Job Details</h3>
                                <p class="text-[11px] text-gray-400 font-medium">Title, department, type and description</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <div class="p-6 space-y-5">

                            {{-- Job Title (full width) --}}
                            <div>
                                <label class="field-label">Job Title <span class="text-red-500">*</span></label>
                                <div class="fi-wrap">
                                    <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <input wire:model="title" type="text"
                                           placeholder="e.g. Senior PHP Developer"
                                           class="field-input"/>
                                </div>
                                @error('title')
                                    <p class="field-error">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Department / Location --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Department</label>
                                    <div class="fi-wrap">
                                        <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <select wire:model="department_id" class="field-select">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Location</label>
                                    <div class="fi-wrap">
                                        <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <input wire:model="location" type="text"
                                               placeholder="e.g. Lahore, Remote"
                                               class="field-input"/>
                                    </div>
                                </div>
                            </div>

                            {{-- Job Type / Positions --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Job Type</label>
                                    <div class="fi-wrap">
                                        <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <select wire:model="type" class="field-select">
                                            <option value="full_time">Full Time</option>
                                            <option value="part_time">Part Time</option>
                                            <option value="contract">Contract</option>
                                            <option value="internship">Internship</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Positions Available</label>
                                    <div class="fi-wrap">
                                        <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <input wire:model="positions" type="number" min="1"
                                               placeholder="1"
                                               class="field-input"/>
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="field-label">Job Description</label>
                                <div class="fi-wrap top">
                                    <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <textarea wire:model="description" rows="4"
                                              placeholder="Describe the role, responsibilities and day-to-day tasks..."
                                              class="field-textarea"></textarea>
                                </div>
                            </div>

                            {{-- Requirements --}}
                            <div>
                                <label class="field-label">Requirements</label>
                                <div class="fi-wrap top">
                                    <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                    <textarea wire:model="requirements" rows="4"
                                              placeholder="List required skills, qualifications, and experience..."
                                              class="field-textarea"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ── Section 2: Compensation & Schedule ───────── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden slide-up delay-2">
                        <div class="flex items-center gap-3.5 px-6 py-4 border-b border-gray-50"
                             style="background:linear-gradient(90deg,#fff 0%,#fff7ed 100%);">
                            <div class="section-badge bg-gradient-to-br from-[#ff6b35] to-orange-400 text-white shadow-lg shadow-orange-400/20">2</div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-gray-900">Compensation & Schedule</h3>
                                <p class="text-[11px] text-gray-400 font-medium">Salary range, deadline and posting status</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div class="p-6 space-y-5">

                            {{-- Salary range --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Salary Min <span class="text-gray-400 font-medium text-xs">(optional)</span></label>
                                    <div class="salary-wrap">
                                        <span class="salary-badge">{{ \App\Models\Setting::get('currency', 'PKR') }}</span>
                                        <input wire:model="salary_min" type="number"
                                               placeholder="30,000"
                                               class="field-input w-full"/>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Salary Max <span class="text-gray-400 font-medium text-xs">(optional)</span></label>
                                    <div class="salary-wrap">
                                        <span class="salary-badge">{{ \App\Models\Setting::get('currency', 'PKR') }}</span>
                                        <input wire:model="salary_max" type="number"
                                               placeholder="80,000"
                                               class="field-input w-full"/>
                                    </div>
                                </div>
                            </div>

                            {{-- Deadline / Status --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="field-label">Application Deadline <span class="text-gray-400 font-medium text-xs">(optional)</span></label>
                                    <div class="fi-wrap">
                                        <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <input wire:model="deadline" type="date" class="field-input"/>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Posting Status</label>
                                    <div class="fi-wrap">
                                        <svg class="fi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <select wire:model="status" class="field-select">
                                            <option value="open">Open — Accepting applications</option>
                                            <option value="on_hold">On Hold — Paused</option>
                                            <option value="closed">Closed — No longer accepting</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Status info card --}}
                            <div class="flex items-start gap-2.5 p-3.5 bg-blue-50 rounded-xl border border-blue-100">
                                <svg class="w-4 h-4 text-[#0f4c81] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-[11px] text-blue-600/80 leading-relaxed">
                                    Set status to <strong>Open</strong> to make this posting visible and accept applications. You can change this at any time from the job listings page.
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- ── Action Bar ───────────────────────────────── --}}
                    <div class="slide-up delay-3 flex items-center justify-between gap-3 bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4">
                        <div class="flex items-center gap-2 text-[11px] text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Data is saved securely
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('recruitment.jobs') }}"
                               class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                                    style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $editId ? 'Update Job' : 'Post Job' }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
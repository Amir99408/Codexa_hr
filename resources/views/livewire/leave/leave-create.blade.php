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
        @keyframes slideUp  { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

        .fade-in    { animation: fadeIn    0.25s ease both; }
        .scale-up   { animation: scaleUp   0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-up   { animation: slideUp   0.35s cubic-bezier(0.4,0,0.2,1) both; }

        /* ── Form inputs ─────────────────────────────────────── */
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
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #9ca3af;
            width: 1rem;
            height: 1rem;
            transition: color 0.18s;
        }
        .fi-icon-top {
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            pointer-events: none;
            color: #9ca3af;
            width: 1rem;
            height: 1rem;
            transition: color 0.18s;
        }
        .fi-wrap:focus-within .fi-icon,
        .fi-wrap:focus-within .fi-icon-top { color: #0f4c81; }

        /* ── Days info box ───────────────────────────────────── */
        .days-box {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            border: 1.5px solid #bfdbfe;
        }

        /* ── Section divider ─────────────────────────────────── */
        .section-label {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 1rem;
        }
        .section-label span {
            font-size: 0.6875rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b7280;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, #e5e7eb, transparent);
        }

        /* ── Back button ─────────────────────────────────────── */
        .back-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.75rem;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            color: #6b7280;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: all 0.18s ease;
            flex-shrink: 0;
        }
        .back-btn:hover {
            background: #fff;
            border-color: #0f4c81;
            color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
            transform: translateX(-1px);
        }

        /* ── Field label ─────────────────────────────────────── */
        .field-label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 800;
            color: #374151;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* ── Error text ──────────────────────────────────────── */
        .field-error {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: #ef4444;
            font-size: 0.6875rem;
            font-weight: 500;
            margin-top: 0.375rem;
        }

        /* ── Card header stripe ──────────────────────────────── */
        .card-stripe {
            height: 2px;
            background: linear-gradient(90deg, #0f4c81, #1a6eb5, #38bdf8);
            border-radius: 1rem 1rem 0 0;
        }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">
        <div class="max-w-2xl mx-auto">

            {{-- ── Page Header ──────────────────────────────────── --}}
            <div class="flex items-center gap-3 mb-8 slide-down">
                <a href="{{ route('leave.index') }}" class="back-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Leave</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Apply</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Apply for Leave</h2>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">Submit a new leave request for an employee</p>
                </div>
            </div>

            {{-- ── Form Card ─────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden scale-up">

                {{-- Top stripe --}}
                <div class="card-stripe"></div>

                {{-- Card title bar --}}
                <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                     style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-800">Leave Request Form</span>
                    </div>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">New Request</span>
                </div>

                <form wire:submit="save" class="p-6 space-y-6">

                    {{-- ── Section: Employee Info ─────────────────── --}}
                    <div>
                        <div class="section-label">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Employee Details</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Employee --}}
                            <div class="sm:col-span-2">
                                <label class="field-label">
                                    Employee <span class="text-red-500 normal-case tracking-normal">*</span>
                                </label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <select wire:model="employee_id" class="form-select">
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}">
                                                {{ $emp->full_name }} — {{ $emp->emp_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('employee_id')
                                    <p class="field-error">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Leave Type --}}
                            <div class="sm:col-span-2">
                                <label class="field-label">
                                    Leave Type <span class="text-red-500 normal-case tracking-normal">*</span>
                                </label>

                                @if($leaveTypes->isEmpty())
                                    <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                                        <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        <p class="text-xs font-semibold text-amber-700">
                                            No leave types configured.
                                            <a href="{{ route('leave.types') }}" class="font-bold underline ml-1">
                                                Add leave types →
                                            </a>
                                        </p>
                                    </div>
                                @else
                                    <div class="fi-wrap">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <select wire:model="leave_type_id" class="form-select">
                                            <option value="">Select Leave Type</option>
                                            @foreach($leaveTypes as $type)
                                                <option value="{{ $type->id }}">
                                                    {{ $type->name }} — {{ $type->days_allowed }} days allowed
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @error('leave_type_id')
                                    <p class="field-error">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- ── Section: Duration ──────────────────────── --}}
                    <div>
                        <div class="section-label">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Leave Duration</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- From Date --}}
                            <div>
                                <label class="field-label">From Date</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <input wire:model.live="from_date" type="date" class="form-input"/>
                                </div>
                                @error('from_date')
                                    <p class="field-error">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- To Date --}}
                            <div>
                                <label class="field-label">To Date</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <input wire:model.live="to_date" type="date" class="form-input"/>
                                </div>
                                @error('to_date')
                                    <p class="field-error">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>

                        {{-- Days Counter --}}
                        @if($days > 0)
                            <div class="days-box mt-4 p-4 rounded-xl flex items-center justify-between gap-3 fade-in">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-[#0f4c81]/60 uppercase tracking-wider">Total Duration</p>
                                        <p class="text-sm font-extrabold text-[#0f4c81]">
                                            {{ $days }} {{ $days == 1 ? 'day' : 'days' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-100 text-[#0f4c81] border border-blue-200 rounded-lg text-xs font-extrabold">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Calculated
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- ── Section: Reason ────────────────────────── --}}
                    <div>
                        <div class="section-label">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Additional Information</span>
                        </div>

                        <div>
                            <label class="field-label">Reason</label>
                            <div class="fi-wrap">
                                <svg class="fi-icon-top" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <textarea wire:model="reason" rows="3"
                                          placeholder="Briefly explain the reason for this leave request..."
                                          class="form-textarea"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ── Divider ────────────────────────────────── --}}
                    <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                    {{-- ── Action Buttons ──────────────────────────── --}}
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-[11px] text-gray-400 font-medium">
                            <span class="text-red-400">*</span> Required fields
                        </p>
                        <div class="flex items-center gap-2.5">
                            <a href="{{ route('leave.index') }}"
                               class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit"
                                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                                    style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Submit Request
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
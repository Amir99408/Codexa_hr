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

        /* ── Type card ───────────────────────────────────────── */
        .type-card {
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
        }
        .type-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        /* ── Form inputs ─────────────────────────────────────── */
        .form-input, .form-select {
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
        .form-input-plain {
            width: 100%;
            padding: 0.5625rem 0.875rem;
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
        .form-input:focus, .form-select:focus, .form-input-plain:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .form-input::placeholder { color:#9ca3af; font-weight:400; }

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
        .fi-wrap:focus-within .fi-icon { color: #0f4c81; }

        /* ── Toggle checkbox ─────────────────────────────────── */
        .toggle-wrap { display: flex; align-items: center; gap: 0.625rem; cursor: pointer; }
        .toggle-box {
            position: relative;
            width: 2.25rem;
            height: 1.25rem;
            background: #e5e7eb;
            border-radius: 9999px;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .toggle-box::after {
            content: '';
            position: absolute;
            left: 0.15rem;
            top: 0.15rem;
            width: 0.95rem;
            height: 0.95rem;
            background: #fff;
            border-radius: 9999px;
            transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }
        input[type=checkbox]:checked + .toggle-box { background: #0f4c81; }
        input[type=checkbox]:checked + .toggle-box::after { transform: translateX(1rem); }
        input[type=checkbox] { display: none; }

        /* ── Color swatch input ──────────────────────────────── */
        .color-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }
        .color-swatch {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            border: 2px solid #e5e7eb;
            cursor: pointer;
            flex-shrink: 0;
            overflow: hidden;
        }
        .color-swatch input[type=color] {
            width: 100%;
            height: 100%;
            border: none;
            padding: 0;
            cursor: pointer;
            opacity: 0;
            position: absolute;
            inset: 0;
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
            white-space: nowrap;
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
            border-color: #0f4c81;
            color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
            transform: translateX(-1px);
        }

        @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }
        .pulse { animation: pulse-dot 2s ease infinite; }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div class="flex items-center gap-3">
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
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Types</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Leave Types</h2>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">Configure and manage leave categories</p>
                </div>
            </div>

            <button wire:click="create"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200 self-start flex-shrink-0"
                    style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add Leave Type
            </button>
        </div>

        {{-- ── Toast ────────────────────────────────────────────── --}}
        @if($message)
            <div class="mb-5 flex items-center justify-between gap-4 p-4 bg-white rounded-2xl border border-emerald-100 shadow-sm slide-down">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">{{ $message }}</p>
                </div>
                <button wire:click="$set('message', '')"
                        class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- ── Cards Grid ────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card title bar --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Leave Categories</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $leaveTypes->count() }} type{{ $leaveTypes->count() !== 1 ? 's' : '' }}
                </span>
            </div>

            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse($leaveTypes as $type)
                        <div class="type-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            {{-- Colored top stripe using type color --}}
                            <div class="h-1.5 w-full" style="background: {{ $type->color }};"></div>

                            <div class="p-5">
                                {{-- Card header --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-sm"
                                             style="background: {{ $type->color }}18; border: 1.5px solid {{ $type->color }}30;">
                                            <div class="w-3 h-3 rounded-full" style="background: {{ $type->color }};"></div>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-extrabold text-gray-800 leading-tight">{{ $type->name }}</h3>
                                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">
                                                {{ $type->is_paid ? 'Paid' : 'Unpaid' }} · {{ $type->carry_forward ? 'Carry forward' : 'No carry forward' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <button wire:click="edit({{ $type->id }})"
                                                title="Edit"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg text-blue-500 hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $type->id }})"
                                                title="Delete"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg text-red-400 hover:bg-red-50 border border-transparent hover:border-red-100 transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <div class="h-px bg-gray-50 mb-4"></div>

                                {{-- Stats row --}}
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-gray-50 rounded-xl px-3 py-2.5">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Days Allowed</p>
                                        <p class="text-lg font-extrabold text-gray-800 leading-tight">{{ $type->days_allowed }}</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl px-3 py-2.5">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Requests</p>
                                        <p class="text-lg font-extrabold text-gray-800 leading-tight">{{ $type->leaves_count }}</p>
                                    </div>
                                </div>

                                {{-- Badges --}}
                                <div class="flex items-center gap-1.5 mt-3 flex-wrap">
                                    @if($type->is_paid)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-[10px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                            Paid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-500 border border-gray-200 rounded-full text-[10px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                            Unpaid
                                        </span>
                                    @endif
                                    @if($type->carry_forward)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-full text-[10px] font-bold">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Carry Forward
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-500">No leave types configured</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Get started by adding your first leave category</p>
                                </div>
                                <button wire:click="create"
                                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-900/20"
                                        style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Leave Type
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- ── Add / Edit Modal ──────────────────────────────────────── --}}
    @if($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden scale-up">

                {{-- Blue stripe --}}
                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8)"></div>

                {{-- Modal header --}}
                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between"
                     style="background:linear-gradient(135deg,#f0f7ff 0%,#f8fafc 100%);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                             style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">
                                {{ $editId ? 'Edit Leave Type' : 'Add Leave Type' }}
                            </h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">
                                {{ $editId ? 'Update the leave category details' : 'Create a new leave category' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('showForm', false)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="p-6 space-y-5">

                    {{-- ── Section: Basic Info ────────────────────── --}}
                    <div>
                        <div class="section-label">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Basic Info</span>
                        </div>

                        <div class="space-y-4">
                            {{-- Name --}}
                            <div>
                                <label class="field-label">
                                    Name <span class="text-red-500 normal-case tracking-normal">*</span>
                                </label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <input wire:model="name" type="text" placeholder="e.g. Annual Leave"
                                           class="form-input"/>
                                </div>
                                @error('name')
                                    <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Days + Color --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="field-label">Days Allowed</label>
                                    <div class="fi-wrap">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <input wire:model="days_allowed" type="number" min="0"
                                               placeholder="0" class="form-input"/>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">Color</label>
                                    <div class="flex items-center gap-2">
                                        <div class="relative w-10 h-10 rounded-xl border-2 border-gray-200 overflow-hidden flex-shrink-0 cursor-pointer"
                                             style="background: {{ $color ?? '#0f4c81' }};">
                                            <input wire:model="color" type="color"
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                                        </div>
                                        <input wire:model="color" type="text"
                                               placeholder="#0f4c81"
                                               class="form-input-plain text-xs font-mono"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Section: Options ──────────────────────── --}}
                    <div>
                        <div class="section-label">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            <span>Options</span>
                        </div>

                        <div class="space-y-3">
                            {{-- Paid Leave toggle --}}
                            <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                                <div>
                                    <p class="text-sm font-bold text-gray-700">Paid Leave</p>
                                    <p class="text-[11px] text-gray-400 font-medium mt-0.5">Employee receives salary during this leave</p>
                                </div>
                                <label class="toggle-wrap">
                                    <input wire:model="is_paid" type="checkbox" id="is_paid"/>
                                    <div class="toggle-box"></div>
                                </label>
                            </div>

                            {{-- Carry Forward toggle --}}
                            <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                                <div>
                                    <p class="text-sm font-bold text-gray-700">Carry Forward</p>
                                    <p class="text-[11px] text-gray-400 font-medium mt-0.5">Unused days roll over to next year</p>
                                </div>
                                <label class="toggle-wrap">
                                    <input wire:model="carry_forward" type="checkbox" id="carry_forward"/>
                                    <div class="toggle-box"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showForm', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-150"
                                style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $editId ? 'Update Type' : 'Save Type' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif

    {{-- ── Delete Confirm Modal ──────────────────────────────────── --}}
    @if($deleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden scale-up">

                {{-- Red stripe --}}
                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171)"></div>

                <div class="p-6">
                    {{-- Icon --}}
                    <div class="flex flex-col items-center text-center mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-gray-900 mb-1">Delete Leave Type?</h3>
                        <p class="text-xs text-gray-400 font-medium leading-relaxed max-w-xs">
                            This will permanently remove this leave type. All associated leave requests will also be deleted.
                        </p>
                    </div>

                    {{-- Warning banner --}}
                    <div class="flex items-start gap-2.5 p-3 bg-red-50 rounded-xl border border-red-100 mb-5">
                        <svg class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-[11px] text-red-600 font-medium leading-relaxed">
                            This action <strong>cannot be undone</strong>. All leave history linked to this type will be lost.
                        </p>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button wire:click="$set('deleteId', null)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button wire:click="delete"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-150"
                                style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Type
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif

</div>
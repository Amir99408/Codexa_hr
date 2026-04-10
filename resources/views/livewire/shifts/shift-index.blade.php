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
        @keyframes pulse-dot{ 0%,100%{opacity:1} 50%{opacity:.4} }

        .fade-in    { animation: fadeIn    0.25s ease both; }
        .scale-up   { animation: scaleUp   0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .pulse      { animation: pulse-dot 2s ease infinite; }

        /* ── Shift cards ──────────────────────────────────────── */
        .shift-card { transition: all 0.18s cubic-bezier(0.4,0,0.2,1); }
        .shift-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }

        /* ── Swap table rows ──────────────────────────────────── */
        .swap-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .swap-row:hover { background: linear-gradient(90deg,rgba(255,107,53,0.025) 0%,transparent 100%); }
        .swap-row:hover .row-bar { opacity: 1; }
        .row-bar { opacity: 0; transition: opacity 0.15s; }

        /* ── Avatar palette ───────────────────────────────────── */
        .av-0{background:linear-gradient(135deg,#0f4c81,#1a6eb5)}
        .av-1{background:linear-gradient(135deg,#059669,#10b981)}
        .av-2{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
        .av-3{background:linear-gradient(135deg,#d97706,#fbbf24)}
        .av-4{background:linear-gradient(135deg,#e11d48,#fb7185)}
        .av-5{background:linear-gradient(135deg,#0891b2,#22d3ee)}

        /* ── Form inputs ──────────────────────────────────────── */
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
        .form-select { appearance: none; cursor: pointer; }
        .form-input:focus, .form-select:focus, .form-input-plain:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .form-input::placeholder { color:#9ca3af; font-weight:400; }

        .fi-wrap { position: relative; }
        .fi-icon {
            position: absolute; left:0.75rem; top:50%;
            transform: translateY(-50%);
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .fi-wrap:focus-within .fi-icon { color: #0f4c81; }

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
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Shifts</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Shift Management</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Manage shifts and swap requests</p>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0 self-start">
                <a href="{{ route('shifts.roster') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    View Roster
                </a>
                <button wire:click="openModal()"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                        style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Shift
                </button>
            </div>
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

        {{-- ── Shifts Grid ───────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">

            {{-- Card title bar --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Shifts</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $shifts->count() }} shift{{ $shifts->count() !== 1 ? 's' : '' }}
                </span>
            </div>

            <div class="p-5">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    @forelse($shifts as $shift)
                        <div class="shift-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            {{-- Colored top stripe --}}
                            <div class="h-1.5 w-full" style="background: {{ $shift->color }};"></div>

                            <div class="p-5">
                                {{-- Card header --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm"
                                             style="background: {{ $shift->color }}18; border: 1.5px solid {{ $shift->color }}35;">
                                            <svg class="w-4 h-4" style="color: {{ $shift->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-extrabold text-gray-800 leading-tight">{{ $shift->name }}</h3>
                                            @if($shift->description)
                                                <p class="text-[11px] text-gray-400 font-medium mt-0.5 truncate max-w-[140px]">{{ $shift->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <button wire:click="openModal({{ $shift->id }})"
                                                title="Edit"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg text-blue-500 hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $shift->id }})" wire:confirm="Delete this shift?"
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

                                {{-- Time + stats --}}
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div class="bg-gray-50 rounded-xl px-3 py-2.5">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Start</p>
                                        <p class="text-sm font-extrabold text-gray-800">{{ $shift->start_time }}</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl px-3 py-2.5">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">End</p>
                                        <p class="text-sm font-extrabold text-gray-800">{{ $shift->end_time }}</p>
                                    </div>
                                </div>

                                {{-- Badges --}}
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-50 text-[#0f4c81] border border-blue-100 rounded-full text-[10px] font-bold">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $shift->duration }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-600 border border-gray-200 rounded-full text-[10px] font-bold">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $shift->assignments_count }} assigned
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="lg:col-span-3 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-500">No shifts created yet</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Add your first shift to get started</p>
                                </div>
                                <button wire:click="openModal()"
                                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-900/20"
                                        style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Shift
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ── Pending Swap Requests ─────────────────────────────── --}}
        @if($swapRequests->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Card title bar --}}
                <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                     style="background:linear-gradient(90deg,#fff8f5 0%,#fff 100%);">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-orange-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-[#ff6b35]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-800">Pending Swap Requests</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-orange-50 text-[#ff6b35] border border-orange-100 rounded-full text-[10px] font-bold ml-1">
                            <span class="w-1.5 h-1.5 bg-[#ff6b35] rounded-full pulse"></span>
                            {{ $swapRequests->count() }}
                        </span>
                    </div>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Awaiting Review</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr style="background:linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">
                                <th></th>
                                <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Requester</th>
                                <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Their Shift</th>
                                <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Swap With</th>
                                <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Reason</th>
                                <th class="text-right px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/80">
                            @foreach($swapRequests as $swap)
                                <tr class="swap-row relative group">

                                    {{-- Accent bar --}}
                                    <td class="p-0 w-0">
                                        <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 rounded-r bg-[#ff6b35]"></div>
                                    </td>

                                    {{-- Requester --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                                {{ strtoupper(substr($swap->requester->first_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800 group-hover:text-[#0f4c81] transition-colors duration-150">
                                                    {{ $swap->requester->full_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Their shift --}}
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-xl">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div>
                                                <p class="text-xs font-bold text-gray-700 leading-none">{{ $swap->requesterAssignment->shift->name }}</p>
                                                <p class="text-[10px] text-gray-400 font-medium leading-none mt-0.5">{{ $swap->requesterAssignment->date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Swap with --}}
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-[#ff6b35] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-bold text-gray-700">{{ $swap->requested->full_name }}</p>
                                                <p class="text-[11px] text-gray-400 font-medium">{{ $swap->requestedAssignment->shift->name }} · {{ $swap->requestedAssignment->date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Reason --}}
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <span class="text-xs text-gray-500 font-medium">{{ $swap->reason ?? '—' }}</span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1">
                                            <button wire:click="approveSwap({{ $swap->id }})"
                                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 hover:border-emerald-200 rounded-lg transition-all duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="hidden sm:inline">Approve</span>
                                            </button>
                                            <button wire:click="rejectSwap({{ $swap->id }})"
                                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-red-50 hover:text-red-500 border border-gray-200 hover:border-red-200 rounded-lg transition-all duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                <span class="hidden sm:inline">Reject</span>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>

    {{-- ── Shift Modal ───────────────────────────────────────────── --}}
    @if($showModal)
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">
                                {{ $editId ? 'Edit Shift' : 'Add New Shift' }}
                            </h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">
                                {{ $editId ? 'Update shift details' : 'Create a new work shift' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('showModal', false)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="p-6 space-y-5">

                    {{-- ── Section: Details ──────────────────────── --}}
                    <div>
                        <div class="section-label">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Shift Details</span>
                        </div>

                        <div class="space-y-4">

                            {{-- Name --}}
                            <div>
                                <label class="field-label">
                                    Shift Name <span class="text-red-500 normal-case tracking-normal">*</span>
                                </label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <input wire:model="name" type="text" placeholder="e.g. Morning Shift" class="form-input"/>
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

                            {{-- Start + End time --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="field-label">
                                        Start Time <span class="text-red-500 normal-case tracking-normal">*</span>
                                    </label>
                                    <div class="fi-wrap">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <input wire:model="start_time" type="time" class="form-input"/>
                                    </div>
                                </div>
                                <div>
                                    <label class="field-label">
                                        End Time <span class="text-red-500 normal-case tracking-normal">*</span>
                                    </label>
                                    <div class="fi-wrap">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <input wire:model="end_time" type="time" class="form-input"/>
                                    </div>
                                </div>
                            </div>

                            {{-- Color + Description --}}
                            <div>
                                <label class="field-label">Color</label>
                                <div class="flex items-center gap-2">
                                    <div class="relative w-10 h-10 rounded-xl border-2 border-gray-200 overflow-hidden flex-shrink-0 cursor-pointer"
                                         style="background: {{ $color ?? '#0f4c81' }};">
                                        <input wire:model="color" type="color"
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                                    </div>
                                    <input wire:model="color" type="text" placeholder="#0f4c81"
                                           class="form-input-plain text-xs font-mono"/>
                                </div>
                            </div>

                            <div>
                                <label class="field-label">Description</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <input wire:model="description" type="text" placeholder="Optional note..." class="form-input"/>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showModal', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-150"
                                style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $editId ? 'Update Shift' : 'Create Shift' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif

</div>
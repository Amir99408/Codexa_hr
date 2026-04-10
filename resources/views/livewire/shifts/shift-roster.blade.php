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

        @keyframes fadeIn  { from{opacity:0} to{opacity:1} }
        @keyframes scaleUp { from{opacity:0;transform:scale(0.96) translateY(8px)} to{opacity:1;transform:scale(1) translateY(0)} }
        @keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }

        .fade-in    { animation: fadeIn    0.25s ease both; }
        .scale-up   { animation: scaleUp   0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }

        /* Roster table */
        .roster-table { border-collapse: separate; border-spacing: 0; }

        .sticky-col {
            position: sticky;
            left: 0;
            z-index: 10;
            background: #fff;
        }
        thead .sticky-col { background: #f8fafc; z-index: 11; }

        .day-cell { min-width: 2.75rem; }
        .weekend-col { background-color: rgba(254,242,242,0.6); }
        .today-col   { background-color: rgba(15,76,129,0.04); }

        .emp-row { transition: background 0.15s ease; }
        .emp-row:hover .sticky-col { background: #f8fafc; }

        /* Shift badge */
        .shift-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.875rem; height: 1.875rem;
            border-radius: 0.5rem;
            font-size: 0.625rem;
            font-weight: 800;
            color: white;
            cursor: pointer;
            transition: all 0.15s ease;
            position: relative;
        }
        .shift-badge:hover { transform: scale(1.12); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .shift-badge:hover .remove-btn { opacity: 1; pointer-events: all; }

        .remove-btn {
            position: absolute;
            top: -5px; right: -5px;
            width: 1rem; height: 1rem;
            background: #ef4444;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.5rem;
            color: white;
            font-weight: 900;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
            border: 1.5px solid white;
        }

        /* Add cell button */
        .add-cell-btn {
            width: 1.875rem; height: 1.875rem;
            border-radius: 0.5rem;
            border: 1.5px dashed #d1d5db;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto;
            color: #d1d5db;
            font-size: 1rem;
            font-weight: 300;
            transition: all 0.15s ease;
            cursor: pointer;
            background: transparent;
        }
        .add-cell-btn:hover {
            border-color: #0f4c81;
            background: rgba(15,76,129,0.06);
            color: #0f4c81;
            transform: scale(1.08);
        }

        /* Filter selects */
        .period-select {
            padding: 0.5rem 0.75rem 0.5rem 2.25rem;
            font-size: 0.8125rem;
            font-weight: 600;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #374151;
            outline: none;
            appearance: none;
            cursor: pointer;
            transition: all 0.18s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .period-select:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .period-wrap { position: relative; display: inline-flex; align-items: center; }
        .period-wrap .p-icon {
            position: absolute; left: 0.625rem;
            pointer-events: none; color: #9ca3af;
            width: 0.875rem; height: 0.875rem;
        }

        /* Modal inputs */
        .modal-select {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            background: #fafafa;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            appearance: none;
            cursor: pointer;
            transition: all 0.18s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .modal-select:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .modal-input {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            background: #fafafa;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            transition: all 0.18s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .modal-input:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .modal-input::placeholder { color: #9ca3af; font-weight: 400; }
        .mi-wrap { position: relative; }
        .mi-wrap .mi-icon {
            position: absolute; left: 0.75rem; top: 50%;
            transform: translateY(-50%);
            pointer-events: none; color: #9ca3af;
            width: 1rem; height: 1rem;
            transition: color 0.18s;
        }
        .mi-wrap:focus-within .mi-icon { color: #0f4c81; }

        /* Avatar palette */
        .av-0{background:linear-gradient(135deg,#0f4c81,#1a6eb5)}
        .av-1{background:linear-gradient(135deg,#059669,#10b981)}
        .av-2{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
        .av-3{background:linear-gradient(135deg,#d97706,#fbbf24)}
        .av-4{background:linear-gradient(135deg,#e11d48,#fb7185)}
        .av-5{background:linear-gradient(135deg,#0891b2,#22d3ee)}

        /* Scrollbar styling */
        .roster-scroll::-webkit-scrollbar { height: 5px; }
        .roster-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
        .roster-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .roster-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 slide-down">

            {{-- Back + Title --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('shifts.index') }}"
                   class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-500 hover:text-[#0f4c81] hover:border-[#0f4c81] hover:bg-blue-50 rounded-xl shadow-sm transition-all duration-200 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">Shifts</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Roster</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Shift Roster</h2>
                    <p class="text-sm text-gray-400 font-medium mt-0.5">Assign and manage employee shifts</p>
                </div>
            </div>

            {{-- Month + Year pickers --}}
            <div class="flex items-center gap-2 flex-shrink-0">

                {{-- Month --}}
                <div class="period-wrap">
                    <svg class="p-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <select wire:model.live="selectedMonth" class="period-select">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Year --}}
                <div class="period-wrap">
                    <svg class="p-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <select wire:model.live="selectedYear" class="period-select">
                        @foreach(range(now()->year - 1, now()->year + 1) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

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
                    <div>
                        <p class="text-sm font-bold text-gray-800">Done!</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $message }}</p>
                    </div>
                </div>
                <button wire:click="$set('message', '')"
                        class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- ── Legend ───────────────────────────────────────────── --}}
        <div class="flex items-center gap-4 mb-4 flex-wrap">
            <div class="flex items-center gap-1.5">
                <div class="w-4 h-4 rounded bg-red-50 border border-red-100"></div>
                <span class="text-[11px] font-semibold text-gray-400">Weekend</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-4 h-4 rounded bg-blue-50 border border-blue-100"></div>
                <span class="text-[11px] font-semibold text-gray-400">Today</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-4 h-4 rounded bg-[#0f4c81] flex items-center justify-center">
                    <span class="text-white text-[8px] font-black">M</span>
                </div>
                <span class="text-[11px] font-semibold text-gray-400">Shift assigned (hover to remove)</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-4 h-4 rounded border-2 border-dashed border-gray-300 flex items-center justify-center">
                    <span class="text-gray-300 text-[10px] font-bold leading-none">+</span>
                </div>
                <span class="text-[11px] font-semibold text-gray-400">Click to assign</span>
            </div>
        </div>

        {{-- ── Roster Table Card ────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card header --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background: linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">
                        {{ \Carbon\Carbon::create()->month($selectedMonth)->format('F') }} {{ $selectedYear }}
                    </span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $daysInMonth }} days
                </span>
            </div>

            {{-- Scrollable table --}}
            <div class="roster-scroll overflow-x-auto">
                <table class="roster-table text-xs min-w-full">
                    <thead>
                        <tr style="background: linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">

                            {{-- Employee sticky header --}}
                            <th class="sticky-col text-left px-5 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-r border-gray-100"
                                style="min-width:11rem;">
                                Employee
                            </th>

                            {{-- Day headers --}}
                            @for($d = 1; $d <= $daysInMonth; $d++)
                                @php
                                    $date     = $startOfMonth->copy()->setDay($d);
                                    $isWeekend= in_array($date->dayOfWeek, [0, 6]);
                                    $isToday  = $date->isToday();
                                @endphp
                                <th class="day-cell px-1 py-2.5 font-extrabold text-center
                                    {{ $isToday   ? 'today-col text-[#0f4c81]' : '' }}
                                    {{ $isWeekend && !$isToday ? 'weekend-col text-red-400' : '' }}
                                    {{ !$isWeekend && !$isToday ? 'text-gray-400' : '' }}">
                                    <div class="text-[9px] uppercase tracking-wider font-bold">
                                        {{ $date->format('D') }}
                                    </div>
                                    <div class="text-sm font-extrabold mt-0.5 {{ $isToday ? 'w-6 h-6 bg-[#0f4c81] text-white rounded-full flex items-center justify-center mx-auto text-xs' : '' }}">
                                        {{ $d }}
                                    </div>
                                </th>
                            @endfor
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($employees as $employee)
                            <tr class="emp-row group">

                                {{-- Sticky employee cell --}}
                                <td class="sticky-col px-4 py-3 border-r border-gray-100 group-hover:bg-blue-50/30 transition-colors duration-150"
                                    style="min-width:11rem;">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0 av-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-800 truncate text-xs leading-tight">
                                                {{ $employee->first_name }}
                                            </p>
                                            <p class="text-[10px] text-gray-400 font-mono font-semibold">
                                                {{ $employee->emp_code }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Day cells --}}
                                @for($d = 1; $d <= $daysInMonth; $d++)
                                    @php
                                        $date       = $startOfMonth->copy()->setDay($d)->format('Y-m-d');
                                        $assignment = $employee->shiftAssignments
    ->first(fn($a) => \Carbon\Carbon::parse($a->date)->format('Y-m-d') === $date);
                                        $isWeekend  = \Carbon\Carbon::parse($date)->isWeekend();
                                        $isToday    = \Carbon\Carbon::parse($date)->isToday();
                                    @endphp
                                    <td class="day-cell px-1 py-2.5 text-center align-middle
    {{ $isToday   ? 'today-col'   : '' }}
    {{ $isWeekend && !$isToday ? 'weekend-col' : '' }}">
    @if($assignment)
        <div class="flex items-center justify-center">
            <div class="shift-badge"
     style="background-color: {{ $assignment->shift->color }};"
     title="{{ $assignment->shift->name }} · {{ $assignment->shift->start_time }}–{{ $assignment->shift->end_time }} · Assigned by: {{ $assignment->assignedBy->first_name ?? 'N/A' }}">
    {{ strtoupper(substr($assignment->shift->name, 0, 2)) }}
    <button wire:click="removeAssignment({{ $assignment->id }})"
            class="remove-btn"
            title="Remove">
        ×
    </button>
</div>
        </div>
    @else
        <button wire:click="openAssign('{{ $date }}', {{ $employee->id }})"
                class="add-cell-btn"
                title="Assign shift on {{ \Carbon\Carbon::parse($date)->format('d M') }}">
            +
        </button>
    @endif
</td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $daysInMonth + 1 }}" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">No active employees found</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Add employees to start building your roster</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ── Assign Shift Modal ───────────────────────────────────── --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background: rgba(15,23,42,0.45); backdrop-filter: blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden scale-up">

                {{-- Modal header --}}
                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between"
                     style="background: linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow"
                             style="background: linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Assign Shift</h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">
                                {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('showModal', false)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Form --}}
                <form wire:submit="save" class="p-6 space-y-4">

                    {{-- Employee --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                            Employee <span class="text-red-500">*</span>
                        </label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <select wire:model="employee_id" class="modal-select">
                                <option value="">Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('employee_id')
                            <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Shift --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                            Shift <span class="text-red-500">*</span>
                        </label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <select wire:model="shift_id" class="modal-select">
                                <option value="">Select Shift</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}">
                                        {{ $shift->name }} ({{ $shift->start_time }} — {{ $shift->end_time }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('shift_id')
                            <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Note --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                            Note
                            <span class="text-gray-400 font-medium normal-case tracking-normal ml-1">(optional)</span>
                        </label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <input wire:model="note" type="text"
                                   placeholder="e.g. Cover for John"
                                   class="modal-input"/>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-1">
                        <button type="button" wire:click="$set('showModal', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:-translate-y-0.5 hover:shadow-blue-900/30 transition-all duration-150"
                                style="background: linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Assign Shift
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
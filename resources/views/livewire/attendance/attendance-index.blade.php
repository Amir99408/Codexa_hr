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
        @keyframes barFill  { from{width:0} to{width:var(--w)} }

        .fade-in    { animation: fadeIn    0.25s ease both; }
        .scale-up   { animation: scaleUp   0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .pulse      { animation: pulse-dot 2s ease infinite; }

        /* Table rows */
        .att-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .att-row:hover { background: linear-gradient(90deg,rgba(15,76,129,0.025) 0%,transparent 100%); }
        .att-row:hover .row-bar { opacity:1; }
        .row-bar { opacity:0; transition: opacity 0.15s; }

        /* Filter inputs */
        .filter-input, .filter-select {
            width: 100%;
            padding: 0.5625rem 0.875rem 0.5625rem 2.375rem;
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
        .filter-select { appearance: none; cursor: pointer; }
        .filter-input:focus, .filter-select:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .filter-input::placeholder { color:#9ca3af; font-weight:400; }
        .filter-wrap { position: relative; }
        .filter-wrap .f-icon {
            position: absolute; left:0.75rem; top:50%;
            transform: translateY(-50%);
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .filter-wrap:focus-within .f-icon { color:#0f4c81; }

        /* Modal inputs */
        .modal-input, .modal-select {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            background: #fafafa;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.18s ease;
        }
        .modal-select { appearance: none; cursor: pointer; }
        .modal-input:focus, .modal-select:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .mi-wrap { position: relative; }
        .mi-wrap .mi {
            position: absolute; left:0.75rem; top:50%;
            transform: translateY(-50%);
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .mi-wrap:focus-within .mi { color:#0f4c81; }

        /* Avatar palette */
        .av-0{background:linear-gradient(135deg,#0f4c81,#1a6eb5)}
        .av-1{background:linear-gradient(135deg,#059669,#10b981)}
        .av-2{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
        .av-3{background:linear-gradient(135deg,#d97706,#fbbf24)}
        .av-4{background:linear-gradient(135deg,#e11d48,#fb7185)}
        .av-5{background:linear-gradient(135deg,#0891b2,#22d3ee)}

        /* Stat card bar */
        .stat-bar { height:3px; border-radius:9999px; background:#e5e7eb; overflow:hidden; margin-top:0.75rem; }
        .stat-bar-fill { height:100%; border-radius:9999px; transition: width 1s cubic-bezier(0.4,0,0.2,1); }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Attendance</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Attendance</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Track and manage daily employee attendance</p>
            </div>

            <button wire:click="openMark()"
                    class="flex-shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200 self-start"
                    style="background:linear-gradient(135deg,#0f4c81 0%,#1a6eb5 100%);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mark Attendance
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

        {{-- ── Today's Stats ────────────────────────────────────── --}}
        @php
            $presentPct = $todayTotal > 0 ? round(($todayPresent / $todayTotal) * 100) : 0;
            $absentPct  = $todayTotal > 0 ? round(($todayAbsent  / $todayTotal) * 100) : 0;
            $latePct    = $todayTotal > 0 ? round(($todayLate    / $todayTotal) * 100) : 0;
        @endphp
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            {{-- Total --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-[#0f4c81]">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm"
                         style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold tracking-wide text-blue-600 bg-blue-50 px-2 py-1 rounded-full uppercase">Today</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $todayTotal }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Employees</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-[#0f4c81] to-[#1a6eb5]" style="width:100%"></div>
                </div>
            </div>

            {{-- Present --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-emerald-500">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <span class="w-3 h-3 rounded-full bg-emerald-400 pulse"></span>
                    </div>
                    <span class="text-[10px] font-bold tracking-wide text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full uppercase">{{ $presentPct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-emerald-600 tracking-tight mb-0.5">{{ $todayPresent }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Present Today</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-emerald-500 to-emerald-400" style="width:{{ $presentPct }}%"></div>
                </div>
            </div>

            {{-- Absent --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-red-400">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold tracking-wide text-red-500 bg-red-50 px-2 py-1 rounded-full uppercase">{{ $absentPct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-red-500 tracking-tight mb-0.5">{{ $todayAbsent }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Absent Today</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-red-400 to-red-300" style="width:{{ $absentPct }}%"></div>
                </div>
            </div>

            {{-- Late --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-amber-400">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold tracking-wide text-amber-600 bg-amber-50 px-2 py-1 rounded-full uppercase">{{ $latePct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-amber-500 tracking-tight mb-0.5">{{ $todayLate }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Late Today</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-amber-400 to-amber-300" style="width:{{ $latePct }}%"></div>
                </div>
            </div>

        </div>

        {{-- ── Filters ───────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                {{-- Search --}}
                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input wire:model.live="search" type="text" placeholder="Search employee..." class="filter-input"/>
                </div>

                {{-- Date --}}
                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <input wire:model.live="filterDate" type="date" class="filter-input"/>
                </div>

                {{-- Department --}}
                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <select wire:model.live="filterDept" class="filter-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <select wire:model.live="filterStatus" class="filter-select">
                        <option value="">All Status</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                        <option value="half_day">Half Day</option>
                        <option value="work_from_home">Work From Home</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ── Attendance Table ─────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card title --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Attendance Records</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ now()->format('d M Y') }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background:linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">
                            <th></th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Employee</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden sm:table-cell">Date</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Check In</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Check Out</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="text-right px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($attendances as $att)
                            <tr class="att-row relative group">

                                {{-- Accent bar --}}
                                <td class="p-0 w-0">
                                    <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 bg-[#0f4c81] rounded-r"></div>
                                </td>

                                {{-- Employee --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($att->employee->first_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                                {{ $att->employee->full_name }}
                                            </p>
                                            <p class="text-xs text-gray-400 font-medium truncate">
                                                {{ $att->employee->department?->name ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-50 border border-gray-200 px-2.5 py-1 rounded-lg">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $att->date->format('d M Y') }}
                                    </span>
                                </td>

                                {{-- Check In --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    @if($att->check_in)
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-lg">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                            </svg>
                                            {{ $att->check_in }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Check Out --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    @if($att->check_out)
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-lg">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            {{ $att->check_out }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'present'        => ['bg-emerald-50 text-emerald-700 border-emerald-100', 'bg-emerald-400', 'Present'],
                                            'absent'         => ['bg-red-50 text-red-600 border-red-100',             'bg-red-400',     'Absent'],
                                            'late'           => ['bg-amber-50 text-amber-700 border-amber-100',       'bg-amber-400',   'Late'],
                                            'half_day'       => ['bg-yellow-50 text-yellow-700 border-yellow-100',    'bg-yellow-400',  'Half Day'],
                                            'work_from_home' => ['bg-blue-50 text-blue-700 border-blue-100',          'bg-blue-400',    'WFH'],
                                        ];
                                        $sc = $statusConfig[$att->status] ?? ['bg-gray-50 text-gray-600 border-gray-200', 'bg-gray-300', ucfirst($att->status)];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $sc[0] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $sc[1] }} {{ $att->status === 'present' ? 'pulse' : '' }}"></span>
                                        {{ $sc[2] }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="openMark({{ $att->employee_id }})"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-blue-50 hover:text-[#0f4c81] border border-gray-200 hover:border-blue-200 rounded-lg transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        <button wire:click="deleteAttendance({{ $att->id }})"
                                                wire:confirm="Delete this attendance record?"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-red-50 hover:text-red-500 border border-gray-200 hover:border-red-200 rounded-lg transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span class="hidden sm:inline">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">No attendance records found</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ $search || $filterDept || $filterStatus ? 'Try adjusting your filters' : 'Start by marking attendance for today' }}
                                            </p>
                                        </div>
                                        @if(!$search && !$filterDept && !$filterStatus)
                                            <button wire:click="openMark()"
                                                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-900/20"
                                                    style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Mark Attendance Now
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendances->hasPages())
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ── Mark Attendance Modal ─────────────────────────────────── --}}
    @if($showMarkModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden scale-up">

                {{-- Modal header --}}
                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between"
                     style="background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow"
                             style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">
                                {{ $markEmployeeId ? 'Mark Attendance' : 'Bulk Mark Attendance' }}
                            </h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">
                                {{ $markEmployeeId ? 'Update attendance for this employee' : 'Apply to all active employees' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('showMarkModal', false)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="markAttendance" class="p-6 space-y-4">

                    {{-- Date --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Date</label>
                        <div class="mi-wrap">
                            <svg class="mi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <input wire:model="markDate" type="date" class="modal-input"/>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Status</label>
                        <div class="mi-wrap">
                            <svg class="mi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <select wire:model.live="markStatus" class="modal-select">
                                <option value="present">✅ Present</option>
                                <option value="absent">❌ Absent</option>
                                <option value="late">⏰ Late</option>
                                <option value="half_day">🌓 Half Day</option>
                                <option value="work_from_home">🏠 Work From Home</option>
                            </select>
                        </div>
                    </div>

                    {{-- Check In / Out (hidden for absent) --}}
                    @if(!in_array($markStatus, ['absent']))
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Check In</label>
                                <div class="mi-wrap">
                                    <svg class="mi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    <input wire:model="markCheckIn" type="time" class="modal-input"/>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Check Out</label>
                                <div class="mi-wrap">
                                    <svg class="mi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <input wire:model="markCheckOut" type="time" class="modal-input"/>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Bulk warning --}}
                    @if(!$markEmployeeId)
                        <div class="flex items-start gap-2.5 p-3.5 bg-amber-50 rounded-xl border border-amber-100">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-[11px] text-amber-700 font-medium leading-relaxed">
                                <strong>Bulk mode:</strong> This will mark attendance for <strong>all active employees</strong> on the selected date. Existing records will be updated.
                            </p>
                        </div>
                    @endif

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-1">
                        <button type="button" wire:click="$set('showMarkModal', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:-translate-y-0.5 hover:shadow-blue-900/30 transition-all duration-150"
                                style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Attendance
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif

</div>
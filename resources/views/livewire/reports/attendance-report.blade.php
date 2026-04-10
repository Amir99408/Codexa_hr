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

        @keyframes slideDown{ from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pulse-dot{ 0%,100%{opacity:1} 50%{opacity:.4} }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .pulse      { animation: pulse-dot 2s ease infinite; }

        .att-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .att-row:hover { background: linear-gradient(90deg,rgba(15,76,129,0.025) 0%,transparent 100%); }
        .att-row:hover .row-bar { opacity:1; }
        .row-bar { opacity:0; transition: opacity 0.15s; }

        .av-0{background:linear-gradient(135deg,#0f4c81,#1a6eb5)}
        .av-1{background:linear-gradient(135deg,#059669,#10b981)}
        .av-2{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
        .av-3{background:linear-gradient(135deg,#d97706,#fbbf24)}
        .av-4{background:linear-gradient(135deg,#e11d48,#fb7185)}
        .av-5{background:linear-gradient(135deg,#0891b2,#22d3ee)}

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

        .stat-bar { height:3px; border-radius:9999px; background:#f1f5f9; overflow:hidden; margin-top:0.875rem; }
        .stat-bar-fill { height:100%; border-radius:9999px; transition: width 1s cubic-bezier(0.4,0,0.2,1); }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Reports</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Attendance</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Attendance Report</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">View and filter attendance records</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0 self-start">
                <a href="{{ route('reports.leave') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Leave Report
                </a>
                <a href="{{ route('reports.payroll') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Payroll Report
                </a>
            </div>
        </div>

        {{-- ── Summary Stats ─────────────────────────────────────── --}}
        @php
            $total      = $summary['total'] ?: 1;
            $presentPct = round(($summary['present']  / $total) * 100);
            $absentPct  = round(($summary['absent']   / $total) * 100);
            $latePct    = round(($summary['late']     / $total) * 100);
            $halfPct    = round(($summary['half_day'] / $total) * 100);
            $wfhPct     = round(($summary['wfh']      / $total) * 100);
        @endphp
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mb-6">

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-[#0f4c81] hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
                    <svg class="w-4 h-4 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-2xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $summary['total'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-[#0f4c81] to-blue-400" style="width:100%"></div></div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-emerald-500 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">{{ $presentPct }}%</span>
                </div>
                <p class="text-2xl font-extrabold text-emerald-600 tracking-tight mb-0.5">{{ $summary['present'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Present</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-emerald-500 to-emerald-400" style="width:{{ $presentPct }}%"></div></div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-red-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-red-500 bg-red-50 px-1.5 py-0.5 rounded-full">{{ $absentPct }}%</span>
                </div>
                <p class="text-2xl font-extrabold text-red-500 tracking-tight mb-0.5">{{ $summary['absent'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Absent</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-red-400 to-red-300" style="width:{{ $absentPct }}%"></div></div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-orange-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-orange-500 bg-orange-50 px-1.5 py-0.5 rounded-full">{{ $latePct }}%</span>
                </div>
                <p class="text-2xl font-extrabold text-orange-500 tracking-tight mb-0.5">{{ $summary['late'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Late</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-orange-400 to-orange-300" style="width:{{ $latePct }}%"></div></div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-amber-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-13l-.87.5M4.21 15.5l-.87.5M19.66 15.5l-.87-.5M4.21 8.5l-.87-.5M21 12h-1M4 12H3"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-full">{{ $halfPct }}%</span>
                </div>
                <p class="text-2xl font-extrabold text-amber-500 tracking-tight mb-0.5">{{ $summary['half_day'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Half Day</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-amber-400 to-amber-300" style="width:{{ $halfPct }}%"></div></div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-sky-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-sky-600 bg-sky-50 px-1.5 py-0.5 rounded-full">{{ $wfhPct }}%</span>
                </div>
                <p class="text-2xl font-extrabold text-sky-500 tracking-tight mb-0.5">{{ $summary['wfh'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">WFH</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-sky-400 to-sky-300" style="width:{{ $wfhPct }}%"></div></div>
            </div>

        </div>

        {{-- ── Filters ───────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3">

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input wire:model.live="search" type="text" placeholder="Search employee..." class="filter-input"/>
                </div>

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <input wire:model.live="from_date" type="date" class="filter-input"/>
                </div>

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <input wire:model.live="to_date" type="date" class="filter-input"/>
                </div>

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
                        <option value="work_from_home">WFH</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ── Attendance Table ──────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Attendance Records</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $records->total() }} record{{ $records->total() !== 1 ? 's' : '' }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background:linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">
                            <th></th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Employee</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden sm:table-cell">Department</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Date</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Check In</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Check Out</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($records as $rec)
                            @php
                                $statusMeta = [
                                    'present'        => ['label'=>'Present',  'classes'=>'bg-emerald-50 text-emerald-700 border-emerald-100', 'dot'=>'bg-emerald-400', 'bar'=>'bg-emerald-500'],
                                    'absent'         => ['label'=>'Absent',   'classes'=>'bg-red-50 text-red-600 border-red-100',             'dot'=>'bg-red-400',     'bar'=>'bg-red-400'],
                                    'late'           => ['label'=>'Late',     'classes'=>'bg-orange-50 text-orange-700 border-orange-100',     'dot'=>'bg-orange-400',  'bar'=>'bg-orange-400'],
                                    'half_day'       => ['label'=>'Half Day', 'classes'=>'bg-amber-50 text-amber-700 border-amber-100',        'dot'=>'bg-amber-400',   'bar'=>'bg-amber-400'],
                                    'work_from_home' => ['label'=>'WFH',      'classes'=>'bg-sky-50 text-sky-700 border-sky-100',              'dot'=>'bg-sky-400',     'bar'=>'bg-sky-400'],
                                ];
                                $meta = $statusMeta[$rec->status] ?? ['label'=>ucfirst($rec->status),'classes'=>'bg-gray-100 text-gray-600 border-gray-200','dot'=>'bg-gray-400','bar'=>'bg-gray-400'];
                            @endphp
                            <tr class="att-row relative group">

                                <td class="p-0 w-0">
                                    <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 rounded-r {{ $meta['bar'] }}"></div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($rec->employee->first_name, 0, 1)) }}
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                            {{ $rec->employee->full_name }}
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="text-xs font-semibold text-gray-500">{{ $rec->employee->department?->name ?? '—' }}</span>
                                </td>

                                <td class="px-6 py-4 hidden md:table-cell">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-xl">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-gray-600">{{ $rec->date->format('d M Y') }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if($rec->check_in)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-lg text-xs font-bold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/>
                                            </svg>
                                            {{ $rec->check_in }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs font-bold">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if($rec->check_out)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-600 border border-red-100 rounded-lg text-xs font-bold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                            {{ $rec->check_out }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs font-bold">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 border rounded-full text-[11px] font-bold {{ $meta['classes'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $meta['dot'] }}"></span>
                                        {{ $meta['label'] }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">No attendance records found</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Try adjusting your filters or date range</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($records->hasPages())
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                    {{ $records->links() }}
                </div>
            @endif

        </div>

    </div>
</div>
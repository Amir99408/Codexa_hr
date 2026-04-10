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

        .leave-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .leave-row:hover { background: linear-gradient(90deg,rgba(15,76,129,0.025) 0%,transparent 100%); }
        .leave-row:hover .row-bar { opacity:1; }
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
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Leave</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Leave Report</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">View and filter leave requests</p>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0 self-start flex-wrap">
                <a href="{{ route('reports.attendance') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Attendance Report
                </a>
                <a href="{{ route('reports.payroll') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Payroll Report
                </a>
                <a href="{{ route('pdf.leave', ['from_date' => $from_date, 'to_date' => $to_date, 'status' => $filterStatus]) }}"
                   class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/20 hover:shadow-red-500/30 hover:-translate-y-0.5 transition-all duration-200"
                   style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>

        {{-- ── Summary Stats ─────────────────────────────────────── --}}
        @php
            $total       = $summary['total'] ?: 1;
            $approvedPct = round(($summary['approved'] / $total) * 100);
            $pendingPct  = round(($summary['pending']  / $total) * 100);
            $rejectedPct = round(($summary['rejected'] / $total) * 100);
        @endphp
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

            {{-- Total --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-[#0f4c81] hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
                    <svg class="w-4 h-4 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $summary['total'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Requests</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-[#0f4c81] to-blue-400" style="width:100%"></div></div>
            </div>

            {{-- Approved --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-emerald-500 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">{{ $approvedPct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-emerald-600 tracking-tight mb-0.5">{{ $summary['approved'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Approved</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-emerald-500 to-emerald-400" style="width:{{ $approvedPct }}%"></div></div>
            </div>

            {{-- Pending --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-amber-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-full">{{ $pendingPct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-amber-500 tracking-tight mb-0.5">{{ $summary['pending'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pending</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-amber-400 to-amber-300" style="width:{{ $pendingPct }}%"></div></div>
            </div>

            {{-- Rejected --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-red-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-red-500 bg-red-50 px-1.5 py-0.5 rounded-full">{{ $rejectedPct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-red-500 tracking-tight mb-0.5">{{ $summary['rejected'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Rejected</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-red-400 to-red-300" style="width:{{ $rejectedPct }}%"></div></div>
            </div>

            {{-- Total Days --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-violet-500 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-violet-600 bg-violet-50 px-1.5 py-0.5 rounded-full uppercase tracking-wide">Days</span>
                </div>
                <p class="text-3xl font-extrabold text-violet-600 tracking-tight mb-0.5">{{ $summary['days'] }}</p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Days</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-violet-500 to-violet-400" style="width:100%"></div></div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <select wire:model.live="filterType" class="filter-select">
                        <option value="">All Types</option>
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <select wire:model.live="filterStatus" class="filter-select">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ── Leave Table ───────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Leave Records</span>
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
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Leave Type</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Duration</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Days</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($records as $rec)
                            <tr class="leave-row relative group">

                                <td class="p-0 w-0">
                                    <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 rounded-r
                                        {{ $rec->status === 'approved' ? 'bg-emerald-500' : ($rec->status === 'pending' ? 'bg-amber-400' : 'bg-red-400') }}">
                                    </div>
                                </td>

                                {{-- Employee --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($rec->employee->first_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                                {{ $rec->employee->full_name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Department --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="text-xs font-semibold text-gray-500">{{ $rec->employee->department?->name ?? '—' }}</span>
                                </td>

                                {{-- Leave Type --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-sm"
                                          style="background-color:{{ $rec->leaveType->color }};">
                                        {{ $rec->leaveType->name }}
                                    </span>
                                </td>

                                {{-- Duration --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-xl">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-gray-600">{{ $rec->from_date->format('d M') }}</span>
                                        <span class="text-gray-300">→</span>
                                        <span class="text-xs font-semibold text-gray-600">{{ $rec->to_date->format('d M Y') }}</span>
                                    </div>
                                </td>

                                {{-- Days --}}
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-[#0f4c81] border border-blue-100 rounded-lg text-xs font-extrabold">
                                        {{ $rec->days }}
                                        <span class="font-medium text-blue-400">day{{ $rec->days !== 1 ? 's' : '' }}</span>
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($rec->status === 'approved')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                            Approved
                                        </span>
                                    @elseif($rec->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full pulse"></span>
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 border border-red-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">No leave records found</p>
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
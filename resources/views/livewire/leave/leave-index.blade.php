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

        /* Table rows */
        .leave-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .leave-row:hover { background: linear-gradient(90deg,rgba(15,76,129,0.025) 0%,transparent 100%); }
        .leave-row:hover .row-bar { opacity:1; }
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

        /* Modal textarea */
        .modal-textarea {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            background: #fafafa;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            resize: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.18s ease;
            line-height: 1.6;
        }
        .modal-textarea:focus {
            background: #fff;
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.08);
        }
        .modal-textarea::placeholder { color:#9ca3af; font-weight:400; }
        .mi-wrap { position: relative; }
        .mi-wrap .mi {
            position: absolute; left:0.75rem; top:0.875rem;
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .mi-wrap:focus-within .mi { color:#ef4444; }

        /* Stat bar */
        .stat-bar { height:3px; border-radius:9999px; background:#f1f5f9; overflow:hidden; margin-top:0.875rem; }
        .stat-bar-fill { height:100%; border-radius:9999px; transition: width 1s cubic-bezier(0.4,0,0.2,1); }

        /* Avatar palette */
        .av-0{background:linear-gradient(135deg,#0f4c81,#1a6eb5)}
        .av-1{background:linear-gradient(135deg,#059669,#10b981)}
        .av-2{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
        .av-3{background:linear-gradient(135deg,#d97706,#fbbf24)}
        .av-4{background:linear-gradient(135deg,#e11d48,#fb7185)}
        .av-5{background:linear-gradient(135deg,#0891b2,#22d3ee)}
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ───────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Leave</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Leave Management</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Review and manage employee leave requests</p>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0 self-start">
                <a href="{{ route('leave.types') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Leave Types
                </a>
                <a href="{{ route('leave.create') }}"
                   class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                   style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Apply Leave
                </a>
            </div>
        </div>

        {{-- ── Toast ─────────────────────────────────────────────── --}}
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

        {{-- ── Stats ─────────────────────────────────────────────── --}}
        @php
            $total = $pending + $approved + $rejected;
            $pendingPct  = $total > 0 ? round(($pending  / $total) * 100) : 0;
            $approvedPct = $total > 0 ? round(($approved / $total) * 100) : 0;
            $rejectedPct = $total > 0 ? round(($rejected / $total) * 100) : 0;
        @endphp
        <div class="grid grid-cols-3 gap-4 mb-6">

            {{-- Pending --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-amber-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full uppercase tracking-wide">{{ $pendingPct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-amber-500 tracking-tight mb-0.5">{{ $pending }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pending</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-amber-400 to-amber-300" style="width:{{ $pendingPct }}%"></div>
                </div>
            </div>

            {{-- Approved --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-emerald-500 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full uppercase tracking-wide">{{ $approvedPct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-emerald-600 tracking-tight mb-0.5">{{ $approved }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Approved</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-emerald-500 to-emerald-400" style="width:{{ $approvedPct }}%"></div>
                </div>
            </div>

            {{-- Rejected --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-red-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-1 rounded-full uppercase tracking-wide">{{ $rejectedPct }}%</span>
                </div>
                <p class="text-3xl font-extrabold text-red-500 tracking-tight mb-0.5">{{ $rejected }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Rejected</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-red-400 to-red-300" style="width:{{ $rejectedPct }}%"></div>
                </div>
            </div>

        </div>

        {{-- ── Filters ────────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input wire:model.live="search" type="text" placeholder="Search employee..." class="filter-input"/>
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
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ── Leave Table ─────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card title --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Leave Requests</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $leaves->total() }} record{{ $leaves->total() !== 1 ? 's' : '' }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        
                        <tr style="background:linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">
                            <th></th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Employee</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden sm:table-cell">Leave Type</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Duration</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Days</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="text-right px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($leaves as $leave)
                            <tr class="leave-row relative group">

                                {{-- Accent bar --}}
                                <td class="p-0 w-0">
                                    <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 rounded-r
                                        {{ $leave->status === 'pending' ? 'bg-amber-400' : ($leave->status === 'approved' ? 'bg-emerald-500' : 'bg-red-400') }}">
                                    </div>
                                </td>

                                {{-- Employee --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($leave->employee->first_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                                {{ $leave->employee->full_name }}
                                            </p>
                                            <p class="text-xs text-gray-400 font-medium truncate">
                                                {{ $leave->employee->department?->name ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Leave Type --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-sm"
                                          style="background-color:{{ $leave->leaveType->color }};">
                                        {{ $leave->leaveType->name }}
                                    </span>
                                </td>

                                {{-- Duration --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-xl">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-gray-600">
                                            {{ $leave->from_date->format('d M') }}
                                        </span>
                                        <span class="text-gray-300">→</span>
                                        <span class="text-xs font-semibold text-gray-600">
                                            {{ $leave->to_date->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Days --}}
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-[#0f4c81] border border-blue-100 rounded-lg text-xs font-extrabold">
                                        {{ $leave->days }}
                                        <span class="font-medium text-blue-400">day{{ $leave->days !== 1 ? 's' : '' }}</span>
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($leave->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full pulse"></span>
                                            Pending
                                        </span>
                                    @elseif($leave->status === 'approved')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                            Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 border border-red-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        @if($leave->status === 'pending')
                                            <button wire:click="approve({{ $leave->id }})"
                                                    title="Approve"
                                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 hover:border-emerald-200 rounded-lg transition-all duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="hidden sm:inline">Approve</span>
                                            </button>
                                            <button wire:click="confirmReject({{ $leave->id }})"
                                                    title="Reject"
                                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-red-500 bg-red-50 hover:bg-red-100 border border-red-100 hover:border-red-200 rounded-lg transition-all duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                <span class="hidden sm:inline">Reject</span>
                                            </button>
                                        @endif
                                        <button wire:click="delete({{ $leave->id }})"
                                                wire:confirm="Delete this leave request?"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-red-50 hover:text-red-500 border border-gray-200 hover:border-red-200 rounded-lg transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">No leave requests found</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ $search || $filterDept || $filterStatus ? 'Try adjusting your filters' : 'No leave requests have been submitted yet' }}
                                            </p>
                                        </div>
                                        @if(!$search && !$filterDept && !$filterStatus)
                                            <a href="{{ route('leave.create') }}"
                                               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-900/20"
                                               style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Apply Leave
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($leaves->hasPages())
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                    {{ $leaves->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ── Reject Modal ─────────────────────────────────────────── --}}
    @if($rejectId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden scale-up">

                {{-- Red stripe --}}
                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171)"></div>

                {{-- Modal header --}}
                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between"
                     style="background:linear-gradient(135deg,#fff5f5 0%,#fef2f2 100%);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                             style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Reject Leave Request</h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">Provide a reason for the employee</p>
                        </div>
                    </div>
                    <button wire:click="$set('rejectId', null)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">

                    {{-- Warning --}}
                    <div class="flex items-start gap-2.5 p-3.5 bg-red-50 rounded-xl border border-red-100">
                        <svg class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-[11px] text-red-600 font-medium leading-relaxed">
                            The employee will be notified of this rejection. This action updates the leave status to <strong>Rejected</strong>.
                        </p>
                    </div>

                    {{-- Reason textarea --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                            Rejection Reason <span class="text-red-500">*</span>
                        </label>
                        <div class="mi-wrap">
                            <svg class="mi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <textarea wire:model="rejectionReason"
                                      rows="3"
                                      placeholder="Explain why this leave request is being rejected..."
                                      class="modal-textarea"></textarea>
                        </div>
                        @error('rejectionReason')
                            <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-1">
                        <button wire:click="$set('rejectId', null)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button wire:click="reject"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-150"
                                style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject Leave
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
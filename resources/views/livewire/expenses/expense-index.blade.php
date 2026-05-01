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

        /* ── Table rows ───────────────────────────────────────── */
        .claim-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .claim-row:hover { background: linear-gradient(90deg,rgba(15,76,129,0.025) 0%,transparent 100%); }
        .claim-row:hover .row-bar { opacity:1; }
        .row-bar { opacity:0; transition: opacity 0.15s; }

        /* ── Avatar palette ───────────────────────────────────── */
        .av-0{background:linear-gradient(135deg,#0f4c81,#1a6eb5)}
        .av-1{background:linear-gradient(135deg,#059669,#10b981)}
        .av-2{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
        .av-3{background:linear-gradient(135deg,#d97706,#fbbf24)}
        .av-4{background:linear-gradient(135deg,#e11d48,#fb7185)}
        .av-5{background:linear-gradient(135deg,#0891b2,#22d3ee)}

        /* ── Filter inputs ────────────────────────────────────── */
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

        /* ── Modal textarea ───────────────────────────────────── */
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

        /* ── Stat bar ─────────────────────────────────────────── */
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
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Expenses</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Expense Claims</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Review and manage employee expense claims</p>
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

        {{-- ── Stats ────────────────────────────────────────────── --}}
        @php
            $total    = $stats['total'];
            $pending  = $stats['pending'];
            $approved = $stats['approved'];
            $pendingPct  = $total > 0 ? round(($pending  / $total) * 100) : 0;
            $approvedPct = $total > 0 ? round(($approved / $total) * 100) : 0;
        @endphp
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            {{-- Total Claims --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-[#0f4c81] hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-[#0f4c81] bg-blue-50 px-2 py-1 rounded-full uppercase tracking-wide">All</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $stats['total'] }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Claims</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-[#0f4c81] to-blue-400" style="width:100%"></div>
                </div>
            </div>

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
                <p class="text-3xl font-extrabold text-amber-500 tracking-tight mb-0.5">{{ $stats['pending'] }}</p>
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
                <p class="text-3xl font-extrabold text-emerald-600 tracking-tight mb-0.5">{{ $stats['approved'] }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Approved</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-emerald-500 to-emerald-400" style="width:{{ $approvedPct }}%"></div>
                </div>
            </div>

            {{-- Total Approved Amount --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-violet-500 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-violet-600 bg-violet-50 px-2 py-1 rounded-full uppercase tracking-wide">{{ \App\Models\Setting::get('currency', 'PKR') }}</span>
                </div>
                <p class="text-2xl font-extrabold text-violet-600 tracking-tight mb-0.5">{{ currency($stats['total_amount']) }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Approved</p>
                <div class="stat-bar">
                    <div class="stat-bar-fill bg-gradient-to-r from-violet-500 to-violet-400" style="width:{{ $approvedPct }}%"></div>
                </div>
            </div>

        </div>

        {{-- ── Filters ───────────────────────────────────────────── --}}
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <select wire:model.live="filterStatus" class="filter-select">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="reimbursed">Reimbursed</option>
                    </select>
                </div>

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <select wire:model.live="filterCategory" class="filter-select">
                        <option value="">All Categories</option>
                        <option value="travel">Travel</option>
                        <option value="food">Food</option>
                        <option value="equipment">Equipment</option>
                        <option value="accommodation">Accommodation</option>
                        <option value="other">Other</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ── Claims Table ──────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card title bar --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Expense Claims</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $claims->total() }} record{{ $claims->total() !== 1 ? 's' : '' }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background:linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">
                            <th></th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Employee</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden sm:table-cell">Claim</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Amount</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Date</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="text-right px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($claims as $claim)
                            <tr class="claim-row relative group">

                                {{-- Accent bar --}}
                                <td class="p-0 w-0">
                                    <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 rounded-r
                                        {{ $claim->status === 'pending'     ? 'bg-amber-400'   :
                                          ($claim->status === 'approved'    ? 'bg-emerald-500' :
                                          ($claim->status === 'reimbursed'  ? 'bg-[#0f4c81]'  : 'bg-red-400')) }}">
                                    </div>
                                </td>

                                {{-- Employee --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($claim->employee->first_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                                {{ $claim->employee->full_name }}
                                            </p>
                                            <p class="text-xs text-gray-400 font-medium truncate">
                                                {{ $claim->employee->department?->name ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Claim --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <p class="text-sm font-bold text-gray-800 truncate max-w-[200px]">
                                        {{ $claim->category_icon }} {{ $claim->title }}
                                    </p>
                                    @if($claim->description)
                                        <p class="text-xs text-gray-400 font-medium truncate max-w-[200px] mt-0.5">{{ $claim->description }}</p>
                                    @endif
                                </td>

                                {{-- Amount --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-[#0f4c81] border border-blue-100 rounded-lg text-xs font-extrabold">
                                        {{ currency($claim->amount) }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-xl">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-gray-600">{{ $claim->expense_date->format('d M Y') }}</span>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($claim->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full pulse"></span>
                                            Pending
                                        </span>
                                    @elseif($claim->status === 'approved')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                            Approved
                                        </span>
                                    @elseif($claim->status === 'reimbursed')
                                        <div>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 bg-[#0f4c81] rounded-full"></span>
                                                Reimbursed
                                            </span>
                                            @if($claim->reimbursed_at)
                                                <p class="text-[10px] text-gray-400 font-medium mt-1">{{ $claim->reimbursed_at->format('d M Y') }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <div>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 border border-red-100 rounded-full text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                                Rejected
                                            </span>
                                            @if($claim->rejection_reason)
                                                <p class="text-[10px] text-red-400 font-medium mt-1 max-w-[160px] truncate">{{ $claim->rejection_reason }}</p>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        @if($claim->status === 'pending')
                                            <button wire:click="approve({{ $claim->id }})"
                                                    title="Approve"
                                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 hover:border-emerald-200 rounded-lg transition-all duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="hidden sm:inline">Approve</span>
                                            </button>
                                            <button wire:click="openReject({{ $claim->id }})"
                                                    title="Reject"
                                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-red-500 bg-red-50 hover:bg-red-100 border border-red-100 hover:border-red-200 rounded-lg transition-all duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                <span class="hidden sm:inline">Reject</span>
                                            </button>
                                        @endif
                                        @if($claim->status === 'approved')
                                            <button wire:click="markReimbursed({{ $claim->id }})"
                                                    wire:confirm="Mark this claim as reimbursed? This confirms payment has been made to {{ $claim->employee->full_name }}."
                                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-[#0f4c81] bg-blue-50 hover:bg-blue-100 border border-blue-100 hover:border-blue-200 rounded-lg transition-all duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                Reimburse
                                            </button>
                                        @endif
                                    </div>
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
                                            <p class="text-sm font-bold text-gray-500">No expense claims found</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ $search || $filterStatus || $filterCategory ? 'Try adjusting your filters' : 'No expense claims have been submitted yet' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($claims->hasPages())
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                    {{ $claims->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ── Reject Modal ──────────────────────────────────────────── --}}
    @if($showRejectModal)
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
                            <h3 class="text-sm font-extrabold text-gray-900">Reject Expense Claim</h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">Provide a reason for the employee</p>
                        </div>
                    </div>
                    <button wire:click="$set('showRejectModal', false)"
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
                            The employee will be notified of this rejection. This action updates the claim status to <strong>Rejected</strong>.
                        </p>
                    </div>

                    {{-- Reason --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                            Rejection Reason <span class="text-red-500">*</span>
                        </label>
                        <div class="mi-wrap">
                            <svg class="mi" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <textarea wire:model="rejection_reason"
                                      rows="3"
                                      placeholder="Why is this claim being rejected?"
                                      class="modal-textarea"></textarea>
                        </div>
                        @error('rejection_reason')
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
                        <button wire:click="$set('showRejectModal', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button wire:click="reject"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-150"
                                style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject Claim
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
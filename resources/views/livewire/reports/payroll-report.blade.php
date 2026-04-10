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

        .pay-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .pay-row:hover { background: linear-gradient(90deg,rgba(15,76,129,0.025) 0%,transparent 100%); }
        .pay-row:hover .row-bar { opacity:1; }
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
        .stat-bar-fill { height:100%; border-radius:9999px; }

        .dept-bar { height:4px; border-radius:9999px; background:#f1f5f9; overflow:hidden; margin-top:0.375rem; }
        .dept-bar-fill { height:100%; border-radius:9999px; background:linear-gradient(90deg,#0f4c81,#1a6eb5); transition: width 1s cubic-bezier(0.4,0,0.2,1); }
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
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Payroll</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Payroll Report</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Monthly payroll summary</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0 self-start">
                <a href="{{ route('reports.attendance') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Attendance Report
                </a>
                <a href="{{ route('reports.leave') }}"
                   class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Leave Report
                </a>
            </div>
        </div>

        {{-- ── Summary Stats ─────────────────────────────────────── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-[#0f4c81] hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $summary['total_employees'] }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Employees</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-[#0f4c81] to-blue-400" style="width:100%"></div></div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-violet-500 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-violet-600 bg-violet-50 px-2 py-1 rounded-full uppercase tracking-wide">Gross</span>
                </div>
                <p class="text-2xl font-extrabold text-violet-600 tracking-tight mb-0.5">{{ currency($summary['total_basic'] + $summary['total_earnings']) }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Gross</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-violet-500 to-violet-400" style="width:100%"></div></div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-red-400 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-1 rounded-full uppercase tracking-wide">−</span>
                </div>
                <p class="text-2xl font-extrabold text-red-500 tracking-tight mb-0.5">{{ currency($summary['total_deductions']) }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Deductions</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-red-400 to-red-300" style="width:100%"></div></div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-emerald-500 hover:-translate-y-0.5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full uppercase tracking-wide">Net</span>
                </div>
                <p class="text-2xl font-extrabold text-emerald-600 tracking-tight mb-0.5">{{ currency($summary['total_net']) }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Net Payable</p>
                <div class="stat-bar"><div class="stat-bar-fill bg-gradient-to-r from-emerald-500 to-emerald-400" style="width:100%"></div></div>
            </div>

        </div>

        {{-- ── Filters ───────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

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
                    <select wire:model.live="selectedMonth" class="filter-select">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <select wire:model.live="selectedYear" class="filter-select">
                        @foreach(range(now()->year - 2, now()->year + 1) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <select wire:model.live="filterStatus" class="filter-select">
                        <option value="">All Status</option>
                        <option value="draft">Draft</option>
                        <option value="processed">Processed</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ── Department Breakdown + Table ─────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Department Breakdown --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                     style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-800">By Department</span>
                    </div>
                </div>

                <div class="p-5 space-y-4">
                    @php $maxNet = collect($deptBreakdown)->max('net_total') ?: 1; @endphp
                    @forelse($deptBreakdown as $deptName => $data)
                        <div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $deptName }}</p>
                                    <p class="text-[11px] text-gray-400 font-medium">{{ $data['count'] }} employee{{ $data['count'] !== 1 ? 's' : '' }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-[#0f4c81] border border-blue-100 rounded-lg text-xs font-extrabold">
                                    {{ currency($data['net_total']) }}
                                </span>
                            </div>
                            <div class="dept-bar">
                                <div class="dept-bar-fill" style="width:{{ round(($data['net_total'] / $maxNet) * 100) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10 gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-gray-400">No data available</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Payroll Table --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                     style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-800">Payroll Records</span>
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
                                <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Basic</th>
                                <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Net</th>
                                <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/80">
                            @forelse($records as $rec)
                                <tr class="pay-row relative group">
                                    <td class="p-0 w-0">
                                        <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 rounded-r
                                            {{ $rec->status === 'paid' ? 'bg-emerald-500' : ($rec->status === 'processed' ? 'bg-[#0f4c81]' : 'bg-amber-400') }}">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                                {{ strtoupper(substr($rec->employee->first_name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                                    {{ $rec->employee->full_name }}
                                                </p>
                                                <p class="text-xs text-gray-400 font-medium truncate">{{ $rec->employee->department?->name ?? '—' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <span class="text-sm font-semibold text-gray-600">{{ currency($rec->basic_salary) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-[#0f4c81] border border-blue-100 rounded-lg text-xs font-extrabold">
                                            {{ currency($rec->net_salary) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($rec->status === 'paid')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>Paid
                                            </span>
                                        @elseif($rec->status === 'processed')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 bg-[#0f4c81] rounded-full"></span>Processed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full pulse"></span>Draft
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-bold text-gray-500">No payroll records found</p>
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
</div>
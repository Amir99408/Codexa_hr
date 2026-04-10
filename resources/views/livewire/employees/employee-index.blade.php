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

        @keyframes fadeIn  { from { opacity:0; } to { opacity:1; } }
        @keyframes scaleUp { from { opacity:0; transform:scale(0.96) translateY(8px); } to { opacity:1; transform:scale(1) translateY(0); } }
        @keyframes slideDown { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
        @keyframes pulse-dot { 0%,100% { opacity:1; } 50% { opacity:.4; } }

        .fade-in   { animation: fadeIn   0.25s ease both; }
        .scale-up  { animation: scaleUp  0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down{ animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }

        .active-dot { animation: pulse-dot 2s ease infinite; }

        /* Table row */
        .emp-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .emp-row:hover { background: linear-gradient(90deg, rgba(15,76,129,0.025) 0%, transparent 100%); }
        .emp-row:hover .row-bar { opacity:1; }
        .row-bar { opacity:0; transition: opacity 0.15s; }

        /* Filter inputs */
        .filter-input {
            width: 100%;
            padding: 0.5625rem 0.875rem 0.5625rem 2.375rem;
            font-size: 0.8125rem;
            font-weight: 500;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .filter-input:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .filter-input::placeholder { color: #9ca3af; font-weight: 400; }
        .filter-select {
            width: 100%;
            padding: 0.5625rem 0.875rem 0.5625rem 2.375rem;
            font-size: 0.8125rem;
            font-weight: 500;
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #374151;
            outline: none;
            appearance: none;
            cursor: pointer;
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .filter-select:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .filter-wrap { position: relative; }
        .filter-wrap .f-icon {
            position: absolute; left: 0.75rem; top: 50%;
            transform: translateY(-50%);
            pointer-events: none; color: #9ca3af;
            transition: color 0.18s;
            width: 1rem; height: 1rem;
        }
        .filter-wrap:focus-within .f-icon { color: #0f4c81; }

        /* Avatar palette */
        .av-0 { background: linear-gradient(135deg,#0f4c81,#1a6eb5); }
        .av-1 { background: linear-gradient(135deg,#059669,#10b981); }
        .av-2 { background: linear-gradient(135deg,#7c3aed,#a78bfa); }
        .av-3 { background: linear-gradient(135deg,#d97706,#fbbf24); }
        .av-4 { background: linear-gradient(135deg,#e11d48,#fb7185); }
        .av-5 { background: linear-gradient(135deg,#0891b2,#22d3ee); }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ─────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Employees</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Employees</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Manage and track all your team members</p>
            </div>

            <a href="{{ route('employees.create') }}"
               class="flex-shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200 self-start"
               style="background: linear-gradient(135deg, #0f4c81 0%, #1a6eb5 100%);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="hidden sm:inline">Add Employee</span>
                <span class="sm:hidden">Add</span>
            </a>
        </div>

        {{-- ── Quick Stat Pills ─────────────────────────────────── --}}
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xl font-extrabold text-gray-900 leading-none">{{ $employees->total() }}</p>
                    <p class="text-[11px] font-semibold text-gray-400 mt-0.5 truncate">Total</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 active-dot"></span>
                </div>
                <div class="min-w-0">
                    <p class="text-xl font-extrabold text-emerald-600 leading-none">
                        {{ $employees->getCollection()->where('status','active')->count() }}
                    </p>
                    <p class="text-[11px] font-semibold text-gray-400 mt-0.5 truncate">Active</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xl font-extrabold text-red-500 leading-none">
                        {{ $employees->getCollection()->where('status','terminated')->count() }}
                    </p>
                    <p class="text-[11px] font-semibold text-gray-400 mt-0.5 truncate">Terminated</p>
                </div>
            </div>
        </div>

        {{-- ── Filters ──────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                {{-- Search --}}
                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input wire:model.live="search"
                           type="text"
                           placeholder="Search by name or code..."
                           class="filter-input"/>
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
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ── Table Card ───────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Table title row --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background: linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Employee Directory</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $employees->total() }} result{{ $employees->total() !== 1 ? 's' : '' }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background: linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">
                            <th></th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Employee</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Code</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Department</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Designation</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden sm:table-cell">Salary</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="text-right px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($employees as $employee)
                            <tr class="emp-row relative group">

                                {{-- Hover accent bar --}}
                                <td class="p-0 w-0">
                                    <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 bg-[#0f4c81] rounded-r"></div>
                                </td>

                                {{-- Employee --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($employee->photo && file_exists(public_path('storage/' . $employee->photo)))
                                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                                 alt="{{ $employee->full_name }}"
                                                 class="w-10 h-10 rounded-xl object-cover flex-shrink-0 shadow-sm ring-2 ring-white"/>
                                        @else
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                                {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                                {{ $employee->full_name }}
                                            </p>
                                            <p class="text-xs text-gray-400 font-medium truncate">
                                                {{ $employee->phone ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Code --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="inline-flex items-center px-2.5 py-1 bg-slate-50 border border-slate-200 text-slate-500 rounded-lg text-xs font-mono font-bold tracking-wider">
                                        {{ $employee->emp_code }}
                                    </span>
                                </td>

                                {{-- Department --}}
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if($employee->department?->name)
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-50 border border-gray-200 px-2.5 py-1 rounded-lg">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#0f4c81]/40"></span>
                                            {{ $employee->department->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Designation --}}
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <span class="text-xs font-semibold text-gray-500">
                                        {{ $employee->designation ?? '—' }}
                                    </span>
                                </td>

                                {{-- Salary --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="text-sm font-bold text-gray-700">
                                        {{ currency($employee->basic_salary) }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($employee->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full active-dot"></span>
                                            Active
                                        </span>
                                    @elseif($employee->status === 'inactive')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span>
                                            Inactive
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 border border-red-100 rounded-full text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                            Terminated
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('employees.edit', $employee) }}"
                                           class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-blue-50 hover:text-[#0f4c81] border border-gray-200 hover:border-blue-200 rounded-lg transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </a>
                                        <button wire:click="confirmDelete({{ $employee->id }})"
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">No employees found</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                @if($search || $filterDept || $filterStatus)
                                                    Try adjusting your filters or search term
                                                @else
                                                    Get started by adding your first team member
                                                @endif
                                            </p>
                                        </div>
                                        @if(!$search && !$filterDept && !$filterStatus)
                                            <a href="{{ route('employees.create') }}"
                                               class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-900/20"
                                               style="background: linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Add First Employee
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($employees->hasPages())
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                    {{ $employees->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ── Delete Modal ─────────────────────────────────────────── --}}
    @if($deleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background: rgba(15,23,42,0.45); backdrop-filter: blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden scale-up">

                {{-- Red stripe --}}
                <div class="h-1.5 w-full" style="background: linear-gradient(90deg,#ef4444,#f87171)"></div>

                <div class="p-7">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-2xl flex items-center justify-center"
                         style="background: linear-gradient(135deg,#fef2f2,#fee2e2);">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>

                    <h3 class="text-base font-extrabold text-gray-900 text-center mb-1.5">Delete Employee?</h3>
                    <p class="text-sm text-gray-400 text-center leading-relaxed mb-1">This will permanently remove the employee and all associated records.</p>
                    <p class="text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded-xl px-3 py-2 text-center font-medium mb-6">
                        ⚠️ This action cannot be undone
                    </p>

                    <div class="flex gap-3">
                        <button wire:click="$set('deleteId', null)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button wire:click="deleteEmployee"
                                class="flex-1 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-150"
                                style="background: linear-gradient(135deg,#ef4444,#dc2626);">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
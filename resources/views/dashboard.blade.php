<x-app-layout>

    {{-- Google Font: Plus Jakarta Sans --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .mesh-bg {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 20% 10%, rgba(15,76,129,0.06) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(255,107,53,0.05) 0px, transparent 50%),
                radial-gradient(at 100% 80%, rgba(15,76,129,0.04) 0px, transparent 50%);
        }

        .card-hover {
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(15,76,129,0.10), 0 2px 8px rgba(0,0,0,0.04);
        }

        .shimmer-line {
            background: linear-gradient(90deg, rgba(255,255,255,0.0) 0%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0.0) 100%);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .action-arrow {
            opacity: 0;
            transform: translateX(-4px);
            transition: all 0.2s ease;
        }
        .action-tile:hover .action-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        .bar-fill {
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .emp-avatar {
            background: linear-gradient(135deg, #0f4c81 0%, #1a6eb5 100%);
        }
        .emp-avatar-green  { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
        .emp-avatar-violet { background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%); }
        .emp-avatar-rose   { background: linear-gradient(135deg, #e11d48 0%, #fb7185 100%); }
        .emp-avatar-amber  { background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%); }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Header ───────────────────────────────────────────────────── --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-semibold tracking-widest text-[#0f4c81]/60 uppercase">
                        {{ now()->format('l, d F Y') }}
                    </span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-gray-900 leading-tight">
                    Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }},
                    <span class="text-[#0f4c81]">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    <span class="ml-1">👋</span>
                </h1>
                <p class="text-sm text-gray-400 mt-0.5 font-medium">Here's what's happening with your team today.</p>
            </div>

            <a href="{{ route('employees.create') }}"
               class="hidden lg:flex items-center gap-2 px-5 py-2.5 bg-[#0f4c81] text-white rounded-xl text-sm font-semibold shadow-lg shadow-blue-900/20 hover:bg-blue-800 hover:shadow-blue-900/30 transition-all duration-200 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add Employee
            </a>
        </div>

        {{-- ── Stat Cards ───────────────────────────────────────────────── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            {{-- Total Employees --}}
            <div class="card-hover bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-[#0f4c81]">
                <div class="flex items-start justify-between mb-5">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#0f4c81] to-[#1a6eb5] flex items-center justify-center shadow-lg shadow-blue-900/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold tracking-wide text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full uppercase">Active</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $stats['total_employees'] }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Employees</p>
                <div class="mt-4 h-1 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#0f4c81] to-[#1a6eb5] rounded-full bar-fill" style="width:100%"></div>
                </div>
            </div>

            {{-- Present Today --}}
            <div class="card-hover bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-emerald-500">
                <div class="flex items-start justify-between mb-5">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold tracking-wide text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase">In Office</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $stats['present_today'] }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Present Today</p>
                @php $presentRate = $stats['total_employees'] > 0 ? round(($stats['present_today'] / $stats['total_employees']) * 100) : 0; @endphp
                <div class="mt-4 h-1 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full bar-fill" style="width:{{ $presentRate }}%"></div>
                </div>
            </div>

            {{-- On Leave Today --}}
            <div class="card-hover bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-amber-400">
                <div class="flex items-start justify-between mb-5">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-400 flex items-center justify-center shadow-lg shadow-amber-400/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold tracking-wide text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full uppercase">Away</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $stats['on_leave_today'] }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">On Leave Today</p>
                @php $leaveRate = $stats['total_employees'] > 0 ? round(($stats['on_leave_today'] / $stats['total_employees']) * 100) : 0; @endphp
                <div class="mt-4 h-1 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full bar-fill" style="width:{{ $leaveRate }}%"></div>
                </div>
            </div>

            {{-- Pending Leaves --}}
            <div class="card-hover bg-white rounded-2xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-[#ff6b35]">
                <div class="flex items-start justify-between mb-5">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#ff6b35] to-orange-400 flex items-center justify-center shadow-lg shadow-orange-400/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold tracking-wide text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full uppercase">Review</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 tracking-tight mb-0.5">{{ $stats['pending_leaves'] }}</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pending Leaves</p>
                <div class="mt-4 h-1 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#ff6b35] to-orange-400 rounded-full bar-fill" style="width:{{ $stats['pending_leaves'] > 0 ? min(100, $stats['pending_leaves'] * 10) : 5 }}%"></div>
                </div>
            </div>

        </div>

        {{-- ── Main Grid ─────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            {{-- Recent Employees ──────────────────────────────────────── --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-[#0f4c81]/8 bg-blue-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Recent Employees</h3>
                            <p class="text-[11px] text-gray-400">Latest team additions</p>
                        </div>
                    </div>
                    <a href="{{ route('employees.index') }}"
                       class="flex items-center gap-1 text-xs font-semibold text-[#0f4c81] bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors duration-150">
                        View All
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="divide-y divide-gray-50/80">
                    @php
                        $avatarClasses = ['emp-avatar', 'emp-avatar-green', 'emp-avatar-violet', 'emp-avatar-rose', 'emp-avatar-amber'];
                    @endphp

                    @forelse($recentEmployees as $index => $emp)
                        <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50/70 transition-colors duration-150 group">

                            {{-- Avatar --}}
                            <div class="w-10 h-10 rounded-xl overflow-hidden flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm {{ $avatarClasses[$index % count($avatarClasses)] }}">

    @if($emp->photo)
        <img src="{{ asset('storage/' . $emp->photo) }}"
             class="w-full h-full object-cover"
             alt="{{ $emp->full_name }}">
    @else
        {{ strtoupper(substr($emp->first_name, 0, 1)) }}
    @endif

</div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                    {{ $emp->full_name }}
                                </p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    @if($emp->designation)
                                        <span class="text-[11px] text-gray-400 font-medium">{{ $emp->designation }}</span>
                                    @endif
                                    @if($emp->department?->name)
                                        <span class="text-gray-300">·</span>
                                        <span class="text-[11px] text-gray-400 font-medium truncate">{{ $emp->department->name }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Right side --}}
                            <div class="flex items-center gap-2.5 flex-shrink-0">
                                <span class="hidden sm:block text-xs font-mono text-gray-300 bg-gray-50 px-2 py-0.5 rounded-md">
                                    {{ $emp->emp_code }}
                                </span>
                                @if($emp->status === 'active')
                                    <span class="flex items-center gap-1 text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="flex items-center gap-1 text-[11px] font-semibold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span>
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-14 text-center">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-gray-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-400">No employees yet</p>
                            <p class="text-xs text-gray-300 mt-1">Add your first team member to get started</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ── Right Column ──────────────────────────────────────────── --}}
            <div class="flex flex-col gap-5">

                {{-- Payroll Card ─────────────────────────────────────────── --}}
                <div class="relative bg-[#0a3560] rounded-2xl p-6 text-white overflow-hidden shadow-xl shadow-blue-900/25">

                    {{-- Background orbs --}}
                    <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full bg-white/5 pointer-events-none"></div>
                    <div class="absolute -bottom-10 -left-6 w-32 h-32 rounded-full bg-[#ff6b35]/10 pointer-events-none"></div>

                    {{-- Shimmer stripe --}}
                    <div class="absolute inset-0 shimmer-line pointer-events-none rounded-2xl"></div>

                    <div class="relative">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-10 h-10 bg-white/15 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <a href="{{ route('payroll.index') }}"
                               class="text-xs font-semibold text-blue-200 hover:text-white bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg transition-all duration-150">
                                View →
                            </a>
                        </div>

                        <p class="text-blue-300 text-[11px] font-bold uppercase tracking-widest mb-2">Payroll This Month</p>
                        <p class="text-3xl font-extrabold mb-1 tracking-tight">{{ currency($payrollThisMonth) }}</p>
                        <p class="text-blue-300 text-xs font-medium">{{ now()->format('F Y') }}</p>

                        <div class="mt-5 pt-4 border-t border-white/15">
                            <a href="{{ route('payroll.index') }}"
                               class="flex items-center justify-center gap-2 w-full py-2.5 bg-white/15 hover:bg-white/25 border border-white/20 rounded-xl text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-black/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Run Payroll
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Quick Stats ────────────────────────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-orange-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#ff6b35]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Quick Stats</h3>
                            <p class="text-[11px] text-gray-400">Overview at a glance</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-gray-50/80 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#0f4c81]"></div>
                                <span class="text-sm text-gray-500 font-medium">Departments</span>
                            </div>
                            <span class="text-sm font-extrabold text-gray-800">{{ $totalDepartments }}</span>
                        </div>

                        <div class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-gray-50/80 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-violet-500"></div>
                                <span class="text-sm text-gray-500 font-medium">Total Staff</span>
                            </div>
                            <span class="text-sm font-extrabold text-gray-800">{{ $stats['total_employees_count'] }}</span>
                        </div>

                        <div class="py-2.5 px-3 rounded-xl bg-gray-50/80">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-sm text-gray-500 font-medium">Attendance Rate</span>
                                </div>
                                @php
                                    $rate = $stats['total_employees'] > 0
                                        ? round(($stats['present_today'] / $stats['total_employees']) * 100)
                                        : 0;
                                @endphp
                                <span class="text-sm font-extrabold text-emerald-600">{{ $rate }}%</span>
                            </div>
                            <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full bar-fill transition-all duration-1000"
                                     style="width: {{ $rate }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Quick Actions ─────────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-orange-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#ff6b35]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Quick Actions</h3>
                    <p class="text-[11px] text-gray-400">Jump right in</p>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

                <a href="{{ route('employees.create') }}"
                   class="action-tile group flex items-center justify-between p-4 rounded-xl bg-blue-50 hover:bg-[#0f4c81] border border-blue-100 hover:border-[#0f4c81] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-900/15">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white group-hover:bg-white/20 flex items-center justify-center flex-shrink-0 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 text-[#0f4c81] group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-[#0f4c81] group-hover:text-white transition-colors duration-200">Add Employee</span>
                    </div>
                    <svg class="action-arrow w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('attendance.index') }}"
                   class="action-tile group flex items-center justify-between p-4 rounded-xl bg-emerald-50 hover:bg-emerald-600 border border-emerald-100 hover:border-emerald-600 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-600/15">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white group-hover:bg-white/20 flex items-center justify-center flex-shrink-0 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 text-emerald-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-emerald-700 group-hover:text-white transition-colors duration-200">Attendance</span>
                    </div>
                    <svg class="action-arrow w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('leave.index') }}"
                   class="action-tile group flex items-center justify-between p-4 rounded-xl bg-amber-50 hover:bg-amber-500 border border-amber-100 hover:border-amber-500 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-amber-500/15">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white group-hover:bg-white/20 flex items-center justify-center flex-shrink-0 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 text-amber-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-amber-700 group-hover:text-white transition-colors duration-200">Manage Leaves</span>
                    </div>
                    <svg class="action-arrow w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('payroll.index') }}"
                   class="action-tile group flex items-center justify-between p-4 rounded-xl bg-orange-50 hover:bg-[#ff6b35] border border-orange-100 hover:border-[#ff6b35] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/15">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white group-hover:bg-white/20 flex items-center justify-center flex-shrink-0 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 text-[#ff6b35] group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-orange-700 group-hover:text-white transition-colors duration-200">Run Payroll</span>
                    </div>
                    <svg class="action-arrow w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

            </div>
        </div>

    </div>
</x-app-layout>
<div class="flex flex-col h-full w-64 relative overflow-hidden" style="background: linear-gradient(175deg, #0d3f6e 0%, #0f4c81 40%, #0c3d6b 100%);">

    <style>
        

        .sidebar-root * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Hide scrollbar but keep scroll */
        .nav-scroll::-webkit-scrollbar { display: none; }
        .nav-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* Nav item base */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.625rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: rgba(186,214,255,0.75);
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
            position: relative;
            margin-bottom: 1px;
            text-decoration: none;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.07);
            color: #ffffff;
        }
        .nav-item:hover .nav-icon { color: #93c5fd; transform: scale(1.08); }

        /* Active state */
        .nav-item.active {
            background: linear-gradient(135deg, #ff6b35 0%, #e85d26 100%);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(255,107,53,0.35), inset 0 1px 0 rgba(255,255,255,0.15);
        }
        .nav-item.active .nav-icon { color: #ffffff; }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            top: 50%; transform: translateY(-50%);
            width: 3px; height: 60%;
            background: #ff6b35;
            border-radius: 0 2px 2px 0;
            box-shadow: 0 0 8px rgba(255,107,53,0.6);
        }

        .nav-icon {
            width: 1.125rem; height: 1.125rem;
            flex-shrink: 0;
            transition: all 0.18s ease;
        }

        /* Section label */
        .nav-section {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 0.75rem 0.375rem;
        }
        .nav-section span {
            font-size: 0.625rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(147,197,253,0.45);
            white-space: nowrap;
        }
        .nav-section-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, rgba(147,197,253,0.15), transparent);
            border-radius: 1px;
        }

        /* Sidebar depth orbs */
        .orb-1 {
            position: absolute;
            top: -4rem; right: -4rem;
            width: 12rem; height: 12rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,107,53,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .orb-2 {
            position: absolute;
            bottom: 6rem; left: -5rem;
            width: 14rem; height: 14rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(15,76,129,0.4) 0%, transparent 70%);
            pointer-events: none;
        }
    </style>

    {{-- Depth orbs --}}
    <div class="orb-1"></div>
    <div class="orb-2"></div>

    <div class="sidebar-root flex flex-col h-full relative z-10">

        {{-- ── Logo ─────────────────────────────────────────── --}}
<div class="flex items-center gap-3 px-5 py-5 flex-shrink-0" style="border-bottom: 1px solid rgba(255,255,255,0.07);">
    <div class="relative flex-shrink-0">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30"
             style="background: linear-gradient(135deg, #ff6b35 0%, #e85d26 100%);">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 border-2 border-[#0f4c81] rounded-full"></span>
    </div>

    <div class="flex-1">
        <div class="leading-none mb-0.5" style="font-family:'Syne',sans-serif;">
            <span class="text-white font-bold text-lg tracking-tight">HR</span>
            <span class="font-bold text-lg" style="color:#ff6b35;">Flow</span>
        </div>
        <p class="text-[10px] font-semibold tracking-widest uppercase" style="color:rgba(147,197,253,0.5);">HR Management</p>
    </div>

    {{-- Close button — mobile only --}}
    <button onclick="closeSidebar()"
            class="lg:hidden flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-xl
                   text-blue-300 hover:text-white hover:bg-white/10
                   transition-all duration-150">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
        

        {{-- ── Navigation ──────────────────────────────────── --}}
        <nav class="nav-scroll flex-1 overflow-y-auto px-3 py-3">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
                @if(request()->routeIs('dashboard'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            {{-- People ──────────────────────────────────────── --}}
            <div class="nav-section">
                <span>People</span>
                <div class="nav-section-line"></div>
            </div>

            <a href="{{ route('employees.index') }}"
               class="nav-item {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Employees
                @if(request()->routeIs('employees.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            <a href="{{ route('departments.index') }}"
               class="nav-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Departments
                @if(request()->routeIs('departments.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            {{-- Recruitment ───────────────────────────────── --}}
            <div class="nav-section">
                <span>Recruitment</span>
                <div class="nav-section-line"></div>
            </div>

            <a href="{{ route('recruitment.jobs') }}"
               class="nav-item {{ request()->routeIs('recruitment.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Recruitment
                @if(request()->routeIs('recruitment.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            <a href="{{ route('performance.index') }}"
               class="nav-item {{ request()->routeIs('performance.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Performance
                @if(request()->routeIs('performance.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            {{-- Time & Leave ──────────────────────────────── --}}
            <div class="nav-section">
                <span>Time & Leave</span>
                <div class="nav-section-line"></div>
            </div>

            <a href="{{ route('attendance.index') }}"
               class="nav-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Attendance
                @if(request()->routeIs('attendance.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            <a href="{{ route('leave.index') }}"
               class="nav-item {{ request()->routeIs('leave.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Leave
                @if(request()->routeIs('leave.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            <a href="{{ route('holidays.index') }}"
               class="nav-item {{ request()->routeIs('holidays.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Holidays
                @if(request()->routeIs('holidays.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            <a href="{{ route('shifts.index') }}"
               class="nav-item {{ request()->routeIs('shifts.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Shifts
                @if(request()->routeIs('shifts.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            {{-- Finance ───────────────────────────────────── --}}
            <div class="nav-section">
                <span>Finance</span>
                <div class="nav-section-line"></div>
            </div>

            <a href="{{ route('payroll.index') }}"
               class="nav-item {{ request()->routeIs('payroll.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Payroll
                @if(request()->routeIs('payroll.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            <a href="{{ route('expenses.index') }}"
               class="nav-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                </svg>
                Expenses
                @if(request()->routeIs('expenses.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            {{-- Analytics ────────────────────────────────── --}}
            <div class="nav-section">
                <span>Analytics</span>
                <div class="nav-section-line"></div>
            </div>

            <a href="{{ route('reports.attendance') }}"
               class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Reports
                @if(request()->routeIs('reports.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            {{-- System ────────────────────────────────────── --}}
            <div class="nav-section">
                <span>System</span>
                <div class="nav-section-line"></div>
            </div>

            <a href="{{ route('audit.index') }}"
               class="nav-item {{ request()->routeIs('audit.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Audit Log
                @if(request()->routeIs('audit.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            <a href="{{ route('notifications.index') }}"
               class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Notifications
                @if(request()->routeIs('notifications.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            <a href="{{ route('settings.company') }}"
               class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
                @if(request()->routeIs('settings.*'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                @endif
            </a>

            {{-- Bottom padding --}}
            <div class="h-3"></div>
        </nav>

        {{-- ── User Profile Footer ──────────────────────────── --}}
        <div class="flex-shrink-0 p-3" style="border-top: 1px solid rgba(255,255,255,0.07);">
            <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-colors duration-150 group">

                {{-- Avatar with ring --}}
                <div class="relative flex-shrink-0">
                    <div class="w-9 h-9 rounded-xl overflow-hidden flex-shrink-0 bg-[#ff6b35] flex items-center justify-center">
    @if(auth()->user()->photo)
        <img src="{{ auth()->user()->photo }}" class="w-full h-full object-cover"/>
    @else
        <span class="text-white text-sm font-bold">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </span>
    @endif
</div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 border-2 rounded-full"
                          style="border-color: #0f4c81;"></span>
                </div>

                {{-- Name + role --}}
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-bold truncate leading-tight">
                        {{ auth()->user()->name ?? 'Admin User' }}
                    </p>
                    <p class="text-[10px] font-medium truncate mt-0.5" style="color:rgba(147,197,253,0.55);">
                        {{ auth()->user()->email ?? '' }}
                    </p>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                    @csrf
                    <button type="submit"
                            title="Sign out"
                            class="w-8 h-8 flex items-center justify-center rounded-lg transition-all duration-150 hover:bg-red-500/20 hover:text-red-300"
                            style="color:rgba(147,197,253,0.45);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
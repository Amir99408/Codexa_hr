<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @php
        $appName = \App\Models\Setting::get('company_name') ?: config('app.name', 'DevStaq HR');
        $favicon = \App\Models\Setting::get('company_favicon', '');
        $companyLogo = \App\Models\Setting::get('company_logo', '');
    @endphp
    <title>{{ $title ?? 'Employee Portal' }} — {{ $appName }}</title>
    @if($favicon)
        <link rel="icon" href="{{ $favicon }}" type="image/x-icon"/>
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Syne', sans-serif;
        }

        /* Hide scrollbar on portal nav, same as admin sidebar */
        .portal-nav::-webkit-scrollbar { display: none; }
        .portal-nav { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes pulse-t { 0%,100%{opacity:1;} 50%{opacity:.3;} }
    </style>
</head>

<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden" style="display:none">
        </div>

        {{-- Portal Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 transform transition-transform duration-200 ease-in-out
                  lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:flex-shrink-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="flex flex-col h-full w-64 bg-[#0f4c81]">

                {{-- Logo --}}
                <div class="flex items-center gap-3 px-5 py-5 border-b border-blue-700 flex-shrink-0">
                    @if($companyLogo)
                        <div class="w-9 h-9 rounded-lg overflow-hidden bg-white/10 flex items-center justify-center flex-shrink-0">
                            <img src="{{ $companyLogo }}" alt="{{ $appName }}" class="w-full h-full object-contain p-0.5"/>
                        </div>
                    @else
                        <div class="w-9 h-9 bg-[#ff6b35] rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif
                    <div class="min-w-0">
                        <p class="text-white font-bold text-sm truncate" style="font-family:'Syne',sans-serif">
                            {{ $appName }}
                        </p>
                        <p class="text-blue-300 text-xs">Employee Portal</p>
                    </div>
                </div>

                {{-- Nav --}}
                <nav class="portal-nav flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

                    <p class="text-blue-400 text-xs font-semibold uppercase px-3 pt-2 pb-1 tracking-wider">My Portal</p>

                    <a href="{{ route('employee.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
                          {{ request()->routeIs('employee.dashboard') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('employee.attendance') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
                          {{ request()->routeIs('employee.attendance') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        My Attendance
                    </a>

                    <a href="{{ route('employee.leave.apply') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
                          {{ request()->routeIs('employee.leave.*') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        My Leaves
                    </a>

                    <a href="{{ route('employee.payslips') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
                          {{ request()->routeIs('employee.payslips') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        My Payslips
                    </a>

                    <a href="{{ route('employee.expenses') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
          {{ request()->routeIs('employee.expenses') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                        </svg>
                        My Expenses
                    </a>
                    <a href="{{ route('employee.shifts') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
          {{ request()->routeIs('employee.shifts') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        My Shifts
                    </a>
                    <a href="{{ route('employee.advance') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
          {{ request()->routeIs('employee.advance') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        My Advance
                    </a>
                    <a href="{{ route('employee.warnings') }}"
   class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
          {{ request()->routeIs('employee.warnings') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    My Warnings
</a>

                    <p class="text-blue-400 text-xs font-semibold uppercase px-3 pt-4 pb-1 tracking-wider">Account</p>

                    <a href="{{ route('employee.update-photo') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
                          {{ request()->routeIs('employee.update-photo') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Update Photo
                    </a>

                    <a href="{{ route('employee.change-password') }}"
                        class="flex items-center gap-3 px-3 py-2.5 mb-1 rounded-lg text-sm font-medium
                          {{ request()->routeIs('employee.change-password') ? 'bg-[#ff6b35] text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Change Password
                    </a>

                </nav>

                {{-- User at bottom --}}
                <div class="border-t border-blue-700 p-4 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        @php $portalEmployee = auth()->user()->employee; @endphp
                        @if($portalEmployee?->photo)
                            <img src="{{ asset('storage/' . $portalEmployee->photo) }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="w-9 h-9 rounded-full object-cover flex-shrink-0 ring-2 ring-white/20"/>
                        @else
                            <div class="w-9 h-9 rounded-full bg-[#ff6b35] flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name ?? 'E', 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                            <p class="text-blue-300 text-xs">Employee</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="p-1.5 text-blue-300 hover:text-white hover:bg-blue-700 rounded-lg transition"
                                title="Logout">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Topbar --}}
            <header class="bg-white border-b border-gray-100 px-4 lg:px-6 py-3 flex items-center gap-3 flex-shrink-0">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex-1 flex items-center justify-between">
                    <h1 class="text-sm font-semibold text-gray-700">{{ $title ?? 'Employee Portal' }}</h1>
                    <div class="flex items-center gap-3">
                        @php $_showBar = ($_trackToken ?? null) && ($_trackActive ?? false); @endphp
                        <div id="tracking-status-bar"
                             style="display:{{ $_showBar ? 'flex' : 'none' }};align-items:center;gap:5px;background:#ecfdf5;border:1px solid #d1fae5;border-radius:20px;padding:3px 10px 3px 7px;cursor:pointer;"
                             onclick="_stopTracking()" title="Location tracking active — click to stop">
                            <span style="width:7px;height:7px;border-radius:50%;background:#10b981;flex-shrink:0;animation:pulse-t 2s infinite;"></span>
                            <span style="font-size:11px;font-weight:600;color:#065f46;white-space:nowrap;">Tracking</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ now()->format('l, d M Y') }}</span>
                        <livewire:notification-bell />
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

    @livewireScripts

    {{-- Auto location tracking when marked present --}}
    @php
        $_trackEmp   = auth()->user()?->employee;
        $_trackToken = $_trackEmp?->location_token;
        $_trackActive = $_trackEmp && \App\Models\Attendance::where('employee_id', $_trackEmp->id)
            ->whereDate('date', today())
            ->whereIn('status', ['present', 'late', 'work_from_home', 'half_day'])
            ->exists();
    @endphp

    @if($_trackToken && $_trackActive)
    <script>
    (function() {
        const PING_URL = '{{ route("location.ping") }}';
        const TOKEN    = '{{ $_trackToken }}';
        const CSRF     = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        let watchId   = null;
        let pingTimer = null;
        let lastCoords = null;

        const bar = document.getElementById('tracking-status-bar');

        function ping(coords) {
            lastCoords = coords;
            fetch(PING_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ token: TOKEN, latitude: coords.latitude, longitude: coords.longitude, accuracy: coords.accuracy }),
            }).catch(() => {});
        }

        function start() {
            if (!navigator.geolocation) return;
            navigator.geolocation.getCurrentPosition(function(pos) {
                ping(pos.coords);
                watchId = navigator.geolocation.watchPosition(function(p) { lastCoords = p.coords; }, null, { enableHighAccuracy: true, maximumAge: 30000 });
                pingTimer = setInterval(function() { if (lastCoords) ping(lastCoords); }, 60000);
                if (bar) { bar.style.display = 'flex'; }
            }, null, { enableHighAccuracy: true, timeout: 15000 });
        }

        window._stopTracking = function() {
            if (watchId !== null) { navigator.geolocation.clearWatch(watchId); watchId = null; }
            if (pingTimer !== null) { clearInterval(pingTimer); pingTimer = null; }
            if (bar) bar.style.display = 'none';
        };

        // Start automatically
        start();
    })();
    </script>
    @endif
</body>

</html>

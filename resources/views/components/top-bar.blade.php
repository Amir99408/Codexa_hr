@props(['title' => 'Dashboard'])

<header class="h-16 bg-white/95 backdrop-blur-sm border-b border-gray-100 flex items-center justify-between px-4 lg:px-6 flex-shrink-0 shadow-sm shadow-gray-100/80">

    <style>
        .search-input {
            padding: 0.5rem 1rem 0.5rem 2.375rem;
            font-size: 0.8125rem;
            background: #f8fafc;
            border: 1.5px solid #f1f5f9;
            border-radius: 0.75rem;
            width: 13rem;
            color: #111827;
            outline: none;
            transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
        }
        .search-input::placeholder { color: #9ca3af; font-weight: 400; }
        .search-input:focus {
            background: #fff;
            border-color: #0f4c81;
            width: 16rem;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .search-wrap:focus-within .search-icon { color: #0f4c81; }

        .header-icon-btn {
            width: 2.375rem; height: 2.375rem;
            display: flex; align-items: center; justify-content: center;
            border-radius: 0.75rem;
            color: #6b7280;
            border: 1.5px solid #f1f5f9;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
        }
        .header-icon-btn:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #0f4c81;
        }

        .avatar-btn {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.3rem 0.625rem 0.3rem 0.3rem;
            border-radius: 0.875rem;
            border: 1.5px solid #f1f5f9;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.18s ease;
        }
        .avatar-btn:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }
    </style>

    {{-- ── Left: Hamburger + Title ──────────────────────────────── --}}
    <div class="flex items-center gap-3">
        <button onclick="openSidebar()" class="lg:hidden header-icon-btn flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div>
            <div class="hidden sm:flex items-center gap-1.5 mb-0.5">
                <span class="text-[10px] font-bold tracking-widest uppercase text-[#0f4c81]/40">HRFlow</span>
                <svg class="w-2.5 h-2.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-[10px] font-bold tracking-widest uppercase text-gray-400">
                    {{ $title }}
                </span>
            </div>
            <h1 class="text-sm lg:text-base font-extrabold text-gray-900 leading-tight tracking-tight">
                {{ $title }}
            </h1>
        </div>
    </div>

    {{-- ── Right: Actions ───────────────────────────────────────── --}}
    <div class="flex items-center gap-2">

        {{-- Search --}}
        <div class="search-wrap relative hidden md:block">
            <input type="text" placeholder="Search anything..." class="search-input"/>
            <svg class="search-icon w-4 h-4 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none transition-colors duration-200"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        {{-- Divider --}}
        <div class="hidden md:block w-px h-6 bg-gray-100 mx-1"></div>

        {{-- Notification Bell --}}
        <div class="header-icon-btn">
            <livewire:notification-bell />
        </div>

        {{-- Divider --}}
        <div class="w-px h-6 bg-gray-100 mx-1"></div>

        {{-- Avatar --}}
        <div class="avatar-btn group">
            <div class="relative">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-extrabold shadow-sm"
                     style="background: linear-gradient(135deg, #0f4c81 0%, #1a6eb5 100%);">

                    {{-- Show profile image if available --}}
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-full h-full object-cover rounded-lg"/>
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    @endif

                </div>
                <span class="absolute -bottom-0.5 -right-0.5 w-2 h-2 bg-emerald-400 border-2 border-white rounded-full"></span>
            </div>

            <div class="hidden sm:block">
                <p class="text-xs font-bold text-gray-800 leading-tight">
                    {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}
                </p>
                <p class="text-[9px] font-semibold text-emerald-500 leading-tight">Online</p>
            </div>

            <svg class="hidden sm:block w-3 h-3 text-gray-400 group-hover:text-[#0f4c81] transition-colors ml-0.5"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

    </div>
</header>
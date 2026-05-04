@props(['title' => 'Dashboard'])

@php $companyName = \App\Models\Setting::get('company_name') ?: config('app.name', 'DevStaq HR'); @endphp

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
                <span class="text-[10px] font-bold tracking-widest uppercase text-[#0f4c81]/40">{{ $companyName }}</span>
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

        {{-- Global Search (Livewire) --}}
        <livewire:global-search />

        {{-- Divider --}}
        <div class="hidden md:block w-px h-6 bg-gray-100 mx-1"></div>

        {{-- Notification Bell --}}
        <div class="header-icon-btn">
            <livewire:notification-bell />
        </div>

        {{-- Divider --}}
        <div class="w-px h-6 bg-gray-100 mx-1"></div>

        {{-- Avatar Dropdown --}}
        <div x-data="{ open: false }" @click.outside="open = false" class="relative">
            <button @click="open = !open" class="avatar-btn group">
                <div class="relative">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-extrabold shadow-sm overflow-hidden"
                         style="background: linear-gradient(135deg, #0f4c81 0%, #1a6eb5 100%);">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-full h-full object-cover"/>
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

                <svg class="hidden sm:block w-3 h-3 text-gray-400 group-hover:text-[#0f4c81] transition-all ml-0.5"
                     :class="open ? 'rotate-180 text-[#0f4c81]' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-100 z-[9999] overflow-hidden"
                 style="display:none">

                {{-- User info header --}}
                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/60">
                    <p class="text-xs font-bold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-gray-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                </div>

                <div class="py-1.5">
                    <a href="{{ route('settings.profile') }}"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-[#0f4c81] transition-colors"
                       @click="open = false">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        My Profile
                    </a>
                    <a href="{{ route('settings.company') }}"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-[#0f4c81] transition-colors"
                       @click="open = false">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Settings
                    </a>
                </div>

                <div class="border-t border-gray-50 py-1.5">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>

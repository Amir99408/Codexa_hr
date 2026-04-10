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
        .holiday-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .holiday-row:hover { background: linear-gradient(90deg,rgba(15,76,129,0.025) 0%,transparent 100%); }
        .holiday-row:hover .row-bar { opacity:1; }
        .row-bar { opacity:0; transition: opacity 0.15s; }

        /* ── Upcoming cards ───────────────────────────────────── */
        .upcoming-card {
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
        }
        .upcoming-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

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

        /* ── Form inputs ──────────────────────────────────────── */
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.5625rem 0.875rem 0.5625rem 2.5rem;
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
        .form-select { appearance: none; cursor: pointer; }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .form-input::placeholder, .form-textarea::placeholder { color:#9ca3af; font-weight:400; }

        .fi-wrap { position: relative; }
        .fi-icon {
            position: absolute; left:0.75rem; top:50%;
            transform: translateY(-50%);
            pointer-events: none; color:#9ca3af;
            width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .fi-wrap:focus-within .fi-icon { color: #0f4c81; }

        /* ── Field label ──────────────────────────────────────── */
        .field-label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 800;
            color: #374151;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* ── Section divider ──────────────────────────────────── */
        .section-label {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 1rem;
        }
        .section-label span {
            font-size: 0.6875rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b7280;
            white-space: nowrap;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, #e5e7eb, transparent);
        }

        /* ── Toggle ───────────────────────────────────────────── */
        .toggle-wrap { display: flex; align-items: center; gap: 0.625rem; cursor: pointer; }
        .toggle-box {
            position: relative;
            width: 2.25rem; height: 1.25rem;
            background: #e5e7eb;
            border-radius: 9999px;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .toggle-box::after {
            content: '';
            position: absolute;
            left: 0.15rem; top: 0.15rem;
            width: 0.95rem; height: 0.95rem;
            background: #fff;
            border-radius: 9999px;
            transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }
        input[type=checkbox]:checked + .toggle-box { background: #0f4c81; }
        input[type=checkbox]:checked + .toggle-box::after { transform: translateX(1rem); }
        input[type=checkbox] { display: none; }

        /* ── Stat bar ─────────────────────────────────────────── */
        .stat-bar { height:3px; border-radius:9999px; background:#f1f5f9; overflow:hidden; margin-top:0.875rem; }
        .stat-bar-fill { height:100%; border-radius:9999px; }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Holidays</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Holidays</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Manage public and company holidays</p>
            </div>

            <button wire:click="create"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200 self-start flex-shrink-0"
                    style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add Holiday
            </button>
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

        {{-- ── Upcoming Holidays ────────────────────────────────── --}}
        @if($upcomingHolidays->count() > 0)
            @php
                $upcomingAccents = [
                    'public'     => ['stripe'=>'#0f4c81', 'bg'=>'bg-blue-50',   'icon'=>'text-[#0f4c81]',  'badge'=>'bg-blue-50 text-blue-700 border-blue-100'],
                    'optional'   => ['stripe'=>'#059669', 'bg'=>'bg-emerald-50','icon'=>'text-emerald-600','badge'=>'bg-emerald-50 text-emerald-700 border-emerald-100'],
                    'restricted' => ['stripe'=>'#ff6b35', 'bg'=>'bg-orange-50', 'icon'=>'text-orange-500', 'badge'=>'bg-orange-50 text-orange-700 border-orange-100'],
                ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                @foreach($upcomingHolidays as $upcoming)
                    @php
                        $daysLeft = (int) now()->diffInDays($upcoming->date, false);
                        $acc = $upcomingAccents[$upcoming->type] ?? $upcomingAccents['public'];
                    @endphp
                    <div class="upcoming-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="h-1" style="background: {{ $acc['stripe'] }};"></div>
                        <div class="p-4 flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl flex flex-col items-center justify-center flex-shrink-0 shadow-sm {{ $acc['bg'] }}">
                                <p class="text-base font-extrabold leading-none" style="color:{{ $acc['stripe'] }}">{{ $upcoming->date->format('d') }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-wider leading-none mt-0.5" style="color:{{ $acc['stripe'] }}">{{ $upcoming->date->format('M') }}</p>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-extrabold text-gray-800 truncate">{{ $upcoming->name }}</p>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 border rounded-full text-[10px] font-bold {{ $acc['badge'] }}">
                                        @if($daysLeft === 0)
                                            <span class="w-1.5 h-1.5 rounded-full pulse" style="background:{{ $acc['stripe'] }}"></span>
                                            Today!
                                        @elseif($daysLeft === 1)
                                            Tomorrow
                                        @else
                                            In {{ $daysLeft }} days
                                        @endif
                                    </span>
                                    <span class="text-[10px] text-gray-400 font-medium">{{ $upcoming->date->format('l') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ── Filters ───────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input wire:model.live="search" type="text" placeholder="Search holidays..." class="filter-input"/>
                </div>

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <select wire:model.live="filterYear" class="filter-select">
                        @foreach(range(now()->year - 1, now()->year + 2) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-wrap">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <select wire:model.live="filterType" class="filter-select">
                        <option value="">All Types</option>
                        <option value="public">Public</option>
                        <option value="optional">Optional</option>
                        <option value="restricted">Restricted</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ── Holiday Table ─────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card title bar --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Holiday Calendar</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $totalThisYear }} holiday{{ $totalThisYear !== 1 ? 's' : '' }} in {{ $filterYear }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background:linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">
                            <th></th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Holiday</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden sm:table-cell">Date</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Day</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Type</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Recurring</th>
                            <th class="text-right px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($holidays as $holiday)
                            @php
                                $isPast   = $holiday->date->isPast() && !$holiday->date->isToday();
                                $isToday  = $holiday->date->isToday();
                                $typeMeta = [
                                    'public'     => ['label'=>'Public',     'classes'=>'bg-blue-50 text-blue-700 border-blue-100',    'dot'=>'bg-[#0f4c81]',   'bar'=>'bg-[#0f4c81]'],
                                    'optional'   => ['label'=>'Optional',   'classes'=>'bg-emerald-50 text-emerald-700 border-emerald-100', 'dot'=>'bg-emerald-500', 'bar'=>'bg-emerald-500'],
                                    'restricted' => ['label'=>'Restricted', 'classes'=>'bg-orange-50 text-orange-700 border-orange-100','dot'=>'bg-orange-400',  'bar'=>'bg-orange-400'],
                                ];
                                $meta = $typeMeta[$holiday->type] ?? $typeMeta['public'];
                            @endphp
                            <tr class="holiday-row relative group {{ $isPast ? 'opacity-50' : '' }}">

                                {{-- Accent bar --}}
                                <td class="p-0 w-0">
                                    <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 rounded-r {{ $meta['bar'] }}"></div>
                                </td>

                                {{-- Holiday name --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex flex-col items-center justify-center flex-shrink-0 border border-blue-100">
                                            <p class="text-sm font-extrabold text-[#0f4c81] leading-none">{{ $holiday->date->format('d') }}</p>
                                            <p class="text-[9px] font-bold uppercase tracking-wider text-blue-400 leading-none mt-0.5">{{ $holiday->date->format('M') }}</p>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                                {{ $holiday->name }}
                                                @if($isToday)
                                                    <span class="ml-1.5 inline-flex items-center gap-1 px-1.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-[9px] font-bold">
                                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full pulse"></span>
                                                        Today
                                                    </span>
                                                @endif
                                            </p>
                                            @if($holiday->description)
                                                <p class="text-xs text-gray-400 font-medium truncate mt-0.5">{{ $holiday->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-xl">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-gray-600">{{ $holiday->date->format('d M Y') }}</span>
                                    </div>
                                </td>

                                {{-- Day --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="text-xs font-semibold text-gray-500">{{ $holiday->date->format('l') }}</span>
                                </td>

                                {{-- Type --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 border rounded-full text-[11px] font-bold {{ $meta['classes'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $meta['dot'] }}"></span>
                                        {{ $meta['label'] }}
                                    </span>
                                </td>

                                {{-- Recurring --}}
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if($holiday->is_recurring)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-violet-50 text-violet-700 border border-violet-100 rounded-full text-[11px] font-bold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Yearly
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs font-bold">—</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="edit({{ $holiday->id }})"
                                                title="Edit"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-100 hover:border-blue-200 rounded-lg transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        <button wire:click="confirmDelete({{ $holiday->id }})"
                                                title="Delete"
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
                                            <p class="text-sm font-bold text-gray-500">No holidays found for {{ $filterYear }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Try changing the year or filters, or add a new holiday</p>
                                        </div>
                                        <button wire:click="create"
                                                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-900/20"
                                                style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Add Holiday
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($holidays->hasPages())
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                    {{ $holidays->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ── Add / Edit Modal ──────────────────────────────────────── --}}
    @if($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden scale-up">

                {{-- Blue stripe --}}
                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8)"></div>

                {{-- Modal header --}}
                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between"
                     style="background:linear-gradient(135deg,#f0f7ff 0%,#f8fafc 100%);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                             style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">
                                {{ $editId ? 'Edit Holiday' : 'Add Holiday' }}
                            </h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">
                                {{ $editId ? 'Update the holiday details' : 'Add a new public or company holiday' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('showForm', false)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="p-6 space-y-5">

                    {{-- ── Section: Details ──────────────────────── --}}
                    <div>
                        <div class="section-label">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Holiday Details</span>
                        </div>

                        <div class="space-y-4">
                            {{-- Name --}}
                            <div>
                                <label class="field-label">
                                    Holiday Name <span class="text-red-500 normal-case tracking-normal">*</span>
                                </label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <input wire:model="name" type="text" placeholder="e.g. Eid ul Fitr" class="form-input"/>
                                </div>
                                @error('name')
                                    <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Date + Type --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="field-label">
                                        Date <span class="text-red-500 normal-case tracking-normal">*</span>
                                    </label>
                                    <div class="fi-wrap">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <input wire:model="date" type="date" class="form-input"/>
                                    </div>
                                    @error('date')
                                        <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Type</label>
                                    <div class="fi-wrap">
                                        <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <select wire:model="type" class="form-select">
                                            <option value="public">Public</option>
                                            <option value="optional">Optional</option>
                                            <option value="restricted">Restricted</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="field-label">Description</label>
                                <div class="fi-wrap">
                                    <svg class="fi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <input wire:model="description" type="text" placeholder="Optional note..." class="form-input"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Section: Options ──────────────────────── --}}
                    <div>
                        <div class="section-label">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            <span>Options</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                            <div>
                                <p class="text-sm font-bold text-gray-700">Recurring Every Year</p>
                                <p class="text-[11px] text-gray-400 font-medium mt-0.5">Automatically repeat this holiday annually</p>
                            </div>
                            <label class="toggle-wrap">
                                <input wire:model="is_recurring" type="checkbox" id="is_recurring"/>
                                <div class="toggle-box"></div>
                            </label>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="h-px bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100"></div>

                    {{-- Buttons --}}
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showForm', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-150"
                                style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $editId ? 'Update Holiday' : 'Save Holiday' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif

    {{-- ── Delete Confirm Modal ──────────────────────────────────── --}}
    @if($deleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden scale-up">

                {{-- Red stripe --}}
                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171)"></div>

                <div class="p-6">
                    <div class="flex flex-col items-center text-center mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-gray-900 mb-1">Delete Holiday?</h3>
                        <p class="text-xs text-gray-400 font-medium leading-relaxed max-w-xs">
                            This will permanently remove the holiday from the calendar. This action cannot be undone.
                        </p>
                    </div>

                    <div class="flex items-start gap-2.5 p-3 bg-red-50 rounded-xl border border-red-100 mb-5">
                        <svg class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-[11px] text-red-600 font-medium leading-relaxed">
                            Employees may have already planned around this holiday. Consider updating instead of deleting.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="$set('deleteId', null)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button wire:click="delete"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-150"
                                style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Holiday
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif

</div>
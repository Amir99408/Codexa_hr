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

        .fade-in    { animation: fadeIn    0.25s ease both; }
        .scale-up   { animation: scaleUp   0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }

        /* Job card */
        .job-card {
            background: #fff;
            border-radius: 1rem;
            border: 1.5px solid #f1f5f9;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
            position: relative;
        }
        .job-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(15,76,129,0.10), 0 2px 8px rgba(0,0,0,0.04);
            border-color: #e2e8f0;
        }

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
            transition: all 0.18s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .filter-input:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .filter-input::placeholder { color: #9ca3af; font-weight: 400; }
        .filter-select {
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
            transition: all 0.18s ease;
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
            width: 1rem; height: 1rem;
            transition: color 0.18s;
        }
        .filter-wrap:focus-within .f-icon { color: #0f4c81; }

        /* Status top bar colors */
        .bar-open     { background: linear-gradient(90deg,#059669,#10b981); }
        .bar-closed   { background: linear-gradient(90deg,#6b7280,#9ca3af); }
        .bar-on_hold  { background: linear-gradient(90deg,#d97706,#fbbf24); }
        .bar-default  { background: linear-gradient(90deg,#0f4c81,#1a6eb5); }

        /* Job icon avatars */
        .job-icon-0 { background: linear-gradient(135deg,#0f4c81,#1a6eb5); }
        .job-icon-1 { background: linear-gradient(135deg,#059669,#10b981); }
        .job-icon-2 { background: linear-gradient(135deg,#7c3aed,#a78bfa); }
        .job-icon-3 { background: linear-gradient(135deg,#d97706,#fbbf24); }
        .job-icon-4 { background: linear-gradient(135deg,#e11d48,#fb7185); }
        .job-icon-5 { background: linear-gradient(135deg,#0891b2,#22d3ee); }

        /* Pulse for open jobs */
        @keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }
        .pulse { animation: pulse-dot 2s ease infinite; }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Recruitment</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Recruitment</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Manage job postings and track applicants</p>
            </div>

            <a href="{{ route('recruitment.jobs.create') }}"
               class="flex-shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200 self-start"
               style="background: linear-gradient(135deg,#0f4c81 0%,#1a6eb5 100%);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Post New Job
            </a>
        </div>

        {{-- ── Quick Stats ───────────────────────────────────────── --}}
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900 leading-none">{{ $jobs->total() }}</p>
                    <p class="text-[11px] font-semibold text-gray-400 mt-0.5">Total Jobs</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 pulse"></span>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-emerald-600 leading-none">
                        {{ $jobs->getCollection()->where('status','open')->count() }}
                    </p>
                    <p class="text-[11px] font-semibold text-gray-400 mt-0.5">Open</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-[#0f4c81] leading-none">
                        {{ $jobs->getCollection()->sum('applicants_count') }}
                    </p>
                    <p class="text-[11px] font-semibold text-gray-400 mt-0.5">Applicants</p>
                </div>
            </div>
        </div>

        {{-- ── Filters ───────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-3">

                {{-- Search --}}
                <div class="filter-wrap flex-1">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input wire:model.live="search"
                           type="text"
                           placeholder="Search job titles..."
                           class="filter-input"/>
                </div>

                {{-- Status filter --}}
                <div class="filter-wrap sm:w-48">
                    <svg class="f-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    <select wire:model.live="filterStatus" class="filter-select w-full">
                        <option value="">All Status</option>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                        <option value="on_hold">On Hold</option>
                    </select>
                </div>

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

        {{-- ── Job Cards Grid ────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @forelse($jobs as $job)
                <div class="job-card">

                    {{-- Status accent bar --}}
                    <div class="h-1
                        @if($job->status === 'open') bar-open
                        @elseif($job->status === 'closed') bar-closed
                        @elseif($job->status === 'on_hold') bar-on_hold
                        @else bar-default @endif">
                    </div>

                    <div class="p-5">

                        {{-- Card header --}}
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex items-start gap-3">

                                {{-- Job icon avatar --}}
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-sm job-icon-{{ $loop->index % 6 }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <h3 class="font-extrabold text-gray-900 text-sm leading-tight">{{ $job->title }}</h3>
                                    <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                        @if($job->department?->name)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                {{ $job->department->name }}
                                            </span>
                                        @endif
                                        @if($job->location)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                </svg>
                                                {{ $job->location }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Status + type badges --}}
                            <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold {{ $job->status_color }}">
                                    @if($job->status === 'open')
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 pulse"></span>
                                    @endif
                                    {{ ucfirst($job->status) }}
                                </span>
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-bold {{ $job->type_color }}">
                                    {{ str_replace('_', ' ', ucfirst($job->type)) }}
                                </span>
                            </div>
                        </div>

                        {{-- Stats row --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-4">

                            {{-- Applicants --}}
                            <div class="flex items-center gap-2 px-3 py-2 bg-blue-50/60 rounded-xl">
                                <svg class="w-3.5 h-3.5 text-[#0f4c81] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-extrabold text-[#0f4c81] leading-none">{{ $job->applicants_count }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium">Applied</p>
                                </div>
                            </div>

                            {{-- Positions --}}
                            <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 rounded-xl">
                                <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-extrabold text-gray-700 leading-none">{{ $job->positions }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium">Positions</p>
                                </div>
                            </div>

                            {{-- Deadline --}}
                            @if($job->deadline)
                                <div class="flex items-center gap-2 px-3 py-2 rounded-xl
                                    {{ $job->deadline->isPast() ? 'bg-red-50' : 'bg-amber-50/60' }}">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0 {{ $job->deadline->isPast() ? 'text-red-400' : 'text-amber-500' }}"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-extrabold {{ $job->deadline->isPast() ? 'text-red-500' : 'text-amber-600' }} leading-none">
                                            {{ $job->deadline->format('d M') }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 font-medium">Deadline</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Salary --}}
                            @if($job->salary_min || $job->salary_max)
                                <div class="flex items-center gap-2 px-3 py-2 bg-emerald-50/60 rounded-xl">
                                    <svg class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-xs font-extrabold text-emerald-600 leading-none truncate">
                                            {{ $job->salary_min ? number_format($job->salary_min/1000, 0).'k' : '' }}
                                            {{ $job->salary_min && $job->salary_max ? '–' : '' }}
                                            {{ $job->salary_max ? number_format($job->salary_max/1000, 0).'k' : '' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 font-medium">Salary</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 pt-3 border-t border-gray-50">

                            {{-- Primary CTA --}}
                            <a href="{{ route('recruitment.applicants', $job) }}"
                               class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-bold text-white shadow-sm hover:-translate-y-0.5 hover:shadow-md transition-all duration-150"
                               style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Applicants
                                @if($job->applicants_count > 0)
                                    <span class="bg-white/25 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full">
                                        {{ $job->applicants_count }}
                                    </span>
                                @endif
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('recruitment.jobs.edit', $job) }}"
                               class="flex items-center gap-1.5 px-3 py-2.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-blue-50 hover:text-[#0f4c81] border border-gray-200 hover:border-blue-200 rounded-xl transition-all duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span class="hidden sm:inline">Edit</span>
                            </a>

                            {{-- Toggle status --}}
                            <button wire:click="toggleStatus({{ $job->id }})"
                                    title="Toggle Status"
                                    class="flex items-center gap-1.5 px-3 py-2.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-amber-50 hover:text-amber-600 border border-gray-200 hover:border-amber-200 rounded-xl transition-all duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                </svg>
                                <span class="hidden sm:inline">Toggle</span>
                            </button>

                            {{-- Delete --}}
                            <button wire:click="confirmDelete({{ $job->id }})"
                                    class="flex items-center gap-1.5 px-3 py-2.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-red-50 hover:text-red-500 border border-gray-200 hover:border-red-200 rounded-xl transition-all duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 p-16 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-500 mb-1">No job postings found</p>
                        <p class="text-xs text-gray-400 mb-4">
                            {{ $search || $filterStatus ? 'Try adjusting your filters' : 'Create your first job posting to start recruiting' }}
                        </p>
                        @if(!$search && !$filterStatus)
                            <a href="{{ route('recruitment.jobs.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-900/20"
                               style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                Post First Job
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($jobs->hasPages())
            <div class="mt-6 bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4">
                {{ $jobs->links() }}
            </div>
        @endif

    </div>

    {{-- ── Delete Modal ─────────────────────────────────────────── --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden scale-up">

                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#ef4444,#f87171)"></div>

                <div class="p-7">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-2xl flex items-center justify-center"
                         style="background:linear-gradient(135deg,#fef2f2,#fee2e2);">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>

                    <h3 class="text-base font-extrabold text-gray-900 text-center mb-1.5">Delete Job Posting?</h3>
                    <p class="text-sm text-gray-400 text-center leading-relaxed mb-1">This action cannot be undone.</p>
                    <p class="text-xs text-red-600 bg-red-50 border border-red-100 rounded-xl px-3 py-2 text-center font-medium mb-6">
                        ⚠️ All applicants for this job will also be deleted
                    </p>

                    <div class="flex gap-3">
                        <button wire:click="$set('showModal', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button wire:click="delete"
                                class="flex-1 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-150"
                                style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
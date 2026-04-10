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

        /* Table rows */
        .app-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .app-row:hover { background: linear-gradient(90deg, rgba(15,76,129,0.025) 0%, transparent 100%); }
        .app-row:hover .row-bar { opacity: 1; }
        .row-bar { opacity: 0; transition: opacity 0.15s; }

        /* Stage dropdown */
        .stage-select {
            padding: 0.3rem 1.75rem 0.3rem 0.625rem;
            font-size: 0.7rem;
            font-weight: 700;
            border-radius: 9999px;
            border: 1.5px solid transparent;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='3'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.4rem center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.15s ease;
        }
        .stage-applied    { background-color:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
        .stage-screening  { background-color:#faf5ff; color:#7c3aed; border-color:#ddd6fe; }
        .stage-interview  { background-color:#fff7ed; color:#c2410c; border-color:#fed7aa; }
        .stage-offer      { background-color:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
        .stage-hired      { background-color:#ecfdf5; color:#059669; border-color:#a7f3d0; }
        .stage-rejected   { background-color:#fef2f2; color:#dc2626; border-color:#fecaca; }

        /* Modal inputs */
        .modal-input, .modal-select, .modal-textarea {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            background: #fafafa;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #111827;
            outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
        }
        .modal-textarea { resize: none; padding-top: 0.625rem; }
        .modal-select   { appearance: none; cursor: pointer; }
        .modal-input:focus, .modal-select:focus, .modal-textarea:focus {
            background: #fff;
            border-color: #0f4c81;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .modal-input::placeholder, .modal-textarea::placeholder { color:#9ca3af; font-weight:400; }
        .mi-wrap { position: relative; }
        .mi-wrap .mi-icon {
            position: absolute; left: 0.75rem; top: 50%;
            transform: translateY(-50%);
            pointer-events: none; color: #9ca3af; width:1rem; height:1rem;
            transition: color 0.18s;
        }
        .mi-wrap.top-icon .mi-icon { top: 0.875rem; transform: none; }
        .mi-wrap:focus-within .mi-icon { color: #0f4c81; }
        .modal-file {
            width: 100%;
            padding: 0.5rem 0.875rem;
            font-size: 0.8125rem;
            background: #fafafa;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            color: #374151;
            outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color 0.18s;
            cursor: pointer;
        }
        .modal-file:focus { border-color: #0f4c81; box-shadow: 0 0 0 3px rgba(15,76,129,0.08); }

        /* Avatar palette */
        .av-0{background:linear-gradient(135deg,#0f4c81,#1a6eb5)}
        .av-1{background:linear-gradient(135deg,#059669,#10b981)}
        .av-2{background:linear-gradient(135deg,#7c3aed,#a78bfa)}
        .av-3{background:linear-gradient(135deg,#d97706,#fbbf24)}
        .av-4{background:linear-gradient(135deg,#e11d48,#fb7185)}
        .av-5{background:linear-gradient(135deg,#0891b2,#22d3ee)}

        /* Stage tab pills */
        .stage-tab {
            display: inline-flex; align-items: center; gap: 0.375rem;
            padding: 0.4rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1.5px solid #e5e7eb;
            color: #6b7280;
            background: #fff;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.18s ease;
        }
        .stage-tab:hover { border-color: #0f4c81; color: #0f4c81; background: #eff6ff; }
        .stage-tab.active {
            background: linear-gradient(135deg,#0f4c81,#1a6eb5);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px rgba(15,76,129,0.25);
        }
        .stage-tab.active .tab-count { background: rgba(255,255,255,0.25); color:#fff; }
        .tab-count {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 1.25rem; height: 1.25rem; padding: 0 0.25rem;
            border-radius: 9999px;
            font-size: 0.625rem; font-weight: 800;
            background: #f1f5f9; color: #6b7280;
        }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-8 slide-down">

            <div class="flex items-start gap-4">
                {{-- Back --}}
                <a href="{{ route('recruitment.jobs') }}"
                   class="mt-1 w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-500 hover:text-[#0f4c81] hover:border-[#0f4c81] hover:bg-blue-50 rounded-xl shadow-sm transition-all duration-200 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">Recruitment</span>
                        <span class="text-gray-200">/</span>
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Applicants</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ $job->title }}</h2>

                    {{-- Job meta row --}}
                    <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                        @if($job->department?->name)
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $job->department->name }}
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $job->positions }} position{{ $job->positions !== 1 ? 's' : '' }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $job->status_color }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Add Applicant --}}
            <button wire:click="$set('showAddModal', true)"
                    class="flex-shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200 self-start"
                    style="background: linear-gradient(135deg,#0f4c81 0%,#1a6eb5 100%);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add Applicant
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

        {{-- ── Stage Filter Tabs ─────────────────────────────────── --}}
        @php
            $stages = [
                'all'       => 'All',
                'applied'   => 'Applied',
                'screening' => 'Screening',
                'interview' => 'Interview',
                'offer'     => 'Offer',
                'hired'     => 'Hired',
                'rejected'  => 'Rejected',
            ];
        @endphp
        <div class="flex gap-2 mb-6 flex-wrap">
            @foreach($stages as $key => $label)
                <button wire:click="$set('activeStage', '{{ $key }}')"
                        class="stage-tab {{ $activeStage === $key ? 'active' : '' }}">
                    {{ $label }}
                    @if($key !== 'all' && isset($stageCounts[$key]) && $stageCounts[$key] > 0)
                        <span class="tab-count">{{ $stageCounts[$key] }}</span>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- ── Applicants Table Card ─────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card header --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background: linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">
                        {{ $activeStage === 'all' ? 'All Applicants' : ucfirst($activeStage) }}
                    </span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $applicants->count() }} record{{ $applicants->count() !== 1 ? 's' : '' }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background: linear-gradient(90deg,#f8fafc 0%,#f1f5f9 100%);">
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Applicant</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden md:table-cell">Contact</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Stage</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Interview</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden sm:table-cell">Applied</th>
                            <th class="text-right px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($applicants as $applicant)
                            <tr class="app-row relative group">

                                {{-- Accent bar --}}
                                <td class="p-0 w-0">
                                    <div class="row-bar absolute left-0 top-0 bottom-0 w-0.5 bg-[#0f4c81] rounded-r"></div>
                                </td>

                                {{-- Applicant --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0 shadow-sm av-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($applicant->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate group-hover:text-[#0f4c81] transition-colors duration-150">
                                                {{ $applicant->name }}
                                            </p>
                                            @if($applicant->cv_path)
                                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full mt-0.5">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    CV attached
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Contact --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <p class="text-xs font-semibold text-gray-700">{{ $applicant->email }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $applicant->phone ?? '—' }}</p>
                                </td>

                                {{-- Stage --}}
                                <td class="px-6 py-4">
                                    <select wire:change="moveStage({{ $applicant->id }}, $event.target.value)"
                                            class="stage-select stage-{{ $applicant->stage }}">
                                        @foreach(['applied','screening','interview','offer','hired','rejected'] as $s)
                                            <option value="{{ $s }}" {{ $applicant->stage === $s ? 'selected' : '' }}>
                                                {{ ucfirst($s) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                {{-- Interview --}}
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if($applicant->interview_date)
                                        <div class="inline-flex items-start gap-2 px-2.5 py-1.5 bg-purple-50 border border-purple-100 rounded-xl">
                                            <svg class="w-3.5 h-3.5 text-purple-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <div>
                                                <p class="text-xs font-bold text-purple-700">{{ $applicant->interview_date->format('d M Y') }}</p>
                                                <p class="text-[11px] text-purple-400 font-medium">{{ $applicant->interview_time }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-300 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Applied date --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="text-xs font-semibold text-gray-400">
                                        {{ $applicant->created_at->format('d M Y') }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="openInterview({{ $applicant->id }})"
                                                title="Schedule Interview"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-purple-600 bg-purple-50 hover:bg-purple-100 border border-purple-100 hover:border-purple-200 rounded-lg transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Interview</span>
                                        </button>

                                        @if($applicant->stage === 'hired' || $applicant->stage === 'offer')
                                            <button wire:click="confirmConvert({{ $applicant->id }})"
                                                    title="Convert to Employee"
                                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 hover:border-emerald-200 rounded-lg transition-all duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                                </svg>
                                                <span class="hidden sm:inline">Convert</span>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">No applicants found</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ $activeStage !== 'all' ? 'No applicants in the ' . $activeStage . ' stage' : 'Add your first applicant to get started' }}
                                            </p>
                                        </div>
                                        @if($activeStage === 'all')
                                            <button wire:click="$set('showAddModal', true)"
                                                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-900/20"
                                                    style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Add First Applicant
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ── Add Applicant Modal ───────────────────────────────────── --}}
    @if($showAddModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden scale-up">

                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between"
                     style="background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow"
                             style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Add Applicant</h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">{{ $job->title }}</p>
                        </div>
                    </div>
                    <button wire:click="$set('showAddModal', false)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="saveApplicant" class="p-6 space-y-4">

                    {{-- Full Name --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Full Name <span class="text-red-500">*</span></label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <input wire:model="name" type="text" placeholder="John Doe" class="modal-input"/>
                        </div>
                        @error('name') <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Email <span class="text-red-500">*</span></label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                            <input wire:model="email" type="email" placeholder="applicant@email.com" class="modal-input"/>
                        </div>
                        @error('email') <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Phone <span class="text-gray-400 font-medium normal-case tracking-normal ml-1">(optional)</span></label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <input wire:model="phone" type="text" placeholder="+1 234 567 8900" class="modal-input"/>
                        </div>
                    </div>

                    {{-- CV Upload --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">CV / Resume <span class="text-gray-400 font-medium normal-case tracking-normal ml-1">(PDF, DOC)</span></label>
                        <input wire:model="cv" type="file" accept=".pdf,.doc,.docx" class="modal-file"/>
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Notes <span class="text-gray-400 font-medium normal-case tracking-normal ml-1">(optional)</span></label>
                        <div class="mi-wrap top-icon">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <textarea wire:model="notes" rows="2" placeholder="Additional notes about this applicant..." class="modal-textarea"></textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-1">
                        <button type="button" wire:click="$set('showAddModal', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:-translate-y-0.5 transition-all"
                                style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Add Applicant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ── Schedule Interview Modal ─────────────────────────────── --}}
    @if($showInterviewModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden scale-up">

                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between"
                     style="background:linear-gradient(135deg,#f5f3ff 0%,#ede9fe 100%);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow"
                             style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">Schedule Interview</h3>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">Set date, time and interviewer</p>
                        </div>
                    </div>
                    <button wire:click="$set('showInterviewModal', false)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="saveInterview" class="p-6 space-y-4">

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Interview Date <span class="text-red-500">*</span></label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <input wire:model="interview_date" type="date" class="modal-input"/>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Interview Time <span class="text-red-500">*</span></label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <input wire:model="interview_time" type="time" class="modal-input"/>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Interviewer <span class="text-gray-400 font-medium normal-case tracking-normal ml-1">(optional)</span></label>
                        <div class="mi-wrap">
                            <svg class="mi-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <select wire:model="interviewer_id" class="modal-select">
                                <option value="">Select Interviewer</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-1">
                        <button type="button" wire:click="$set('showInterviewModal', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-purple-500/25 hover:-translate-y-0.5 transition-all"
                                style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ── Convert to Employee Modal ────────────────────────────── --}}
    @if($showConvertModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background:rgba(15,23,42,0.45);backdrop-filter:blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden scale-up">

                <div class="h-1.5 w-full" style="background:linear-gradient(90deg,#059669,#10b981)"></div>

                <div class="p-7">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-2xl flex items-center justify-center"
                         style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);">
                        <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>

                    <h3 class="text-base font-extrabold text-gray-900 text-center mb-1.5">Convert to Employee?</h3>
                    <p class="text-sm text-gray-400 text-center leading-relaxed mb-1">A new employee profile will be created from this applicant.</p>
                    <p class="text-xs text-blue-600 bg-blue-50 border border-blue-100 rounded-xl px-3 py-2 text-center font-medium mb-6">
                        💡 You can update their salary and department details afterwards
                    </p>

                    <div class="flex gap-3">
                        <button wire:click="$set('showConvertModal', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                        <button wire:click="convertToEmployee"
                                class="flex-1 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-emerald-500/25 hover:-translate-y-0.5 transition-all"
                                style="background:linear-gradient(135deg,#059669,#10b981);">
                            Yes, Convert
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
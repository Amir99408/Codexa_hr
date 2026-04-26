<div>

    {{-- Hero --}}
    <div class="py-16 px-6 text-center" style="background:linear-gradient(135deg,#0d3f6e 0%,#0f4c81 60%,#1a6eb5 100%);">
        <div class="max-w-2xl mx-auto">
            <span class="inline-block text-xs font-bold tracking-widest uppercase text-orange-300 mb-3">We're Hiring</span>
            <h1 class="text-4xl font-extrabold text-white mb-4 leading-tight">
                Join {{ $companyName }}
            </h1>
            <p class="text-blue-200 text-base font-medium">
                Explore open positions and become part of our growing team.
            </p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-10">

        {{-- Filters --}}
        <div class="flex flex-wrap gap-3 mb-8">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search"
                       type="text"
                       placeholder="Search jobs or location..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:border-[#0f4c81] focus:ring-2 focus:ring-blue-100"/>
            </div>

            <select wire:model.live="filterType"
                    class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:border-[#0f4c81]">
                <option value="">All Types</option>
                <option value="full_time">Full Time</option>
                <option value="part_time">Part Time</option>
                <option value="contract">Contract</option>
                <option value="internship">Internship</option>
            </select>

            <select wire:model.live="filterDept"
                    class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:border-[#0f4c81]">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Count --}}
        <p class="text-sm text-gray-500 font-medium mb-5">
            {{ $jobs->count() }} open {{ Str::plural('position', $jobs->count()) }}
        </p>

        {{-- Job Cards --}}
        @forelse($jobs as $job)
            <div class="bg-white border border-gray-100 rounded-2xl p-6 mb-4 hover:shadow-md hover:border-blue-100 transition-all duration-200">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $job->typeColor }}">
                                {{ str_replace('_', ' ', ucfirst($job->type)) }}
                            </span>
                            @if($job->department)
                                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                                    {{ $job->department->name }}
                                </span>
                            @endif
                        </div>

                        <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $job->title }}</h2>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            @if($job->location)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $job->location }}
                                </span>
                            @endif
                            @if($job->salary_min || $job->salary_max)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @if($job->salary_min && $job->salary_max)
                                        {{ number_format($job->salary_min) }} – {{ number_format($job->salary_max) }}
                                    @elseif($job->salary_min)
                                        From {{ number_format($job->salary_min) }}
                                    @else
                                        Up to {{ number_format($job->salary_max) }}
                                    @endif
                                </span>
                            @endif
                            @if($job->deadline)
                                <span class="flex items-center gap-1 {{ $job->deadline->isPast() ? 'text-red-400' : '' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Deadline: {{ $job->deadline->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('careers.apply', $job) }}"
                       class="flex-shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200"
                       style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                        Apply Now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-20">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">No open positions found.</p>
                <p class="text-gray-400 text-sm mt-1">Check back soon for new opportunities.</p>
            </div>
        @endforelse

    </div>
</div>

<div class="max-w-3xl mx-auto px-6 py-10">

    {{-- Back --}}
    <a href="{{ route('careers.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#0f4c81] hover:text-blue-800 mb-8 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to all jobs
    </a>

    @if($submitted)
        {{-- Success --}}
        <div class="bg-white border border-emerald-100 rounded-2xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Application Submitted!</h2>
            <p class="text-gray-500 text-sm mb-6">
                Thank you for applying for <strong>{{ $job->title }}</strong>.<br>
                We'll review your application and get back to you soon.
            </p>
            <a href="{{ route('careers.index') }}"
               class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold text-white transition"
               style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                View More Jobs
            </a>
        </div>
    @else
        {{-- Job Header --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 mb-6 shadow-sm">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $job->typeColor }}">
                    {{ str_replace('_', ' ', ucfirst($job->type)) }}
                </span>
                @if($job->department)
                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                        {{ $job->department->name }}
                    </span>
                @endif
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-2">{{ $job->title }}</h1>
            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                @if($job->location)
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        {{ $job->location }}
                    </span>
                @endif
                @if($job->salary_min || $job->salary_max)
                    <span>
                        {{ number_format($job->salary_min) }}
                        @if($job->salary_max) – {{ number_format($job->salary_max) }} @endif
                    </span>
                @endif
                @if($job->deadline)
                    <span>Deadline: {{ $job->deadline->format('d M Y') }}</span>
                @endif
            </div>

            @if($job->description)
                <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-600 leading-relaxed">
                    {!! nl2br(e($job->description)) !!}
                </div>
            @endif

            @if($job->requirements)
                <div class="mt-3 text-sm text-gray-600 leading-relaxed">
                    <p class="font-semibold text-gray-800 mb-1">Requirements</p>
                    {!! nl2br(e($job->requirements)) !!}
                </div>
            @endif
        </div>

        {{-- Application Form --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-5">Your Application</h2>

            <form wire:submit="submit" class="space-y-5">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Full Name <span class="text-red-400">*</span></label>
                        <input wire:model="name" type="text" placeholder="John Doe"
                               class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#0f4c81] focus:ring-2 focus:ring-blue-100 @error('name') border-red-300 @enderror"/>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Email Address <span class="text-red-400">*</span></label>
                        <input wire:model="email" type="email" placeholder="you@email.com"
                               class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#0f4c81] focus:ring-2 focus:ring-blue-100 @error('email') border-red-300 @enderror"/>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Phone Number</label>
                    <input wire:model="phone" type="text" placeholder="+1 234 567 8900"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#0f4c81] focus:ring-2 focus:ring-blue-100"/>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Cover Letter</label>
                    <textarea wire:model="cover_letter" rows="5"
                              placeholder="Tell us why you're a great fit for this role..."
                              class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#0f4c81] focus:ring-2 focus:ring-blue-100 resize-none"></textarea>
                    @error('cover_letter') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">CV / Resume</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-blue-300 transition-colors">
                        <input wire:model="cv" type="file" accept=".pdf,.doc,.docx" class="hidden" id="cv-upload"/>
                        <label for="cv-upload" class="cursor-pointer">
                            @if($cv)
                                <svg class="w-8 h-8 text-emerald-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm font-semibold text-emerald-600">{{ $cv->getClientOriginalName() }}</p>
                                <p class="text-xs text-gray-400 mt-1">Click to change file</p>
                            @else
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm font-semibold text-gray-600">Upload your CV</p>
                                <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX up to 5MB</p>
                            @endif
                        </label>
                    </div>
                    @error('cv') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-bold text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200"
                            style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Submit Application
                    </button>
                </div>

            </form>
        </div>
    @endif
</div>

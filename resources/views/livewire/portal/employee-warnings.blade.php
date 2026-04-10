<div>

    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">My Warning Letters</h2>
        <p class="text-sm text-gray-500">View warning letters issued to you</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- List --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">All Letters ({{ $letters->count() }})</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($letters as $letter)
                    <button wire:click="$set('viewingId', {{ $letter->id }})"
                            class="w-full text-left px-5 py-4 hover:bg-gray-50 transition
                                   {{ $viewingId === $letter->id ? 'bg-blue-50 border-l-4 border-[#0f4c81]' : '' }}">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $letter->subject }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $letter->issued_date->format('d M Y') }}</p>
                            </div>
                            <span class="px-2 py-0.5 rounded text-xs font-medium flex-shrink-0 {{ $letter->severity_color }}">
                                {{ ucfirst($letter->severity) }}
                            </span>
                        </div>
                        @if(!$letter->employee_acknowledged)
                            <span class="mt-2 inline-flex items-center gap-1 text-xs text-yellow-600">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                                Needs acknowledgement
                            </span>
                        @endif
                    </button>
                @empty
                    <div class="px-5 py-10 text-center text-gray-400 text-sm">
                        No warning letters issued to you
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Letter View --}}
        <div class="lg:col-span-2">
            @if($viewing)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $viewing->subject }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Issued on {{ $viewing->issued_date->format('d F Y') }} by {{ $viewing->issuedBy->name }}
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $viewing->type_color }}">
                                {{ ucfirst($viewing->type) }}
                            </span>
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $viewing->severity_color }}">
                                {{ ucfirst($viewing->severity) }}
                            </span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-6">
                        <pre class="text-sm text-gray-700 whitespace-pre-wrap font-sans leading-relaxed">{{ $viewing->body }}</pre>
                    </div>

                    {{-- Acknowledgement --}}
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        @if($viewing->employee_acknowledged)
                            <div class="flex items-center gap-2 text-emerald-600 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Acknowledged on {{ $viewing->acknowledged_at->format('d M Y, h:i A') }}
                            </div>
                        @else
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-500">Please acknowledge that you have read this letter.</p>
                                <button wire:click="acknowledge({{ $viewing->id }})"
                                        class="px-4 py-2 bg-[#0f4c81] text-white rounded-xl text-sm font-medium hover:bg-blue-800 transition">
                                    I Acknowledge
                                </button>
                            </div>
                        @endif
                    </div>

                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center h-64 text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm">Select a letter to view</p>
                    </div>
                </div>
            @endif
        </div>

    </div>

</div>
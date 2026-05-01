<div class="search-wrap relative hidden md:block"
     x-data="{ open: false }"
     @click.outside="open = false"
     @keydown.escape.window="open = false">

    <input wire:model.live.debounce.300ms="query"
           type="text"
           placeholder="Search employees..."
           class="search-input"
           @focus="open = true"
           @input="open = true"
           autocomplete="off"/>

    <svg class="search-icon w-4 h-4 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none transition-colors duration-200"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>

    {{-- Dropdown --}}
    @if(strlen($query) >= 2)
        <div x-show="open"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="absolute left-0 top-full mt-1.5 w-72 bg-white rounded-xl shadow-xl border border-gray-100 z-[9999] overflow-hidden"
             style="display:none">

            @if($results->isEmpty())
                <div class="px-4 py-5 text-center text-sm text-gray-400">
                    No employees found for "{{ $query }}"
                </div>
            @else
                <div class="py-1.5">
                    <p class="px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest text-gray-400">Employees</p>
                    @foreach($results as $emp)
                        <a href="{{ route('employees.edit', $emp) }}"
                           class="flex items-center gap-3 px-4 py-2.5 hover:bg-blue-50 transition-colors group"
                           @click="open = false">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#0f4c81] to-[#1a6eb5] flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($emp->first_name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 group-hover:text-[#0f4c81] truncate">{{ $emp->full_name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $emp->emp_code }} · {{ $emp->department?->name ?? 'No Dept' }}</p>
                            </div>
                            <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-[#0f4c81] flex-shrink-0 ml-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach

                    <div class="border-t border-gray-50 mt-1 pt-1 px-4 pb-2">
                        <a href="{{ route('employees.index', ['search' => $query]) }}"
                           class="text-xs font-semibold text-[#0f4c81] hover:underline"
                           @click="open = false">
                            View all results for "{{ $query }}" →
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>

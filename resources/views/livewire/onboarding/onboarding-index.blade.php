<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Employee Onboarding</h2>
            <p class="text-sm text-gray-500 mt-0.5">Track new hire progress from onboarding to confirmation</p>
        </div>
        <div class="flex items-center gap-3">
            <select wire:model.live="filter"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="onboarding">Onboarding</option>
                <option value="probation">Probation</option>
                <option value="confirmed">Confirmed</option>
                <option value="all">All</option>
            </select>
            <input wire:model.live="search" type="text" placeholder="Search employees..."
                   class="w-56 px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
        </div>
    </div>

    @if($message)
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            {{ $message }}
        </div>
    @endif

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($employees as $employee)
            @php
                $tasks      = $employee->onboardingTasks;
                $total      = $tasks->count();
                $done       = $tasks->where('is_complete', true)->count();
                $pct        = $total > 0 ? round(($done / $total) * 100) : 0;
                $statusColors = [
                    'onboarding' => 'bg-amber-100 text-amber-700',
                    'probation'  => 'bg-blue-100 text-blue-700',
                    'confirmed'  => 'bg-green-100 text-green-700',
                    'active'     => 'bg-green-100 text-green-700',
                ];
                $statusColor = $statusColors[$employee->onboarding_status] ?? 'bg-gray-100 text-gray-600';
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col gap-4">
                {{-- Employee Info --}}
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <div class="font-semibold text-gray-900">{{ $employee->full_name }}</div>
                        <div class="text-xs text-gray-400">{{ $employee->emp_code }} &middot; {{ $employee->designation }}</div>
                        <div class="text-xs text-gray-400">{{ $employee->department?->name }}</div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusColor }}">
                        {{ ucfirst($employee->onboarding_status) }}
                    </span>
                </div>

                {{-- Probation end date --}}
                @if($employee->probation_end_date)
                    <div class="text-xs text-gray-500">
                        Probation ends:
                        <span class="font-medium text-gray-700">{{ $employee->probation_end_date->format('d M Y') }}</span>
                        @if($employee->probation_end_date->isPast())
                            <span class="ml-1 text-red-500 font-semibold">(overdue)</span>
                        @elseif($employee->probation_end_date->diffInDays(now()) <= 14)
                            <span class="ml-1 text-amber-500 font-semibold">({{ $employee->probation_end_date->diffForHumans() }})</span>
                        @endif
                    </div>
                @endif

                {{-- Progress bar --}}
                @if($total > 0)
                    <div>
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Tasks</span>
                            <span>{{ $done }}/{{ $total }} &mdash; {{ $pct }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full transition-all duration-300
                                {{ $pct === 100 ? 'bg-green-500' : 'bg-blue-500' }}"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex gap-2 mt-auto pt-1">
                    <button wire:click="openTasks({{ $employee->id }})"
                            class="flex-1 text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors text-center">
                        View Checklist
                    </button>
                    @if(in_array($employee->onboarding_status, ['onboarding', 'probation']))
                        <button wire:click="confirmEmployee({{ $employee->id }})"
                                wire:confirm="Confirm {{ $employee->full_name }} as a permanent employee?"
                                class="flex-1 text-xs font-semibold text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors text-center">
                            Confirm
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-sm text-gray-400 bg-white rounded-2xl border border-gray-100">
                No employees found.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $employees->links() }}
    </div>

    {{-- Task Checklist Modal --}}
    @if($showTaskModal && $selectedEmployee)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 max-h-[85vh] flex flex-col">
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">{{ $selectedEmployee->full_name }}</h3>
                        <p class="text-xs text-gray-400">Onboarding Checklist</p>
                    </div>
                    <button wire:click="$set('showTaskModal', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Task List --}}
                <div class="flex-1 overflow-y-auto px-6 py-4 space-y-2">
                    @forelse($selectedEmployee->onboardingTasks as $task)
                        <div class="flex items-center gap-3 p-3 rounded-xl border
                            {{ $task->is_complete ? 'border-green-100 bg-green-50' : 'border-gray-100 bg-white' }}">
                            <button wire:click="toggleTask({{ $task->id }})"
                                    class="flex-shrink-0 w-5 h-5 rounded border-2 flex items-center justify-center transition-colors
                                        {{ $task->is_complete ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-blue-400' }}">
                                @if($task->is_complete)
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </button>
                            <span class="flex-1 text-sm {{ $task->is_complete ? 'line-through text-gray-400' : 'text-gray-700' }}">
                                {{ $task->task }}
                            </span>
                            @if($task->completed_at)
                                <span class="text-xs text-gray-400">{{ $task->completed_at->format('d M') }}</span>
                            @endif
                            <button wire:click="deleteTask({{ $task->id }})"
                                    class="text-gray-300 hover:text-red-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">No tasks yet.</p>
                    @endforelse
                </div>

                {{-- Add Task --}}
                <div class="px-6 py-4 border-t border-gray-100">
                    <div class="flex gap-2">
                        <input wire:model="newTask"
                               wire:keydown.enter="addTask"
                               type="text"
                               placeholder="Add a custom task..."
                               class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                        <button wire:click="addTask"
                                class="px-4 py-2 bg-[#0f4c81] hover:bg-blue-800 text-white text-sm font-semibold rounded-xl transition-colors">
                            Add
                        </button>
                    </div>
                    @error('newTask') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    @endif
</div>

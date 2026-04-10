<div>
    <div class="max-w-3xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('performance.index') }}"
               class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $editId ? 'Edit Review' : 'New Performance Review' }}</h2>
                <p class="text-sm text-gray-500">Rate employee performance by criteria</p>
            </div>
        </div>

        <div class="space-y-6">

            {{-- Basic Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Review Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Employee <span class="text-red-500">*</span></label>
                        <select wire:model="employee_id"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} — {{ $emp->emp_code }}</option>
                            @endforeach
                        </select>
                        @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Review Period</label>
                        <select wire:model.live="period_type"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                            <option value="quarterly">Quarterly</option>
                            <option value="half_yearly">Half Yearly</option>
                            <option value="annual">Annual</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                        <select wire:model.live="year"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                            @foreach(range(now()->year - 1, now()->year + 1) as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Generated Cycle</label>
                        <input type="text" value="{{ $cycle }}" readonly
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-500"/>
                    </div>
                </div>
            </div>

            {{-- Criteria Ratings --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Performance Criteria</h3>
                    <button type="button" wire:click="addCriteria"
                            class="text-sm text-[#0f4c81] hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Criteria
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach($criteriaRows as $index => $row)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3 mb-3">
                                <input wire:model="criteriaRows.{{ $index }}.criteria"
                                       type="text" placeholder="Criteria name"
                                       class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] bg-white"/>
                                <button type="button" wire:click="removeCriteria({{ $index }})"
                                        class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Star Rating --}}
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs text-gray-500 w-12">Rating:</span>
                                <div class="flex gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                                wire:click="$set('criteriaRows.{{ $index }}.rating', {{ $i }})"
                                                class="w-8 h-8 rounded-lg text-sm font-bold transition
                                                       {{ $row['rating'] >= $i ? 'bg-[#ff6b35] text-white' : 'bg-white border border-gray-200 text-gray-400 hover:border-[#ff6b35]' }}">
                                            {{ $i }}
                                        </button>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-500">
                                        @switch($row['rating'])
                                            @case(1) Poor @break
                                            @case(2) Below Average @break
                                            @case(3) Average @break
                                            @case(4) Good @break
                                            @case(5) Excellent @break
                                        @endswitch
                                    </span>
                                </div>
                            </div>

                            <input wire:model="criteriaRows.{{ $index }}.comment"
                                   type="text" placeholder="Optional comment..."
                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] bg-white"/>
                        </div>
                    @endforeach
                </div>

                {{-- Average Score Preview --}}
                @if(count($criteriaRows) > 0)
                    @php
                        $avg = round(collect($criteriaRows)->avg('rating'), 2);
                    @endphp
                    <div class="mt-4 p-3 bg-[#0f4c81] rounded-lg flex items-center justify-between">
                        <span class="text-white text-sm font-medium">Overall Score</span>
                        <span class="text-white text-xl font-bold">{{ $avg }} / 5</span>
                    </div>
                @endif
            </div>

            {{-- Narrative --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Review Narrative</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Strengths</label>
                        <textarea wire:model="strengths" rows="3"
                                  placeholder="What does this employee do well?"
                                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Areas for Improvement</label>
                        <textarea wire:model="improvements" rows="3"
                                  placeholder="What can be improved?"
                                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Goals for Next Period</label>
                        <textarea wire:model="goals_next_period" rows="3"
                                  placeholder="What are the targets for next period?"
                                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] resize-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                <button wire:click="save('draft')"
                        class="flex-1 py-2.5 border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50">
                    Save as Draft
                </button>
                <button wire:click="save('submitted')"
                        class="flex-1 py-2.5 bg-[#0f4c81] text-white rounded-lg text-sm font-medium hover:bg-blue-800">
                    Submit Review
                </button>
            </div>

        </div>
    </div>
</div>
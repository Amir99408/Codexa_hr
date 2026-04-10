<div>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Performance Reviews</h2>
            <p class="text-sm text-gray-500">Track and manage employee performance</p>
        </div>
        <a href="{{ route('performance.create') }}"
           class="bg-[#0f4c81] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-800 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Review
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($message)
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-sm flex justify-between">
            <span>{{ $message }}</span>
            <button wire:click="$set('message', '')">✕</button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Total Reviews</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Submitted</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['submitted'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Drafts</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['draft'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Avg Score</p>
            <p class="text-2xl font-bold text-[#0f4c81]">{{ $stats['avg_score'] ?: '—' }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex gap-4">
            <input wire:model.live="search" type="text" placeholder="Search employee..."
                   class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
            <select wire:model.live="filterYear"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                <option value="">All Years</option>
                @foreach($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterStatus"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                <option value="">All Status</option>
                <option value="draft">Draft</option>
                <option value="submitted">Submitted</option>
                <option value="acknowledged">Acknowledged</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Employee</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Cycle</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Score</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Criteria</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Reviewer</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#0f4c81] flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($review->employee->first_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $review->employee->full_name }}</p>
                                    <p class="text-xs text-gray-400">{{ $review->employee->department?->name ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-800">{{ $review->cycle }}</p>
                            <p class="text-xs text-gray-400">{{ ucfirst(str_replace('_', ' ', $review->period_type)) }}</p>
                        </td>
                        <td class="px-5 py-3">
                            @if($review->overall_score)
                                <p class="text-xl font-bold {{ $review->score_color }}">{{ $review->overall_score }}/5</p>
                                <p class="text-xs {{ $review->score_color }}">{{ $review->score_label }}</p>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="space-y-1">
                                @foreach($review->criteria->take(3) as $c)
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-600 w-24 truncate">{{ $c->criteria }}</span>
                                        <div class="flex gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <div class="w-2 h-2 rounded-full {{ $i <= $c->rating ? 'bg-[#ff6b35]' : 'bg-gray-200' }}"></div>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                                @if($review->criteria->count() > 3)
                                    <p class="text-xs text-gray-400">+{{ $review->criteria->count() - 3 }} more</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600 text-xs">
                            {{ $review->reviewer?->name ?? '—' }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $review->status_color }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('performance.edit', $review) }}"
                                   class="p-1.5 text-[#0f4c81] hover:bg-blue-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $review->id }})"
                                        wire:confirm="Delete this review?"
                                        class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-gray-400 text-sm">
                            No performance reviews yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($reviews->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $reviews->links() }}</div>
        @endif
    </div>

</div>

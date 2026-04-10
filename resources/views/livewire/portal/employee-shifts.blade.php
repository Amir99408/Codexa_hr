<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">My Shifts</h2>
            <p class="text-sm text-gray-500">View your schedule and request swaps</p>
        </div>
        <div class="flex gap-3">
            <select wire:model.live="selectedMonth"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endforeach
            </select>
            <select wire:model.live="selectedYear"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                @foreach(range(now()->year - 1, now()->year + 1) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($message)
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-sm flex justify-between">
            <span>{{ $message }}</span>
            <button wire:click="$set('message', '')">✕</button>
        </div>
    @endif

    {{-- My Shifts --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">My Schedule</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Day</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Shift</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Hours</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($myShifts as $assignment)
                    <tr class="hover:bg-gray-50 {{ $assignment->date->isToday() ? 'bg-blue-50' : '' }}">
                        <td class="px-5 py-3 font-medium text-gray-800">
                            {{ $assignment->date->format('d M Y') }}
                            @if($assignment->date->isToday())
                                <span class="ml-1 px-1.5 py-0.5 bg-[#0f4c81] text-white text-xs rounded">Today</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $assignment->date->format('l') }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium text-white"
                                  style="background-color: {{ $assignment->shift->color }}">
                                {{ $assignment->shift->name }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-600 text-xs">
                            {{ $assignment->shift->start_time }} — {{ $assignment->shift->end_time }}
                        </td>
                        <td class="px-5 py-3">
                            @if($assignment->date->isFuture() || $assignment->date->isToday())
                                <button wire:click="openSwap({{ $assignment->id }})"
                                        class="px-3 py-1.5 text-xs border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50">
                                    Request Swap
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">
                            No shifts assigned for this month
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Swap Requests --}}
    @if($swapRequests->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Swap Requests</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($swapRequests as $swap)
                    <div class="px-5 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $swap->requester->full_name }} ↔ {{ $swap->requested->full_name }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $swap->requesterAssignment->shift->name }} ({{ $swap->requesterAssignment->date->format('d M') }})
                                ↔
                                {{ $swap->requestedAssignment->shift->name }} ({{ $swap->requestedAssignment->date->format('d M') }})
                            </p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $swap->status_color }}">
                            {{ ucfirst($swap->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Swap Modal --}}
    @if($showSwapModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 shadow-xl">
                <h3 class="font-semibold text-gray-800 mb-4">Request Shift Swap</h3>
                <form wire:submit="submitSwap" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select their shift to swap with *</label>
                        <select wire:model="swap_assignment_id"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                            <option value="">Select a shift</option>
                            @foreach($otherShifts as $other)
                                <option value="{{ $other->id }}">
                                    {{ $other->employee->full_name }} —
                                    {{ $other->shift->name }} on
                                    {{ $other->date->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('swap_assignment_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <input wire:model="swap_reason" type="text" placeholder="Why do you need to swap?"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                                class="flex-1 py-2 bg-[#0f4c81] text-white rounded-lg text-sm font-medium hover:bg-blue-800">
                            Submit Request
                        </button>
                        <button type="button" wire:click="$set('showSwapModal', false)"
                                class="flex-1 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
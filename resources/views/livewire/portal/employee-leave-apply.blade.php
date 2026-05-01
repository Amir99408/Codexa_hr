<div>

    {{-- Message --}}
    @if($message)
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-sm flex items-center justify-between">
            <span>{{ $message }}</span>
            <button wire:click="$set('message', '')">✕</button>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">My Leaves</h2>
            <p class="text-sm text-gray-500">Apply and track your leave requests</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-2 mb-6">
        <button wire:click="$set('tab', 'apply')"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $tab === 'apply' ? 'bg-[#0f4c81] text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Apply Leave
        </button>
        <button wire:click="$set('tab', 'history')"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $tab === 'history' ? 'bg-[#0f4c81] text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            My History ({{ $myLeaves->count() }})
        </button>
    </div>

    {{-- Apply Form --}}
    @if($tab === 'apply')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-lg">
            <form wire:submit="save" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Leave Type <span class="text-red-500">*</span></label>
                    @if($leaveTypes->isEmpty())
                        <p class="text-sm text-yellow-600 bg-yellow-50 p-3 rounded-lg">No leave types configured yet. Contact HR.</p>
                    @else
                        <select wire:model="leave_type_id"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                            <option value="">Select Leave Type</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->days_allowed }} days/year)</option>
                            @endforeach
                        </select>
                        @error('leave_type_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Date <span class="text-red-500">*</span></label>
                        <input wire:model.live="from_date" type="date"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                        @error('from_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">To Date <span class="text-red-500">*</span></label>
                        <input wire:model.live="to_date" type="date"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                        @error('to_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                @if($days > 0)
                    <div class="p-3 bg-blue-50 rounded-lg text-sm text-[#0f4c81] font-medium">
                        📅 Total: <strong>{{ $days }} {{ $days == 1 ? 'day' : 'days' }}</strong>
                    </div>
                @endif

                @error('days')
                    <div class="flex items-start gap-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-red-600 font-medium">{{ $message }}</p>
                    </div>
                @enderror

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                    <textarea wire:model="reason" rows="3" placeholder="Reason for leave (optional)..."
                              class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] resize-none"></textarea>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-[#0f4c81] text-white rounded-lg text-sm font-medium hover:bg-blue-800">
                    Submit Leave Request
                </button>

            </form>
        </div>
    @endif

    {{-- History --}}
    @if($tab === 'history')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">From</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">To</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Days</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($myLeaves as $leave)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium text-white"
                                      style="background-color: {{ $leave->leaveType->color }}">
                                    {{ $leave->leaveType->name }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $leave->from_date->format('d M Y') }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $leave->to_date->format('d M Y') }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $leave->days }}</td>
                            <td class="px-5 py-3">
                                @if($leave->status === 'approved')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Approved</span>
                                @elseif($leave->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Pending</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">No leave requests yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

</div>

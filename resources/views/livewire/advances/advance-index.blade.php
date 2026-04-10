<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Advance Management</h2>
            <p class="text-sm text-gray-500 mt-0.5">Manage employee salary advances</p>
        </div>
        <button wire:click="openModal"
                class="flex items-center gap-2 bg-[#0f4c81] text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-800 transition shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Give Advance
        </button>
    </div>

    @if($message)
        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-xl text-sm flex justify-between">
            <span>{{ $message }}</span>
            <button wire:click="$set('message','')">✕</button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
            <p class="text-xs text-gray-500 mb-1">Total Advances</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
            <p class="text-xs text-gray-500 mb-1">Active</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['active'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
            <p class="text-xs text-gray-500 mb-1">Pending Requests</p>
            <p class="text-2xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
            <p class="text-xs text-gray-500 mb-1">Total Outstanding</p>
            <p class="text-2xl font-bold text-[#0f4c81]">{{ currency($stats['total_outstanding']) }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex gap-4">
            <div class="relative flex-1">
                <input wire:model.live="search" type="text" placeholder="Search employee..."
                       class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent transition"/>
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <select wire:model.live="filterStatus"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50/80 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Repayment</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Progress</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($advances as $advance)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-100">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#0f4c81] to-blue-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($advance->employee->first_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $advance->employee->full_name }}</p>
                                    <p class="text-xs text-gray-400">{{ $advance->employee->department?->name ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="font-bold text-gray-900">{{ currency($advance->total_amount) }}</p>
                            <p class="text-xs text-gray-400">Started {{ \Carbon\Carbon::create($advance->start_year, $advance->start_month)->format('M Y') }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($advance->repayment_type === 'full')
                                <span class="px-2 py-1 bg-purple-50 text-purple-700 rounded-lg text-xs font-medium">Full Next Salary</span>
                            @else
                                <p class="text-sm font-medium text-gray-700">{{ currency($advance->installment_amount) }}/month</p>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $percent = $advance->total_amount > 0
                                    ? round(($advance->paid_amount / $advance->total_amount) * 100)
                                    : 0;
                            @endphp
                            <div class="w-32">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">{{ currency($advance->paid_amount) }} paid</span>
                                    <span class="font-medium text-gray-700">{{ $percent }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-[#0f4c81] h-1.5 rounded-full transition-all"
                                         style="width: {{ $percent }}%"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">{{ currency($advance->remaining_amount) }} left</p>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $advance->status_color }}">
                                {{ ucfirst($advance->status) }}
                            </span>
                            @if($advance->reason)
                                <p class="text-xs text-gray-400 mt-1 max-w-xs truncate">{{ $advance->reason }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-1">
                                @if($advance->status === 'pending')
                                    <button wire:click="approve({{ $advance->id }})"
                                            class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Approve">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                    <button wire:click="openReject({{ $advance->id }})"
                                            class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Reject">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @endif
                                @if($advance->status === 'active')
                                    <button wire:click="markCompleted({{ $advance->id }})"
                                            wire:confirm="Mark this advance as fully paid?"
                                            class="px-3 py-1.5 text-xs bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                                        Mark Paid
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">No advances yet</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($advances->hasPages())
            <div class="px-5 py-3.5 border-t border-gray-50">{{ $advances->links() }}</div>
        @endif
    </div>

    {{-- Give Advance Modal --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl p-6 max-w-md w-full">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-gray-800">Give Advance</h3>
                    <button wire:click="$set('showModal', false)"
                            class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Employee *</label>
                        <select wire:model="employee_id"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} — {{ $emp->emp_code }}</option>
                            @endforeach
                        </select>
                        @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount *</label>
                        <input wire:model="total_amount" type="number" min="1" placeholder="5000"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition"/>
                        @error('total_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Repayment Type *</label>
                        <select wire:model.live="repayment_type"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                            <option value="installment">Monthly Installment</option>
                            <option value="full">Full Deduction Next Salary</option>
                        </select>
                    </div>

                    @if($repayment_type === 'installment')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Installment Amount *</label>
                            <input wire:model="installment_amount" type="number" min="1" placeholder="1000"
                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition"/>
                            @error('installment_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Month</label>
                            <select wire:model="start_month"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                                @foreach(range(1,12) as $m)
                                    <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Year</label>
                            <select wire:model="start_year"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                                @foreach(range(now()->year, now()->year + 2) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea wire:model="notes" rows="2"
                                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] resize-none transition"></textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 py-2.5 bg-[#0f4c81] text-white rounded-xl text-sm font-medium hover:bg-blue-800 transition">
                            Give Advance
                        </button>
                        <button type="button" wire:click="$set('showModal', false)"
                                class="flex-1 py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Reject Modal --}}
    @if($showRejectModal)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full">
                <h3 class="font-bold text-gray-800 mb-4">Reject Advance Request</h3>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason *</label>
                    <textarea wire:model="rejection_reason" rows="3"
                              class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] resize-none transition"></textarea>
                    @error('rejection_reason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-3">
                    <button wire:click="reject"
                            class="flex-1 py-2.5 bg-red-500 text-white rounded-xl text-sm font-medium hover:bg-red-600 transition">
                        Reject
                    </button>
                    <button wire:click="$set('showRejectModal', false)"
                            class="flex-1 py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">My Advance</h2>
            <p class="text-sm text-gray-500">Request and track salary advances</p>
        </div>
    </div>

    @if($message)
        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-xl text-sm flex justify-between">
            <span>{{ $message }}</span>
            <button wire:click="$set('message','')">✕</button>
        </div>
    @endif

    {{-- Tabs --}}
    <div class="flex gap-2 mb-6">
        <button wire:click="$set('tab','status')"
                class="px-4 py-2 rounded-xl text-sm font-medium {{ $tab === 'status' ? 'bg-[#0f4c81] text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            My Status
        </button>
        <button wire:click="$set('tab','apply')"
                class="px-4 py-2 rounded-xl text-sm font-medium {{ $tab === 'apply' ? 'bg-[#0f4c81] text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Request Advance
        </button>
    </div>

    @if($tab === 'status')

        {{-- Active Advance --}}
        @if($activeAdvance)
            @php
                $percent = $activeAdvance->total_amount > 0
                    ? round(($activeAdvance->paid_amount / $activeAdvance->total_amount) * 100)
                    : 0;
            @endphp
            <div class="bg-[#0f4c81] rounded-2xl p-6 text-white mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-lg">Active Advance</h3>
                    <span class="px-3 py-1 bg-white/20 rounded-xl text-xs font-medium">
                        {{ $activeAdvance->repayment_type === 'full' ? 'Full Next Salary' : 'Installment' }}
                    </span>
                </div>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <p class="text-blue-200 text-xs mb-1">Total</p>
                        <p class="text-xl font-bold">{{ currency($activeAdvance->total_amount) }}</p>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs mb-1">Paid</p>
                        <p class="text-xl font-bold text-emerald-400">{{ currency($activeAdvance->paid_amount) }}</p>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs mb-1">Remaining</p>
                        <p class="text-xl font-bold text-orange-300">{{ currency($activeAdvance->remaining_amount) }}</p>
                    </div>
                </div>
                <div class="mb-2 flex justify-between text-xs text-blue-200">
                    <span>Progress</span>
                    <span>{{ $percent }}%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2">
                    <div class="bg-emerald-400 h-2 rounded-full transition-all"
                         style="width: {{ $percent }}%"></div>
                </div>
                @if($activeAdvance->repayment_type === 'installment')
                    <p class="text-blue-200 text-xs mt-3">
                        Monthly deduction: <strong class="text-white">{{ currency($activeAdvance->installment_amount) }}</strong>
                    </p>
                @endif
            </div>
        @endif

        {{-- All Advances History --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Advance History</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($advances as $advance)
                    <div class="px-5 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ currency($advance->total_amount) }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ \Carbon\Carbon::create($advance->start_year, $advance->start_month)->format('M Y') }} ·
                                {{ $advance->repayment_type === 'full' ? 'Full deduction' : currency($advance->installment_amount).'/month' }}
                            </p>
                            @if($advance->rejection_reason)
                                <p class="text-xs text-red-400 mt-1">{{ $advance->rejection_reason }}</p>
                            @endif
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $advance->status_color }}">
                            {{ ucfirst($advance->status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-gray-400 text-sm">
                        No advance history yet
                    </div>
                @endforelse
            </div>
        </div>

    @endif

    @if($tab === 'apply')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-lg">
            @if($advances->whereIn('status',['pending','active'])->count() > 0)
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-yellow-700 text-sm">
                    You already have an active or pending advance. Please wait for it to complete before requesting a new one.
                </div>
            @else
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Amount Requested *</label>
                        <input wire:model="total_amount" type="number" min="1" placeholder="5000"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition"/>
                        @error('total_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Repayment Preference</label>
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason *</label>
                        <textarea wire:model="reason" rows="3"
                                  placeholder="Why do you need this advance?"
                                  class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] resize-none transition"></textarea>
                        @error('reason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full py-2.5 bg-[#0f4c81] text-white rounded-xl text-sm font-medium hover:bg-blue-800 transition">
                        Submit Request
                    </button>
                </form>
            @endif
        </div>
    @endif

</div>
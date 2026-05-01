<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">My Expenses</h2>
            <p class="text-sm text-gray-500">Submit and track your expense claims</p>
        </div>
    </div>

    @if($message)
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-sm flex justify-between">
            <span>{{ $message }}</span>
            <button wire:click="$set('message', '')">✕</button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Approved</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Reimbursed</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['reimbursed'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Total Approved</p>
            <p class="text-2xl font-bold text-[#0f4c81]">{{ currency($stats['total']) }}</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-2 mb-6">
        <button wire:click="$set('tab', 'list')"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $tab === 'list' ? 'bg-[#0f4c81] text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            My Claims ({{ count($claims) }})
        </button>
        <button wire:click="$set('tab', 'submit')"
                class="px-4 py-2 rounded-lg text-sm font-medium {{ $tab === 'submit' ? 'bg-[#0f4c81] text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Submit New Claim
        </button>
    </div>

    {{-- Submit Form --}}
    @if($tab === 'submit')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-lg">
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                    <input wire:model="title" type="text" placeholder="e.g. Client meeting taxi fare"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                        <select wire:model="category"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                            <option value="travel">✈️ Travel</option>
                            <option value="food">🍽️ Food</option>
                            <option value="equipment">💻 Equipment</option>
                            <option value="accommodation">🏨 Accommodation</option>
                            <option value="other">📄 Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Amount <span class="text-red-500">*</span></label>
                        <input wire:model="amount" type="number" min="1" placeholder="0"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                        @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expense Date <span class="text-red-500">*</span></label>
                    <input wire:model="expense_date" type="date"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea wire:model="description" rows="3" placeholder="Additional details..."
                              class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Receipt (JPG, PNG, PDF)</label>
                    <input wire:model="receipt" type="file" accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg"/>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-[#0f4c81] text-white rounded-lg text-sm font-medium hover:bg-blue-800">
                    Submit Claim
                </button>
            </form>
        </div>
    @endif

    {{-- Claims List --}}
    @if($tab === 'list')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Claim</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($claims as $claim)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <p class="font-medium text-gray-800">{{ $claim->category_icon }} {{ $claim->title }}</p>
                                @if($claim->description)
                                    <p class="text-xs text-gray-400 mt-0.5 truncate max-w-[200px]">{{ $claim->description }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-semibold text-gray-800">{{ currency($claim->amount) }}</td>
                            <td class="px-5 py-3 text-xs text-gray-500">{{ $claim->expense_date->format('d M Y') }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $claim->status_color }}">
                                    {{ ucfirst($claim->status) }}
                                </span>
                                @if($claim->status === 'reimbursed' && $claim->reimbursed_at)
                                    <p class="text-xs text-gray-400 mt-0.5">Paid {{ $claim->reimbursed_at->format('d M Y') }}</p>
                                @endif
                                @if($claim->status === 'rejected' && $claim->rejection_reason)
                                    <p class="text-xs text-red-400 mt-0.5">{{ $claim->rejection_reason }}</p>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-gray-400 text-sm">
                                No expense claims yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

</div>
<div>

    {{-- Message --}}
    @if($message)
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-sm flex items-center justify-between">
            <span>{{ $message }}</span>
            <button wire:click="$set('message', '')">✕</button>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('payroll.index') }}"
               class="p-2 text-gray-500 hover:text-[#0f4c81] hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Salary Components</h2>
                <p class="text-sm text-gray-500">Define earnings and deductions</p>
            </div>
        </div>
        <button wire:click="create"
                class="bg-[#0f4c81] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-800 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Component
        </button>
    </div>

    {{-- Two columns: Earnings and Deductions --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Earnings --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-green-50">
                <h3 class="font-semibold text-green-700 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Earnings
                </h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Value</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($components->where('type', 'earning') as $comp)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $comp->name }}</td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $comp->calculation_type === 'percentage' ? $comp->value.'%' : number_format($comp->value) }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                    {{ ucfirst($comp->calculation_type) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex gap-1">
                                    <button wire:click="edit({{ $comp->id }})"
                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $comp->id }})"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">No earnings defined</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Deductions --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-red-50">
                <h3 class="font-semibold text-red-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                    Deductions
                </h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Value</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($components->where('type', 'deduction') as $comp)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $comp->name }}</td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $comp->calculation_type === 'percentage' ? $comp->value.'%' : number_format($comp->value) }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                    {{ ucfirst($comp->calculation_type) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex gap-1">
                                    <button wire:click="edit({{ $comp->id }})"
                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $comp->id }})"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">No deductions defined</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Add/Edit Modal --}}
    @if($showForm)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $editId ? 'Edit Component' : 'Add Component' }}
                    </h3>
                    <button wire:click="$set('showForm', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input wire:model="name" type="text" placeholder="e.g. House Allowance"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select wire:model="type"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                                <option value="earning">Earning</option>
                                <option value="deduction">Deduction</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Calculation</label>
                            <select wire:model="calculation_type"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                                <option value="flat">Flat Amount</option>
                                <option value="percentage">% of Basic</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Value <span class="text-gray-400 text-xs">({{ $calculation_type === 'percentage' ? '% of basic salary' : 'fixed amount' }})</span>
                        </label>
                        <input wire:model="value" type="number" step="0.01" min="0"
                               placeholder="{{ $calculation_type === 'percentage' ? 'e.g. 10' : 'e.g. 5000' }}"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                        @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input wire:model="is_active" type="checkbox" class="rounded text-[#0f4c81]"/>
                        Active (apply in payroll calculations)
                    </label>

                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="$set('showForm', false)"
                                class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-[#0f4c81] text-white rounded-lg text-sm font-medium hover:bg-blue-800">
                            {{ $editId ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    @if($deleteId)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm mx-4">
                <h3 class="text-lg font-bold text-gray-800 text-center mb-2">Delete Component?</h3>
                <p class="text-sm text-gray-500 text-center mb-6">This will affect future payroll calculations.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('deleteId', null)"
                            class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="delete"
                            class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>


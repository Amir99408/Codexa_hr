<div>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">My Payslips</h2>
        <p class="text-sm text-gray-500">View your salary slips</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">All Payslips</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($payslips as $slip)
                    <button wire:click="$set('viewingId', {{ $slip->id }})"
                            class="w-full flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition text-left">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $slip->month_name }}</p>
                            <p class="text-xs text-gray-400">Net: {{ currency($slip->net_salary) }}</p>
                        </div>
                        @if($slip->status === 'paid')
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Paid</span>
                        @else
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Processed</span>
                        @endif
                    </button>
                @empty
                    <div class="px-5 py-10 text-center text-gray-400 text-sm">
                        No payslips available yet
                    </div>
                @endforelse
            </div>
        </div>
        <div class="lg:col-span-2">
            @if($viewing)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-[#0f4c81] p-6 text-white flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold">HR<span class="text-[#ff6b35]">Flow</span></h2>
                            <p class="text-blue-200 text-sm">Payslip — {{ $viewing->month_name }}</p>
                        </div>
                        <span class="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-medium">
                            {{ ucfirst($viewing->status) }}
                        </span>
                    </div>
                    <div class="p-6 bg-gray-50 border-b border-gray-100">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-lg font-bold text-gray-800">{{ $viewing->working_days }}</p>
                                <p class="text-xs text-gray-500">Working Days</p>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-green-600">{{ $viewing->present_days }}</p>
                                <p class="text-xs text-gray-500">Present</p>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-red-500">{{ $viewing->absent_days }}</p>
                                <p class="text-xs text-gray-500">Absent</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border-b border-gray-100">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Earnings</p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Basic Salary</span>
                                        <span class="font-medium">{{ currency($viewing->basic_salary) }}</span>
                                    </div>
                                    @foreach($viewing->items->where('type','earning') as $item)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">{{ $item->name }}</span>
                                            <span class="text-green-600 font-medium">+{{ currency($item->amount) }}</span>
                                        </div>
                                    @endforeach
                                    <div class="flex justify-between font-semibold border-t pt-2">
                                        <span>Gross</span>
                                        <span class="text-green-600">{{ currency($viewing->gross_salary) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Deductions</p>
                                <div class="space-y-2 text-sm">
                                    @forelse($viewing->items->where('type','deduction') as $item)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">{{ $item->name }}</span>
                                            <span class="text-red-500 font-medium">-{{ currency($item->amount) }}</span>
                                        </div>
                                    @empty
                                        <p class="text-gray-400 text-sm">No deductions</p>
                                    @endforelse
                                    <div class="flex justify-between font-semibold border-t pt-2">
                                        <span>Total</span>
                                        <span class="text-red-500">{{ currency($viewing->total_deductions) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-[#0f4c81] flex items-center justify-between">
                        <p class="text-white font-semibold">Net Salary</p>
                        <p class="text-3xl font-bold text-white">{{ currency($viewing->net_salary) }}</p>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center h-64 text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm">Select a payslip to view details</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

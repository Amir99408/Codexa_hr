<div>
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('payroll.index') }}"
               class="p-2 text-gray-500 hover:text-[#0f4c81] hover:bg-gray-100 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
            <button onclick="window.print()"
                    class="bg-[#0f4c81] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-800 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Payslip
            </button>
        </div>

        {{-- Payslip Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="payslip">

            {{-- Company Header --}}
            <div class="bg-[#0f4c81] p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">HR<span class="text-[#ff6b35]">Flow</span></h1>
                        <p class="text-blue-200 text-sm mt-1">Payslip</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-semibold">{{ $payroll->month_name }}</p>
                        <span class="px-3 py-1 rounded-full text-xs font-medium mt-1 inline-block
                            {{ $payroll->status === 'paid' ? 'bg-green-500' : ($payroll->status === 'processed' ? 'bg-blue-400' : 'bg-yellow-400 text-yellow-900') }}">
                            {{ ucfirst($payroll->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Employee Info --}}
            <div class="p-6 border-b border-gray-100">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Employee Name</p>
                        <p class="font-semibold text-gray-800">{{ $payroll->employee->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Employee Code</p>
                        <p class="font-semibold text-gray-800">{{ $payroll->employee->emp_code }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Department</p>
                        <p class="font-semibold text-gray-800">{{ $payroll->employee->department?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Designation</p>
                        <p class="font-semibold text-gray-800">{{ $payroll->employee->designation ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Attendance Summary --}}
            <div class="p-6 border-b border-gray-100 bg-gray-50">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Attendance Summary</p>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-lg font-bold text-gray-800">{{ $payroll->working_days }}</p>
                        <p class="text-xs text-gray-500">Working Days</p>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-green-600">{{ $payroll->present_days }}</p>
                        <p class="text-xs text-gray-500">Present Days</p>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-red-500">{{ $payroll->absent_days }}</p>
                        <p class="text-xs text-gray-500">Absent Days</p>
                    </div>
                </div>
            </div>

            {{-- Earnings and Deductions --}}
            <div class="p-6 border-b border-gray-100">
                <div class="grid grid-cols-2 gap-6">

                    {{-- Earnings --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Earnings</p>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Basic Salary</span>
                                <span class="font-medium">{{ currency($payroll->basic_salary) }}</span>
                            </div>
                            @foreach($payroll->items->where('type', 'earning') as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">{{ $item->name }}</span>
                                    <span class="font-medium text-green-600">+{{ currency($item->amount) }}</span>
                                </div>
                            @endforeach
                            <div class="flex justify-between text-sm font-semibold border-t border-gray-100 pt-2">
                                <span>Gross Salary</span>
                                <span class="text-green-600">{{ currency($payroll->gross_salary) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Deductions --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Deductions</p>
                        <div class="space-y-2">
                            @forelse($payroll->items->where('type', 'deduction') as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">{{ $item->name }}</span>
                                    <span class="font-medium text-red-500">-{{ currency($item->amount) }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400">No deductions</p>
                            @endforelse
                            <div class="flex justify-between text-sm font-semibold border-t border-gray-100 pt-2">
                                <span>Total Deductions</span>
                                <span class="text-red-500">{{ currency($payroll->total_deductions) }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Net Salary --}}
            <div class="p-6 bg-[#0f4c81]">
                <div class="flex items-center justify-between">
                    <p class="text-white font-semibold">Net Salary</p>
                    <p class="text-3xl font-bold text-white">
                        {{ currency($payroll->net_salary) }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

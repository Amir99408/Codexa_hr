<div>
    @if(!$employee)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
            <p class="text-yellow-700 font-medium">Your account is not linked to an employee profile yet.</p>
            <p class="text-yellow-600 text-sm mt-1">Please contact your HR administrator.</p>
        </div>
    @else

        {{-- Welcome --}}
        <div class="bg-[#0f4c81] rounded-xl p-6 mb-6 text-white">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-[#ff6b35] flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold">Welcome back, {{ $employee->first_name }}!</h2>
                    <p class="text-blue-200 text-sm">{{ $employee->designation ?? 'Employee' }} — {{ $employee->department?->name ?? '' }}</p>
                    <p class="text-blue-300 text-xs mt-1">{{ now()->format('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <p class="text-xs text-gray-500 mb-1">Today's Status</p>
                @if($todayAtt)
                    @php
                        $colors = ['present'=>'text-green-600','absent'=>'text-red-500','late'=>'text-orange-500','half_day'=>'text-yellow-500','work_from_home'=>'text-blue-500'];
                        $labels = ['present'=>'Present','absent'=>'Absent','late'=>'Late','half_day'=>'Half Day','work_from_home'=>'WFH'];
                    @endphp
                    <p class="text-xl font-bold {{ $colors[$todayAtt->status] ?? 'text-gray-800' }}">
                        {{ $labels[$todayAtt->status] ?? $todayAtt->status }}
                    </p>
                @else
                    <p class="text-xl font-bold text-gray-400">Not Marked</p>
                @endif
            </div>

            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <p class="text-xs text-gray-500 mb-1">Leaves This Year</p>
                <p class="text-xl font-bold text-gray-800">{{ $approvedLeaves->sum('days') }} days</p>
            </div>

            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <p class="text-xs text-gray-500 mb-1">Emp Code</p>
                <p class="text-xl font-bold text-gray-800">{{ $employee->emp_code }}</p>
            </div>

            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <p class="text-xs text-gray-500 mb-1">Last Payslip</p>
                @if($latestPayroll)
                    <p class="text-xl font-bold text-green-600">{{ currency($latestPayroll->net_salary) }}</p>
                    <p class="text-xs text-gray-400">{{ $latestPayroll->month_name }}</p>
                @else
                    <p class="text-xl font-bold text-gray-400">—</p>
                @endif
            </div>

        </div>

        {{-- Recent Leaves + Quick Actions --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Recent Leaves --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Recent Leave Requests</h3>
                    <a href="{{ route('employee.leave.apply') }}" class="text-xs text-[#0f4c81] hover:underline">View All →</a>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($recentLeaves as $leave)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $leave->leaveType->name }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $leave->from_date->format('d M') }} — {{ $leave->to_date->format('d M Y') }}
                                    ({{ $leave->days }} days)
                                </p>
                            </div>
                            @if($leave->status === 'approved')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Approved</span>
                            @elseif($leave->status === 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Pending</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Rejected</span>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">No leave requests yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Quick Actions</h3>
                </div>
                <div class="p-5 space-y-3">
                    <a href="{{ route('employee.leave.apply') }}"
                       class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-[#0f4c81] hover:bg-blue-50 transition group">
                        <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-[#ff6b35]">
                            <svg class="w-4 h-4 text-[#ff6b35] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Apply for Leave</span>
                    </a>
                    <a href="{{ route('employee.attendance') }}"
                       class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-[#0f4c81] hover:bg-blue-50 transition group">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-[#0f4c81]">
                            <svg class="w-4 h-4 text-[#0f4c81] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">View Attendance</span>
                    </a>
                    <a href="{{ route('employee.payslips') }}"
                       class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-[#0f4c81] hover:bg-blue-50 transition group">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-600">
                            <svg class="w-4 h-4 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700">View Payslips</span>
                    </a>
                </div>
            </div>

        </div>
    @endif
</div>



<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">My Attendance</h2>
            <p class="text-sm text-gray-500">View your monthly attendance records</p>
        </div>
    </div>

    {{-- Month/Year Selector --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex gap-4">
            <select wire:model.live="selectedMonth"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endforeach
            </select>
            <select wire:model.live="selectedYear"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                @foreach(range(now()->year - 1, now()->year) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Present</p>
            <p class="text-2xl font-bold text-green-600">{{ $summary['present'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Absent</p>
            <p class="text-2xl font-bold text-red-500">{{ $summary['absent'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Late</p>
            <p class="text-2xl font-bold text-orange-500">{{ $summary['late'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">Half Day</p>
            <p class="text-2xl font-bold text-yellow-500">{{ $summary['half_day'] }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Day</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Check In</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Check Out</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($attendances as $att)
                    @php
                        $colors = ['present'=>'bg-green-100 text-green-700','absent'=>'bg-red-100 text-red-700','late'=>'bg-orange-100 text-orange-700','half_day'=>'bg-yellow-100 text-yellow-700','work_from_home'=>'bg-blue-100 text-blue-700'];
                        $labels = ['present'=>'Present','absent'=>'Absent','late'=>'Late','half_day'=>'Half Day','work_from_home'=>'WFH'];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-800 font-medium">{{ $att->date->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $att->date->format('l') }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $att->check_in ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $att->check_out ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$att->status] ?? '' }}">
                                {{ $labels[$att->status] ?? $att->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">
                            No attendance records for this month
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>


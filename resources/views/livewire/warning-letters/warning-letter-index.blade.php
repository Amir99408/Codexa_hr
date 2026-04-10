<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Warning Letters</h2>
            <p class="text-sm text-gray-500 mt-0.5">Issue and manage employee warning letters</p>
        </div>
        <a href="{{ route('warnings.create') }}"
           class="flex items-center gap-2 bg-[#0f4c81] text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-blue-800 transition shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Issue Warning
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($message)
        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-xl text-sm flex justify-between">
            <span>{{ $message }}</span>
            <button wire:click="$set('message','')">✕</button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
            <p class="text-xs text-gray-500 mb-1">Total Issued</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
            <p class="text-xs text-gray-500 mb-1">This Month</p>
            <p class="text-2xl font-bold text-[#0f4c81]">{{ $stats['this_month'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
            <p class="text-xs text-gray-500 mb-1">Unacknowledged</p>
            <p class="text-2xl font-bold text-yellow-500">{{ $stats['unacknowledged'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200">
            <p class="text-xs text-gray-500 mb-1">Final Warnings</p>
            <p class="text-2xl font-bold text-red-500">{{ $stats['final'] }}</p>
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
            <select wire:model.live="filterType"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                <option value="">All Types</option>
                <option value="misconduct">Misconduct</option>
                <option value="performance">Performance</option>
                <option value="late">Late Attendance</option>
                <option value="absence">Absence</option>
                <option value="other">Other</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50/80 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Severity</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acknowledged</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($letters as $letter)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-100">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#0f4c81] to-blue-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($letter->employee->first_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $letter->employee->full_name }}</p>
                                    <p class="text-xs text-gray-400">{{ $letter->employee->department?->name ?? '—' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-sm font-medium text-gray-800 max-w-xs truncate">{{ $letter->subject }}</p>
                            <p class="text-xs text-gray-400">by {{ $letter->issuedBy->name }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $letter->type_color }}">
                                {{ ucfirst($letter->type) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $letter->severity_color }}">
                                {{ ucfirst($letter->severity) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 text-sm">
                            {{ $letter->issued_date->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5">
                            @if($letter->employee_acknowledged)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Acknowledged
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-50 text-yellow-700 rounded-lg text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('warnings.edit', $letter) }}"
                                   class="p-1.5 text-gray-400 hover:text-[#0f4c81] hover:bg-blue-50 rounded-lg transition-all duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $letter->id }})"
                                        wire:confirm="Delete this warning letter?"
                                        class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">No warning letters issued yet</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($letters->hasPages())
            <div class="px-5 py-3.5 border-t border-gray-50">{{ $letters->links() }}</div>
        @endif
    </div>

</div>
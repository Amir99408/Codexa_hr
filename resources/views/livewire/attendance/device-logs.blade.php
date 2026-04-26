<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Device Sync Logs</h2>
            <p class="text-sm text-gray-500 mt-0.5">Attendance punches received from biometric devices</p>
        </div>
        <a href="{{ route('settings.company') }}"
           class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-[#0f4c81] border border-blue-200 rounded-xl hover:bg-blue-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Device Settings
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Punches</p>
            <p class="text-2xl font-extrabold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-emerald-100 p-4 shadow-sm">
            <p class="text-xs font-bold text-emerald-400 uppercase tracking-wider mb-1">Matched</p>
            <p class="text-2xl font-extrabold text-emerald-600">{{ number_format($stats['matched']) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-red-100 p-4 shadow-sm">
            <p class="text-xs font-bold text-red-400 uppercase tracking-wider mb-1">Unmatched</p>
            <p class="text-2xl font-extrabold text-red-500">{{ number_format($stats['unmatched']) }}</p>
            @if($stats['unmatched'] > 0)
                <p class="text-[10px] text-red-400 mt-0.5">Employee code not found</p>
            @endif
        </div>
        <div class="bg-white rounded-2xl border border-amber-100 p-4 shadow-sm">
            <p class="text-xs font-bold text-amber-400 uppercase tracking-wider mb-1">Duplicates</p>
            <p class="text-2xl font-extrabold text-amber-500">{{ number_format($stats['duplicate']) }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-3 mb-5">
        <input wire:model.live.debounce.300ms="search"
               type="text" placeholder="Search employee code..."
               class="px-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#0f4c81] w-56"/>
        <select wire:model.live="filterStatus"
                class="px-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#0f4c81]">
            <option value="">All Status</option>
            <option value="matched">Matched</option>
            <option value="unmatched">Unmatched</option>
            <option value="duplicate">Duplicate</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50">
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Employee</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Punch Time</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Device</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $log->employee?->full_name ?? '—' }}
                        </td>
                        <td class="px-4 py-3 font-mono text-gray-600 text-xs">{{ $log->employee_code }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $log->punch_time->format('d M Y H:i:s') }}</td>
                        <td class="px-4 py-3">
                            @if($log->punch_type === 'in')
                                <span class="text-xs font-bold px-2 py-1 bg-emerald-50 text-emerald-600 rounded-full">IN</span>
                            @elseif($log->punch_type === 'out')
                                <span class="text-xs font-bold px-2 py-1 bg-blue-50 text-blue-600 rounded-full">OUT</span>
                            @else
                                <span class="text-xs font-bold px-2 py-1 bg-gray-100 text-gray-500 rounded-full">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs font-mono">{{ $log->device_serial ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if($log->status === 'matched')
                                <span class="text-xs font-bold px-2 py-1 bg-emerald-50 text-emerald-600 rounded-full">Matched</span>
                            @elseif($log->status === 'unmatched')
                                <span class="text-xs font-bold px-2 py-1 bg-red-50 text-red-500 rounded-full">Unmatched</span>
                            @else
                                <span class="text-xs font-bold px-2 py-1 bg-amber-50 text-amber-500 rounded-full">Duplicate</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400 text-sm">
                            No device logs yet. Connect a biometric device to start receiving punches.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($logs->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>

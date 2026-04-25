<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Role Management</h2>
            <p class="text-sm text-gray-500 mt-0.5">Assign roles to system users</p>
        </div>
        <input wire:model.live="search" type="text" placeholder="Search users..."
               class="w-64 px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
    </div>

    @if($message)
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            {{ $message }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Roles</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($user->roles as $role)
                                    @php
                                        $colors = [
                                            'admin'       => 'bg-blue-100 text-blue-700',
                                            'hr_manager'  => 'bg-violet-100 text-violet-700',
                                            'finance'     => 'bg-emerald-100 text-emerald-700',
                                            'dept_manager'=> 'bg-amber-100 text-amber-700',
                                            'employee'    => 'bg-gray-100 text-gray-600',
                                        ];
                                        $color = $colors[$role->name] ?? 'bg-gray-100 text-gray-600';
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $color }}">
                                        {{ str_replace('_', ' ', ucfirst($role->name)) }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400">No roles</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="openEdit({{ $user->id }})"
                                    class="text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                Edit Roles
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-400">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-3 border-t border-gray-50">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Edit Roles Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Edit User Roles</h3>

                <div class="space-y-2 mb-6">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox"
                                   wire:model="selectedRoles"
                                   value="{{ $role->name }}"
                                   class="w-4 h-4 text-blue-600 rounded">
                            <div>
                                <div class="text-sm font-semibold text-gray-700">{{ str_replace('_', ' ', ucfirst($role->name)) }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $role->permissions->pluck('name')->map(fn($p) => str_replace('-', ' ', $p))->implode(', ') ?: 'No permissions' }}
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex gap-3">
                    <button wire:click="save"
                            class="flex-1 py-2.5 bg-[#0f4c81] hover:bg-blue-800 text-white rounded-xl text-sm font-semibold transition-colors">
                        Save Roles
                    </button>
                    <button wire:click="$set('showModal', false)"
                            class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

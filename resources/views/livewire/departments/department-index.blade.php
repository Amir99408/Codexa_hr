<div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .mesh-bg {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 20% 10%, rgba(15,76,129,0.05) 0px, transparent 50%),
                radial-gradient(at 80% 5%,  rgba(255,107,53,0.04) 0px, transparent 50%);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes scaleUp {
            from { opacity: 0; transform: scale(0.96) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes pulseBorder {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.5; }
        }

        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .fade-in    { animation: fadeIn 0.25s ease both; }
        .scale-up   { animation: scaleUp 0.3s cubic-bezier(0.4,0,0.2,1) both; }

        .toast-bar { animation: pulseBorder 2s ease infinite; }

        /* Table row hover */
        .dept-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .dept-row:hover { background: linear-gradient(90deg, rgba(15,76,129,0.03) 0%, rgba(255,255,255,0) 100%); }
        .dept-row:hover .row-accent { opacity: 1; }
        .row-accent { opacity: 0; transition: opacity 0.15s; }

        /* Field styles */
        .modal-input {
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.5rem;
            font-size: 0.875rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            background: #fafafa;
            color: #111827;
            outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
        }
        .modal-input:focus {
            border-color: #0f4c81;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15,76,129,0.08);
        }
        .modal-input::placeholder { color: #9ca3af; font-weight: 400; }
        .modal-input-plain {
            padding-left: 0.875rem;
        }
        .modal-icon-wrap { position: relative; }
        .modal-icon-wrap .m-icon {
            position: absolute; left: 0.75rem; top: 50%;
            transform: translateY(-50%);
            color: #9ca3af; pointer-events: none;
            transition: color 0.18s;
        }
        .modal-icon-wrap:focus-within .m-icon { color: #0f4c81; }

        /* Dept avatar colors */
        .dept-avatar-0 { background: linear-gradient(135deg, #0f4c81, #1a6eb5); }
        .dept-avatar-1 { background: linear-gradient(135deg, #059669, #10b981); }
        .dept-avatar-2 { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
        .dept-avatar-3 { background: linear-gradient(135deg, #d97706, #fbbf24); }
        .dept-avatar-4 { background: linear-gradient(135deg, #e11d48, #fb7185); }
        .dept-avatar-5 { background: linear-gradient(135deg, #0891b2, #22d3ee); }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ─────────────────────────────────────────── --}}
        <div class="flex items-start justify-between mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Departments</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Departments</h2>
                <p class="text-sm text-gray-400 font-medium mt-0.5">Manage and organise your company departments</p>
            </div>

            <button wire:click="create"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all duration-200"
                    style="background: linear-gradient(135deg, #0f4c81 0%, #1a6eb5 100%);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="hidden sm:inline">Add Department</span>
                <span class="sm:hidden">Add</span>
            </button>
        </div>

        {{-- ── Toast Message ────────────────────────────────────────── --}}
        @if($message)
            <div class="mb-5 flex items-center justify-between gap-4 p-4 bg-white rounded-2xl border border-emerald-100 shadow-sm shadow-emerald-100/50 slide-down">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Success</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $message }}</p>
                    </div>
                </div>
                <button wire:click="$set('message', '')"
                        class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- ── Search + Stats Bar ───────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">

            {{-- Search --}}
            <div class="relative flex-1 max-w-sm">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live="search"
                       type="text"
                       placeholder="Search departments..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm font-medium bg-white border border-gray-200 rounded-xl outline-none focus:border-[#0f4c81] focus:ring-2 focus:ring-[#0f4c81]/10 transition-all duration-200 shadow-sm"/>
            </div>

            {{-- Count badge --}}
            <div class="flex items-center gap-2 px-4 py-2.5 bg-white rounded-xl border border-gray-100 shadow-sm flex-shrink-0">
                <div class="w-2 h-2 rounded-full bg-[#0f4c81]"></div>
                <span class="text-xs font-bold text-gray-500">
                    {{ $departments->total() }} department{{ $departments->total() !== 1 ? 's' : '' }}
                </span>
            </div>
        </div>

        {{-- ── Table Card ───────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Table header --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background: linear-gradient(90deg, #f8fafc 0%, #fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">All Departments</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ now()->format('M Y') }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);">
                            <th></th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest w-12">#</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Department</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest hidden sm:table-cell">Code</th>
                            <th class="text-left px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Team Size</th>
                            <th class="text-right px-6 py-3 text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @forelse($departments as $dept)
                            <tr class="dept-row relative group">

                                {{-- Left accent bar on hover --}}
                                <td class="pl-0 pr-0 py-0 w-0">
                                    <div class="row-accent absolute left-0 top-0 bottom-0 w-0.5 bg-[#0f4c81] rounded-r"></div>
                                </td>

                                {{-- # --}}
                                <td class="px-6 py-4 text-xs font-mono font-bold text-gray-300">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                {{-- Department Name --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0 shadow-sm dept-avatar-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($dept->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 group-hover:text-[#0f4c81] transition-colors duration-150">
                                                {{ $dept->name }}
                                            </p>
                                            @if($dept->description ?? false)
                                                <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $dept->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Code --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    @if($dept->code)
                                        <span class="inline-flex items-center px-2.5 py-1 bg-slate-50 border border-slate-200 text-slate-600 rounded-lg text-xs font-mono font-bold tracking-wider">
                                            {{ $dept->code }}
                                        </span>
                                    @else
                                        <span class="text-gray-200 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Employees --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex -space-x-1.5">
                                            @for($i = 0; $i < min(3, $dept->employees_count); $i++)
                                                <div class="w-6 h-6 rounded-full border-2 border-white flex items-center justify-center text-white text-[9px] font-extrabold dept-avatar-{{ $i }}"></div>
                                            @endfor
                                        </div>
                                        <span class="text-sm font-bold text-gray-700">
                                            {{ $dept->employees_count }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-medium hidden lg:inline">
                                            {{ $dept->employees_count === 1 ? 'member' : 'members' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="edit({{ $dept->id }})"
                                                title="Edit department"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-blue-50 hover:text-[#0f4c81] border border-gray-200 hover:border-blue-200 rounded-lg transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        <button wire:click="confirmDelete({{ $dept->id }})"
                                                title="Delete department"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-500 bg-gray-50 hover:bg-red-50 hover:text-red-500 border border-gray-200 hover:border-red-200 rounded-lg transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span class="hidden sm:inline">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">No departments found</p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                @if($search) Try a different search term @else Get started by adding your first department @endif
                                            </p>
                                        </div>
                                        @if(!$search)
                                            <button wire:click="create"
                                                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white transition-all hover:-translate-y-0.5"
                                                    style="background: linear-gradient(135deg, #0f4c81, #1a6eb5);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Add First Department
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($departments->hasPages())
                <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/50">
                    {{ $departments->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ── Add / Edit Modal ─────────────────────────────────────── --}}
    @if($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background: rgba(15,23,42,0.45); backdrop-filter: blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden scale-up">

                {{-- Modal header --}}
                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between"
                     style="background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow"
                             style="background: linear-gradient(135deg, #0f4c81, #1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-gray-900">
                                {{ $editId ? 'Edit Department' : 'New Department' }}
                            </h3>
                            <p class="text-[11px] text-gray-400 font-medium">
                                {{ $editId ? 'Update department details' : 'Add a new department to your organisation' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('showForm', false)"
                            class="w-8 h-8 flex items-center justify-center rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Modal body --}}
                <form wire:submit="save" class="p-6 space-y-4">

                    {{-- Department Name --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                            Department Name <span class="text-red-500">*</span>
                        </label>
                        <div class="modal-icon-wrap">
                            <svg class="m-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <input wire:model="name" type="text"
                                   placeholder="e.g. Human Resources"
                                   class="modal-input"/>
                        </div>
                        @error('name')
                            <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Code --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                            Department Code
                            <span class="text-gray-400 font-medium normal-case tracking-normal ml-1">(optional)</span>
                        </label>
                        <div class="modal-icon-wrap">
                            <svg class="m-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            <input wire:model="code" type="text"
                                   placeholder="e.g. HR, ENG, FIN"
                                   class="modal-input"/>
                        </div>
                        @error('code')
                            <p class="flex items-center gap-1 text-red-500 text-[11px] mt-1.5 font-medium">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="$set('showForm', false)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:-translate-y-0.5 hover:shadow-blue-900/30 transition-all duration-150"
                                style="background: linear-gradient(135deg, #0f4c81, #1a6eb5);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $editId ? 'Update Department' : 'Save Department' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ── Delete Confirmation Modal ────────────────────────────── --}}
    @if($deleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 fade-in"
             style="background: rgba(15,23,42,0.45); backdrop-filter: blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden scale-up">

                {{-- Red top strip --}}
                <div class="h-1.5 w-full" style="background: linear-gradient(90deg, #ef4444, #f87171)"></div>

                <div class="p-7">
                    {{-- Icon --}}
                    <div class="w-14 h-14 mx-auto mb-5 rounded-2xl flex items-center justify-center"
                         style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>

                    <h3 class="text-base font-extrabold text-gray-900 text-center mb-1.5">Delete Department?</h3>
                    <p class="text-sm text-gray-400 text-center leading-relaxed mb-1">This action cannot be undone.</p>
                    <p class="text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded-xl px-3 py-2 text-center font-medium mb-6">
                        ⚠️ Departments with employees cannot be deleted
                    </p>

                    <div class="flex gap-3">
                        <button wire:click="$set('deleteId', null)"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:border-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button wire:click="delete"
                                class="flex-1 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-150"
                                style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
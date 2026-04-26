<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Document Management</h2>
            <p class="text-sm text-gray-500 mt-0.5">Upload and track employee documents with expiry alerts</p>
        </div>
        <div class="flex items-center gap-3">
            <select wire:model.live="category"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Categories</option>
                <option value="id">ID Documents</option>
                <option value="contract">Contracts</option>
                <option value="certificate">Certificates</option>
                <option value="general">General</option>
            </select>
            <input wire:model.live="search" type="text" placeholder="Search employees..."
                   class="w-56 px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
        </div>
    </div>

    @if($message)
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            {{ $message }}
        </div>
    @endif

    {{-- Expiry Alerts --}}
    @if($expiringSoon->count())
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-4">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span class="text-sm font-semibold text-amber-700">{{ $expiringSoon->count() }} document(s) expiring within 30 days</span>
            </div>
            <div class="space-y-1">
                @foreach($expiringSoon as $doc)
                    <div class="text-xs text-amber-600">
                        <span class="font-semibold">{{ $doc->employee->full_name }}</span>
                        — {{ $doc->title }}
                        <span class="ml-1 text-amber-500">(expires {{ $doc->expiry_date->format('d M Y') }})</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Employee Document Table --}}
    <div class="space-y-4">
        @forelse($employees as $employee)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Employee row --}}
                <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100">
                    <div>
                        <span class="font-semibold text-gray-800 text-sm">{{ $employee->full_name }}</span>
                        <span class="text-xs text-gray-400 ml-2">{{ $employee->emp_code }} &middot; {{ $employee->department?->name }}</span>
                    </div>
                    <button wire:click="openUpload({{ $employee->id }})"
                            class="text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                        + Upload Document
                    </button>
                </div>

                @if($employee->documents->count())
                    <table class="w-full text-sm">
                        <thead class="border-b border-gray-50">
                            <tr>
                                <th class="text-left px-5 py-2 text-xs font-semibold text-gray-400">Title</th>
                                <th class="text-left px-5 py-2 text-xs font-semibold text-gray-400">Category</th>
                                <th class="text-left px-5 py-2 text-xs font-semibold text-gray-400">Expiry</th>
                                <th class="text-left px-5 py-2 text-xs font-semibold text-gray-400">Status</th>
                                <th class="text-right px-5 py-2 text-xs font-semibold text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($employee->documents as $doc)
                                @php
                                    $catColors = [
                                        'id'          => 'bg-blue-100 text-blue-700',
                                        'contract'    => 'bg-purple-100 text-purple-700',
                                        'certificate' => 'bg-emerald-100 text-emerald-700',
                                        'general'     => 'bg-gray-100 text-gray-600',
                                    ];
                                @endphp
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-5 py-3 font-medium text-gray-800">{{ $doc->title }}</td>
                                    <td class="px-5 py-3">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $catColors[$doc->category] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($doc->category) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-xs">
                                        @if($doc->expiry_date)
                                            <span class="{{ $doc->is_expired ? 'text-red-600 font-semibold' : ($doc->is_expiring_soon ? 'text-amber-600 font-semibold' : 'text-gray-500') }}">
                                                {{ $doc->expiry_date->format('d M Y') }}
                                                @if($doc->is_expired) (expired) @elseif($doc->is_expiring_soon) (soon) @endif
                                            </span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        @if($doc->is_verified)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Verified</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button wire:click="download({{ $doc->id }})"
                                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium">Download</button>
                                            @if(!$doc->is_verified)
                                                <button wire:click="verify({{ $doc->id }})"
                                                        class="text-xs text-green-600 hover:text-green-800 font-medium">Verify</button>
                                            @endif
                                            <button wire:click="delete({{ $doc->id }})"
                                                    wire:confirm="Delete this document?"
                                                    class="text-xs text-red-500 hover:text-red-700 font-medium">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="px-5 py-4 text-xs text-gray-400">No documents uploaded yet.</p>
                @endif
            </div>
        @empty
            <div class="py-16 text-center text-sm text-gray-400 bg-white rounded-2xl border border-gray-100">
                No employees found.
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $employees->links() }}</div>

    {{-- Upload Modal --}}
    @if($showUploadModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Upload Document</h3>

                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Title</label>
                        <input wire:model="title" type="text" placeholder="e.g. National ID Card"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                        @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Category</label>
                        <select wire:model="docCategory"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="id">ID Document</option>
                            <option value="contract">Contract</option>
                            <option value="certificate">Certificate</option>
                            <option value="general">General</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Expiry Date (optional)</label>
                        <input wire:model="expiryDate" type="date"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                        @error('expiryDate') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">File (PDF, JPG, PNG, DOC — max 10MB)</label>
                        <input wire:model="document" type="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                               class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        @error('document') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="document" class="text-xs text-blue-500 mt-1">Uploading...</div>
                    </div>
                </div>

                <div class="flex gap-3 mt-5">
                    <button wire:click="upload"
                            class="flex-1 py-2.5 bg-[#0f4c81] hover:bg-blue-800 text-white rounded-xl text-sm font-semibold transition-colors">
                        Upload
                    </button>
                    <button wire:click="$set('showUploadModal', false)"
                            class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

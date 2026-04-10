<div>
    <div class="max-w-3xl mx-auto">

        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('warnings.index') }}"
               class="p-2 text-gray-500 hover:text-[#0f4c81] hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $editId ? 'Edit Warning Letter' : 'Issue Warning Letter' }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">Fill in the details below</p>
            </div>
        </div>

        <form wire:submit="save" class="space-y-6">

            {{-- Details --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-2 pb-4 border-b border-gray-50 mb-5">
                    <div class="w-1 h-5 bg-[#0f4c81] rounded-full"></div>
                    <h3 class="font-semibold text-gray-800">Letter Details</h3>
                </div>
                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Employee *</label>
                        <select wire:model.live="employee_id"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->full_name }} — {{ $emp->emp_code }}</option>
                            @endforeach
                        </select>
                        @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Warning Type *</label>
                            <select wire:model.live="type"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                                <option value="misconduct">Misconduct</option>
                                <option value="performance">Performance</option>
                                <option value="late">Late Attendance</option>
                                <option value="absence">Absence</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Severity *</label>
                            <select wire:model="severity"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition">
                                <option value="minor">Minor</option>
                                <option value="major">Major</option>
                                <option value="final">Final Warning</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Issue Date *</label>
                            <input wire:model="issued_date" type="date"
                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition"/>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                        <input wire:model="subject" type="text"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] transition"/>
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>

            {{-- Letter Body --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-50 mb-5">
                    <div class="flex items-center gap-2">
                        <div class="w-1 h-5 bg-[#ff6b35] rounded-full"></div>
                        <h3 class="font-semibold text-gray-800">Letter Content</h3>
                    </div>
                    <button type="button" wire:click="reloadTemplate"
                            class="text-xs text-[#0f4c81] hover:underline">
                        ↺ Reload Template
                    </button>
                </div>

                <textarea wire:model="body" rows="18"
                          placeholder="Write the warning letter content here..."
                          class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#0f4c81] resize-none transition font-mono leading-relaxed"></textarea>
                @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-2">The template is auto-filled based on warning type. You can edit it freely.</p>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('warnings.index') }}"
                   class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 bg-[#0f4c81] text-white rounded-xl text-sm font-medium hover:bg-blue-800 transition shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ $editId ? 'Update Letter' : 'Issue Letter' }}
                </button>
            </div>

        </form>
    </div>
</div>
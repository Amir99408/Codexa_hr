<div>
    <div class="max-w-3xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('employees.index') }}"
               class="p-2 text-gray-500 hover:text-[#0f4c81] hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Employee</h2>
                <p class="text-sm text-gray-500">{{ $employee->emp_code }} — {{ $employee->full_name }}</p>
            </div>
        </div>

        {{-- Form --}}
        <form wire:submit.prevent="update" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">

            {{-- Image Upload --}}
            <div class="flex items-center gap-4">
                <div id="photo-preview-edit" class="relative w-24 h-24 rounded-xl overflow-hidden border border-gray-200">
                    @if($employee->photo)
                        <img src="{{ asset('storage/'.$employee->photo) }}" alt="Employee Photo" class="object-cover w-full h-full">
                        <button type="button" wire:click="removePhoto"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            &times;
                        </button>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400 font-bold text-xl">
                            {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Photo</label>
                    <input type="file" wire:model="photo" accept="image/*"
                           onchange="previewPhoto(this, 'photo-preview-edit')"
                           class="w-full text-sm text-gray-700 border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                    @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">JPG, JPEG, PNG | Max 2MB</p>
                </div>
            </div>

            {{-- Names --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                    <input wire:model="first_name" type="text"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                    <input wire:model="last_name" type="text"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                    @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Other fields --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input wire:model="phone" type="text"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                    <input wire:model="designation" type="text"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                    @error('designation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Department & Gender --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select wire:model="department_id"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select wire:model="gender"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            {{-- Date & Salary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input wire:model="date_of_birth" type="date"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Join Date <span class="text-red-500">*</span></label>
                    <input wire:model="join_date" type="date"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                    @error('join_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Salary & Status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Basic Salary <span class="text-red-500">*</span></label>
                    <input wire:model="basic_salary" type="number"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]"/>
                    @error('basic_salary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select wire:model="status"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81]">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>
            </div>

            {{-- Address / Device ID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea wire:model="address" rows="2"
                              class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Device ID
                        <span class="text-[10px] font-normal text-gray-400 ml-1">(biometric device user ID)</span>
                    </label>
                    <input wire:model="device_id" type="text" placeholder="e.g. 1, 2, 101"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                    @error('device_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Leave blank if no device assigned</p>
                </div>
            </div>

            {{-- Portal Access --}}
            <div class="border-t border-gray-100 pt-5">
                <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Portal Access
                </h3>

                @if($employee->user_id)
                    {{-- Has account: show email + optional password change --}}
                    <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-medium text-emerald-700">Employee has a login account</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Login Email <span class="text-red-500">*</span></label>
                            <input wire:model="account_email" type="email"
                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                            @error('account_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                New Password
                                <span class="text-[10px] font-normal text-gray-400 ml-1">(leave blank to keep current)</span>
                            </label>
                            <input wire:model="account_password" type="password" placeholder="Min. 8 characters"
                                   class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                            @error('account_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @else
                    {{-- No account: option to create one --}}
                    <label class="flex items-center justify-between p-4 rounded-xl bg-gray-50 hover:bg-gray-100/60 border border-gray-100 cursor-pointer transition-colors duration-150">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Create Login Account</p>
                                <p class="text-xs text-gray-400 mt-0.5">Give this employee portal access</p>
                            </div>
                        </div>
                        <input wire:model.live="create_account" type="checkbox"
                               class="w-4 h-4 rounded text-emerald-600 border-gray-300 focus:ring-emerald-500"/>
                    </label>

                    @if($create_account)
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Login Email <span class="text-red-500">*</span></label>
                                <input wire:model="account_email" type="email" placeholder="employee@company.com"
                                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                                @error('account_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                                <input wire:model="account_password" type="password" placeholder="Min. 8 characters"
                                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0f4c81] focus:border-transparent"/>
                                @error('account_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('employees.index') }}"
                   class="px-5 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-[#0f4c81] text-white rounded-lg text-sm font-medium hover:bg-blue-800 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Employee
                </button>
            </div>

        </form>
    </div>
</div>
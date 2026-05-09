<div class="max-w-lg mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-1 w-full" style="background:linear-gradient(90deg,#0f4c81,#1a6eb5,#38bdf8)"></div>

        <div class="p-6">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6eb5)">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900" style="font-family:'Syne',sans-serif">Update Profile Photo</h2>
                    <p class="text-xs text-gray-500">JPG or PNG, max 2 MB</p>
                </div>
            </div>

            {{-- Flash message --}}
            @if($message)
                <div class="mb-5 flex items-center gap-3 p-4 rounded-xl border
                    {{ $messageType === 'success' ? 'bg-emerald-50 border-emerald-100' : 'bg-red-50 border-red-100' }}">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0
                        {{ $messageType === 'success' ? 'bg-emerald-100' : 'bg-red-100' }}">
                        @if($messageType === 'success')
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        @endif
                    </div>
                    <p class="text-sm font-semibold {{ $messageType === 'success' ? 'text-emerald-700' : 'text-red-700' }}">
                        {{ $message }}
                    </p>
                </div>
            @endif

            @php $employee = auth()->user()->employee; @endphp

            {{-- Current photo --}}
            <div class="flex flex-col items-center gap-4 mb-6">
                <div class="relative">
                    @if($photo)
                        <img src="{{ $photo->temporaryUrl() }}"
                             alt="Preview"
                             class="w-28 h-28 rounded-full object-cover ring-4 ring-[#0f4c81]/20 shadow-lg"/>
                        <span class="absolute bottom-1 right-1 bg-[#ff6b35] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">Preview</span>
                    @elseif($employee?->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}"
                             alt="Current photo"
                             class="w-28 h-28 rounded-full object-cover ring-4 ring-[#0f4c81]/20 shadow-lg"/>
                    @else
                        <div class="w-28 h-28 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-lg ring-4 ring-[#0f4c81]/20"
                             style="background:linear-gradient(135deg,#0f4c81,#1a6eb5)">
                            {{ strtoupper(substr($employee?->first_name ?? auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                @if($employee?->photo && !$photo)
                    <button type="button"
                            wire:click="removePhoto"
                            wire:confirm="Remove your current profile photo?"
                            class="flex items-center gap-1.5 text-xs font-semibold text-red-500 hover:text-red-700 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Remove current photo
                    </button>
                @endif
            </div>

            {{-- Upload form --}}
            <form wire:submit.prevent="save" class="space-y-4">

                {{-- Drop zone --}}
                <div x-data="{ dragging: false }"
                     @dragover.prevent="dragging = true"
                     @dragleave.prevent="dragging = false"
                     @drop.prevent="dragging = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))"
                     :class="dragging ? 'border-[#0f4c81] bg-blue-50' : 'border-gray-200 bg-gray-50 hover:border-[#0f4c81] hover:bg-blue-50'"
                     class="border-2 border-dashed rounded-xl p-6 text-center transition-colors cursor-pointer"
                     @click="$refs.fileInput.click()">

                    <input x-ref="fileInput"
                           wire:model="photo"
                           type="file"
                           accept="image/jpeg,image/png"
                           class="hidden"/>

                    <div wire:loading wire:target="photo" class="flex flex-col items-center gap-2">
                        <svg class="w-6 h-6 text-[#0f4c81] animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <p class="text-sm text-gray-500">Uploading...</p>
                    </div>

                    <div wire:loading.remove wire:target="photo">
                        @if($photo)
                            <svg class="w-8 h-8 text-emerald-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-sm font-semibold text-gray-700">{{ $photo->getClientOriginalName() }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ number_format($photo->getSize() / 1024, 1) }} KB — click to change</p>
                        @else
                            <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm font-semibold text-gray-600">Click or drag & drop to upload</p>
                            <p class="text-xs text-gray-400 mt-0.5">JPG, PNG — max 2 MB</p>
                        @endif
                    </div>
                </div>

                @error('photo')
                    <p class="flex items-center gap-1 text-red-500 text-xs font-medium">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                <button type="submit"
                        @class(['w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg transition-all duration-200',
                                'opacity-50 cursor-not-allowed' => !$photo,
                                'shadow-blue-900/20 hover:shadow-blue-900/30 hover:-translate-y-0.5' => $photo])
                        [disabled]="!$wire.photo"
                        style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Photo
                </button>

            </form>

        </div>
    </div>

</div>

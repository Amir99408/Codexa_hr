<div class="relative" x-data="{ open: false }" @click.outside="open = false">

    <button @click="open = !open"
            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium
                   text-gray-600 hover:bg-gray-100 border border-gray-200 transition">
        @if(app()->getLocale() === 'ur')
            <span class="text-base">🇵🇰</span>
            <span>اردو</span>
        @elseif(app()->getLocale() === 'ar')
            <span class="text-base">🇸🇦</span>
            <span>عربي</span>
        @else
            <span class="text-base">🇬🇧</span>
            <span>EN</span>
        @endif
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden"
         style="display:none">

        <a href="{{ route('language.switch', 'en') }}"
           class="flex items-center gap-2 px-4 py-2.5 text-sm hover:bg-gray-50 transition
                  {{ app()->getLocale() === 'en' ? 'bg-blue-50 text-[#0f4c81] font-semibold' : 'text-gray-700' }}">
            <span>🇬🇧</span> English
        </a>
        <a href="{{ route('language.switch', 'ur') }}"
           class="flex items-center gap-2 px-4 py-2.5 text-sm hover:bg-gray-50 transition
                  {{ app()->getLocale() === 'ur' ? 'bg-blue-50 text-[#0f4c81] font-semibold' : 'text-gray-700' }}">
            <span>🇵🇰</span> اردو
        </a>
        <a href="{{ route('language.switch', 'ar') }}"
           class="flex items-center gap-2 px-4 py-2.5 text-sm hover:bg-gray-50 transition
                  {{ app()->getLocale() === 'ar' ? 'bg-blue-50 text-[#0f4c81] font-semibold' : 'text-gray-700' }}">
            <span>🇸🇦</span> عربي
        </a>

    </div>
</div>
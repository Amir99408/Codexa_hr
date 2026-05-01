<div class="relative" x-data="{ open: false }" @click.outside="open = false">

    {{-- Bell Button --}}
    <button @click="open = !open"
            class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 w-5 h-5 bg-[#ff6b35] text-white text-xs font-bold rounded-full flex items-center justify-center">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 z-[9999] overflow-hidden"
         style="display:none">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 text-sm">
                Notifications
                @if($unreadCount > 0)
                    <span class="ml-1 px-2 py-0.5 bg-[#ff6b35] text-white text-xs rounded-full">{{ $unreadCount }}</span>
                @endif
            </h3>
            @if($unreadCount > 0)
                <button wire:click="markAllRead"
                        class="text-xs text-[#0f4c81] hover:underline">
                    Mark all read
                </button>
            @endif
        </div>

        {{-- List --}}
        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
            @forelse($notifications as $notif)
                <div wire:click="markRead({{ $notif->id }})"
                     class="flex gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer transition
                            {{ $notif->isRead() ? 'opacity-60' : 'bg-blue-50/30' }}">

                    {{-- Icon --}}
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 text-sm
                                {{ $notif->type_color }}">
                        {{ $notif->type_icon }}
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 leading-snug">{{ $notif->title }}</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-snug">{{ $notif->message }}</p>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</p>
                            @if($notif->url)
                                <span class="text-[10px] text-[#0f4c81] font-medium">View →</span>
                            @endif
                        </div>
                    </div>

                    {{-- Unread dot --}}
                    @if(!$notif->isRead())
                        <div class="w-2 h-2 bg-[#ff6b35] rounded-full flex-shrink-0 mt-1.5"></div>
                    @endif
                </div>
            @empty
                <div class="px-4 py-8 text-center text-gray-400 text-sm">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    No notifications yet
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if($notifications->count() > 0)
            <div class="px-4 py-2 border-t border-gray-100 text-center">
                <a href="{{ route('notifications.index') }}"
                   class="text-xs text-[#0f4c81] hover:underline">
                    View all notifications →
                </a>
            </div>
        @endif

    </div>
</div>
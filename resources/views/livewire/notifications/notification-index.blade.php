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

        @keyframes slideDown{ from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pulse-dot{ 0%,100%{opacity:1} 50%{opacity:.4} }
        .slide-down { animation: slideDown 0.3s cubic-bezier(0.4,0,0.2,1) both; }
        .pulse      { animation: pulse-dot 2s ease infinite; }

        .notif-row { transition: all 0.15s cubic-bezier(0.4,0,0.2,1); }
        .notif-row:hover { background: linear-gradient(90deg,rgba(15,76,129,0.03) 0%,transparent 100%); }
        .notif-row-unread { background: linear-gradient(90deg,rgba(15,76,129,0.04) 0%,transparent 60%); }
        .notif-row-unread:hover { background: linear-gradient(90deg,rgba(15,76,129,0.07) 0%,transparent 60%); }
    </style>

    <div class="mesh-bg min-h-screen p-5 lg:p-8">

        {{-- ── Page Header ──────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 slide-down">
            <div>
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-[10px] font-bold tracking-widest text-[#0f4c81]/50 uppercase">HR Management</span>
                    <span class="text-gray-200">/</span>
                    <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Notifications</span>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Notifications</h2>
                <p class="text-sm font-medium mt-0.5 {{ $unreadCount > 0 ? 'text-[#0f4c81]' : 'text-gray-400' }}">
                    @if($unreadCount > 0)
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-[#ff6b35] rounded-full pulse"></span>
                            {{ $unreadCount }} unread notification{{ $unreadCount !== 1 ? 's' : '' }}
                        </span>
                    @else
                        All caught up!
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0 self-start">
                @if($unreadCount > 0)
                    <button wire:click="markAllRead"
                            class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 bg-white rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Mark All Read
                    </button>
                @endif
                <button wire:click="deleteAll"
                        wire:confirm="Delete all notifications?"
                        class="flex items-center gap-2 px-4 py-2.5 border border-red-200 bg-white rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 hover:border-red-300 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Clear All
                </button>
            </div>
        </div>

        {{-- ── Filter Tabs ───────────────────────────────────────── --}}
        <div class="flex items-center gap-2 mb-5">
            <button wire:click="$set('filter', 'all')"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all duration-150
                        {{ $filter === 'all'
                            ? 'text-white shadow-lg shadow-blue-900/20'
                            : 'border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 shadow-sm' }}"
                    @if($filter === 'all') style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);" @endif>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                All
            </button>
            <button wire:click="$set('filter', 'unread')"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all duration-150
                        {{ $filter === 'unread'
                            ? 'text-white shadow-lg shadow-blue-900/20'
                            : 'border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 shadow-sm' }}"
                    @if($filter === 'unread') style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);" @endif>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Unread
                @if($unreadCount > 0)
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-extrabold
                        {{ $filter === 'unread' ? 'bg-white/20 text-white' : 'bg-[#ff6b35] text-white' }}">
                        {{ $unreadCount }}
                    </span>
                @endif
            </button>
            <button wire:click="$set('filter', 'read')"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition-all duration-150
                        {{ $filter === 'read'
                            ? 'text-white shadow-lg shadow-blue-900/20'
                            : 'border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300 shadow-sm' }}"
                    @if($filter === 'read') style="background:linear-gradient(135deg,#0f4c81,#1a6eb5);" @endif>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Read
            </button>
        </div>

        {{-- ── Notification List ─────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Card title bar --}}
            <div class="flex items-center justify-between px-6 py-3.5 border-b border-gray-50"
                 style="background:linear-gradient(90deg,#f8fafc 0%,#fff 100%);">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#0f4c81]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Notifications</span>
                </div>
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $notifications->total() }} total
                </span>
            </div>

            <div class="divide-y divide-gray-50/80">
                @forelse($notifications as $notif)
                    <div wire:click="markRead({{ $notif->id }})"
                         class="notif-row{{ $notif->isRead() ? '' : ' notif-row-unread' }} relative flex gap-4 px-6 py-4 cursor-pointer">

                        {{-- Unread left border --}}
                        @if(!$notif->isRead())
                            <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-[#0f4c81] rounded-r"></div>
                        @endif

                        {{-- Icon --}}
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-lg {{ $notif->type_color }} shadow-sm">
                            {{ $notif->type_icon }}
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <p class="text-sm font-extrabold text-gray-800 leading-snug">{{ $notif->title }}</p>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @if(!$notif->isRead())
                                        <span class="w-2 h-2 bg-[#ff6b35] rounded-full pulse flex-shrink-0"></span>
                                    @endif
                                    <p class="text-[10px] font-bold text-gray-400 whitespace-nowrap">
                                        {{ $notif->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 font-medium mt-0.5 leading-relaxed">{{ $notif->message }}</p>
                            <p class="text-[10px] text-gray-400 font-medium mt-1.5">{{ $notif->created_at->format('d M Y, h:i A') }}</p>
                        </div>

                    </div>
                @empty
                    <div class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-500">No notifications found</p>
                                <p class="text-xs text-gray-400 mt-0.5">You're all caught up — nothing to show here</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>

        @if($notifications->hasPages())
            <div class="mt-4 px-1">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>
</div>
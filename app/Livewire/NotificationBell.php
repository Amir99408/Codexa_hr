<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Component;

class NotificationBell extends Component
{
    public bool $open = false;

    public function toggle(): void
    {
        $this->open = !$this->open;
    }

    public function markRead(int $id): void
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['read_at' => now()]);
    }

    public function markAllRead(): void
    {
        Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function render()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->take(15)
            ->get();

        $unreadCount = Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return view('livewire.notification-bell', [
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount,
        ]);
    }
}

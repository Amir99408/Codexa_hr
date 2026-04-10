<?php

namespace App\Livewire\Notifications;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationIndex extends Component
{
    use WithPagination;

    public string $filter = 'all'; // all | unread | read

    public function markAllRead(): void
    {
        Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function markRead(int $id): void
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['read_at' => now()]);
    }

    public function deleteAll(): void
    {
        Notification::where('user_id', auth()->id())->delete();
    }

    public function render()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->when($this->filter === 'unread', fn($q) => $q->whereNull('read_at'))
            ->when($this->filter === 'read',   fn($q) => $q->whereNotNull('read_at'))
            ->latest()
            ->paginate(20);

        $unreadCount = Notification::where('user_id', auth()->id())
            ->whereNull('read_at')->count();

        return view('livewire.notifications.notification-index', [
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount,
        ])->layout('layouts.app', ['title' => 'Notifications']);
    }
}

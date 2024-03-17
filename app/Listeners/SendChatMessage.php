<?php

namespace App\Listeners;

use App\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Broadcast;

class SendChatMessage
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        // Lấy tin nhắn từ sự kiện
        $message = $event->message;
    
        // Gửi thông điệp đến kênh "chat" để cập nhật giao diện người nhận
        Broadcast::channel('chat', function ($user) use ($message) {
            return $user->id === $message->receiver_id;
        });
    
    }
}

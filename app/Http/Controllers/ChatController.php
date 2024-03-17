<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Pusher\Pusher;

class ChatController extends Controller
{

    public function getMessages($receiverId)
    {
        // Return all messages between the authenticated user and the selected user
        return Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', auth()->id())->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', auth()->id());
        })->get();
    }

    public function sendMessage(Request $request)
    {
        // Validate the request
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required',
        ]);

        // Save the message to the database
        $message = new Message([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->input('receiver_id'),
            'message' => $request->input('message'),
        ]);
        $message->save();

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);

        $pusher->trigger('chat-channel', 'chat-event', ['message' => $request->input('message')]);


        return response()->json(['message' => $request->input('message')]);
    }

}

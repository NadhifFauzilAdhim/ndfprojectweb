<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ForumChat extends Component
{
    public $message;

    public function render()
    {
        return view('livewire.forum-chat', [
            'messages' => ChatMessage::with('user')
                ->latest()
                ->take(50)
                ->get()
                ->sortBy('created_at'),
        ]);
    }

    public function sendMessage()
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        $executed = RateLimiter::attempt(
            'chat-message:'.Auth::id(),
            $perMinute = 5,
            function () {
                $this->validate([
                    'message' => 'required|string|max:1000',
                ]);

                ChatMessage::create([
                    'user_id' => Auth::id(),
                    'message' => $this->message,
                ]);

                $this->message = '';
            }
        );

        if (! $executed) {
            $seconds = RateLimiter::availableIn('chat-message:'.Auth::id());
            $this->addError('message', "Too many messages. Please wait {$seconds} seconds.");
        }
    }

    public function deleteMessage($messageId)
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }
        $message = ChatMessage::find($messageId);

        if ($message && $message->user_id === Auth::id()) {
            $message->delete();
        }
    }
}

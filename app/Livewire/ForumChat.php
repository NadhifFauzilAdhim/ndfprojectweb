<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ForumChat extends Component
{
    public $message;

    protected $cacheKey = 'forum_chat_messages';

    public function render()
    {
        $messages = Cache::remember($this->cacheKey, 3600, function () {
            return ChatMessage::with('user')
                ->latest()
                ->take(50)
                ->get()
                ->sortBy('created_at');
        });

        return view('livewire.forum-chat', [
            'messages' => $messages,
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
                $saveInput = strip_tags($this->message);
                $this->validate([
                    'message' => 'required|string|max:1000',
                ]);

                ChatMessage::create([
                    'user_id' => Auth::id(),
                    'message' => $saveInput,
                ]);

                $this->message = '';

                Cache::forget($this->cacheKey);
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

        if ($message && ($message->user_id === Auth::id() || Auth::user()->is_admin)) {
            $message->delete();

            Cache::forget($this->cacheKey);
        }
    }
}

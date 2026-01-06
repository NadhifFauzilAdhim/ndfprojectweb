<?php

namespace Tests\Feature;

use App\Livewire\ForumChat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class ForumChatRateLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_messages_are_rate_limited()
    {
        $user = User::factory()->create();

        RateLimiter::clear('chat-message:' . $user->id);

        for ($i = 0; $i < 5; $i++) {
            Livewire::actingAs($user)
                ->test(ForumChat::class)
                ->set('message', 'Test message ' . $i)
                ->call('sendMessage')
                ->assertHasNoErrors(['message']);
        }

        Livewire::actingAs($user)
            ->test(ForumChat::class)
            ->set('message', 'Test message 6')
            ->call('sendMessage')
            ->assertHasErrors(['message']);
    }
}

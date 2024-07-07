<?php

namespace Tests\Feature\Chat;

use App\Actions\Chat\CreateChatMessage;
use App\Actions\Chat\CreateChatRoom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateChatMessageTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_send_a_message()
    {
        $user = User::factory()->create();

        $chat = (new CreateChatRoom())->execute($user, collect());

        $message = (new CreateChatMessage())->execute($chat, $user, 'Hello');

        $this->assertEquals('Hello', $message->message);
        $this->assertEquals($message->id, $chat->last_chat_message_id);
    }
}

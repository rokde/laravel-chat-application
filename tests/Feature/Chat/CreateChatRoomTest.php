<?php

namespace Tests\Feature\Chat;

use App\Actions\Chat\CreateChatRoom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateChatRoomTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_chat_room_with_just_me()
    {
        $user = User::factory()->create();

        $chat = (new CreateChatRoom())->execute($user, collect());

        $this->assertEquals($user->name, $chat->name);

        $this->assertCount(1, $chat->participants);
        $this->assertEquals($user->id, $chat->participants->first()->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_chat_room_with_just_me_and_a_custom_name()
    {
        $user = User::factory()->create();

        $chat = (new CreateChatRoom())->execute($user, collect(), 'hello me');

        $this->assertEquals('hello me', $chat->name);

        $this->assertCount(1, $chat->participants);
        $this->assertEquals($user->id, $chat->participants->first()->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_chat_room_with_two_people()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $chat = (new CreateChatRoom())->execute($user, collect([$user2]));

        $this->assertEquals($user->name . ', ' . $user2->name, $chat->name);

        $this->assertCount(2, $chat->participants);
        $this->assertEquals($user->id, $chat->participants->first()->id);
        $this->assertEquals($user2->id, $chat->participants[1]->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_chat_room_with_two_people_and_a_custom_name()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $chat = (new CreateChatRoom())->execute($user, collect([$user2]), 'That topic is hot!');

        $this->assertEquals('That topic is hot!', $chat->name);

        $this->assertCount(2, $chat->participants);
        $this->assertEquals($user->id, $chat->participants->first()->id);
        $this->assertEquals($user2->id, $chat->participants[1]->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_chat_room_with_multiple_but_unique_users()
    {
        $user = User::factory()->create();
        $users = User::factory(10)->create();

        $chat = (new CreateChatRoom())->execute($user, collect($users)->add($user), 'That topic is hot!');

        $this->assertEquals('That topic is hot!', $chat->name);

        $this->assertCount(11, $chat->participants);
    }
}

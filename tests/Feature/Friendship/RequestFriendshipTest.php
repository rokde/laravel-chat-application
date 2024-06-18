<?php

namespace Tests\Feature\Friendship;

use App\Actions\Friendship\RequestFriendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestFriendshipTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_invite_a_user_to_be_a_friend()
    {
        $user = User::factory()->create();
        $wannabeFriend = User::factory()->create();

        (new RequestFriendship())->execute($user, $wannabeFriend);

        $this->assertDatabaseHas('friends', [
            'user_id' => $user->id,
            'friend_id' => $wannabeFriend->id,
            'accepted' => false,
        ]);

        $user->fresh();

        $this->assertEmpty($user->friends);
        $this->assertEquals($wannabeFriend->id, $user->unacceptedFriends->first()->id);
        $this->assertEmpty($user->friendOf);
        $this->assertEmpty($user->openFriendRequests);

        $this->assertEmpty($wannabeFriend->friends);
        $this->assertEmpty($wannabeFriend->unacceptedFriends);
        $this->assertEmpty($wannabeFriend->friendOf);
        $this->assertEquals($user->id, $wannabeFriend->openFriendRequests->first()->id);
    }
}

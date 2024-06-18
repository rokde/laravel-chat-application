<?php

namespace Tests\Feature\Friendship;

use App\Actions\Friendship\AcceptFriendshipRequest;
use App\Actions\Friendship\RequestFriendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcceptFriendshipRequestTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_accept_a_request()
    {
        $user = User::factory()->create();
        $wannabeFriend = User::factory()->create();

        (new RequestFriendship())->execute($user, $wannabeFriend);

        $this->assertDatabaseHas('friends', [
            'user_id' => $user->id,
            'friend_id' => $wannabeFriend->id,
            'accepted' => false,
        ]);

        (new AcceptFriendshipRequest())->execute($user, $wannabeFriend);

        $this->assertDatabaseHas('friends', [
            'user_id' => $user->id,
            'friend_id' => $wannabeFriend->id,
            'accepted' => true,
        ]);
        $this->assertDatabaseHas('friends', [
            'user_id' => $wannabeFriend->id,
            'friend_id' => $user->id,
            'accepted' => true,
        ]);

        $this->assertEquals($wannabeFriend->id, $user->friends->first()->id);
        $this->assertEmpty($user->unacceptedFriends);
        $this->assertEquals($wannabeFriend->id, $user->friendOf->first()->id);
        $this->assertEmpty($user->openFriendRequests);

        $this->assertEquals($user->id, $wannabeFriend->friends->first()->id);
        $this->assertEmpty($wannabeFriend->unacceptedFriends);
        $this->assertEquals($user->id, $wannabeFriend->friendOf->first()->id);
        $this->assertEmpty($wannabeFriend->openFriendRequests);
    }
}

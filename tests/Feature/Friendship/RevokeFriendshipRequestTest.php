<?php

namespace Tests\Feature\Friendship;

use App\Actions\Friendship\RequestFriendship;
use App\Actions\Friendship\RevokeFriendshipRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevokeFriendshipRequestTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_revoke_a_request()
    {
        $user = User::factory()->create();
        $wannabeFriend = User::factory()->create();

        (new RequestFriendship())->execute($user, $wannabeFriend);

        $this->assertDatabaseHas('friends', [
            'user_id' => $user->id,
            'friend_id' => $wannabeFriend->id,
            'accepted' => false,
        ]);

        (new RevokeFriendshipRequest())->execute($user, $wannabeFriend);

        $this->assertDatabaseMissing('friends', [
            'user_id' => $user->id,
            'friend_id' => $wannabeFriend->id,
        ]);
        $this->assertDatabaseMissing('friends', [
            'user_id' => $wannabeFriend->id,
            'friend_id' => $user->id,
        ]);

        $this->assertEmpty($user->friends);
        $this->assertEmpty($user->unacceptedFriends);
        $this->assertEmpty($user->friendOf);
        $this->assertEmpty($user->openFriendRequests);

        $this->assertEmpty($wannabeFriend->friends);
        $this->assertEmpty($wannabeFriend->unacceptedFriends);
        $this->assertEmpty($wannabeFriend->friendOf);
        $this->assertEmpty($wannabeFriend->openFriendRequests);
    }
}

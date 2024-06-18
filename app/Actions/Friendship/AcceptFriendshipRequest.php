<?php

namespace App\Actions\Friendship;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AcceptFriendshipRequest
{
    public function execute(User $user, User $friend)
    {
        DB::transaction(function () use ($user, $friend) {
            Friend::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'friend_id' => $friend->id,
                ],
                ['accepted' => true],
            );
            Friend::query()->updateOrCreate(
                [
                    'user_id' => $friend->id,
                    'friend_id' => $user->id,
                ],
                ['accepted' => true],
            );
        });
    }
}

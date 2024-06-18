<?php

namespace App\Actions\Friendship;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RequestFriendship
{
    public function execute(User $user, User $friend)
    {
        try {
            Friend::forUser($user->id)->forFriend($friend->id)
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            Friend::create([
                'user_id' => $user->id,
                'friend_id' => $friend->id,
                'accepted' => false,
            ]);
        }
    }
}

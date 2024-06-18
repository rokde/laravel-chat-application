<?php

namespace App\Actions\Friendship;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RevokeFriendshipRequest
{
    public function execute(User $user, User $friend)
    {
        DB::transaction(function () use ($user, $friend) {
            Friend::forUser($user->id)->forFriend($friend->id)->delete();
            Friend::forUser($friend->id)->forFriend($user->id)->delete();
        });
    }
}

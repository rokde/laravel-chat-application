<?php

namespace App\Actions\Friendship;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class RevokeFriendshipRequest
{
    public function execute(User $user, User $friend)
    {
        DB::table('friends')
            ->where([
                'user_id' => $user->id,
                'friend_id' => $friend->id,
            ])->orWhere([
                'user_id' => $friend->id,
                'friend_id' => $user->id,
            ])
            ->delete();
    }
}

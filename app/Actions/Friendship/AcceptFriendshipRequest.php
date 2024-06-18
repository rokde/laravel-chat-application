<?php

namespace App\Actions\Friendship;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AcceptFriendshipRequest
{
    public function execute(User $user, User $friend)
    {
        DB::table('friends')
            ->where([
                'user_id' => $user->id,
                'friend_id' => $friend->id,
            ])
            ->update([
                'accepted' => true,
                'updated_at' => now(),
            ]);

        DB::table('friends')->insert([
            'user_id' => $friend->id,
            'friend_id' => $user->id,
            'accepted' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

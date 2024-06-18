<?php

namespace App\Actions\Friendship;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class RequestFriendship
{
    public function execute(User $user, User $friend)
    {
        // @TODO check for duplicates

        DB::table('friends')->insert([
            'user_id' => $user->id,
            'friend_id' => $friend->id,
            'accepted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

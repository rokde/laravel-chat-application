<?php

namespace App\Actions\Chat;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Collection;

class CreateChatRoom
{
    public function execute(User $user, Collection $participants, string|null $name = null): Chat
    {
        $participants->prepend($user);

        if (empty($name)) {
            $name = $participants->pluck('name')->implode(', ');
        }

        return tap(Chat::create([
            'name' => $name,
        ]), function (Chat $chat) use ($participants) {
            $participants->unique('id')->each(fn(User $participant) => $chat->participants()->create([
                'user_id' => $participant->id,
                'displayName' => $participant->name,
            ]));
        });
    }
}

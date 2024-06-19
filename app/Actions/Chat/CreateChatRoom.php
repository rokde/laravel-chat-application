<?php

namespace App\Actions\Chat;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateChatRoom
{
    /**
     * @param \App\Models\User $user
     * @param \Illuminate\Support\Collection|array{array{id: integer, name: string}} $participants
     * @param string|null $name
     * @return \App\Models\Chat
     */
    public function execute(User $user, Collection $participants, string|null $name = null): Chat
    {
        $participants->prepend($user);

        if (empty($name)) {
            $name = $participants->pluck('name')->implode(', ');
        }

        return DB::transaction(function () use ($user, $participants, $name) {
            return tap(Chat::create([
                'name' => $name,
            ]), function (Chat $chat) use ($participants) {
                $participants->unique('id')->each(fn(User|array $participant) => $chat->participants()->create([
                    'user_id' => data_get($participant, 'id'),
                    'displayName' => data_get($participant, 'name'),
                ]));
            });
        });
    }
}

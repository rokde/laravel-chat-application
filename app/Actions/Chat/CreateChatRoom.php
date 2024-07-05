<?php

namespace App\Actions\Chat;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateChatRoom
{
    /**
     * @param  \Illuminate\Support\Collection|array{array{id: int, name: string}}  $participants
     */
    public function execute(User $user, Collection $participants, ?string $name = null): Chat
    {
        $participants->prepend($user);

        if (empty($name)) {
            $name = $participants->pluck('name')->implode(', ');
        }

        return DB::transaction(function () use ($participants, $name) {
            return tap(Chat::create([
                'name' => $name,
            ]), function (Chat $chat) use ($participants) {
                $participants->unique('id')->each(fn (User|array $participant) => $chat->participants()->create([
                    'user_id' => data_get($participant, 'id'),
                    'displayName' => data_get($participant, 'name'),
                ]));
            });
        });
    }
}

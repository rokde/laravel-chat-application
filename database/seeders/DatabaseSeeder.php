<?php

namespace Database\Seeders;

use App\Actions\Chat\CreateChatMessage;
use App\Actions\Chat\CreateChatRoom;
use App\Actions\Friendship\AcceptFriendshipRequest;
use App\Actions\Friendship\RequestFriendship;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        try {
            $firstUser = User::query()
                ->where('email', 'robert@kummer.email')
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            $firstUser = User::factory()->withPersonalTeam()->create([
                'name' => 'Robert Kummer',
                'email' => 'robert@kummer.email',
            ]);
        }

        $secondUser = User::factory()->withPersonalTeam()->create();

        $this->makeFriends($firstUser, $secondUser);

        $chat = $this->createChatRoom($firstUser, $secondUser);
        $this->chat($chat, $firstUser, $secondUser);
    }

    private function makeFriends(
        User $user,
        User $friend
    ): void {
        (new RequestFriendship())->execute($user, $friend);

        (new AcceptFriendshipRequest())->execute($user, $friend);
    }

    private function createChatRoom(
        User $user,
        User $friend
    ): Chat {
        return (new CreateChatRoom())->execute($user, collect([$friend]), fake()->name());
    }

    private function chat(
        Chat $chat,
        User $user,
        User $friend
    ) {
        (new CreateChatMessage())->execute($chat, $user, 'Hi');
        (new CreateChatMessage())->execute($chat, $friend, 'Hello');

        for ($i = 0; $i < fake()->randomNumber(); $i++) {
            (new CreateChatMessage())->execute($chat, fake()->randomElement([$user, $friend]), fake()->text());
        }
    }
}

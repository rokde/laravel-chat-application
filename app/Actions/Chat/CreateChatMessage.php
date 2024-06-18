<?php

namespace App\Actions\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;

class CreateChatMessage
{
    public function execute(Chat $chat, User $sender, string $message): ChatMessage
    {
        return $chat->messages()->create([
            'user_id' => $sender->id,
            'message' => $message,
        ]);
    }
}

<?php

namespace App\Actions\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateChatMessage
{
    public function execute(Chat $chat, User $sender, string $message): ChatMessage
    {
        return DB::transaction(function () use ($chat, $sender, $message) {
            return tap($chat->messages()->create([
                'user_id' => $sender->id,
                'message' => $message,
            ]), function (ChatMessage $message) use ($chat) {
                $chat->update([
                    'last_chat_message_id' => $message->id,
                ]);
            });
        });
    }
}

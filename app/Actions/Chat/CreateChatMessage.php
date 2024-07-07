<?php

namespace App\Actions\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateChatMessage
{
    /**
     * @param \App\Models\Chat $chat
     * @param \App\Models\User $sender
     * @param string|null $message
     * @param array<\Illuminate\Http\UploadedFile> $attachments
     * @return \App\Models\ChatMessage
     */
    public function execute(Chat $chat, User $sender, string|null $message, array|null $attachments = []): ChatMessage
    {
        return DB::transaction(function () use ($chat, $sender, $message, $attachments) {
            return tap($chat->messages()->create([
                'user_id' => $sender->id,
                'message' => (string)$message,
            ]), function (ChatMessage $message) use ($chat, $attachments) {
                $chat->update([
                    'last_chat_message_id' => $message->id,
                ]);

                if (empty($attachments)) {
                    return;
                }

                $directory = Str::random(32);
                Storage::makeDirectory($directory);

                foreach ($attachments as $attachment) {
                    $message->attachments()->create([
                        'name' => $attachment->getClientOriginalName(),
                        'type' => 'external',
                        'path' => $attachment->storePublicly($directory),
                        'content' => null,
                        'mime' => $attachment->getClientMimeType(),
                        'size' => $attachment->getSize(),
                    ]);
                }
            });
        });
    }
}

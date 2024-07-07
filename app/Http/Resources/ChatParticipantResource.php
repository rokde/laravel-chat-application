<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\ChatParticipant $resource
 */
class ChatParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $unseen = false;

        if ($this->resource->relationLoaded('chat')) {
            if ($this->resource->chat->last_chat_message_id !== null) {
                if ($this->resource->last_seen_chat_message_id === null || $this->resource->last_seen_chat_message_id < $this->resource->chat->last_chat_message_id) {
                    $unseen = true;
                }
            }
        }

        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'name' => $this->resource->display_name,
            'unseen' => $unseen,
        ];
    }
}

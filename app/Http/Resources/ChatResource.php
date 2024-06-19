<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\Chat $resource
 */
class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'participants' => ChatParticipantResource::collection($this->whenLoaded('participants')),
            'messages' => ChatMessageResource::collection($this->whenLoaded('messages')),
        ];
    }
}

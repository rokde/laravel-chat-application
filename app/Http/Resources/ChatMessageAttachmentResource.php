<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read \App\Models\ChatMessageAttachment $resource
 */
class ChatMessageAttachmentResource extends JsonResource
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
            'chat_message_id' => $this->resource->chat_message_id,
            'name' => $this->resource->name,
            'mime' => $this->resource->mime,
            'type' => $this->resource->type,
            'size' => $this->resource->size,
            'url' => $this->resource->path ? Storage::url($this->resource->path) : null,
            'timestamp' => $this->resource->created_at,
        ];
    }
}

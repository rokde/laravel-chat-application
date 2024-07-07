<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $chat_message_id
 * @property string $name
 * @property string $type
 * @property string|null $path
 * @property string|null $content
 * @property string $mime
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ChatMessage|null $message
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereChatMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageAttachment whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ChatMessageAttachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function message(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class);
    }
}

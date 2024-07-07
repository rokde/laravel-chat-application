<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $chat_id
 * @property int $user_id
 * @property string|null $display_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $last_seen_chat_message_id
 * @property-read \App\Models\Chat $chat
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereLastSeenChatMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereUserId($value)
 *
 * @mixin \Eloquent
 */
class ChatParticipant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

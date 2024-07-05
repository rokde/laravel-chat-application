<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property int $accepted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static Builder|Friend accepted()
 * @method static Builder|Friend forFriend(int $friendId)
 * @method static Builder|Friend forUser(int $userId)
 * @method static Builder|Friend newModelQuery()
 * @method static Builder|Friend newQuery()
 * @method static Builder|Friend query()
 * @method static Builder|Friend unaccepted()
 * @method static Builder|Friend whereAccepted($value)
 * @method static Builder|Friend whereCreatedAt($value)
 * @method static Builder|Friend whereFriendId($value)
 * @method static Builder|Friend whereId($value)
 * @method static Builder|Friend whereUpdatedAt($value)
 * @method static Builder|Friend whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Friend extends Model
{
    protected $guarded = [];

    public function scopeForUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    public function scopeForFriend(Builder $query, int $friendId): void
    {
        $query->where('friend_id', $friendId);
    }

    public function scopeAccepted(Builder $query): void
    {
        $query->where('accepted', true);
    }

    public function scopeUnaccepted(Builder $query): void
    {
        $query->where('accepted', false);
    }
}

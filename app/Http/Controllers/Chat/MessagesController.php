<?php

namespace App\Http\Controllers\Chat;

use App\Actions\Chat\CreateChatMessage;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Resources\NameBasedResource;
use App\Models\Chat;
use App\Models\ChatParticipant;
use App\Notifications\MessageSentNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MessagesController extends Controller
{
    public function store(Request $request, Chat $chat, CreateChatMessage $createChatMessage): RedirectResponse
    {
        $chat->loadMissing('participants');

        //  only allow participants to access this chat
        abort_unless(in_array($request->user()->id, $chat->participants->pluck('user_id')->toArray()), 404);

        $message = $createChatMessage->execute($chat, $request->user(), $request->get('message'));

        MessageSent::dispatch($message);
        $message->recipients()
            ->each(
                fn(ChatParticipant $participant) => $participant->user->notify(new MessageSentNotification($message))
            );

        return back();
    }

    public function show(Request $request, Chat $chat): Response
    {
        $chat->loadMissing('participants');

        //  only allow participants to access this chat
        abort_unless(in_array($request->user()->id, $chat->participants->pluck('user_id')->toArray()), 404);

        $beforeMessageId = $request->get('before_message_id');
        $chat->load([
            'messages' => function (HasMany $query) use ($beforeMessageId) {
                return $query->when($beforeMessageId, function (Builder $query) use ($beforeMessageId) {
                    $query->where('id', '<', $beforeMessageId);
                })
                    ->latest('id')
                    ->limit(10);
            },
        ]);

        $user = $request->user();
        $user->loadMissing('friends', 'chats.lastMessage.user', 'chats.participants');
        $chat->participants->each(fn(ChatParticipant $participant) => $participant->setRelation('chat', $chat));

        return Inertia::render('Chats', [
            'chat' => new ChatResource($chat),
            'chats' => ChatResource::collection($user->chats),
            'friends' => NameBasedResource::collection($user->friends),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

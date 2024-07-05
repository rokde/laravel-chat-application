<?php

use App\Actions\Chat\CreateChatMessage;
use App\Actions\Chat\CreateChatRoom;
use App\Http\Resources\ChatResource;
use App\Http\Resources\NameBasedResource;
use App\Models\Chat;
use App\Models\ChatParticipant;
use App\Notifications\MessageSentNotification;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/chats', function (Request $request) {
        $user = $request->user();
        $user->loadMissing('chats.latestMessage.user', 'chats.participants');

        return Inertia::render('Chats', [
            'chats' => ChatResource::collection($user->chats),
        ]);
    })->name('chats.index');

    Route::post('/chats', function (Request $request, CreateChatRoom $createChatRoom) {
        $chat = $createChatRoom->execute(
            $request->user(),
            collect($request->get('participants')),
            $request->get('name'),
        );

        return redirect()->route('chats.show', [$chat]);
    })->name('chats.store');

    Route::get('/chats/{chat}', function (Request $request, Chat $chat) {
        $user = $request->user();
        $user->loadMissing('chats.latestMessage.user', 'chats.participants');
        $chat->loadMissing('participants', 'messages');

        return Inertia::render('Chats', [
            'chat' => new ChatResource($chat),
            'chats' => ChatResource::collection($user->chats),
        ]);
    })->name('chats.show');

    Route::post('/chats/{chat}', function (Request $request, Chat $chat, CreateChatMessage $createChatMessage) {
        $message = $createChatMessage->execute($chat, $request->user(), $request->get('message'));

        \App\Events\MessageSent::dispatch($message);
        $message->recipients()
            ->each(
                fn (ChatParticipant $participant) => $participant->user->notify(new MessageSentNotification($message))
            );

        return back();
    })->name('chats.messages.store');

    Route::get('/contacts', function (Request $request) {

        return Inertia::render('Contacts', [
            'friends' => NameBasedResource::collection($request->user()->friends),
        ]);
    })->name('contacts.index');

    Route::get('/contacts/{contact}', function (Request $request, \App\Models\User $contact) {

        return Inertia::render('Contacts', [
            'friends' => NameBasedResource::collection($request->user()->friends),
            'contact' => new \App\Http\Resources\UserResource($contact),
        ]);
    })->name('contacts.show');
});

Route::get('/imprint', function () {
    $imprintFile = Jetstream::localizedMarkdownPath('imprint.md');

    return Inertia::render('Imprint', [
        'imprint' => Str::markdown(file_get_contents($imprintFile)),
    ]);
})->name('imprint.show');

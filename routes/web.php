<?php

use App\Actions\Chat\CreateChatRoom;
use App\Http\Controllers\Chat\MessagesController;
use App\Http\Resources\ChatResource;
use App\Http\Resources\NameBasedResource;
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
        /** @var \App\Models\User $user */
        $user = $request->user();
        $user->loadMissing('friends', 'chats.lastMessage.user', 'chats.participants');

        return Inertia::render('Chats', [
            'chats' => ChatResource::collection($user->chats),
            'friends' => NameBasedResource::collection($user->friends),
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

    Route::get('/chats/{chat}', [MessagesController::class, 'show'])->name('chats.show');

    Route::post('/chats/{chat}', [MessagesController::class, 'store'])->name('chats.messages.store');

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

<?php

use App\Models\Chat;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
        $chats = $request->user()->chats
            ->map(function ($chat) {
                return [
                    'id' => $chat->id,
                    'name' => $chat->name,
                ];
            })
            ->all();

        $friends = $request->user()->friends
            ->map(function ($friend) {
                return [
                    'id' => $friend->id,
                    'name' => $friend->name,
                ];
            });

        return Inertia::render('Chats', [
            'chats' => $chats,
            'friends' => $friends,
        ]);
    })->name('chats.index');

});

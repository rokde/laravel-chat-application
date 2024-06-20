# Laravel Chat Application

This should be a reference chat application. I want to learn how to do that :)

Come and learn with me. I will commit every single step going forward.

## Features

### Friendship

A user can have friends. But he had to ask. So first he requests a friendship and the other user can accept or revoke.

We have Actions to handle friendship between users.

You can only chat with friends.

### Chat

We can have chats. On your own, or with friends. So create a chat.

In a chat we can send messages. From one participant to the others. Empty messages can have attachments in the future.
So you can just send an attachment. We want to add reactions and replies as well.

### Realtime collaboration

We use the event and the notification sending through the websocket.

You have to start several commands locally to make that happen:

- `php artisan serve` to start your webservice
- `npm run dev` optional, but building assets can be important
- `php reverb:start [--debug]` to start websocket with reverb
- `php queue:listen` to start queue worker, because all events and notifications will be send via queue (you can run
  queue:work as well, but queue:listen restarts automatically on php changes)

After having this running open two different browsers (or incognito window) and meet in the same chat.

## Local development

start local server in one console

```bash
php artisan serve
```

Then open your browser with http://localhost:8000.

Mail is configured for log -> you can register and verify your email by opening
the [log file](./storage/logs/laravel.log) and clicking the link.

Building assets, open a new console and run

```bash
npm run dev
```

## Dependencies

### Frontend

- [Day.js](https://day.js.org/docs/en/installation/installation) for displaying dates in the ui

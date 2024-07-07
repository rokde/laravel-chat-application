<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_message_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_message_id')->constrained()->cascadeOnDelete();
            $table->string('name', 191);
            $table->string('type', 191);
            $table->string('path', 1024)->nullable()->default(null);
            $table->binary('content')->nullable()->default(null);
            $table->string('mime', 191);
            $table->unsignedBigInteger('size')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_message_attachments');
    }
};

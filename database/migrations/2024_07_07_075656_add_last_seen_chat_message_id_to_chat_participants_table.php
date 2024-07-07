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
        Schema::table('chat_participants', function (Blueprint $table) {
            $table->foreignId('last_seen_chat_message_id')
                ->after('display_name')
                ->nullable()->default(null)
                ->constrained('chat_messages')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_participants', function (Blueprint $table) {
            $table->dropColumn('last_seen_chat_message_id');
        });
    }
};

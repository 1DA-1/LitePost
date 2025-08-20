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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // The user who will RECEIVE the notification
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Notification type (like, comment, follow, mention, etc.)
            $table->string('type');

           
            $table->json('data');

            // If user opened/read the notification
            $table->boolean('read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
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
        Schema::create('comment_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')->constrained(
                table : 'comments',
                indexName : 'comment_replies_comment_id'
            )->onDelete('cascade');
            $table->foreignId('user_id')->constrained(
                table : 'users',
                indexName : 'comment_replies_user_id'
            )->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_replies');
    }
};

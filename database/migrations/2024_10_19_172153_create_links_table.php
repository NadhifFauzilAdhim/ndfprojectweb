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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table : 'users',
                indexName : 'links_user_id'
            );
            $table->string('title')->nullable();
            $table->string('slug');
            $table->string('target_url');
            $table->integer('visits')->default(0);
            $table->integer('unique_visits')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('multi_link')->default(false);
            $table->boolean('password_protected')->default(false);
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};

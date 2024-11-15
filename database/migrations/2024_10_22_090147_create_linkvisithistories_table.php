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
        Schema::create('linkvisithistories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained(
                table : 'links',
                indexName : 'linkvisithistories_link_id'
            )->cascadeOnDelete();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linkvisithistories');
    }
};

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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->references('id')->on('test_user')->constrained()->cascadeOnDelete();
            $table->foreignId('test_id')->references('id')->on('tests')->constrained()->cascadeOnDelete();
            $table->foreignId('quest_id')->references('id')->on('questions')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreignId('answer_id')->references('id')->on('answers')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->integer('total_questions')->default(0);
            $table->integer('time_spent')->default(0); // dalam detik
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_answers');
        Schema::dropIfExists('quiz_attempts');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel quizzes (sudah ada, tambahkan jika belum)
        if (!Schema::hasTable('quizzes')) {
            Schema::create('quizzes', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->integer('question_count')->default(0);
                $table->integer('duration')->default(30); // menit
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Tabel questions
        if (!Schema::hasTable('questions')) {
            Schema::create('questions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
                $table->text('question_text');
                $table->string('question_image')->nullable();
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }

        // Tabel options
        if (!Schema::hasTable('options')) {
            Schema::create('options', function (Blueprint $table) {
                $table->id();
                $table->foreignId('question_id')->constrained()->onDelete('cascade');
                $table->string('option_letter', 1); // A, B, C, D
                $table->text('option_text');
                $table->string('option_image')->nullable();
                $table->boolean('is_correct')->default(false);
                $table->timestamps();
            });
        }

        // Tabel quiz_attempts
        if (!Schema::hasTable('quiz_attempts')) {
            Schema::create('quiz_attempts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
                $table->integer('score')->default(0);
                $table->integer('correct_answers')->default(0);
                $table->integer('total_questions')->default(0);
                $table->integer('time_spent')->default(0); // detik
                $table->timestamp('started_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
            });
        }

        // Tabel user_answers
        if (!Schema::hasTable('user_answers')) {
            Schema::create('user_answers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('quiz_attempt_id')->constrained()->onDelete('cascade');
                $table->foreignId('question_id')->constrained()->onDelete('cascade');
                $table->foreignId('option_id')->nullable()->constrained()->onDelete('cascade');
                $table->boolean('is_correct')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('user_answers');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
    }
};
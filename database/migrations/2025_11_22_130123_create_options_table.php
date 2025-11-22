<?php
// database/migrations/2024_01_01_000003_create_options_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->string('option_letter'); // a, b, c, d
            $table->text('option_text');
            $table->string('option_image')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('options');
    }
};
<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_social_features_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('verification_code');
            $table->integer('level')->default(1)->after('points');
            $table->integer('quizzes_completed')->default(0)->after('level');
            $table->integer('correct_answers')->default(0)->after('quizzes_completed');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['points', 'level', 'quizzes_completed', 'correct_answers']);
        });
    }
};
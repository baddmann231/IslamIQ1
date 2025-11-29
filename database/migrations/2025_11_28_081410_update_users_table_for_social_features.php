<?php
// database/migrations/xxxx_xx_xx_xxxxxx_update_users_table_for_social_features.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambah kolom jika belum ada
            if (!Schema::hasColumn('users', 'points')) {
                $table->integer('points')->default(0)->after('verification_code');
            }
            
            if (!Schema::hasColumn('users', 'level')) {
                $table->integer('level')->default(1)->after('points');
            }
            
            if (!Schema::hasColumn('users', 'quizzes_completed')) {
                $table->integer('quizzes_completed')->default(0)->after('level');
            }
            
            if (!Schema::hasColumn('users', 'correct_answers')) {
                $table->integer('correct_answers')->default(0)->after('quizzes_completed');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hanya drop kolom jika ada
            if (Schema::hasColumn('users', 'points')) {
                $table->dropColumn('points');
            }
            if (Schema::hasColumn('users', 'level')) {
                $table->dropColumn('level');
            }
            if (Schema::hasColumn('users', 'quizzes_completed')) {
                $table->dropColumn('quizzes_completed');
            }
            if (Schema::hasColumn('users', 'correct_answers')) {
                $table->dropColumn('correct_answers');
            }
        });
    }
};
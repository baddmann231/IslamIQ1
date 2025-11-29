<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom username jika belum ada
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('name');
            }
            
            // Tambahkan kolom verification_code jika belum ada
            if (!Schema::hasColumn('users', 'verification_code')) {
                $table->string('verification_code', 6)->nullable()->after('password');
            }
            
            // Tambahkan kolom avatar, phone, birth_date jika belum ada
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('verification_code');
            }
            
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('avatar');
            }
            
            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'verification_code', 'avatar', 'phone', 'birth_date']);
        });
    }
};
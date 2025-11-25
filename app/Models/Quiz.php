<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'question_count',
        'duration',
        'is_active'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // ✅ TAMBAHKAN RELASI INI
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // ✅ TAMBAHKAN METHOD INI UNTUK DASHBOARD
    public function getCompletedAttemptsCountAttribute()
    {
        return $this->quizAttempts()->whereNotNull('completed_at')->count();
    }

    public function getAverageScoreAttribute()
    {
        return $this->quizAttempts()->whereNotNull('completed_at')->avg('score') ?? 0;
    }
}
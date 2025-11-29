<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    // ✅ TAMBAHKAN KONSTANTA KATEGORI
    const CATEGORIES = [
        'rukun_islam' => 'Rukun Islam',
        'rukun_iman' => 'Rukun Iman', 
        'sejarah_islam' => 'Sejarah Islam'
    ];

    protected $fillable = [
        'title',
        'description',
        'image',
        'question_count',
        'duration',
        'is_active',
        'category' // ✅ TAMBAHKAN INI
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function getCompletedAttemptsCountAttribute()
    {
        return $this->quizAttempts()->whereNotNull('completed_at')->count();
    }

    public function getAverageScoreAttribute()
    {
        return $this->quizAttempts()->whereNotNull('completed_at')->avg('score') ?? 0;
    }

    // ✅ METHOD BARU UNTUK MENDAPATKAN LABEL KATEGORI
    public function getCategoryLabelAttribute()
    {
        return self::CATEGORIES[$this->category] ?? 'Tidak Diketahui';
    }
}
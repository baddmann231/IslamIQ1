<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content', 
        'image',
        'admin_id',
        'is_published'
    ];

    // Admin yang membuat content
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scope untuk content yang published
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
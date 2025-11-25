<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',        // ✅ TAMBAH: untuk menyimpan path avatar
        'phone',         // ✅ TAMBAH: nomor telepon
        'birth_date',    // ✅ TAMBAH: tanggal lahir
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date', // ✅ TAMBAH: cast birth_date
        ];
    }

    // ✅ Relasi untuk quiz attempts
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function getQuizHistory()
    {
        return $this->quizAttempts()->with('quiz')->orderBy('created_at', 'desc')->get();
    }

    // ✅ METHODS BARU UNTUK PROFILE & AVATAR

    /**
     * Get URL avatar user
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // Cek jika avatar sudah full URL atau path storage
            if (str_starts_with($this->avatar, 'http')) {
                return $this->avatar;
            }
            return asset('storage/' . $this->avatar);
        }
        
        // Avatar default
        return '/assets/img/default-avatar.png';
    }

    /**
     * Upload avatar baru untuk user
     */
    public function uploadAvatar($avatarFile)
    {
        // Hapus avatar lama jika ada
        $this->deleteAvatar();
        
        // Simpan avatar baru
        $path = $avatarFile->store('avatars/user-' . $this->id, 'public');
        $this->update(['avatar' => $path]);
        
        return $path;
    }

    /**
     * Hapus avatar user
     */
    public function deleteAvatar()
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            Storage::disk('public')->delete($this->avatar);
        }
        $this->update(['avatar' => null]);
    }

    /**
     * Cek jika user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek jika user adalah regular user
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * Get user's age dari birth_date
     */
    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }
        
        return $this->birth_date->age;
    }

    /**
     * Format phone number untuk display
     */
    public function getFormattedPhoneAttribute()
    {
        if (!$this->phone) {
            return 'Belum diatur';
        }

        // Format: +62 812-3456-7890
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        
        if (strlen($phone) === 12) {
            return '+62 ' . substr($phone, 2, 4) . '-' . substr($phone, 6, 4) . '-' . substr($phone, 10);
        }
        
        return $this->phone;
    }

    /**
     * Get user's progress stats untuk dashboard
     */
    // Di dalam class User, ganti method getQuizStats() dengan ini:

/**
 * Get user's progress stats untuk dashboard
 */
public function getQuizStats()
{
    $attempts = $this->quizAttempts()->whereNotNull('completed_at')->get();
    
    return [
        'total_attempts' => $attempts->count(),
        'average_score' => $attempts->avg('score') ?? 0,
        'highest_score' => $attempts->max('score') ?? 0,
        'completed_quizzes' => $attempts->count(),
        'total_correct_answers' => $attempts->sum('correct_answers'),
        'total_questions_answered' => $attempts->sum('total_questions'),
    ];
}

    /**
     * Update profile information
     */
    public function updateProfile($data)
    {
        return $this->update([
            'name' => $data['name'] ?? $this->name,
            'phone' => $data['phone'] ?? $this->phone,
            'birth_date' => $data['birth_date'] ?? $this->birth_date,
        ]);
    }
}
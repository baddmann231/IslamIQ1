<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'birth_date',
        'verification_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    // ✅ SEMUA RELATIONSHIP FRIENDSHIP YANG DIBUTUHKAN
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->withPivot('status')
                    ->withTimestamps()
                    ->wherePivot('status', 'accepted');
    }

    public function pendingFriendRequests()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                    ->withPivot('status')
                    ->withTimestamps()
                    ->wherePivot('status', 'pending');
    }

    public function sentFriendRequests()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->withPivot('status')
                    ->withTimestamps()
                    ->wherePivot('status', 'pending');
    }

    // ✅ TAMBAHKAN sentFriendships() METHOD
    public function sentFriendships()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function receivedFriendships()
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    // ✅ METHOD UNTUK MANAGE FRIENDSHIPS
    public function addFriend(User $friend)
    {
        return Friendship::create([
            'user_id' => $this->id,
            'friend_id' => $friend->id,
            'status' => 'pending'
        ]);
    }

    public function acceptFriendRequest(User $user)
    {
        $friendship = Friendship::where('user_id', $user->id)
                               ->where('friend_id', $this->id)
                               ->where('status', 'pending')
                               ->first();

        if ($friendship) {
            $friendship->update(['status' => 'accepted']);
            return true;
        }

        return false;
    }

    public function rejectFriendRequest(User $user)
    {
        $friendship = Friendship::where('user_id', $user->id)
                               ->where('friend_id', $this->id)
                               ->where('status', 'pending')
                               ->first();

        if ($friendship) {
            $friendship->delete();
            return true;
        }

        return false;
    }

    public function removeFriend(User $friend)
    {
        Friendship::where(function ($query) use ($friend) {
            $query->where('user_id', $this->id)
                  ->where('friend_id', $friend->id);
        })->orWhere(function ($query) use ($friend) {
            $query->where('user_id', $friend->id)
                  ->where('friend_id', $this->id);
        })->delete();

        return true;
    }

    public function isFriendWith(User $user)
    {
        return Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $this->id)
                  ->where('friend_id', $user->id)
                  ->where('status', 'accepted');
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', $this->id)
                  ->where('status', 'accepted');
        })->exists();
    }

    public function hasSentFriendRequestTo(User $user)
    {
        return Friendship::where('user_id', $this->id)
                        ->where('friend_id', $user->id)
                        ->where('status', 'pending')
                        ->exists();
    }

    public function hasReceivedFriendRequestFrom(User $user)
    {
        return Friendship::where('user_id', $user->id)
                        ->where('friend_id', $this->id)
                        ->where('status', 'pending')
                        ->exists();
    }

    // Relasi untuk quiz attempts
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function getQuizHistory()
    {
        return $this->quizAttempts()->with('quiz')->orderBy('created_at', 'desc')->get();
    }

    // METHODS UNTUK PROFILE & AVATAR

    /**
     * Get URL avatar user
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http')) {
                return $this->avatar;
            }
            return asset('storage/' . $this->avatar);
        }
        
        return '/assets/img/default-avatar.png';
    }

    /**
     * Upload avatar baru untuk user
     */
    public function uploadAvatar($avatarFile)
    {
        $this->deleteAvatar();
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
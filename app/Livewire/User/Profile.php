<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $birth_date;
    public $newAvatar;

    // HAPUS property $userAvatars dan $activeAvatarId karena tidak digunakan
    // public $userAvatars = [];
    // public $activeAvatarId;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->birth_date = $user->birth_date;
    }

    public function updateProfile()
    {
        $user = Auth::user();
        
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
        ]);

        $user->update($validated); // Langsung update, tidak perlu method updateProfile

        session()->flash('message', 'Profile updated successfully!');
    }

    public function uploadAvatar()
    {
        $this->validate([
            'newAvatar' => 'required|image|max:2048', // 2MB max
        ]);

        $user = Auth::user();
        
        // Upload avatar menggunakan method dari User model
        if (method_exists($user, 'uploadAvatar')) {
            $user->uploadAvatar($this->newAvatar);
        } else {
            // Fallback: langsung simpan ke field avatar
            $path = $this->newAvatar->store('avatars/user-' . $user->id, 'public');
            $user->update(['avatar' => $path]);
        }
        
        $this->newAvatar = null;
        session()->flash('message', 'Avatar uploaded successfully!');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();
        
        // Hapus avatar menggunakan method dari User model
        if (method_exists($user, 'deleteAvatar')) {
            $user->deleteAvatar();
        } else {
            // Fallback: langsung set avatar ke null
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $user->update(['avatar' => null]);
        }
        
        session()->flash('message', 'Avatar deleted successfully!');
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}
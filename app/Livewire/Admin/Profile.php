<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')] // Pastikan ada admin layout
class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $birth_date;
    public $newAvatar;

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

        $user->updateProfile($validated);

        session()->flash('message', 'Profile updated successfully!');
    }

    public function uploadAvatar()
    {
        $this->validate([
            'newAvatar' => 'required|image|max:2048',
        ]);

        $user = Auth::user();
        $user->uploadAvatar($this->newAvatar);
        
        $this->newAvatar = null;
        session()->flash('message', 'Avatar uploaded successfully!');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();
        $user->deleteAvatar();
        session()->flash('message', 'Avatar deleted successfully!');
    }

    public function render()
    {
        return view('livewire.admin.profile');
    }
}
<?php

namespace App\Livewire\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Quiz;

#[Layout('components.layouts.app')]
class DaftarKuis extends Component
{
    public $quizzes;

    public function mount()
    {
        // Ambil semua kuis yang aktif
        $this->quizzes = Quiz::where('is_active', true)->get();
    }

    public function render()
    {
        return view('livewire.user.daftar-kuis');
    }
}
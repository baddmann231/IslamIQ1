<?php
// app/Livewire/Admin/DaftarKuis.php

namespace App\Livewire\Admin;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Quiz;

#[Layout('components.layouts.admin')]
class DaftarKuis extends Component
{
    public $quizzes;

    public function mount()
    {
        $this->quizzes = Quiz::all();
    }

    public function deleteQuiz($id)
    {
        $quiz = Quiz::find($id);
        if ($quiz) {
            $quiz->delete();
            session()->flash('message', 'Kuis berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.admin.daftar-kuis');
    }
}
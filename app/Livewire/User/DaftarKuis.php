<?php

namespace App\Livewire\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Quiz;

#[Layout('components.layouts.app')]
class DaftarKuis extends Component
{
    public $quizzes;
    public $search = '';
    public $category = '';
    
    // ✅ TAMBAHKAN KATEGORI YANG SAMA DENGAN ADMIN
    public $categories = [
        'rukun_islam' => 'Rukun Islam',
        'rukun_iman' => 'Rukun Iman', 
        'sejarah_islam' => 'Sejarah Islam'
    ];

    public function mount()
    {
        $this->loadQuizzes();
    }

    public function loadQuizzes()
    {
        $query = Quiz::where('is_active', true);

        // ✅ FILTER BERDASARKAN PENCARIAN
        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        // ✅ FILTER BERDASARKAN KATEGORI
        if (!empty($this->category)) {
            $query->where('category', $this->category);
        }

        $this->quizzes = $query->get();
    }

    // ✅ METHOD UNTUK REAL-TIME SEARCH
    public function updatedSearch()
    {
        $this->loadQuizzes();
    }

    // ✅ METHOD UNTUK REAL-TIME CATEGORY FILTER
    public function updatedCategory()
    {
        $this->loadQuizzes();
    }

    // ✅ METHOD UNTUK RESET FILTER
    public function resetFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->loadQuizzes();
    }

    public function render()
    {
        return view('livewire.user.daftar-kuis');
    }
}
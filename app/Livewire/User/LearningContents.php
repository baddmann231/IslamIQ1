<?php

namespace App\Livewire\User;

use App\Models\LearningContent;
use Livewire\Component;
use Livewire\WithPagination;

class LearningContents extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $contents = LearningContent::published()
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);

        return view('livewire.user.learning-contents', compact('contents'))
            ->layout('components.layouts.app');
    }
}
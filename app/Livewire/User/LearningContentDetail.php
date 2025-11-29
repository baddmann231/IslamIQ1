<?php

namespace App\Livewire\User;

use App\Models\LearningContent;
use Livewire\Component;

class LearningContentDetail extends Component
{
    public $content;

    public function mount($id)
    {
        $this->content = LearningContent::published()->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.user.learning-content-detail')
            ->layout('components.layouts.app');
    }
}
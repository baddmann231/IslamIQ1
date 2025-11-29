<?php

namespace App\Livewire\Admin;

use App\Models\LearningContent;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class ManageLearningContents extends Component
{
    use WithPagination;

    public $search = '';

    public function deleteContent($id)
    {
        $content = LearningContent::findOrFail($id);
        if ($content->image) {
            \Storage::disk('public')->delete($content->image);
        }
        $content->delete();
        
        session()->flash('success', 'Konten pembelajaran berhasil dihapus!');
    }

    public function render()
    {
        $contents = LearningContent::when($this->search, function ($query) {
            return $query->where('title', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(12);

        return view('livewire.admin.manage-learning-contents', compact('contents'));
    }
}
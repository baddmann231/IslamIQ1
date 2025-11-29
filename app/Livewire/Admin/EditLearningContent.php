<?php

namespace App\Livewire\Admin;

use App\Models\LearningContent;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditLearningContent extends Component
{
    use WithFileUploads;

    public $contentItem;
    public $title;
    public $content;
    public $image;
    public $oldImage;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string|min:10',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];

    public function mount($id)
    {
        $this->contentItem = LearningContent::findOrFail($id);
        $this->title = $this->contentItem->title;
        $this->content = $this->contentItem->content;
        $this->oldImage = $this->contentItem->image;
    }

    public function update()
    {
        $this->validate();

        try {
            $imagePath = $this->oldImage;
            
            if ($this->image) {
                if ($this->oldImage) {
                    \Storage::disk('public')->delete($this->oldImage);
                }
                $imagePath = $this->image->store('content_images', 'public');
            }

            $this->contentItem->update([
                'title' => $this->title,
                'content' => $this->content,
                'image' => $imagePath,
            ]);

            session()->flash('success', 'Konten pembelajaran berhasil diupdate!');
            return redirect()->route('admin.learning-contents');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal update konten: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.edit-learning-content')
            ->layout('components.layouts.admin');
    }
}
<?php

namespace App\Livewire\Admin;
use Livewire\Attributes\Layout;
use App\Models\LearningContent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class CreateLearningContent extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string|min:10',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];

    public function save()
    {
        $this->validate();

        try {
            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('content_images', 'public');
            }

            LearningContent::create([
                'title' => $this->title,
                'content' => $this->content,
                'image' => $imagePath,
                'admin_id' => Auth::id(),
                'is_published' => true,
            ]);

            session()->flash('success', 'Konten pembelajaran berhasil dibuat!');
            return redirect()->route('admin.learning-contents');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat konten: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.create-learning-content');
    }
}
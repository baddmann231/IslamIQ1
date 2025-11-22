<?php
// app/Livewire/Admin/CreateQuiz.php

namespace App\Livewire\Admin;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;

#[Layout('components.layouts.admin')]
class CreateQuiz extends Component
{
    use WithFileUploads;

    public $quizTitle;
    public $quizDescription;
    public $quizDuration = 20;
    public $quizImage;
    
    public $questions = [
        [
            'text' => '',
            'image' => null,
            'options' => [
                ['letter' => 'A', 'text' => '', 'image' => null, 'is_correct' => false],
                ['letter' => 'B', 'text' => '', 'image' => null, 'is_correct' => false],
                ['letter' => 'C', 'text' => '', 'image' => null, 'is_correct' => false],
                ['letter' => 'D', 'text' => '', 'image' => null, 'is_correct' => false],
            ]
        ]
    ];

    public function addQuestion()
    {
        $this->questions[] = [
            'text' => '',
            'image' => null,
            'options' => [
                ['letter' => 'A', 'text' => '', 'image' => null, 'is_correct' => false],
                ['letter' => 'B', 'text' => '', 'image' => null, 'is_correct' => false],
                ['letter' => 'C', 'text' => '', 'image' => null, 'is_correct' => false],
                ['letter' => 'D', 'text' => '', 'image' => null, 'is_correct' => false],
            ]
        ];
    }

    public function removeQuestion($index)
    {
        if (count($this->questions) > 1) {
            unset($this->questions[$index]);
            $this->questions = array_values($this->questions);
        }
    }

    public function setCorrectAnswer($questionIndex, $optionIndex)
    {
        // Reset semua jawaban benar untuk soal ini
        foreach ($this->questions[$questionIndex]['options'] as $index => $option) {
            $this->questions[$questionIndex]['options'][$index]['is_correct'] = false;
        }
        
        // Set jawaban yang dipilih sebagai benar
        $this->questions[$questionIndex]['options'][$optionIndex]['is_correct'] = true;
    }

    public function saveQuiz()
    {
        // Validasi
        $this->validate([
            'quizTitle' => 'required|string|max:255',
            'quizDescription' => 'nullable|string',
            'quizDuration' => 'required|integer|min:1',
            'quizImage' => 'nullable|image|max:2048',
            'questions.*.text' => 'required|string',
            'questions.*.image' => 'nullable|image|max:2048',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.image' => 'nullable|image|max:2048',
        ]);

        // Simpan gambar kuis
        $quizImagePath = null;
        if ($this->quizImage) {
            $quizImagePath = $this->quizImage->store('quiz-images', 'public');
        }

        // Buat kuis
        $quiz = Quiz::create([
            'title' => $this->quizTitle,
            'description' => $this->quizDescription,
            'duration' => $this->quizDuration,
            'image' => $quizImagePath,
            'question_count' => count($this->questions),
        ]);

        // Simpan setiap soal
        foreach ($this->questions as $index => $questionData) {
            // Simpan gambar soal
            $questionImagePath = null;
            if ($questionData['image']) {
                $questionImagePath = $questionData['image']->store('question-images', 'public');
            }

            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['text'],
                'question_image' => $questionImagePath,
                'order' => $index + 1,
            ]);

            // Simpan setiap pilihan jawaban
            foreach ($questionData['options'] as $optionData) {
                // Simpan gambar pilihan
                $optionImagePath = null;
                if ($optionData['image']) {
                    $optionImagePath = $optionData['image']->store('option-images', 'public');
                }

                Option::create([
                    'question_id' => $question->id,
                    'option_letter' => $optionData['letter'],
                    'option_text' => $optionData['text'],
                    'option_image' => $optionImagePath,
                    'is_correct' => $optionData['is_correct'],
                ]);
            }
        }

        session()->flash('message', 'Kuis berhasil dibuat!');
        return redirect()->route('admin.daftar-kuis');
    }

    public function render()
    {
        return view('livewire.admin.create-quiz');
    }
}
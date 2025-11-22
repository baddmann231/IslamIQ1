<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Quiz;
use Livewire\Attributes\Layout;
use App\Models\Question;
use App\Models\Option;

#[Layout('components.layouts.admin')]
class ManageQuestions extends Component
{
    use WithFileUploads;

    public $quiz;
    public $quizId;
    public $questions = [];

    public function mount($quiz)
    {
        $this->quiz = Quiz::with(['questions.options'])->findOrFail($quiz);
        $this->quizId = $this->quiz->id;

        // Load existing questions
        foreach ($this->quiz->questions as $question) {
            $options = [];
            foreach ($question->options as $option) {
                $options[] = [
                    'id' => $option->id,
                    'letter' => $option->option_letter,
                    'text' => $option->option_text,
                    'image' => $option->option_image,
                    'new_image' => null,
                    'is_correct' => $option->is_correct,
                ];
            }

            $this->questions[] = [
                'id' => $question->id,
                'text' => $question->question_text,
                'image' => $question->question_image,
                'new_image' => null,
                'options' => $options
            ];
        }

        // Jika belum ada soal, tambahkan satu soal kosong
        if (empty($this->questions)) {
            $this->addQuestion();
        }
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'id' => null, // new question
            'text' => '',
            'image' => null,
            'new_image' => null,
            'options' => [
                ['id' => null, 'letter' => 'A', 'text' => '', 'image' => null, 'new_image' => null, 'is_correct' => false],
                ['id' => null, 'letter' => 'B', 'text' => '', 'image' => null, 'new_image' => null, 'is_correct' => false],
                ['id' => null, 'letter' => 'C', 'text' => '', 'image' => null, 'new_image' => null, 'is_correct' => false],
                ['id' => null, 'letter' => 'D', 'text' => '', 'image' => null, 'new_image' => null, 'is_correct' => false],
            ]
        ];
    }

    public function removeQuestion($index)
    {
        $question = $this->questions[$index];
        
        // If it's an existing question, delete from database
        if ($question['id']) {
            Question::find($question['id'])->delete();
        }
        
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
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

    public function saveQuestions()
    {
        // Validasi
        $this->validate([
            'questions.*.text' => 'required|string',
            'questions.*.new_image' => 'nullable|image|max:2048',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.new_image' => 'nullable|image|max:2048',
        ]);

        // Update or create questions
        foreach ($this->questions as $index => $questionData) {
            $questionImage = $questionData['image'];
            
            // If new image uploaded, use it
            if ($questionData['new_image']) {
                $questionImage = $questionData['new_image']->store('question-images', 'public');
            }

            $question = Question::updateOrCreate(
                ['id' => $questionData['id']],
                [
                    'quiz_id' => $this->quiz->id,
                    'question_text' => $questionData['text'],
                    'question_image' => $questionImage,
                    'order' => $index + 1,
                ]
            );

            // Update or create options
            foreach ($questionData['options'] as $optionData) {
                $optionImage = $optionData['image'];
                
                // If new image uploaded, use it
                if ($optionData['new_image']) {
                    $optionImage = $optionData['new_image']->store('option-images', 'public');
                }

                Option::updateOrCreate(
                    ['id' => $optionData['id']],
                    [
                        'question_id' => $question->id,
                        'option_letter' => $optionData['letter'],
                        'option_text' => $optionData['text'],
                        'option_image' => $optionImage,
                        'is_correct' => $optionData['is_correct'],
                    ]
                );
            }
        }

        // Update question count
        $this->quiz->update(['question_count' => count($this->questions)]);

        session()->flash('message', 'Soal berhasil disimpan!');
        return redirect()->route('admin.daftar-kuis');
    }

    public function render()
    {
        return view('livewire.admin.manage-questions');
    }
}
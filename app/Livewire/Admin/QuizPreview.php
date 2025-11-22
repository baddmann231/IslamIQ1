<?php

namespace App\Livewire\Admin;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Quiz;

#[Layout('components.layouts.admin')]
class QuizPreview extends Component
{
    public $quiz;
    public $quizId;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $userAnswers = [];
    public $showAnswers = false;

    public function mount($quiz)
    {
        $this->quiz = Quiz::with(['questions.options'])->findOrFail($quiz);
        $this->quizId = $this->quiz->id;
        
        // Convert questions to array
        $this->questions = $this->quiz->questions->map(function($question) {
            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'question_image' => $question->question_image,
                'options' => $question->options->map(function($option) {
                    return [
                        'id' => $option->id,
                        'option_letter' => $option->option_letter,
                        'option_text' => $option->option_text,
                        'option_image' => $option->option_image,
                        'is_correct' => $option->is_correct,
                    ];
                })->toArray()
            ];
        })->toArray();

        // Initialize user answers
        foreach ($this->questions as $question) {
            $this->userAnswers[$question['id']] = null;
        }
    }

    public function selectAnswer($questionId, $optionId)
    {
        $this->userAnswers[$questionId] = $optionId;
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function toggleAnswers()
    {
        $this->showAnswers = !$this->showAnswers;
    }

    // Computed property for current question
    public function getCurrentQuestionProperty()
    {
        if (!empty($this->questions) && isset($this->questions[$this->currentQuestionIndex])) {
            $question = $this->questions[$this->currentQuestionIndex];
            return (object) [
                'id' => $question['id'],
                'question_text' => $question['question_text'],
                'question_image' => $question['question_image'],
                'options' => array_map(function($option) {
                    return (object) $option;
                }, $question['options'])
            ];
        }
        return null;
    }

    public function getProgressPercentageProperty()
    {
        return count($this->questions) > 0 ? round(($this->currentQuestionIndex + 1) / count($this->questions) * 100) : 0;
    }

    public function render()
    {
        return view('livewire.admin.quiz-preview');
    }
}
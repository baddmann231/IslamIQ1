<?php

namespace App\Livewire\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\QuizAttempt;

#[Layout('components.layouts.app')]
class QuizResult extends Component
{
    public $quizAttempt;
    public $quiz;
    public $userAnswers;

    public function mount($quizAttempt)
    {
        $this->quizAttempt = QuizAttempt::with([
            'quiz', 
            'userAnswers.question', 
            'userAnswers.option'
        ])->findOrFail($quizAttempt);
        
        $this->quiz = $this->quizAttempt->quiz;
        $this->userAnswers = $this->quizAttempt->userAnswers;
    }

    public function getScoreColor()
    {
        $percentage = $this->quizAttempt->percentage;
        
        if ($percentage >= 80) return 'success';
        if ($percentage >= 60) return 'warning';
        return 'danger';
    }

    public function getScoreMessage()
    {
        $percentage = $this->quizAttempt->percentage;
        
        if ($percentage >= 80) return 'Excellent!';
        if ($percentage >= 60) return 'Good Job!';
        if ($percentage >= 40) return 'Not Bad!';
        return 'Keep Trying!';
    }

    // ✅ Fix: Helper method untuk mendapatkan jawaban yang benar
    public function getCorrectOption($question)
    {
        return $question->options->firstWhere('is_correct', true);
    }

    public function render()
    {
        return view('livewire.user.quiz-result');
    }
}
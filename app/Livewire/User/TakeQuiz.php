<?php

namespace App\Livewire\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;

#[Layout('components.layouts.app')]
class TakeQuiz extends Component
{
    public $quiz;
    public $quizId;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $userAnswers = [];
    public $timeRemaining;
    public $quizAttempt;
    public $isCompleted = false;

    public function mount($quiz)
    {
        $this->quiz = Quiz::with(['questions.options'])->findOrFail($quiz);
        $this->quizId = $this->quiz->id;
        
        // ✅ Fix: Convert questions collection to array properly
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

        $this->timeRemaining = $this->quiz->duration * 60;

        // Create new quiz attempt
        $this->quizAttempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $this->quiz->id,
            'total_questions' => count($this->questions),
            'started_at' => now(),
        ]);

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

    public function submitQuiz()
    {
        // Calculate score
        $correctAnswers = 0;
        
        foreach ($this->userAnswers as $questionId => $selectedOptionId) {
            $isCorrect = false;
            
            if ($selectedOptionId) {
                $question = collect($this->questions)->firstWhere('id', $questionId);
                $correctOption = collect($question['options'])->firstWhere('is_correct', true);
                
                $isCorrect = $correctOption && $correctOption['id'] == $selectedOptionId;
                
                if ($isCorrect) {
                    $correctAnswers++;
                }
            }

            // ✅ Fix: Save user answer for both answered and unanswered questions
            UserAnswer::create([
                'quiz_attempt_id' => $this->quizAttempt->id,
                'question_id' => $questionId,
                'option_id' => $selectedOptionId, // null if not answered
                'is_correct' => $isCorrect,
            ]);
        }

        // Update quiz attempt
        $this->quizAttempt->update([
            'correct_answers' => $correctAnswers,
            'score' => $correctAnswers,
            'completed_at' => now(),
            'time_spent' => $this->quiz->duration * 60 - $this->timeRemaining,
        ]);

        // Redirect to results page
        return redirect()->route('user.quiz-result', $this->quizAttempt->id);
    }

    // ✅ Fix: Better computed property for current question
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

    // ✅ Fix: Add timer countdown
    public function decrementTime()
    {
        if ($this->timeRemaining > 0) {
            $this->timeRemaining--;
        } else {
            // Auto submit when time is up
            $this->submitQuiz();
        }
    }

    public function render()
    {
        // Start polling for timer
        $this->dispatch('start-timer');
        
        return view('livewire.user.take-quiz');
    }
}
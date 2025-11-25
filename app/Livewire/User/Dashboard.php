<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\QuizAttempt;

class Dashboard extends Component
{
    use WithPagination;

    public $userStats = [];
    public $chartData = [];
    public $showQuizDetail = false;
    public $selectedQuiz = null;

    public function mount()
    {
        $this->loadUserStats();
        $this->loadChartData();
    }

    public function loadUserStats()
    {
        $userId = auth()->id();
        
        // Gunakan method dari User model yang sudah diperbaiki
        $stats = auth()->user()->getQuizStats();
        
        $this->userStats = [
            'total_attempts' => $stats['total_attempts'],
            'average_score' => round($stats['average_score'], 1),
            'highest_score' => round($stats['highest_score'], 1),
            'completed_quizzes' => $stats['completed_quizzes'],
            'total_correct_answers' => $stats['total_correct_answers'],
            'accuracy_rate' => $stats['total_questions_answered'] > 0 
                ? round(($stats['total_correct_answers'] / $stats['total_questions_answered']) * 100, 1)
                : 0,
        ];
    }

    public function loadChartData()
    {
        $userId = auth()->id();
        $recentAttempts = QuizAttempt::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->with('quiz')
            ->orderBy('completed_at', 'desc')
            ->limit(8)
            ->get();

        // Jika ada data, gunakan data sebenarnya
        if ($recentAttempts->count() > 0) {
            $this->chartData['labels'] = $recentAttempts->map(function($attempt) {
                return \Carbon\Carbon::parse($attempt->completed_at)->format('d/m');
            })->toArray();
            
            $this->chartData['scores'] = $recentAttempts->pluck('score')->toArray();
        } else {
            // Jika tidak ada data, beri data dummy untuk chart
            $this->chartData['labels'] = ['01/01', '02/01', '03/01', '04/01', '05/01'];
            $this->chartData['scores'] = [0, 0, 0, 0, 0];
        }
    }

    public function viewQuizDetails($quizAttemptId)
    {
        $this->selectedQuiz = QuizAttempt::with(['quiz'])
            ->find($quizAttemptId);
            
        $this->showQuizDetail = true;
    }

    public function closeQuizDetail()
    {
        $this->showQuizDetail = false;
        $this->selectedQuiz = null;
    }

    public function render()
    {
        $userQuizAttempts = QuizAttempt::where('user_id', auth()->id())
            ->whereNotNull('completed_at')
            ->with('quiz')
            ->orderBy('completed_at', 'desc')
            ->paginate(8);

        return view('livewire.user.dashboard', [
            'userQuizAttempts' => $userQuizAttempts
        ]);
    }
}
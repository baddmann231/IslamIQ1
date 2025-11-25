<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public $stats = [];
    public $chartData = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadChartData();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_users' => User::where('role', 'user')->count(),
            'active_users' => User::where('role', 'user')->where('created_at', '>=', now()->subDays(30))->count(),
            'total_quizzes' => Quiz::count(),
            'active_quizzes' => Quiz::where('is_active', true)->count(),
            'completed_attempts' => QuizAttempt::whereNotNull('completed_at')->count(),
            'average_score' => round(QuizAttempt::whereNotNull('completed_at')->avg('score') ?? 0, 1),
        ];

        // Get most popular quiz
        $popularQuiz = Quiz::withCount(['quizAttempts as completed_attempts_count' => function($query) {
            $query->whereNotNull('completed_at');
        }])->orderBy('completed_attempts_count', 'desc')->first();

        $this->stats['popular_quiz_name'] = $popularQuiz ? $popularQuiz->title : 'Tidak ada';
        $this->stats['popular_quiz_attempts'] = $popularQuiz ? $popularQuiz->completed_attempts_count : 0;
    }

    public function loadChartData()
    {
        // Performance data (last 7 days average scores)
        $performanceData = QuizAttempt::whereNotNull('completed_at')
            ->where('completed_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(completed_at) as date, AVG(score) as avg_score')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->chartData['performance'] = [
            'labels' => $performanceData->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d/m'))->toArray(),
            'scores' => $performanceData->pluck('avg_score')->map(fn($score) => round($score, 1))->toArray()
        ];

        // User activity data (quiz attempts per day)
        $activityData = QuizAttempt::whereNotNull('completed_at')
            ->where('completed_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(completed_at) as date, COUNT(*) as attempts')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->chartData['activity'] = [
            'labels' => $activityData->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d/m'))->toArray(),
            'data' => $activityData->pluck('attempts')->toArray()
        ];

        // Jika data kosong, beri nilai default
        if (empty($this->chartData['performance']['labels'])) {
            $this->chartData['performance'] = [
                'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                'scores' => [0, 0, 0, 0, 0, 0, 0]
            ];
        }

        if (empty($this->chartData['activity']['labels'])) {
            $this->chartData['activity'] = [
                'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                'data' => [0, 0, 0, 0, 0, 0, 0]
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
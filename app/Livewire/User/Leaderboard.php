<?php
// app/Livewire/User/Leaderboard.php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Leaderboard extends Component
{
    public $view = 'global'; // 'global' or 'friends'
    public $globalLeaderboard = [];
    public $friendsLeaderboard = [];

    public function mount()
    {
        $this->loadGlobalLeaderboard();
        $this->loadFriendsLeaderboard();
    }

    public function loadGlobalLeaderboard()
    {
        $this->globalLeaderboard = User::orderBy('points', 'desc')
            ->orderBy('correct_answers', 'desc')
            ->orderBy('quizzes_completed', 'desc')
            ->limit(100)
            ->get()
            ->map(function($user, $index) {
                $user->rank = $index + 1;
                return $user;
            });
    }

    public function loadFriendsLeaderboard()
    {
        $friends = auth()->user()->friends()->get();
        $user = auth()->user();
        
        $this->friendsLeaderboard = $friends->push($user)
            ->sortByDesc('points')
            ->values()
            ->map(function($user, $index) {
                $user->rank = $index + 1;
                return $user;
            });
    }

    public function switchView($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return view('livewire.user.leaderboard');
    }
}
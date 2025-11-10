<?php

namespace App\Livewire\Admin;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')] // <-- Ini pakai layout admin
class Dashboard extends Component
{
    public $totalUsers = 100;
    public $totalQuiz = 25;

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}

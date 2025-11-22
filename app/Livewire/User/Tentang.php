<?php

namespace App\Livewire\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Tentang extends Component
{
    public function render()
    {
        return view('livewire.user.tentang');
    }
}

<?php

namespace App\Livewire;

use Filament\Facades\Filament;
use Livewire\Component;

class Policy extends Component
{
    public function render()
    {
        return view('livewire.policy');
    }

    public function confirm()
    {
        redirect()->intended(Filament::getUrl());
    }
}

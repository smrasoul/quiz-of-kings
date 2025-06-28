<?php

namespace App\Livewire;


use Livewire\Attributes\Locked;
use Livewire\Component;

class RoundStatus extends Component
{


    #[Locked]
    public $game;
    #[Locked]
    public $round;
    #[Locked]
    public $userId;

    public function render()
    {
        return view('livewire.round-status');
    }
}

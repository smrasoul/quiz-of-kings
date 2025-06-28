<?php

namespace App\Livewire;

use App\Enums\Status;
use App\Models\Game;
use App\Models\GameQueue;
use App\Models\Round;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class MatchMaking extends Component
{
    #[Computed]
    public function userId(){
        return Auth::id();
    }

    #[Computed]
    public function queue()
    {
        return GameQueue::where('user_id', $this->userId)->latest()->get();
    }

    #[Computed]
    public function game()
    {

        $userId = $this->userId;

        return Game::where(function ($query) use ($userId) {
            $query->where('player_one_id', $userId)
                ->orWhere('player_two_id', $userId);
        })->where('status', Status::PENDING)->first();
    }

    public function store()
    {
        $player = GameQueue::latest()->first();

        $userId = $this->userId;

        if($player){
            $game = Game::create([
                'player_one_id' => $userId,
                'player_two_id' => $player->user_id,
                'current_turn' => $userId,
                'last_activity' => now()->timestamp,
                'status' => Status::PENDING
            ]);
            Round::create([
                'game_id' => $game->id,
                'round_number' => 1,
                'status' => Status::PENDING
            ]);

            $player->delete();

            return redirect("/game/$game->id");
        }else{
            GameQueue::create([
                'user_id' => $userId,
                'queued_at' => now()
            ]);

            return redirect("/game/create");
        }
    }

    public function render()
    {
        return view('livewire.match-making');
    }
}

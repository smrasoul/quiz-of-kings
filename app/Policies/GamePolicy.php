<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\GameQueue;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GamePolicy
{

    public function access(User $user, Game $game): bool
    {
        return $game->player_one_id === $user->id || $game->player_two_id === $user->id;
    }

    public function queue(User $user): bool
    {
        return !GameQueue::where('user_id', $user->id)->exists();
    }


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Game $game): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Game $game): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Game $game): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Game $game): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Game $game): bool
    {
        return false;
    }
}

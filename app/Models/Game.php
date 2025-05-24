<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $guarded = [];

    public function playerOne():BelongsTo
    {
        return $this->belongsTo(User::class, 'player_one_id');
    }

    public function playerTwo():BelongsTo
    {
        return $this->belongsTo(User::class, 'player_two_id');
    }

}

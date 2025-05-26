<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function playerOne():BelongsTo
    {
        return $this->belongsTo(User::class, 'player_one_id');
    }

    public function playerTwo():BelongsTo
    {
        return $this->belongsTo(User::class, 'player_two_id');
    }

    public function rounds():HasMany
    {
        return $this->hasMany(Round::class, 'game_id');
    }

}

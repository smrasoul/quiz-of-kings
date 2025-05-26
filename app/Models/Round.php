<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Round extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function roundQuestions(): HasMany
    {
        return $this->hasMany(RoundQuestion::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function roundAnswers(): HasMany
    {
        return $this->hasMany(RoundAnswer::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}

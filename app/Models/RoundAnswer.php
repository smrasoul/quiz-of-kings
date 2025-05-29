<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoundAnswer extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }

    public function playerOne(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'user_id');
    }

}

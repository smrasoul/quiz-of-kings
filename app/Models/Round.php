<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Round extends Model
{
    protected $guarded = [];

    public function roundQuestions(): HasMany
    {
        return $this->hasMany(RoundQuestion::class);
    }
}

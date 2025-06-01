<?php

namespace App\Jobs;

use App\Models\RoundAnswer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRoundAnswer implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected RoundAnswer $roundAnswer;
    protected int $selectedOptionId;
    protected bool $isCorrect;

    public function __construct(RoundAnswer $roundAnswer, int $selectedOptionId, bool $isCorrect)
    {
        $this->roundAnswer = $roundAnswer;
        $this->selectedOptionId = $selectedOptionId;
        $this->isCorrect = $isCorrect;
    }

    public function handle(): void
    {
        $this->roundAnswer->update([
            'selected_option_id' => $this->selectedOptionId,
            'is_correct' => $this->isCorrect,
        ]);
    }
}

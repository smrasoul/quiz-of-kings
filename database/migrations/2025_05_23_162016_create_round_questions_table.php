<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('round_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('round_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('order'); // 1 to N (e.g., 3 questions per round)
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('round_questions');
    }
};

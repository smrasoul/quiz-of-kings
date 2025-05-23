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
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chosen_by')->constrained('users'); // The one who chose the category
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('round_number'); // 1 to 5, for example
            $table->boolean('player_one_ready')->default(false);
            $table->boolean('player_two_ready')->default(false);
            $table->timestamp('started_at')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rounds');
    }
};

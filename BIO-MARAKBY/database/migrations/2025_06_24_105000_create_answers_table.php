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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade'); // يعتمد على questions
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('answer_text')->nullable(); // لو essay
            $table->foreignId('option_id')->nullable()->constrained('options')->onDelete('set null'); // لو MCQ
            $table->integer('score')->nullable(); // الدرجة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'user_id', 'score', 'finished_at'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function getStudentAnswer($question)
    {
        $answer = $this->answers->where('question_id', $question->id)->first();

        if ($question->type == 'mcq') {
            return $answer?->selectedOption?->option_text ?? 'لا يوجد';
        } else {
            return $answer?->text_answer ?? 'لا يوجد';
        }
    }

    public function getAnswerPoints($question)
    {
        return $this->answers->where('question_id', $question->id)->first()?->points_awarded;
    }
}

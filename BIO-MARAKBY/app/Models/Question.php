<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    protected $fillable = [
        'exam_id',
        'type',
        'question_text',
        'points',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function essayAnswer(): HasOne
    {
        return $this->hasOne(EssayAnswer::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(QuestionImage::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function getCorrectOptionAttribute()
    {
        if ($this->type === 'mcq') {
            return $this->options->where('is_correct', true)->first();
        }
        return null;
    }
}

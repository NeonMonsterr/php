<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property string $form_url
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $exam_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereExamDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereFormUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Exam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Exam extends Model
{
    protected $table = 'exams';

    protected $fillable = [
        'title',
        'description',
        'type',
        'duration_minutes',
        'start_time',
        'end_time',
        'exam_date',
        'show_score_immediately',
        'course_id',
        'total_score',
        'is_published',
    ];

    // لو في حقول تاريخ (date/time) عايز Laravel يتعامل معاها ككائنات Carbon
    protected $dates = [
        'start_time',
        'end_time',
    ];


    // App\Models\Exam.php
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];



    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function isActive()
    {
        return now()->between($this->start_time, $this->end_time);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }




    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}

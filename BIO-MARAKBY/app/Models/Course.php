<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property string $stage   // preparatory | secondary
 * @property int $level      // 1, 2, 3
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exam> $exams
 * @property-read int|null $exams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lecture> $lectures
 * @property-read int|null $lectures_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $students
 * @property-read int|null $students_count
 * @property-read \App\Models\User $user
 */
class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'stage_id',       // preparatory | secondary
        'level_id',       // 1, 2, 3
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'stage_id' => 'integer',
            'level_id' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function students()
    {
        return $this->hasMany(User::class, 'course_id');
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers for Display
    |--------------------------------------------------------------------------
    */
}

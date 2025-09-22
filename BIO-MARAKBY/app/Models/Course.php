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
        'stage',       // preparatory | secondary
        'level',       // 1, 2, 3
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'stage' => 'string',
            'level' => 'integer',
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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePreparatory($query)
    {
        return $query->where('stage', 'preparatory');
    }

    public function scopeSecondary($query)
    {
        return $query->where('stage', 'secondary');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers for Display
    |--------------------------------------------------------------------------
    */
    public function getStageNameAttribute(): string
    {
        return match ($this->stage) {
            'preparatory' => 'إعدادي',
            'secondary'   => 'ثانوي',
            default       => $this->stage,
        };
    }

    public function getLevelNameAttribute(): string
    {
        return match ($this->level) {
            1 => 'الأول',
            2 => 'الثاني',
            3 => 'الثالث',
            default => (string) $this->level,
        };
    }

    public function getFullStageLevelAttribute(): string
    {
        return $this->stage_name . ' ' . $this->level_name;
    }
    public function getStageArabicAttribute()
{
    return match($this->stage) {
        'preparatory' => 'إعدادي',
        'secondary'  => 'ثانوي',
        default      => 'غير محدد',
    };
}

public function getLevelArabicAttribute()
{
    return match((string) $this->level) {
        '1' => 'أولى',
        '2' => 'تانية',
        '3' => 'تالتة',
        default => 'غير محدد',
    };
}
}

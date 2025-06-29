<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property string $youtube_url
 * @property int $position
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereYoutubeUrl($value)
 * @mixin \Eloquent
 */
class Lecture extends Model
{
    protected $table = 'lectures';

    protected $fillable = [
        'course_id',
        'title',
        'youtube_url',
        'position',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'position' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}

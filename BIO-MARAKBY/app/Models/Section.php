<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';

    protected $fillable = [
        'lecture_id',
        'title',
        'youtube_url',
        'position',
        'is_published',
        'video_title',
        'file',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'position' => 'integer',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}

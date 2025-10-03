<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['level_id', 'name', 'description'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function courses() {
    return $this->hasMany(Course::class);
}
}

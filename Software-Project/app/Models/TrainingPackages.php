<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPackages extends Model
{
    use HasFactory;

    protected $fillable = ['support_id', 'title', 'description','id'];

    public function support()
    {
        return $this->belongsTo(TrainingAndSupport::class, 'support_id');  // Use 'support_id' as the foreign key
    }
}

